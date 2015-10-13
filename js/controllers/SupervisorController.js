supervisor.controller('SupervisorController', ['$scope', 'DataRequest', '$window', '$routeParams', 'Idle', '$modal',
    function ($scope, DataRequest, window, $routeParams, Idle, $modal) {

        //Supervisor options
        $scope.OptionsBar = [
            {name: 'Add Task', url: 'newTask'},
            {name: 'Pin Task', url: 'pinTask'}
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
        $scope.addTask = function(){
            var task = this.task;
            var userShift = this.userShift;
            var category = this.category;
            if(!(task && userShift && category)){
                this.message = "*Please complete all fields.";
            }else{
                DataRequest.addTask(task,userShift,category);
            }
        }
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

