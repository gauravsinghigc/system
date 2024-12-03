<?php

//main header navigation menus
DEFINE("NAVIGATION_MENUS",  [
    "Home" => [
        "url" => DOMAIN . "/app",
        "icon" => "home",
        "title" => "Dashboard",
        "counts" => "0"
    ],
    "Customers" => [
        "url" => DOMAIN . "/app/customers",
        "icon" => "users",
        "title" => "Customers",
        "counts" => "0"
    ],
    "Projects" => [
        "url" => DOMAIN . "/app/projects",
        "icon" => "table",
        "title" => "Projects",
        "counts" => "0"
    ],
    "Tasks" => [
        "url" => DOMAIN . "/app/tasks",
        "icon" => "tasks",
        "title" => "Tasks",
        "counts" => "0"
    ],
    "Invoices" => [
        "url" => DOMAIN . "/app/invoices",
        "icon" => "file-pdf-o",
        "title" => "Invoices",
        "counts" => "0"
    ],
    "Payments" => [
        "url" => DOMAIN . "/app/payments",
        "icon" => "inr",
        "title" => "Payments",
        "counts" => "0"
    ],
    "Expanses" => [
        "url" => DOMAIN . "/app/expanses",
        "icon" => "exchange",
        "title" => "Expanses",
        "counts" => "0"
    ],
    "FuelExpanses" => [
        "url" => DOMAIN . "/app/expanses/fuel",
        "icon" => "gas-pump",
        "title" => "Fuel Fillings",
        "counts" => "0"
    ],
    "Domains" => [
        "url" => DOMAIN . "/app/domains",
        "icon" => "globe",
        "title" => "Domains",
        "counts" => "0"
    ],
    "Credentials" => [
        "url" => DOMAIN . "/app/credentials",
        "icon" => "key",
        "title" => "Credentials",
        "counts" => "0"
    ],
    "Subscriptions" => [
        "url" => DOMAIN . "/app/subscriptions",
        "icon" => "refresh",
        "title" => "Subscriptions",
        "counts" => "0"
    ],
    "Reminders" => [
        "url" => DOMAIN . "/app/reminders",
        "icon" => "bell",
        "title" => "Reminders",
        "counts" => "0"
    ],
    "UseFullLinks" => [
        "url" => DOMAIN . "/app/usefulllinks",
        "icon" => "link",
        "title" => "Usefull Urls",
        "counts" => "0"
    ],
    "YoutubeLinks" => [
        "url" => DOMAIN . "/app/youtube",
        "icon" => "video",
        "title" => "Youtube Links",
        "counts" => "0"
    ],
    "users" => [
        "url" => DOMAIN . "/app/users",
        "icon" => "briefcase",
        "title" => "All Users",
        "counts" => "0"
    ],
    "Vendors" => [
        "url" => DOMAIN . "/app/vendors",
        "icon" => "users",
        "title" => "All Vendors",
        "counts" => "0"
    ],
    "Accounts" => [
        "url" => DOMAIN . "/app/accounts",
        "icon" => "briefcase",
        "title" => "All Users",
        "counts" => "0"
    ],
    "Inbox" => [
        "url" => DOMAIN . "/app/mails",
        "icon" => "envelope",
        "title" => "All Mails",
        "counts" => "0"
    ],
    "Assets" => [
        "url" => DOMAIN . "/app/assets",
        "icon" => "table",
        "title" => "All Assets",
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
