<?php

require_once('DbHandler.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$lastName = $request->lastName;
$firstName = $request->firstName;
$username = $request->username;
$password = $request->password;
$userType = $request->userType;
$userShift = $request->userShift;

$connection = new DBHandler();
$res = $connection->register($lastName, $firstName, $username, $password, $userType, $userShift);
//convert the response to a json object
die(json_encode($res));
