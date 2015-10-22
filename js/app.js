/* global angular */

var login = angular.module('VRC_Login', []); // module for login
var admin = angular.module('adminModule', ['ngRoute', 'ngIdle', 'ui.bootstrap']); // module for the rest fo system.
var officer = angular.module('officerModule', ['ngRoute', 'ngIdle', 'ui.bootstrap']);
var supervisor = angular.module('supervisorModule', ['ngRoute','ngIdle', 'ui.bootstrap']);

admin.config(function ($routeProvider, IdleProvider) { //$routeProvider defines the application routes.
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
//            .when('/Supervisor', {
//                templateUrl: './Supervisor_Profile.php'
//            })
//            .when('/Officer', {
//                templateUrl: './Officer_Profile.php'
//            })
            .otherwise({
                redirectTo: '/register'
            });

    // time is in seconds.
    IdleProvider.idle(15 * 60); // amount of time to wait while the user is iddle
    IdleProvider.timeout(5); // Warning time.
//    KeepaliveProvider.interval(10);

});

officer.config(function ($routeProvider, IdleProvider) {
    $routeProvider
            .when('/viewCategories', {
                templateUrl: '../views/categories.html',
//                scope: '$rootScope'
            })
            .when('/viewDocs', {
                templateUrl: '../views/taskDocs.html',
//                scope: '$rootScope'
            })
            .otherwise({
                redirectTo: '/viewCategories'
            });
    // time is in seconds.
    IdleProvider.idle(15 * 60); // amount of time to wait while the user is iddle
    IdleProvider.timeout(5); // Warning time.
});

supervisor.config(function ($routeProvider, IdleProvider) {
    $routeProvider
        .when('/newTask', {
            templateUrl: '../views/newTask.html'
        })
        .when('/pinTask', {
            templateUrl: '../views/dndNewTask.html'
        })
        .otherwise({
            redirectTo: '/newTask'
        });
    IdleProvider.idle(5 * 60); // amount of time to wait while the user is iddle
    IdleProvider.timeout(5); // Warning time.
});
