<?php

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

if (isset($_GET['step']) && isset($_GET['verification'])) {
    $Step = $_GET['step'];
    $Verification = $_GET['verification'];

    if ($Step == "password" && $Verification == "enabled") {
        $overview = "";
        $profile = "";
        $password = "show active";
    } else {
        $overview = "show active";
        $profile = "";
        $password = "";
    }
} else {
    $Step = "";
    $Verification = "";
    $password = "";
    $overview = "show active";
    $profile = "";
}
