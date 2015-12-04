<?php
session_start();
$login_session = $_SESSION['user_Session'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script> <!--ANGULAR-->
        <script src="https://code.angularjs.org/1.2.28/angular-route.min.js"></script> <!--ROUTING-->

        <!-- jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"> <!-- CSS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> <!-- BOOTSTRAP's JS -->

        <!--UI_boostrap-->
        <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.4.js"></script>

        <!-- Admin CSS -->  
        <link type="text/css" rel="stylesheet" href="../css/admin.css"/>

        <!--CryptoJS-->
        <script src="../js/vendor/encryptor.js"></script>
        <!--Idle script-->
        <script src="../js/vendor/angular-idle.min.js"></script>

        <!--tables-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-smart-table/2.1.4/smart-table.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-smart-table/2.1.4/smart-table.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-smart-table/2.1.4/smart-table.min.js.map"></script>

    <body ng-app="adminModule" class="container">

        <br>
        <div ng-controller = "AdminController">
            <!--Nav-Bar containing all the options--> 
            <div class="navContainer" ng-init="start()">
                <div class="row">
                    <nav class="nav navbar-inverse navbar-static-top marginBottom-0" role="navigation">
                        <ul class="nav nav-pills">
                            <li ng-repeat="option in OptionsBar"
                                role="presentation"
                                ng-class="{ active: isActive('/')}">
                                <a href="#/{{option.url}}">{{option.name}}</a>
                            </li><!--
                            <!--dropdown Menu here-->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    More<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown dropdown-submenu">
                                        <a class="dropdown-toggle" data-toggle="dropdown">View as</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="./Admin_Profile.php#/">View As Administrator</a></li>
                                            <li><a href="./Supervisor_Profile.php   ">View As Supervisor</a></li>
                                            <li><a href="./Officer_Profile.php">View As Officer</a></li>
                                        </ul>
                                    </li>
                                    <li> 
                                        <span>
                                            <a href="logout.php" data-original-title="Log out" 
                                               data-toggle="tooltip" class="btn btn-sm btn-danger">
                                                <i class="glyphicon glyphicon-log-out"></i>
                                                Log out</a>
                                        </span>
                                    </li>
                                </ul>
                            </li> <!-- end of dropdown menu -->
                        </ul>
                    </nav>
                </div> <!-- Row -->
            </div> <!-- Container-->

            <br> 

            <ng-view></ng-view>

        </div> <!--CONTROLLER -->

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

        <br><br>


        <!--                <div id="profile">
                            <b id="welcome">Welcome : <i><?php echo $login_session; ?></i></b>
                            <br>
                        </div>-->
        <!--modules-->
        <script src="../js/app.js"></script> 
        <!--controllers-->
        <script src="../js/controllers/AdminController.js"></script>
        <!-- Services -->
        <script src = "../js/services/DataRequest.js"></script>
    </body>
</html>