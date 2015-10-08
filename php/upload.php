<?php

require_once('DbHandler.php');
$userShift = $_POST["userShift"];
$target_dir = "../uploads/";
$uploadedFileName = $target_dir . basename($_FILES["task"]["name"]);

$uploadResult = move_uploaded_file($_FILES["task"]["tmp_name"], $uploadedFileName);
$conn = new DBHandler();

$result = $conn->addDocument($uploadedFileName, $userShift);

?>