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

        $stmt = $dbConn->prepare("SELECT username,password,userType"
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

        echo $lastName, $firstName, $username, $password, $userType, $userShift;

        if (!($stmt = $dbConn->prepare("INSERT INTO users(Last_Name,First_Name,Username,Password,userType,Shift) "
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
        // close connections.
        $dbConn->close();
        $stmt->close();
        return $result;
    }

    function getUsers() {
        global $dbConn;

        $users = [];
        if (!($stmt = $dbConn->prepare("SELECT * from users"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->execute()) {
//            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $result;
        }

        $stmt->bind_result($id, $lastName, $firstName, $username, $password, $type, $shift, $registrationDate);

        while ($stmt->fetch()) {
            // create an array with the record
            $tmp = ["id" => $id,
                "lastName" => $lastName,
                "firstName" => $firstName,
                "username" => $username,
                "password" => $password,
                "type" => $type,
                "shift" => $shift,
                "Registration" => $registrationDate];
            // push the record into the user
            array_push($users, $tmp);
        }
        return $users;
    }

    function getUser($id) {
        global $dbConn;
        $user = [
            "lastName" => NULL,
            "firstName" => NULL,
            "username" => NULL,
            "password" => NULL,
            "type" => NULL,
            "shift" => NULL,
            "Registration" => NULL];

        $query = "SELECT Last_Name,First_Name,Username,Password,userType,Shift,registrationDate "
                . "FROM users "
                . "WHERE id=?";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $user;
        }
        $stmt->bind_result($user["lastName"], $user["firstName"], $user["username"], $user["password"], $user["type"], $user["shift"], $user["Registration"]);

        // retrieve the record
        if (!$stmt->fetch()) {
            return $user;
        }
        $dbConn->close();
        $stmt->close();
        return $user;
    }

    function updateUser($id, $lastName, $firstName, $username, $password, $userType, $userShift) {

        global $dbConn;
        $result = ["response" => null];
        $query = "UPDATE users SET  "
                . "Last_Name=?,First_Name=?,Username=?,Password=?,userType=?,Shift=?"
                . " WHERE ID=?";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("sssssss", $lastName, $firstName, $username, $password, $userType, $userShift, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
//            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $result;
        }
        $result["response"] = 1;

        $dbConn->close();
        $stmt->close();
        return $result;
    }

}
