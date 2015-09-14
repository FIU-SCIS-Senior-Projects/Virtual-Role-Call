
/* global app */

app.controller('LoginController', ['$scope', 'DataRequest', '$window',
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

                    // decrypt the password stored in the database.
                    var decryptedPass = CryptoJS.AES.decrypt(data['password'], "fiu");
                    var pass = CryptoJS.enc.Latin1.stringify(decryptedPass);

                    if (data['username'] === null || (pass !== pw)) {
                        $scope.message = "Invalid credentials. Try Again!";
                    } else { //username found

                        var userType = data['type'];
                        var username = data['username'];
                        window.location.href = "php/Session.php?username=" + username + "&type=" + userType;
                    }
                }, function (error) {
                    console.log("Error: " + error);
                });
            }
        };
    }]);
