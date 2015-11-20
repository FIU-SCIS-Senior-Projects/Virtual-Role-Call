<?php

require_once('DbHandler.php');

$postdata = file_get_contents("php://input");
$req = json_decode($postdata);
$address = $req->address;
$city = $req->city;
$zip = $req->zip;
$state = $req->state;
$validDays = $req->validDays;
$description = $req->description;

$connection = new DBHandler();
$res = $connection->addWatchOrder($address, $city, $zip, $state, $validDays, $description);
die(json_encode($res));

