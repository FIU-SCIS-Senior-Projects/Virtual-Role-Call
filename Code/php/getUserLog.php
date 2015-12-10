<?php

require_once('DbHandler.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$username = $request->username;

$connection = new DBHandler();
$res = $connection->getUserLog($username);
//convert the response to a json object
die(json_encode($res));


