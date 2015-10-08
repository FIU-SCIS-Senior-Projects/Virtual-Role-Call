
/* global admin */
//decryption
//            var decdrypted = CryptoJS.AES.decrypt(encryptedPass, "fiu");
//            console.log("decrypted", CryptoJS.enc.Latin1.stringify(decrypted));

admin.controller('AdminController', ['$scope', 'DataRequest', '$window', '$routeParams', 'Idle', '$modal',
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


        //display message through a modal.
        function displayMessage(message) {
            $scope.message = message;
            $scope.msgModal = $modal.open({
                templateUrl: 'notification.html',
                windowClass: 'modal-danger',
                scope: $scope
            });
        }
//      **************** monitoring idle user ************ ****

        $scope.started = false;
        // close modals.
        function closeModals() {
            if ($scope.warning) {
                $scope.warning.close(); // close the warning modal
                $scope.warning = null;
            }
            if ($scope.msgModal) {
                $scope.msgModal.close();
                $scope.msgModal = null;
            }
        }

        // user has been idle for too long. Prompt message.
        $scope.$on('IdleStart', function () {
            closeModals();
            $scope.warning = $modal.open({
                templateUrl: 'warning-dialog.html',
                windowClass: 'modal-danger'
            });
        });
        // idle warning time has ended. close the notificatoin modal.
        $scope.$on('IdleEnd', function () {
            closeModals();
        });
        // idle timeout. sign user out.
        $scope.$on('IdleTimeout', function () { // Timed out.
            closeModals();
            window.location.href = "../php/logout.php";  //Log the user out.
        });
        // begin idle time monitoring.
        $scope.start = function () {
            closeModals();
            Idle.watch(); // begin monitoring.
            $scope.started = true;
        };
//  ****************************************************************

        // get the register users and populate the table
        $scope.retrieveUsers = function () {

            DataRequest.getRegisteredUsers().then(function (data) {
                var list = [];
                for (var x in data) {
                    var status;
                    data[x].OnlineStatus ? status = "../img/online.ico" : status = "../img/offline.ico";

                    var tmp = new Object();

                    tmp.id = data[x].id;
                    tmp.lastName = data[x].lastName;
                    tmp.firstName = data[x].firstName;
                    tmp.username = data[x].username;
                    tmp.type = data[x].type;
                    tmp.shift = data[x].shift;
                    tmp.status = status;
                    // add the object to the list.
                    list.push(tmp);
                }
                $scope.users = list;
            }
            , function (error) {
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
                displayMessage("*Please complete all fields.");

            } else { // all fields entered. Register user.

                //encrypt password using "cryptoJS"
                var encryptedPass = CryptoJS.AES.encrypt(password, "fiu");
                var strPass = encryptedPass.toString();
                DataRequest.register(lastName, firstName, username, strPass, userType, userShift)
                        .then(function (data) {

                            if (data['username'] === null) {
                                displayMessage("*This username is already associated with another user.");
                            } else { //sucessful registration
                                displayMessage(username + " has been sucessfully registered.");
                                //wait 2 seconds.
                                setTimeout(function () {
                                    //reload page after 2 seconds of sucessul registration.
                                    window.location.reload();
                                }, 2000);
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
                    console.log("Error", "This user does not exist.");
                } else {   // populate the form with the user's data.
                    $scope.lName = data.lastName;
                    $scope.fName = data.firstName;
                    $scope.uName = data.username;
                    //decrypt password before showin in form.
                    $scope.userPass = CryptoJS.enc.Latin1.stringify(CryptoJS.AES.decrypt(data.password, "fiu"));
                    $scope.uType = data.type;
                    $scope.uShift = data.shift;
                    $scope.regDate = data.Registration;
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
                                displayMessage("*This username already belongs to another user.");
                            } else {
                                displayMessage("User has been updated.");
                                setTimeout(function () {
                                    closeModals();
                                    //redirect back to the users list after 2 seconds of sucessul editing user.
                                    window.location.href = "#/editUser";
                                }, 1500);
                            }
                        }, function (error) {
                            console.log("Error: " + error);
                        });
            }
        };

        $scope.removeUser = function () {
            DataRequest.removeUser($routeParams.id)
                    .then(function (data) {
                        if (data.response === "success") {
                            displayMessage("User sucessfully removed.");
                            setTimeout(function () {
                                closeModals();
                                //redirect back to the users list after 2 seconds of sucessul editing user.
                                window.location.href = "#/editUser";
                            }, 1500);
                        }
                    }, function (error) {
                        console.log("Error: " + error);
                    });
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


