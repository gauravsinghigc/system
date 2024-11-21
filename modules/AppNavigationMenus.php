<?php

//main header navigation menus
DEFINE("NAVIGATION_MENUS",  [
    "Home" => [
        "url" => DOMAIN . "/app",
        "icon" => "home",
        "title" => "Dashboard",
        "counts" => "0"
    ],
    "users" => [
        "url" => DOMAIN . "/app/users",
        "icon" => "briefcase",
        "title" => "All Users",
        "counts" => "0"
    ],
    "Profile" => [
        "url" => DOMAIN . "/app/profile",
        "icon" => "user",
        "title" => "Profile",
        "counts" => "0"
    ],
    "settings" => [
        "url" => DOMAIN . "/app/settings",
        "icon" => "gears",
        "title" => "Settings",
        "counts" => "0"
    ],
    "Logout" => [
        "url" => DOMAIN . "/auth/logout",
        "icon" => "sign-out",
        "title" => "Logout",
        "counts" => "0"
    ]
]);

//Login Menus and login forms
define("LOGIN_FORMS", [
    "LoginForm" => "LoginForm.php",
    "ForgetForm" => "ForgetForm.php",
    "ResetPassword" => "ResetPasswordForm.php",
    "VerifyAccount" => "VerifyAccount.php"
]);
