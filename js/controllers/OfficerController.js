
/* global officer */

officer.controller('OfficerController', ['$scope', 'DataRequest', '$window', 'Idle', '$modal', '$routeParams',
    function ($scope, DataRequest, window, Idle, $modal, $routeParams) {

        // session storage variables
        var officerShift, currentUsername;
        // variables used for logging officer activity
        var doc_startTime, doc_endTime, currentDocument, viewingTime;
        // wait until the document is ready to get the officer's shift.
        $(document).ready(function () {
            officerShift = document.getElementById("officerShift").value;
        });
        // wait until the document is ready to get the username.
        $(document).ready(function () {
            currentUsername = document.getElementById("currentUsername").value;
        });

        $scope.retrieveCategories = function () {
            DataRequest.retrieveCategories().then(function (data) {
                $scope.categories = data;
            }, function (error) {
                console.log("Error: " + error);
            });
        };

        $scope.retrieveDocs = function () {
            var category = $routeParams.currentCategory;
            DataRequest.retrieveDocs(category, officerShift).then(function (data) {
                $scope.documents = data;
                $scope.category = category;
            }, function (error) {
                console.log("Error: " + error);
            });
        };
        $scope.loadLocations = function () {
            DataRequest.retrieveAddresses().then(function (data) {

                // the map will focus on this location when opening. 
                var mapFocus = {lat: 25.662284, lng: -80.307039}; // Pinecrest
                $scope.mapOptions = {
                    zoom: 14,
                    //Map focus set up for Pinecrest.
                    center: new google.maps.LatLng(mapFocus)
                };
                //create the map
                var map = new google.maps.Map(document.getElementById('googleMap'), $scope.mapOptions);
                //create the geocoder for the map
                geocoder = new google.maps.Geocoder();

                // loop through the addresses
                for (var i = 0; i < data.length; i++) {
                    var element = data[i];
                    var description = element['description'];
                    var geoOptions = {
                        address: element['address'] + "," + element['city'] + "," + element['state'] + "," + element['zip']
                    };
                    geocoder.geocode(geoOptions, addMarker(description));
                } //end of loop

                function addMarker(myTitle) {
                    return function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                                title: myTitle
                            });
                        }
                    };
                }
            }, function (error) {
                console.log("Error: " + error);
            });
        };
        //      **************** monitoring idle user ************ ****

        $scope.started = false;
        // close modals.
        function closeModals() {
            if ($scope.warning) {
                $scope.warning.close(); // close the warning modal
                $scope.warning = null;
            }
            if ($scope.msgModal) {
                $scope.msgModal.close();
                $scope.msgModal = null;
            }
        }

        // user has been idle for too long. Prompt message.
        $scope.$on('IdleStart', function () {
            closeModals();
            $scope.warning = $modal.open({
                templateUrl: 'warning-dialog.html',
                windowClass: 'modal-danger'
            });
        });
        // idle warning time has ended. close the notificatoin modal.
        $scope.$on('IdleEnd', function () {
            closeModals();
        });
        // idle timeout. sign user out.
        $scope.$on('IdleTimeout', function () { // Timed out.
            closeModals();
            window.location.href = "../php/logout.php"; //Log the user out.
        });
        // begin idle time monitoring.
        $scope.start = function () {
            closeModals();
            Idle.watch(); // begin monitoring.
            $scope.started = true;
        };
        //display messages through a modal to notify users of an event.
        function displayMessage(message) {
            $scope.message = message;
            $scope.msgModal = $modal.open({
                templateUrl: 'notification.html',
                windowClass: 'modal-danger',
                scope: $scope
            });
        }
//      ****************************************************************

        (function (a) {
            a.createModal = function (b) {
                defaults = {
                    message: "Message Here!",
                    closeButton: true,
                    scrollable: false
                };
                var b = a.extend({}, defaults, b);
                var c = (b.scrollable === true) ? 'style="max-height: 420px;overflow-y: auto;"' : "";
                html = '<div class="modal fade" id="myModal">';
                html += '<div class="modal-dialog modal-lg">';
                html += '<div class="modal-content">';
                html += '<div class="modal-body" ' + c + ">";
                html += b.message;
                html += "</div>";
                html += "</div>";
                html += "</div>";
                html += "</div>";

                a("body").prepend(html);
                a("#myModal").modal().on("hidden.bs.modal", function () {
                    logUserActivity();
                    //delete the modal from the page 
                    a(this).remove();
                });
            };
        })(jQuery);

        logUserActivity = function () {
            // get the moment at which the modal was closed.
            doc_endTime = Date.now();
            //calculate the activity time.
            viewingTime = Math.floor((doc_endTime - doc_startTime) / 1000); // in seconds.
            //log the user activity into the database.
            DataRequest.logUserActivity(currentUsername, viewingTime, currentDocument).then(function (data) {
            }, function (error) {
                console.log("Error: " + error);
            });
        };

        //displaying pdf document in a modal.
        $scope.viewDoc = function (Category, docName) {
            //catch the moment the user starts viewing the document.
            doc_startTime = Date.now();
            // get the document name for activity logging purposes.
            currentDocument = docName;


            var iframe;
            // Internet reads a space as %20
            docName = docName.replace(" ", "%20");
            Category = Category.replace(" ", "%20");
            //Find the document type.
            var contents = docName.split(".");
            var docType = contents[contents.length - 1 ];
            var documentUrl = "http://" + location.host + "/VirtualRollCall/uploads/" + Category + "/" + docName;
            //check if the file is supported by the system.
            if (isSupported(docType)) {

                if (docType === "pdf") { //document is pdf.
                    iframe = '<iframe width="100%" height="600px" \n\
                src= "../js/vendor/web/viewer.html?file=' + documentUrl + '" ></iframe>';
                }   //video. mp4 
                else if (docType === "mp4") {
                    iframe = '<iframe <video src="' + documentUrl + '" type="video/mp4"/></iframe>';
                }
                //display the modal with the information.
                $.createModal({
                    message: iframe,
                    closeButton: true,
                    scrollable: false
                });
            } else {
                displayMessage("This file is not currently supported.");
            }
        };
        //any supported extensions are included here.
        function isSupported(extension) {
            return extension === "pdf" || extension === "mp4";
        }
    }]);
