/* global admin, login, officer */

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
}); // Login Factory

// module for the rest of the rest of the system.
admin.factory('DataRequest', function ($http, $q) {

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
        removeUser: function (id) {
            function promiseExecutor(resolve, reject) {
                $http.post("removeUser.php", {"id": id})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished. 
        },
        retrieveCategories: function () {
            function promiseExecutor(resolve, reject) {
                $http.post("retrieveCategories.php", {})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished. 
        },
        addNewCategory: function (categoryName) {
            function promiseExecutor(resolve, reject) {
                $http.post("newCategory.php", {
                    "category": categoryName})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished. 
        },
    };
}); // Admin Factory

supervisor.factory('DataRequest', function ($http, $q) {
    return {
        retrieveTasks: function () {
            function promiseExecutor(resolve, reject) {
                $http.post("retrieveTasks.php", {})
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
officer.factory('DataRequest', function ($http, $q) {

    return {
        retrieveDocs: function (taskType, shift) {
            function promiseExecutor(resolve, reject) {
                $http.post("retrieveDocs.php",
                        {"taskType": taskType,
                            "shift": shift})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished. 
        },
        retrieveCategories: function () {
            function promiseExecutor(resolve, reject) {
                $http.post("retrieveCategories.php", {})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished. 
        },
        retrieveAddresses: function () {
            function promiseExecutor(resolve, reject) {
                $http.post("addresses.php", {})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished. 
        },
    };
}); // Officer Factory
