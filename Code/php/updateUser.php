<?php

require_once('DbHandler.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$id = $request->id;
$lastName = $request->lastName;
$firstName = $request->firstName;
$username = $request->username;
$password = $request->password;
$userType = $request->userType;
$userShift = $request->userShift;

//var_dump($id . " " . $lastName . " " . $firstName . " " . $username . " " . $password . " " . $userType . " " . $userShift);
$connection = new DBHandler();
$res = $connection->updateUser($id, $lastName, $firstName, $username, $password, $userType, $userShift);
//convert the response to a json object
die(json_encode($res));
