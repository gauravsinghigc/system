<?php
$Dir = "..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

if (DEVICE_TYPE == "MOBILE") {
    header("location: ../mobile");
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

<body>
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="main-content">
            <?php
            require_once __DIR__ . "/components/DashHeader.php";
            require_once __DIR__ . "/components/LoginBaseCounterOptions.php";
            ?>
            <div class="row">
                <div class="col-md-8">
                    <?php
                    require_once __DIR__ . "/components/DashboardIntegrationCounts.php";

                    // Include the appropriate dashboard view based on the active dashboard
                    include_once __DIR__ . "/components" . "/" . DASHBOARD_VIEW_FOR_TEAM_HEADS[$ActiveDashboardView];
                    ?>
                    <section class="section animate-fade-up">
                        <!-- Widgets -->
                        <!-- Analytics Graphs -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card pt-4">
                                    <?php include_once "components/CallFlowGraph.php"; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Special Contacts & Recent Meetings -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card pt-4 mb-3">
                                    <?php require_once __DIR__ . "/components/CallReminders.php"; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card pt-4 mb-3">
                                    <?php require_once __DIR__ . "/components/SiteVisitsDashboard.php"; ?>
                                </div>
                            </div>
                            <?php require_once __DIR__ . "/components/TeamMemberCallingGraph.php"; ?>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <?php require_once __DIR__ . "/components/AllTeamActivityTrack.php"; ?>
                </div>
            </div>


            <?php if (AuthAppUser("UserType") == "ADMIN" || AuthAppUser("TEAM_HEAD")) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card pt-4">
                            <?php require_once __DIR__ . "/components/TeamCallingReport.php"; ?>
                        </div>
                    </div>
                </div>
            <?php  } ?>
        </div>


    </main>

    <?php include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>