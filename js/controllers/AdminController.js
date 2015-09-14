
/* global app */
//decryption
//            var decrypted = CryptoJS.AES.decrypt(encryptedPass, "fiu");
//            console.log("decrypted", CryptoJS.enc.Latin1.stringify(decrypted));

app.controller('AdminController', ['$scope', 'DataRequest', '$window', function ($scope, DataRequest, window) {

        //Admin options
        $scope.OptionsBar = [
            {name: 'Register User', url: 'register'},
            {name: 'Edit/view userInfo', url: 'editUser'},
            {name: 'Edit Archives', url: 'editArchive'},
            {name: 'Add new Task type', url: 'newTask'},
            {name: 'View Logs', url: 'viewLogs'}
        ];

        $scope.register = function () {

            // this = $scope of the current registration form.
            var lastName = this.lastName;
            var firstName = this.firstName;
            var username = this.username;
            var password = this.password;
            var userType = this.userType;
            var userShift = this.userShift;
            if (!(lastName && firstName && username && password && userType && userShift)) {
                this.message = "*Please complete all fields.";
            } else { // all fields entered. Register user.

                //encrypt password using "cryptoJS"
                var encryptedPass = CryptoJS.AES.encrypt(password, "fiu");
                var strPass = encryptedPass.toString();

                DataRequest.register(lastName, firstName, username, strPass, userType, userShift)
                        .then(function (data) {
                            if (data['username'] === null) {
                                $scope.message = "*Registration unsucessful. This username is already associated with another user.";
                            } else { //sucessful registration
                                confirm(data['username'] + " Sucesfully added.")
                                window.location.reload();
                            }
                        }, function (error) {
                            console.log("Error: " + error);
                        });
            }
        };
    }]);


