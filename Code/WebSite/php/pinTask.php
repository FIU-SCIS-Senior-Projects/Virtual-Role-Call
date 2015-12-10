<?php
require_once('DbHandler.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
var_dump($request);
$documentId = $request->documentId;
$connection = new DBHandler();
$res = $connection->pinTask($documentId);
die(json_encode($res));
