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

<body onload="generatePagination()">
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <?php echo GENERATE_CALENDAR; ?>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="app-heading"><i class="bi bi-bell-fill"></i> All Events/Meetings/Reminders</h5>
                                    <?php
                                    $ActiveCalendarModule = ReturnSessionalValues("getCalendarModule", "ACTIVE_CALENDAR_MODULE_VIEW", "leads");
                                    foreach (CALENDER_ACTIVITY as $ActKey => $ActValues) {
                                        $SelectActive = CheckEquality($ActKey, $ActiveCalendarModule, "btn-primary"); ?>
                                        <a href="?getCalendarModule=<?php echo $ActKey; ?>" class="btn btn-sm <?php echo $SelectActive; ?> btn-default">
                                            <i class="<?php echo $ActValues['icon']; ?>"></i>
                                            <?php echo $ActValues['name']; ?>
                                        </a>
                                    <?php }
                                    $Month = ReturnSessionalValues("month", "ACTIVE_MONTH", date("m"));
                                    $Year = ReturnSessionalValues("year", "ACTIVE_YEAR", date("Y"));
                                    $Day = ReturnSessionalValues("day", "ACTIVE_DAY", date("d"));
                                    $ActiveDate = DATE_FORMATES("Y-m-d", "$Year-$Month-$Day");
                                    ?>
                                    <?php require_once __DIR__ . "/" . CALENDER_ACTIVITY[$ActiveCalendarModule]['module']; ?>
                                </div>
                            </div>


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