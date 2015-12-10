<?php

class DBHandler
{

    function __construct()
    {

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

    function loginUser($username)
    {
        global $dbConn;
        //store the result here
        $result = ["username" => NULL,
            "password" => NULL,
            "type" => NULL,
            "onlineStatus" => NULL,
            "shift" => NULL
        ];

        $stmt = $dbConn->prepare("SELECT username,password,userType,onlineStatus,shift"
            . " FROM users WHERE username=?");
        if (!$stmt) {
            return -1;
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $stmt->bind_result($result['username'], $result['password'], $result['type'], $result['onlineStatus'], $result['shift']);
        // no results found.
        if (!$stmt->fetch()) {
            return $result;
        }
        //close the statement.
        $stmt->close();

        if (!$result['onlineStatus']) { // mark user as logged in.
            $onlineStatus = 1;
            $this->changeOnlineStatus($username, $onlineStatus);
        }
        return $result;
    }

    // helper method to change the login status of a user.
    function changeOnlineStatus($username, $status)
    {
        global $dbConn;
        if (!($updateStatus = $dbConn->prepare("UPDATE users SET OnlineStatus = ? WHERE Username = ?"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$updateStatus->bind_param("ss", $status, $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$updateStatus->execute()) {
            echo "error executing: (" . $stmt->errno . ") " . $stmt->error;
        }
        //close connections.
        $updateStatus->close();
        $dbConn->close();
    }

    function addWatchOrder($address, $city, $zip, $state, $validDays, $description)
    {
        global $dbConn;
        $result = ["address" => NULL];
        if (!($stmt = $dbConn->prepare("INSERT INTO addresses(Address,City,State,ZIP,validDays,Description)"
            . "VALUES (?,?,?,?,?,?)"))
        ) {
            echo "Preparation of Address Statement Failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->bind_param("ssssis", $address, $city, $state, $zip, $validDays, $description)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            return $result;
        }
        $result['address'] = $address;
        $dbConn->close();
        $stmt->close();
        return $result;
    }

    function register($lastName, $firstName, $username, $password, $userType, $userShift)
    {
        global $dbConn;
        $result = ["username" => NULL];

        if (!($stmt = $dbConn->prepare("INSERT INTO users(Last_Name,First_Name,Username,Password,userType,Shift) "
            . "VALUES (?,?,?,?,?,?)"))
        ) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("ssssss", $lastName, $firstName, $username, $password, $userType, $userShift)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            return $result;
        }
        $result["username"] = $username;
        // close connections.
        $dbConn->close();
        $stmt->close();
        return $result;
    }

    function addTask($documentName, $userShift, $category)
    {
        global $dbConn;
        if (!($stmt = $dbConn->prepare("INSERT INTO documents(DocumentName, UserShift, Category) VALUES (?,?,?)"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->bind_param("sss", $documentName, $userShift, $category)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execution Failure";
        }
        // close connections.
        $dbConn->close();
        $stmt->close();
    }

    function pinTask($documentId)
    {
        global $dbConn;
        if (!($stmt = $dbConn->prepare("INSERT INTO pinneddocuments(DocumentId, UserId) VALUES (?,?)"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        $userId = 1;
        if (!$stmt->bind_param("ss", $documentId, $userId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execution Failure";
        }
        // close connections.
        $dbConn->close();
        $stmt->close();
    }

    function getPinnedTasks()
    {
        global $dbConn;

        $pinned = [];
        if (!($stmt = $dbConn->prepare("SELECT * from pinneddocuments"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->execute()) {
            return $result;
        }

        $stmt->bind_result($userId, $documentId, $dateCreated);
        while ($stmt->fetch()) {
            $tmp = [
                "username" => $userId,
                "timestamp" => $dateCreated,
                "documentId" => $documentId
            ];
            array_push($pinned, $tmp);
        }
//        foreach($pinned as $pin) {
//            if (!($DocStmt = $dbConn->prepare("SELECT documentName FROM documents WHERE id =?"))) {
//                echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
//            }
//            if (!$DocStmt->bind_param("s", $pin["documentId"])) {
//                echo "Binding parameters failed: (" . $DocStmt->errno . ") " . $DocStmt->error;
//            }
//            if (!$DocStmt->execute()) {
//                return $result;
//            }
//            $DocStmt->bind_result($documentName);
//            $DocStmt->fetch();
//            $pin["documentName"] = $documentName;
//
//        }
        $pinned = $this->fillDocumentName($pinned);
        return $pinned;
    }

    function fillDocumentName($pinned)
    {
        global $dbConn;
        if (!($DocStmt = $dbConn->prepare("SELECT documentName FROM documents WHERE id =?"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        $named = [];
        foreach ($pinned as $pin) {

            if (!$DocStmt->bind_param("s", $pin["documentId"])) {
                echo "Binding parameters failed: (" . $DocStmt->errno . ") " . $DocStmt->error;
            }
            if (!$DocStmt->execute()) {
                return $result;
            }
            $DocStmt->bind_result($documentName);
            $DocStmt->fetch();
            array_push($named, array(
                "username" => $pin['username'],
                "timestamp" => $pin['timestamp'],
                "documentId" => $pin['documentId'],
                "documentName" => $documentName
            ));

        }
        return $named;
    }

    function getUsers()
    {
        global $dbConn;

        $users = [];
        if (!($stmt = $dbConn->prepare("SELECT * from users"))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->execute()) {
            return $result;
        }

        $stmt->bind_result($id, $lastName, $firstName, $username, $password, $type, $shift, $registrationDate, $onlineStatus);

        while ($stmt->fetch()) {
            // create an array with the record
            $tmp = ["id" => $id,
                "lastName" => $lastName,
                "firstName" => $firstName,
                "username" => $username,
                "password" => $password,
                "type" => $type,
                "shift" => $shift,
                "Registration" => $registrationDate,
                "OnlineStatus" => $onlineStatus];
            // push the record into the user
            array_push($users, $tmp);
        }
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return $users;
    }

    function getUser($id)
    {
        global $dbConn;
        $user = [
            "lastName" => NULL,
            "firstName" => NULL,
            "username" => NULL,
            "password" => NULL,
            "type" => NULL,
            "shift" => NULL,
            "Registration" => NULL];

        $query = "SELECT Last_Name,First_Name,Username,Password,userType,Shift,RegistrationDate "
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

    function updateUser($id, $lastName, $firstName, $username, $password, $userType, $userShift)
    {

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
            return $result;
        }
        $result["response"] = 1;

        $dbConn->close();
        $stmt->close();
        return $result;
    }

    function removeUser($id)
    {
        global $dbConn;
        $result = ["response" => null];
        $query = "DELETE FROM users WHERE ID = ? ";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            return $result;
        }
        $result["response"] = "success";

        $dbConn->close();
        $stmt->close();
        return $result;
    }
    function removePin($documentId)
    {
        global $dbConn;
        $result = ["response" => null];
        $query = "DELETE FROM pinneddocuments WHERE documentId = ? ";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("s", $documentId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            return $result;
        }
        $result["documentId"] = $documentId;

        $dbConn->close();
        $stmt->close();
        return $result;
    }

    function retrieveDocs($taskType, $userShift)
    {
        global $dbConn;

        $docs = [];
        $query = "SELECT documentName,category from documents WHERE category =? AND (userShift =? OR userShift='d')";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("ss", $taskType, $userShift)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            return $docs;
        }

        $stmt->bind_result($docName, $category);

        while ($stmt->fetch()) {
            // create an array with the record
            $doc = ["docName" => $docName,
                "category" => $category
            ];
            // push the record into the user
            array_push($docs, $doc);
        }
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return $docs;
    }

    function getRecentlyAddedTasks()
    {
        global $dbConn;

        $docs = [];
        $query = "SELECT documentName,id,uploadDate, category, userShift from documents ORDER BY 'id' DESC ";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->execute()) {
            return $docs;
        }

        $stmt->bind_result($docName, $id, $uploadDate, $category, $userShift);

        for ($i = 0; $stmt->fetch() && $i < 50; $i++) {
            if((strcmp("D", $userShift)) == 0){
                $userShift = "All";
            }
            // create an array with the record
            $doc = ["documentName" => $docName,
                "documentId" => $id,
                "uploadDate" => $uploadDate,
                "category" => $category,
                "userShift" => $userShift
            ];
            // push the record into the user
            array_push($docs, $doc);
        }
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return $docs;
    }

    function retrieveCategories()
    {
        global $dbConn;

        $docs = [];
        $query = "SELECT categoryName FROM categories";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->execute()) {
            return $docs;
        }

        $stmt->bind_result($categoryName);

        while ($stmt->fetch()) {
            // create an array with the record
            $doc = ["categoryName" => $categoryName];
            // push the record into the user
            array_push($docs, $doc);
        }
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return $docs;
    }

    function addNewCategory($categoryName)
    {
        global $dbConn;

        $query = "INSERT into categories (categoryName) values(?)";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("s", $categoryName)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            return -1;
        }
        //create the directory
        mkdir("../uploads/" . $categoryName);
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return 0;
    }

    function retrieveAddresses()
    {

        global $dbConn;
        $watchOrders = [];
        $query = "SELECT address,city,state,zip,description "
            . "FROM addresses WHERE dateDiff(NOW(),addedDate) <= validDays";
        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->execute()) {
            return $watchOrders;
        }

        $stmt->bind_result($address, $city, $state, $zip, $description);

        while ($stmt->fetch()) {
            // create an array with the record
            $watchOrder = [
                "address" => $address,
                "city" => $city,
                "state" => $state,
                "zip" => $zip,
                "description" => $description
            ];
            // push the record into the list of watch orders
            array_push($watchOrders, $watchOrder);
        }
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return $watchOrders;
    }

    function logUserActivity($username, $viewTime, $document)
    {
        global $dbConn;

        $query = "INSERT into logs (username,viewingTime,documentName) values(?,?,?)";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }

        if (!$stmt->bind_param("sss", $username, $viewTime, $document)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            return -1;
        }
        // clean connections.
        $dbConn->close();
        $stmt->close();
        return 0;
    }

    function getUserLog($username)
    {
        global $dbConn;
        $userLogs = [];

        $query = "SELECT eventDay,viewingTime,documentName "
            . "FROM logs WHERE username=?";

        if (!($stmt = $dbConn->prepare($query))) {
            echo "Prepare failed: (" . $dbConn->errno . ") " . $dbConn->error;
        }
        if (!$stmt->bind_param("s", $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $userLogs;
        }

        $stmt->bind_result($eventDay, $viewingTime, $documentName);

        while ($stmt->fetch()) {
            $log = [
                "eventDay" => $eventDay,
                "viewingTime" => $viewingTime,
                "documentName" => $documentName
            ];
            // push the record
            array_push($userLogs, $log);
        }

        // clean connections.
        $dbConn->close();
        $stmt->close();
        return $userLogs;
    }

}
