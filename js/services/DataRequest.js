/* global app */

//module for login
login.factory('DataRequest', function ($http, $q) {

    return {
        login: function (username, password) {

            function promiseExecutor(resolve, reject) {
                $http.post("php/login.php", {"username": username,
                    "password": password})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.
        }
    };
});

// module for the rest of the rest of the system.
app.factory('DataRequest', function ($http, $q) {

    return{
        register: function (lastName, firstName, username, encryptedPass, userType, userShift) {

            function promiseExecutor(resolve, reject) {
                $http.post("register.php", {
                    "lastName": lastName,
                    "firstName": firstName,
                    "username": username,
                    "password": encryptedPass,
                    "userType": userType,
                    "userShift": userShift})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.
        },
        getRegisteredUsers: function () {

            function promiseExecutor(resolve, reject) {
                $http.post("getUsers.php", {})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.
        },
        getUser: function (id) {
            function promiseExecutor(resolve, reject) {
                $http.post("getUser.php", {id: id})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.
        },
        save: function (id, lastName, firstName, username, password, type, shift) {

            function promiseExecutor(resolve, reject) {

                $http.post("updateUser.php", {
                    "id": id,
                    "lastName": lastName,
                    "firstName": firstName,
                    "username": username,
                    "password": password,
                    "userType": type,
                    "userShift": shift})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.      
        },
    };
});
