<?php
require_once('DbHandler.php');

$documentId = $_POST["documentId"];
$connection = new DBHandler();
$res = $connection->pinTask($documentId);
header("Location: http://localhost/vrc/php/Supervisor_Profile.php",TRUE,303);