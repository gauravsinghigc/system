<?php
//module
require '../../acm/SysFileAutoLoader.php';
require "../../handler/AuthController/AuthAccessController.php";

$UserId = $_SESSION['APP_LOGIN_USER_ID'];
// Properly expire the cookie
if (isset($_COOKIE['LOGIN_USER_ID'])) {
    setcookie("LOGIN_USER_ID", "", time() - 3600, "/", "", false, false); // Path set, secure flags applied
}

session_destroy(); // Destroy the session
session_unset(); // Unset all session variables

// Optionally force expire by resetting it
setcookie("LOGIN_USER_ID", '', time() - 3600, '/', '', false, false);

LOCATION("info", "Logout Successfully!", DOMAIN . "/auth/login");
