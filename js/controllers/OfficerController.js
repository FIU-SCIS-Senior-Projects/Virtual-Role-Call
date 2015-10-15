
/* global officer */

officer.controller('OfficerController', ['$scope', 'DataRequest', '$window', 'Idle', '$modal',
    function ($scope, DataRequest, window, Idle, $modal) {
//        , 'DataRequest', '$routeParams', 'Idle', '$modal'
//, DataRequest, $routeParams, Idle, $modal

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
            window.location.href = "../php/logout.php";  //Log the user out.
        });
        // begin idle time monitoring.
        $scope.start = function () {
            closeModals();
            Idle.watch(); // begin monitoring.
            $scope.started = true;
        };
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
                html += '<div class="modal-dialog">';
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
                html += '<div class="modal-footer">';
                if (b.closeButton === true) {
                    html += '<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>';
                }
                html += "</div>";
                html += "</div>";
                html += "</div>";
                html += "</div>";
                a("body").prepend(html);
                a("#myModal").modal().on("hidden.bs.modal", function () {
                    a(this).remove();
                });
            };
        })(jQuery);

        //displaying pdf document in a modal.
        $scope.viewDoc = function (category, docName) {
            var pdfDoc = "../uploads/" + category + "/" + docName;
            //Find the document type.
            var contents = docName.split(".");
            var docType = contents[contents.length - 1 ];

            if (docType === "pdf") {
                var iframe = '<object type="application/' + docType + '" data="' + pdfDoc + '" width="100%" height="650">No Support</object>';
                $.createModal({
//                title: 'My Title',
                    message: iframe,
                    closeButton: true,
                    scrollable: false
                });
            } else { //not a pdf document.
                
//                var microsoftDoc = location.host + "/VirtualRollCall/uploads/" + category + "/" + docName;
//                var fullLink =    'https://docs.google.com/viewer?url=' + microsoftDoc; 
//                console.log(microsoftDoc);
//                
//                href = microsoftDoc;
//                var iframe = '<object type="application/' + docType + '" data="' + fullLink + '" width="100%" height="650">No Support</object>';
                        
//                $.createModal({
////                title: 'My Title',
//                    message: iframe,
//                    closeButton: true,
//                    scrollable: false
//                });
                
//                var microsoftDoc = location.host + "/VirtualRollCall/uploads/" + category + "/" + docName;
//                window.open(
//                        'https://docs.google.com/viewer?url=' + microsoftDoc,
//                        '_blank' // <- This is what makes it open in a new window.
//                        );
            }

//            var iframe = '<object type="application/' + docType + '" data="' + docLink + '" width="100%" height="650">No Support</object>';
//            $.createModal({
////                title: 'My Title',
//                message: iframe,
//                closeButton: true,
//                scrollable: false
//            });
        };

    }]);

    