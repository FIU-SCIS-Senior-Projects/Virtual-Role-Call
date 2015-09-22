<?php
session_start();
$login_session = $_SESSION['user_Session'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>

        <!--ANGULAR-->
        <script src="../js/vendor/angular.min.js"></script> 
        <script src="https://code.angularjs.org/1.2.28/angular-route.min.js"></script> <!--ROUTING-->

        <!-- jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- CSS -->  
        <link type="text/css" rel="stylesheet" href="../css/admin.css"/>

        <!--CryptoJS-->
        <script src="../js/vendor/encryptor.js"></script>

    </head>
    <body ng-app="VRC_App" class="container">

        <br>
        <div ng-controller = "AdminController">
            <!--Nav-Bar containing all the options -->
            <div class="navContainer">
                <div class="row">
                    <nav class="nav navbar-inverse navbar-static-top marginBottom-0" role="navigation">
                        <ul class="nav nav-pills">
                            <li ng-repeat="option in OptionsBar"
                                role="presentation"
                                ng-class="{ active: isActive('/')}">
                                <a href="#/{{option.url}}">{{option.name}}</a>
                            </li>
                            <!--dropdown Menu here-->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    More<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown dropdown-submenu">
                                        <a class="dropdown-toggle" data-toggle="dropdown">View as</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="./Admin_Profile.php#/">View As Administrator</a></li>
                                            <li><a href="#/Supervisor">View As Supervisor</a></li>
                                            <li><a href="#/Officer">View As Officer</a></li>
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
                            </li>
                        </ul>
                    </nav>
                </div> <!-- Row -->
            </div> <!-- Container-->

            <br> 

            <ng-view></ng-view>

        </div> <!--CONTROLLER -->

        <br><br>
        <p style="float: right">&copy; 2015 Pinecrest PD. All rights reserved.<p>

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