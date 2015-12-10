<?php

require_once('DbHandler.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$taskType = $request->taskType;
$shift = $request->shift;

$connection = new DBHandler();
$res = $connection->retrieveDocs($taskType, $shift);
//convert the response to a json object
die(json_encode($res));
