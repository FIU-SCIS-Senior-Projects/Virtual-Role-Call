
/* global app */
//decryption
//            var decrypted = CryptoJS.AES.decrypt(encryptedPass, "fiu");
//            console.log("decrypted", CryptoJS.enc.Latin1.stringify(decrypted));

app.controller('AdminController', ['$scope', 'DataRequest', '$window', '$routeParams', 'Idle', '$modal',
    function ($scope, DataRequest, window, $routeParams, Idle, $modal) {

        //Admin options
        $scope.OptionsBar = [
            {name: 'Register User', url: 'register'},
            {name: 'Edit/view userInfo', url: 'editUser'},
            {name: 'Edit Archives', url: 'editArchive'},
            {name: 'Add new Task type', url: 'newTask'},
            {name: 'View Logs', url: 'viewLogs'}
        ];
        // For toggling the submenu (view as) for admin
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

//      **************** monitoring idle user ************ ****

        $scope.started = false;
        function closeModals() {
            if ($scope.warning) {
                $scope.warning.close(); // close the warning modal
                $scope.warning = null;
            }

            if ($scope.timedout) {
                $scope.timedout.close();
                $scope.timedout = null;
            }
        }

        $scope.$on('IdleStart', function () {
            closeModals();
            $scope.warning = $modal.open({
                templateUrl: 'warning-dialog.html',
                windowClass: 'modal-danger'
            });
        });

        $scope.$on('IdleEnd', function () {
            closeModals();
        });

        $scope.$on('IdleTimeout', function () { // Timed out.
            closeModals();
            window.location.href = "../php/logout.php";  //Log the user out.
        });

        $scope.start = function () {
            closeModals();
            Idle.watch(); // begin monitoring.
            $scope.started = true;
        };
//  ****************************************************************

        // get the register users and populate the table
        $scope.retrieveUsers = function () {
            DataRequest.getRegisteredUsers().then(function (data) {
                $scope.users = data;
            }, function (error) {
                console.log("Error: " + error);
            });
        };

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
//                                confirm(data['username'] + " Sucesfully added.");
                                confirm("User Sucessfully Added");
                                window.location.reload();
                            }
                        }, function (error) {
                            console.log("Error: " + error);
                        });
            }
        };

        // Populates the Details form when editing a user.
        $scope.getUserInfo = function () {
            var id = Number($routeParams.id); // user to find. cast into an int

            DataRequest.getUser(id).then(function (data) {
                // The id entered does not match any records
                if (data.lastName === null) {
                    console.log("Error", "This user does not exist");
                } else {   // populate the form with the user's data.
                    $scope.lName = data.lastName;
                    $scope.fName = data.firstName;
                    $scope.uName = data.username;
                    //decrypt password before showin in form.
                    $scope.userPass = CryptoJS.enc.Latin1.stringify(CryptoJS.AES.decrypt(data.password, "fiu"));
                    $scope.uType = data.type;
                    $scope.uShift = data.shift;
                }
            }, function (error) {
                console.log("Error: " + error);
            });
        };

        // saves updated info when editing user.
        $scope.save = function () {

            if (!(this.lName && this.uName && this.userPass && this.uType && this.uShift)) {
                $scope.message = "*Please complete all fields.";
            } else {
                // all data is entered. Proceed with the update.
                var id = Number($routeParams.id);
                //encrypt password before storing in database during update.
                var encryptedPass = CryptoJS.AES.encrypt(this.userPass, "fiu");
                var strPass = encryptedPass.toString();
                // make a request to store the data during the update.

                DataRequest.save(id, this.lName, this.fName, this.uName,
                        strPass, this.uType, this.uShift)
                        .then(function (data) {

                            if (data.response === null) { // unsucessful update
                                $scope.message = "*This username already belongs to another user";
                            } else {
                                confirm("User has been updated");
                                //redirect back to the users list.
                                window.location.href = "#/editUser";
                            }
                        }, function (error) {
                            console.log("Error: " + error);
                        });
            }
        };
//        function setTableBackground() {
//            console.log("IM here");
//            console.log(document);
////            if (document.getElementsByTagName) {
//            var table = document.getElementById("usersTable");
//            console.log(table);
//            var rows = table.getElementsByTagName("tr");
//
//            for (i = 0; i < rows.length; i++) {
//                //manipulate rows 
//
//                if (i % 2 === 0) {
//                    console.log("im even");
//                    rows[i].style.backgroundColor = "red";
//                } else {
//                    rows[i].style.backgroundColor = "blue";
//                }
//            }
//        }
//        }

    }]);


