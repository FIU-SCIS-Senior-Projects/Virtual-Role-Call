/* global angular */
//var app = angular.module('VRC_App', ['ngRoute']);

var app = angular.module('VRC_App', ['ngRoute']);

app.config(function ($routeProvider) { //$routeProvider defines the application routes.
    $routeProvider
            .when('/register', {
                templateUrl: '../views/register.html'
            })
            .when('/editUser', {
                templateUrl: '../views/editUser.html'
            })
            .when('/editArchive', {
                templateUrl: '../views/editArchive.html'
            })
            .when('/viewLogs', {
                templateUrl: '../views/viewLogs.html'
            })
            .when('/newTask', {
                templateUrl: '../views/newTask.html'
            })
            .otherwise({
                redirectTo: '/register'
            });
});
