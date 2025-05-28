<?php

//app constant
define("APP_URL", DOMAIN . "/app");
define("STORAGE_URL", DOMAIN . "/storage");
define("STORAGE_URL_D", DOMAIN . "/storage/default");
define("STORAGE_URL_U", DOMAIN . "/storage/users");
define("AUTH_URL", DOMAIN . "/auth");
define("CONTROLLER", DOMAIN . "/handler");
define("ASSETS_URL", DOMAIN . "/assets");

//Company Profile
define("APP_NAME", CONFIG("APP_NAME"));
define("APP_LOGO", STORAGE_URL . "/logo/" . CONFIG("APP_LOGO"));
define("LISTING_TYPES", CONFIG("LISTING_TYPES"));
define("TAGLINE", CONFIG("TAGLINE"));
define("OWNER_NAME", CONFIG("OWNER_NAME"));
define("PRIMARY_PHONE", CONFIG("PRIMARY_PHONE"));
define("PRIMARY_EMAIL", CONFIG("PRIMARY_EMAIL"));
define("SHORT_DESCRIPTION", CONFIG("SHORT_DESCRIPTION"));
define("PRIMARY_ADDRESS", CONFIG("PRIMARY_ADDRESS"));

//mail id's setups
define("SUPPORT_MAIL", CONFIG("SUPPORT_MAIL"));
define("ENQUIRY_MAIL", CONFIG("ENQUIRY_MAIL"));

//Controll activity or die activities, function 
define("CONTROL_WORK_ENV", CONFIG("CONTROL_WORK_ENV"));
define("CONTROL_SMS", CONFIG("CONTROL_SMS"));
define("CONTROL_MAILS", CONFIG("CONTROL_MAILS"));
define("CONTROL_APP_LOGS", CONFIG("CONTROL_APP_LOGS"));
define("DEFAULT_RECORD_LISTING", CONFIG("DEFAULT_RECORD_LISTING"));
define("APP_RECORD_LISTING", 15);
if (isset($_GET["MAX_UPLOAD"])) {
    $_SESSION['MAX_UPLOAD'] = $_GET["MAX_UPLOAD"];
} else {
    if (isset($_SESSION['MAX_UPLOAD'])) {
        if (isset($_GET["MAX_UPLOAD"])) {
            $_SESSION['MAX_UPLOAD'] = $_GET["MAX_UPLOAD"];
        } else {
            $_SESSION['MAX_UPLOAD'] = $_SESSION['MAX_UPLOAD'];
        }
    } else {
        if (isset($_GET["MAX_UPLOAD"])) {
            $_SESSION['MAX_UPLOAD'] = $_GET["MAX_UPLOAD"];
        } else {
            $_SESSION['MAX_UPLOAD'] = 50000;
        }
    }
}
define("MAX_NUMBER_OF_UPLOADING_RECODS", $_SESSION['MAX_UPLOAD']);
define("SERVER_DOWN_CONTROL", CONFIG("SERVER_DOWN_CONTROL"));
define("INTERNAL_CHAT_APP", CONFIG("INTERNAL_CHAT_APP"));
define("TYPE_OF_CLOSING", CONFIG("TYPE_OF_CLOSING"));
define("TYPE_OF_RECORDS", CONFIG("TYPE_OF_RECORDS"));
define("TYPES_OF_USERS", CONFIG("TYPES_OF_USERS"));

//default variables
define("DEFAULT_USER_ICON", STORAGE_URL_D . "/default/default.png");

//message variables
define("CONTROL_NOTIFICATION", CONFIG("CONTROL_NOTIFICATION"));
if (CONTROL_WORK_ENV == "PROD") {
    define("CONTROL_MSG_DISPLAY_TIME", CONFIG("CONTROL_MSG_DISPLAY_TIME"));
} else {
    define("CONTROL_MSG_DISPLAY_TIME", 5000); // 1 minute
}
define("CONTROL_NOTIFICATION_SOUND", CONFIG("CONTROL_NOTIFICATION_SOUND"));

//HR configuration variables
DEFINE("OFFICE_START_TIME", CONFIG("OFFICE_START_TIME"));
DEFINE("OFFICE_LUNCH_TIME", CONFIG("OFFICE_LUNCH_TIME"));
define("OFFICE_END_TIME", CONFIG("OFFICE_END_TIME"));
define("WEEKLY_OFF_DAY", CONFIG("WEEKLY_OFF_DAY"));
define("OFFICE_LUNCH_END_TIME", CONFIG("OFFICE_LUNCH_END_TIME"));
