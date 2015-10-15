<?php
session_start();
//echo $_SESSION["user_Session"];
//echo $_SESSION["user_Shift"];
?>
<!DOCTYPE html>
<html>
    <head>
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
    </head>
    <body ng-app="officerModule">

        <h1 class="customText">Officer Profile page.</h1>

        <div class="container"> 

            <br>
            <b><a style="float:  right" href="logout.php">Log Out</a></b>
            <div ng-controller="OfficerController">
                <div ng-init="start()"> <!-- Being monitoring Idle User-->
                    <div ng-init="retrieveTasks()"> <!-- Being retrieving tasks and monitor idle user-->
                        <section>
                            <h1 class="customText">Tasks</h1>
                            <div class="row">
                                <article class="4u" ng-repeat="t in tasks">
                                    <h5 class="customText">{{t.taskName}}</h5>
                                    <a class="image fit thumb" ng-click="retrieveDocs(t.taskName, 'C')">
                                        <img src="../img/taskBackground.jpg" alt="" />
                                    </a>
                                </article>
                            </div>
                        </section>
                    </div>
                    <ng-view></ng-view> <!-- Display documents of the tasks.-->
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

        <!--modules-->
        <script src="../js/app.js"></script> 
        <!--controllers-->
        <script src="../js/controllers/OfficerController.js"></script>
        <!-- Services -->
        <script src = "../js/services/DataRequest.js"></script>

        <!--<b id="welcome">Welcome : <i><?php // echo "Hello"              ?></i></b>-->
    </body>
</html>