app.controller('SupervisorController', ['$scope', 'DataRequest', '$window', '$routeParams',
    function ($scope, DataRequest, window, $routeParams) {

        //Supervisor options
        $scope.OptionsBar = [
            {name: 'Add Task', url: 'newTask'},
            {name: 'Pin Task', url: 'editUser'},
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
            if(!(task && userShift)){
                this.message = "*Please complete all fields.";
            }else{
                
            }
        }
    }]);

