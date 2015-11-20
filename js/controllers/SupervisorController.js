supervisor.controller('SupervisorController', ['$scope', 'DataRequest', '$window', '$routeParams', 'Idle', '$modal',
    function ($scope, DataRequest, window, $routeParams, Idle, $modal) {

        //Supervisor options
        $scope.OptionsBar = [
            {name: 'Add Task', url: 'newTask'},
            {name: 'Pin Task', url: 'pinTask'},
            {name: 'View Pinned Task', url: 'viewPinnedTasks'}
        ];
        // For toggling the submenu (view as) for supervisor
        (function ($) {
            $(document).ready(function () {
                $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    $(this).parent().siblings().removeClass('open');
                    $(this).parent().toggleClass('open');
                });
            });
        })(jQuery);
        function displayMessage(message) {
            $scope.message = message;
            $scope.msgModal = $modal.open({
                templateUrl: 'notification.html',
                windowClass: 'modal-danger',
                scope: $scope
            });
        }
        $scope.removePin = function(documentId, documentName){
            DataRequest.removePin()
                .then(function (data){
                    if(data['documentId'] === null){
                        displayMessage("Error deleting the message")
                    }else{
                        displayMessage("error deleting Document of Id " + documentId + "Titled" + documentName)
                    }
                })
        }
        $scope.retrieveCategories = function () {
            DataRequest.retrieveCategories().then(function (data) {
                $scope.categories = data;
            }, function (error) {
                console.log("Error: " + error);
            });
        };
        $scope.addWatchOrder = function(){
            var address = this.address;
            var city = this.city;
            var zip = this.zip;
            var state = this.state;
            var validDays = this.validDays;
            var description = this.description;
            if(!(address && city && zip && state && validDays && description)){
                displayMessage("*Please Complete all watch order fields");
            }else { // all fields entered. Add Watch Order user.

                DataRequest.addWatchOrder(address, city, zip, state, validDays, description)
                    .then(function (data) {
                        if (data['address'] === null) {
                            displayMessage("*This address is already associated with another order.");
                        } else { //sucessful registration
                            displayMessage(address + " " + city + ", " + state + " has been sucessfully added.");
                            //wait 2 seconds.
                            setTimeout(function () {
                                //reload page after 2 seconds of sucessul addition.
                                window.location.reload();
                            }, 2000);
                        }
                    }, function (error) {
                        console.log("Error: " + error);
                    });
            }
        }
        //
        $scope.getPinnedTasks = function(){
            DataRequest.getPinnedTasks().then(function (data) {
                var list = [];
                for(var x in data) {
                    var tmp = new Object();
                    tmp.documentName = data[x].documentName;
                    tmp.username = data[x].username;
                    tmp.timestamp = data[x].timestamp;
                    tmp.documentId = data[x].documentId;
                    list.push(tmp);
                }
                $scope.pinnedTasks = list;
                }
            , function (error) {
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
    }]);
