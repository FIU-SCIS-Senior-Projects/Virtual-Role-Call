<?php

require_once('DbHandler.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$id = $request->id;

$connection = new DBHandler();
$res = $connection->removeUser($id);
//convert the response to a json object
die(json_encode($res));

