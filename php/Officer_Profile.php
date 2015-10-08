<?php
//$login_session = 'Frank';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Officer Home Page</title>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script> <!--ANGULAR-->
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

        <h1 id="customText">Officer Profile page.</h1>

        <div class="container">
            <!--<b id="welcome">Welcome : <i><?php // echo "Hello"    ?></i></b>-->
            <!--<br>-->

            <section ng-controller="OfficerController">
                <h1 id="customText">Tasks</h1>
                <div class="row">
                    <article class="4u" ng-repeat="t in tasks">
                        <h2 id="customText">{{t.taskName}}</h2>
                        <a href="{{t.url}}" class="image fit thumb">
                            <img src="../img/taskBackground.jpg" alt="" />
                        </a>
                    </article>
                </div>
            </section>

            <b id="logout"><a href="logout.php">Log Out</a></b>
        </div>

        <script src="../js/app.js"></script>
        <script src="../js/controllers/OfficerController.js"></script>
    </body>
</html>