<?php

require_once('DbHandler.php');
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$documentName = $request->documentName;
$userShift = $request->userShift;
$Category = $request->category;

$connection = new DBHandler();
$res = $connection->addDocument($documentName,$userShift,$category);