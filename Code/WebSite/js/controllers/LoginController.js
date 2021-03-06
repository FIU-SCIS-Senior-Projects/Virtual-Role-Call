
/* global app, login */

login.controller('LoginController', ['$scope', 'DataRequest', '$window',
    function ($scope, DataRequest, window) {

        $scope.message = "";
        var username = '';
        var pw = '';
        $scope.loginRequest = function () {
            username = $scope.username;
            pw = $scope.password;
            //are both username and password entered?
            if (!(username && pw)) {
                $scope.message = "*Username or password not entered.";
            } else {
                // password is encrypted in the database. Every encryption is different.
                DataRequest.login(username).then(function (data) {

                    if (data['username'] !== null) {
                        //username found. check password
                        var decryptedPass = CryptoJS.AES.decrypt(data['password'], "fiu");
                        var pass = CryptoJS.enc.Latin1.stringify(decryptedPass);
                        if (pass === pw) {
                            //check if this user is already logged in.
                            var onlineStatus = data['onlineStatus'];
//                            if (onlineStatus) { // this account is already logged in.
//                                $scope.message = "This account is already logged in";
//                            } else {
                            var userType = data['type'];
                            var username = data['username'];
                            var shift = data['shift'];

                            window.location.href = "php/Session.php?username=" + username + "&type=" + userType + "&shift=" + shift;
//                            }
                        } else {// credentials are invalid
                            $scope.message = "Invalid credentials. Try Again!";
                        }
                    } else {
                        $scope.message = "Invalid credentials. Try Again!";
                    }
                }, function (error) {
                    console.log("Error: " + error);
                });
            }
        };
    }]);
