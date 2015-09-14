<?php
$login_session = 'Frank';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Your Home Page</title>
        <!--<link type="text/css" rel="stylesheet" href="css/admin.css"/>-->
        <script src="../js/vendor/angular.min.js"></script>
        <script src="https://code.angularjs.org/1.2.28/angular-route.min.js"></script>
    </head>
    <body ng-app="VRC_App">

        <h1>THIS IS AN Officer PAGE.</h1>

        <div id="profile">
            <b id="welcome">Welcome : <i><?php echo "Hello" ?></i></b>
            <br>
            <b id="logout"><a href="logout.php">Log Out</a></b>
        </div>

        <script src="../js/app.js"></script>
        <script src="../js/controllers/AdminController.js"></script>
    </body>
</html>