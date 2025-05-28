<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

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
</head>

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <?php include_once __DIR__ . "/components/SystemSettingTabs.php"; ?>

                            <div class="tab-content pt-2">
                                <?php
                                include_once __DIR__ . "/sections/AdvanceConfiguration.php";
                                include_once __DIR__ . "/sections/MenuAdjustments.php";
                                include_once __DIR__ . "/sections/HRSettings.php";
                                include_once __DIR__ . "/sections/MailConfigurations.php";
                                include_once __DIR__ . "/sections/MasterDataConfigurations.php";
                                include_once __DIR__ . "/sections/RemindersAndAlerts.php";
                                include_once __DIR__ . "/sections/SystemProfile.php";
                                ?>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
</body>

</html>