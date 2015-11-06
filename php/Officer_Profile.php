
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Officer Home Page</title>

        <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script> <!--ANGULAR-->
        <script src="https://code.angularjs.org/1.2.28/angular-route.min.js"></script> <!--ROUTING-->

        <!-- jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> <!-- CSS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> <!-- BOOTSTRAP's JS -->

        <!--UI_boostrap-->
        <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.4.js"></script>

        <!-- Officer CSS -->  
        <link type="text/css" rel="stylesheet" href="../css/officer.css"/>

        <!--Idle script-->
        <script src="../js/vendor/angular-idle.min.js"></script>

        <!-- Google maps -->
        <script src="https://maps.google.com/maps/api/js?sensor=false"></script>
    </head>
    <body ng-app="officerModule">

        <!--get the officer's shift stored in the session variable-->
        <input type="hidden" id="officerShift" 
               value="<?php
               session_start();
               echo $_SESSION['user_Shift'];
               ?>"/>

        <h1 class="customText">Virtual Roll Call</h1>

        <div class="container"> 

            <br>
            <a href="logout.php"  class="exit-btn exit-btn-2" >Log out </a>

            <div ng-controller="OfficerController">
                <div ng-init="start()"> <!-- Being monitoring Idle User-->

                    <ng-view></ng-view> 
                </div> <!-- Idle user -->
            </div> 
        </div> <!-- Container -->


        <!--This modal will be displayed if the user is idle for too long.-->
        <script type="text/ng-template" id="warning-dialog.html">
            <div class="modal-header">
            <h3>You have been idle for too long. You will be logged out!</h3>
            </div>
            <div idle-countdown="countdown" ng-init="countdown = 5" class="modal-body">
            <progressbar max="5" value="5" animate="false" class="progress-striped active">
            You'll be logged out in {{countdown}} second(s).
            </progressbar>
            </div>
        </script>        

        <!--this modal is used for notification purposes-->
        <script type="text/ng-template" id="notification.html">
            <div class="modal-content">              
            <div class="modal-body">
            <h3>Information</h3>
            <h4 style="color:red; text-align:center">{{message}}</h4>
            </div>       
            </div>
        </script>

        <!--modules-->
        <script src="../js/app.js"></script> 
        <!--controllers-->
        <script src="../js/controllers/OfficerController.js"></script>
        <!-- Services -->
        <script src = "../js/services/DataRequest.js"></script>

    </body>
</html>