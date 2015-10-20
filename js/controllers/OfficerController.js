
/* global officer */

officer.controller('OfficerController', ['$scope', 'DataRequest', '$window', 'Idle', '$modal',
    function ($scope, DataRequest, window, Idle, $modal) {

        $scope.retrieveTasks = function () {
            DataRequest.retrieveTasks().then(function (data) {
                $scope.tasks = data;
            }, function (error) {
                console.log("Error: " + error);
            });
        };
        $scope.retrieveDocs = function (taskType, shift) {
            DataRequest.retrieveDocs(taskType, shift).then(function (data) {
                $scope.documents = data;
                window.location.href = "#/viewDocs";
                
                $scope.category = taskType;
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
//  ****************************************************************

        (function (a) {
            a.createModal = function (b) {
                defaults = {
//                    title: "",
                    message: "Message Here!",
                    closeButton: true,
                    scrollable: false
                };
                var b = a.extend({}, defaults, b);
                var c = (b.scrollable === true) ? 'style="max-height: 420px;overflow-y: auto;"' : "";
                html = '<div class="modal fade" id="myModal">';
                html += '<div class="modal-dialog modal-lg">';
                html += '<div class="modal-content">';
//                html += '<div class="modal-header">';
//                html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
//                if (b.title.length > 0) {
//                    html += '<h4 class="modal-title">' + b.title + "</h4>";
//                }
//                html += "</div>";
                html += '<div class="modal-body" ' + c + ">";
                html += b.message;
                html += "</div>";
                html += "</div>";
                html += "</div>";
                html += "</div>"; // 

                a("body").prepend(html);
                a("#myModal").modal().on("hidden.bs.modal", function () {
                    a(this).remove();
                });
            };
        })(jQuery);
        //displaying pdf document in a modal.
        $scope.viewDoc = function (category, docName) {
            var iframe;
            // Internet reads a space as %20
            docName = docName.replace(" ", "%20");
            category = category.replace(" ", "%20");
            //Find the document type.
            var contents = docName.split(".");
            var docType = contents[contents.length - 1 ];
            var documentUrl = "http://" + location.host + "/VirtualRollCall/uploads/" + category + "/" + docName;

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
//                title: 'My Title',
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
