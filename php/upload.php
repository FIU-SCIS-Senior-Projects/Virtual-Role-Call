<?php

require_once('DbHandler.php');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$userShift = $request->userShift;
$category = $request->category;
//Save uploaded File.
$tmpFileName = $_FILES['task']['tmp_name'];
$documentName = $_FILES['task']['name'];
$targetPath = 'uploads/'.$category.'/'.$documentName;
if (move_uploaded_file($tmpFileName, $targetPath)) {
    echo "The file ". basename($tmpFileName). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}
//Updating Database
$connection = new DBHandler();
$res = $connection->addDocument($documentName,$userShift,$category);
