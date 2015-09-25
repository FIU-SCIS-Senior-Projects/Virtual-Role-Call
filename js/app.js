/* global angular */

var login = angular.module('VRC_Login', []); // module for login
var app = angular.module('VRC_App', ['ngRoute', 'ngIdle', 'ui.bootstrap']); // module for the rest fo system.

app.config(function ($routeProvider, IdleProvider) { //$routeProvider defines the application routes.
    $routeProvider
            .when('/register', {
                templateUrl: '../views/register.html'
            })
            .when('/editUser', {
                templateUrl: '../views/editUser.html'
            })
            .when('/editUser/:id', {
                templateUrl: '../views/Details.html'
            })
            .when('/editArchive', {
                templateUrl: '../views/editArchive.html'
            })
            .when('/viewLogs', {
                templateUrl: '../views/viewLogs.html'
            })
            .when('/newTask', {
                templateUrl: '../views/newTask.html'
            }) //Other users profiles
            .when('/Supervisor', {
                templateUrl: './Supervisor_Profile.php'
            })
            .when('/Officer', {
                templateUrl: './Officer_Profile.php'
            })
            .otherwise({
                redirectTo: '/register'
            });

    // time is in seconds.
    IdleProvider.idle(5*60); // amount of time to wait while the user is iddle
    IdleProvider.timeout(5); // Warning time.
//    KeepaliveProvider.interval(10);



    //for diddle logout. Arg is in seconds. multiply (<minutes>*60)
//    IdleProvider.idleDuration(5); // 10 minutes idle
//    IdleProvider.warningDuration(5); // 30 second warning
//    KeepaliveProvider.interval(5); // 5 minute keep-alive ping
//})
//        .run(function ($rootScope) {
//            $rootScope.$on('$idleTimeout', function () {
//                console.log("You have been logged out");
//                // end their session and redirect to login
//            });

});




//angular.module('demo', ['ngIdle', 'ui.bootstrap'])
//        .controller('DemoCtrl', function ($scope, Idle, Keepalive, $modal) {
//            $scope.started = false;
//
//            function closeModals() {
//                if ($scope.warning) {
//                    $scope.warning.close();
//                    $scope.warning = null;
//                }
//
//                if ($scope.timedout) {
//                    $scope.timedout.close();
//                    $scope.timedout = null;
//                }
//            }
//
//            $scope.$on('IdleStart', function () {
//                closeModals();
//
//                $scope.warning = $modal.open({
//                    templateUrl: 'warning-dialog.html',
//                    windowClass: 'modal-danger'
//                });
//            });
//
//            $scope.$on('IdleEnd', function () {
//                closeModals();
//            });
//
//            $scope.$on('IdleTimeout', function () {
//                closeModals();
//                $scope.timedout = $modal.open({
//                    templateUrl: 'timedout-dialog.html',
//                    windowClass: 'modal-danger'
//                });
//            });
//
//            $scope.start = function () {
//                closeModals();
//                Idle.watch();
//                $scope.started = true;
//            };
//
//            $scope.stop = function () {
//                closeModals();
//                Idle.unwatch();
//                $scope.started = false;
//
//            };
//        })
//        .config(function (IdleProvider, KeepaliveProvider) {
//            IdleProvider.idle(5);
//            IdleProvider.timeout(5);
//            KeepaliveProvider.interval(10);
//        });