<?php

class DBHandler {

    function __construct() {

        global $dbConn;
//        $contents = file_get_contents("../../../dbCredentials");
//        $config = json_decode($contents);
        $uname = "root";
        $pw = "";
        $dbname = "vrc_db";
        $dbAddress = "localhost";
        $dbConn = new mysqli($dbAddress, $uname, $pw, $dbname);
        if ($dbConn->connect_errno > 0) {
            die("Unable to connect to database[" . $dbConn->connect_error . "]");
        }
    }

    function loginUser($username) {
        global $dbConn;
        //store the result here
        $result = ["username" => NULL,
            "password" => NULL,
            "type" => NULL];

        $stmt = $dbConn->prepare("SELECT username,password,type"
                . " FROM users WHERE username=?");
        if (!$stmt) {
            return -1;
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $stmt->bind_result($result["username"], $result['password'], $result["type"]);
        // no results found.
        if (!$stmt->fetch()) {
            return $result;
        }
        // close connections.
        $dbConn->close();
        $stmt->close();
        return $result;
    }

    function register($lastName, $firstName, $username, $password, $userType, $userShift) {
        global $dbConn;
        $result = ["username" => NULL];

        if (!($stmt = $dbConn->prepare("INSERT INTO users(Last_Name,First_Name,Username,Password,Type,Shift) "
                . "VALUES (?,?,?,?,?,?)"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("ssssss", $lastName, $firstName, $username, $password, $userType, $userShift)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
//            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $result;
        }
        $result["username"] = $username;
        return $result;
    }

}
