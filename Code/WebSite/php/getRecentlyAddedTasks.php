<?php
require_once('DbHandler.php');

$connection = new DBHandler();
$res = $connection->getRecentlyAddedTasks();
//convert the response to a json object
die(json_encode($res));