<?php
$Dir = "..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

if (DEVICE_TYPE == "COMPUTER") {
    header("location: ../app");
    exit();
}
$PageName = "Dashboard";
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
unset($_SESSION['ACTIVE_SIDEBAR_MENU']);

// Get current hour for greeting
date_default_timezone_set('Asia/Kolkata'); // Adjust timezone as needed
$hour = date('H');
$greeting = $hour < 12 ? "Good Morning" : ($hour < 18 ? "Good Afternoon" : "Good Night");
$greetingIcon = $hour < 12 ? "bi-sun" : ($hour < 18 ? "bi-cloud-sun" : "bi-moon-stars");

// Assuming logged-in user's name is stored in session
$loggedInUserName = isset($_SESSION['APP_LOGIN_USER_NAME']) ? $_SESSION['APP_LOGIN_USER_NAME'] : "User";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="css/Dashboard.css" type="stylesheet">
</head>

<body class="pb-5 mb-5">
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="main-content">
            <div class="pagetitle animate-fade-up mb-0">
                <div class="flex-s-b">
                    <div class="mt-0 w-100">
                        <span class="app-fs-3 text-secondary"><i class="bi <?php echo $greetingIcon; ?> text-warning"></i> <?php echo $greeting; ?></span><br>
                        <h3 class="mt-0 app-fs-5 mt-0 pt-0 text-primary bold" style="margin-top:-1vw !important; font-weight:800 !important;"><strong style="font-weight:900 !important;"><?php echo UpperCase(AuthAppUser("UserFullName")); ?></strong></h3>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: -1vw !important;margin-bottom: 1vw !important;">
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger app-fs-2 text-shadow text-danger bold">
                        <i class="bi bi-chat-right-quote text-success"></i>
                        <span class="text-danger"><?php echo MOTIVATIONAL_QUOTES[array_rand(MOTIVATIONAL_QUOTES)]; ?></span>
                        <i class="bi bi-chat-left-quote text-success"></i>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: -1vw !important;">
                    <?php require_once __DIR__ . "/components" . "/CounterWidgets.php"; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <?php require_once __DIR__ . "/components/CallFlowGraph.php"; ?>
                </div>
                <div class="col-md-12">
                    <hr>
                    <?php require_once __DIR__ . "/components/TodayReminders.php"; ?>
                </div>
                <div class="col-md-12">
                    <hr>
                    <?php require_once __DIR__ . "/components/TodaySiteVisits.php"; ?>
                </div>
                <div class="col-md-12">
                    <hr>
                    <?php require_once __DIR__ . "/components/UserRecentActivities.php"; ?>
                </div>
            </div>
        </div>

    </main>
    <?php
    include_once __DIR__ . "/components/SiteVisitUpdate.php";
    include_once __DIR__ . "/components/ReScheduleSiteVisits.php";
    include_once __DIR__ . "/components/ReminderUpdate.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>

</body>

</html>