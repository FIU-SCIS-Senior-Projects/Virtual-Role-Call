<?php

require_once('DbHandler.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$categoryName = $request->category;

$connection = new DBHandler();
$res = $connection->addNewCategory($categoryName);
//convert the response to a json object
die(json_encode($res));
