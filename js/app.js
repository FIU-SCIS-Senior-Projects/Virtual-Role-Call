/* global angular */

var app = angular.module('VRC_App', ['ngRoute']);

app.config(function ($routeProvider) { //$routeProvider defines the application routes.
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
            .when('/pinTask', {
                templateUrl: '../views/pinTask.html'
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
});
