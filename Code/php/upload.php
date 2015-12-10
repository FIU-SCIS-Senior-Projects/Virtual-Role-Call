<?php

require_once('DbHandler.php');
$ds = DIRECTORY_SEPARATOR;
$userShift = $_POST['userShift'];
$category = $_POST['category'];
//Save uploaded File.
$tmpFileName = $_FILES['task']['tmp_name'];
$documentName = $_FILES['task']['name'];
$targetPath = __DIR__.$ds.'..'.$ds.'uploads'.$ds.$category.$ds.$documentName;
echo $targetPath;
if (move_uploaded_file($tmpFileName, $targetPath)) {
    echo "The file ". basename($tmpFileName). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}
//Updating Database
$connection = new DBHandler();
$res = $connection->addTask($documentName,$userShift,$category);
//!!!!!IMPORTANT CHANGE TO RELEVANT URL !!!!!!
header("Location: http://localhost/vrc/php/Supervisor_Profile.php",TRUE,303);
