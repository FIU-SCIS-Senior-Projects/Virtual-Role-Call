<?php
require_once('DbHandler.php');

$connection = new DBHandler();
$res = $connection->getPinnedTasks();
//convert the response to a json object
die(json_encode($res));

