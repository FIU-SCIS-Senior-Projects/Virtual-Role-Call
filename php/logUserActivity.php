<?php

require_once('DbHandler.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$username = $request->username;
$viewingTime = $request->viewingTime;
$document = $request->document;

$connection = new DBHandler();
$res = $connection->logUserActivity($username, $viewingTime, $document);
//convert the response to a json object
die(json_encode($res));

