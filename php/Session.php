
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->

<?php
session_start();
$params = $_GET ? : $_POST;
$username = $params['username'];
$userType = $params['type'];
$userShift = $params['shift'];

// Force users to have a single sign in within the same browser.
//if ($_SESSION["user_Session"] === $username) {
?>

<!--Send user back to login page by catching the event with jquery-->
<!--    <script>
    window.alert = function (al, $) {
        return function (msg) {
            al(msg);
            $(window).trigger("okbuttonclicked");
        };
    }(window.alert, window.jQuery);
    $(window).on("okbuttonclicked", function () {
        window.location.href = "../index.html";
    });
    alert("You are already logged in");
</script>-->
<?php
//    exit;
//}
// Redirect user to their page using their credentials.
switch ($userType) {
    case "Officer":
        $_SESSION["user_Session"] = $username;
        $_SESSION["user_Shift"] = $userShift;
        header("location: Officer_Profile.php");
        break;
    case "Supervisor" :
        $_SESSION["user_Session"] = $username;
        $_SESSION["user_Shift"] = $userShift;
        header("location: Supervisor_Profile.php");
        break;
    case "Administrator":
        $_SESSION["user_Session"] = $username;
        $_SESSION["user_Shift"] = $userShift;
        header("location: Admin_Profile.php");
        break;
}

