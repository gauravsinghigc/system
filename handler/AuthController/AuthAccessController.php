<?php
// Restore session from cookie if session is empty
if (isset($_COOKIE['LOGIN_USER_ID'])) {
    $_SESSION['APP_LOGIN_USER_ID'] = $_COOKIE['LOGIN_USER_ID'];
}

// If still not logged in, redirect to login
if (!isset($_SESSION['APP_LOGIN_USER_ID'])) {
    header("location:" . DOMAIN . "/auth/");
    exit;
} else {
    define("LOGIN_USER_ID", $_SESSION['APP_LOGIN_USER_ID']);
}
