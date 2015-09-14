<?php
session_start();
$login_session = $_SESSION['user_Session'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <!-- CSS -->  
        <link type="text/css" rel="stylesheet" href="../css/admin.css"/>

        <!--ANGULAR-->
        <script src="../js/vendor/angular.min.js"></script> 
        <script src="https://code.angularjs.org/1.2.28/angular-route.min.js"></script> <!--ROUTING-->

        <!-- jquery-->
        <script src="//code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>

        <!-- boostrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!--CryptoJS-->
        <script src="../js/vendor/encryptor.js"></script>

    </head>
    <body ng-app="VRC_App" class="container">

        <br>
        <div ng-controller = "AdminController">
            <!--Nav-Bar containing all the options -->
            <div class="navContainer">
                <div class="row">
                    <nav class="nav navbar-nav">
                        <ul class="nav nav-pills">
                            <li ng-repeat="option in OptionsBar"
                                role="presentation"
                                ng-class="{ active: isActive('/')}">
                                <a href="#/{{option.url}}">{{option.name}}</a>
                            </li>
                            <li> 
                                <a href="logout.php">Log Out</a> 
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <br> 

            <ng-view></ng-view>

        </div> <!--CONTROLLER -->


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