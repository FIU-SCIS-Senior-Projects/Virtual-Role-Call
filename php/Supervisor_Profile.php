<?php

$login_session = 'Frank';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Your Home Page</title>
        <!--<link type="text/css" rel="stylesheet" href="css/admin.css"/>-->
    </head>
    <body>
        
        <h1>THIS IS A SUPERVISOR PAGE.</h1>
        <div id="profile">
            <b id="welcome">Welcome : <i><?php echo $login_session; ?></i></b>
            <br>
            <b id="logout"><a href="logout.php">Log Out</a></b>
        </div>
    </body>
</html>