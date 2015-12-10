<?php

require_once('DbHandler.php');
session_start();
if (session_destroy()) { // Destroying user Sessions
    // get the user.
    $user = $_SESSION['user_Session'];
    $status = 0;
    $connection = new DBHandler();
    $res = $connection->changeOnlineStatus($user, $status);
    header("Location: ../index.html"); // Redirecting To sign in Page
}
?>