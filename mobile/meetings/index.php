<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = "All Site Visits"; // Updated for meeting page
$PageDescription = "Manage and schedule meetings for " . APP_NAME;
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

require_once __DIR__ . "/Requests/HeaderQueryRequests.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.85, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
</head>

<body class="pb-5 mb-5">
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="pagetitle animate-fade-up mb-0">
            <?php require_once __DIR__ . "/components/CounterAndInstantFilter.php"; ?>
        </div>

        <section class="section">
            <?php require_once __DIR__ . "/components/AdvanceFilters.php"; ?>
            <div class="row mt-2">
                <div class="col-md-12">
                    <h5 class="app-heading app-fs-4"><i class="bi bi-pin-map text-warning"></i> All Site Visits</h5>

                    <?php
                    $START_FROM = START_FROM;
                    $LISTING_LIMIT = APP_RECORD_LISTING;

                    $ReminderGETSQL = SET_SQL($GeneratedSQL . " LIMIT $LISTING_LIMIT OFFSET $START_FROM", true);
                    if ($ReminderGETSQL != null) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ReminderGETSQL as $Reminder) {
                            $SerialNo++;

                            $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_main_leads_id . "'";
                            $ProjectSQL = "SELECT projects_name FROM projects WHERE projects_id='" . $Reminder->leads_site_visits_projects_id . "'";
                            $LeadName = FETCH($LeadsSQL, "leads_full_name");
                            $LeadPhone = FETCH($LeadsSQL, "leads_phone_number");
                            $ProjectName = FETCH($ProjectSQL, "projects_name");
                    ?>
                            <div class="app-list-shadow">
                                <a href="<?php echo DOMAIN . "/mobile/leads/details/?leadsid=$Reminder->leads_main_leads_id"; ?>" class="d-block">
                                    <div class="flex-s-b" style="line-height: 1.5rem !important;">
                                        <div class="w-pr-75">
                                            <h6 class="bold app-fs-3 text-danger mb-0"><i class="fa fa-user text-success bold"></i> <?php echo $LeadName; ?></h6>
                                            <p class="mb-0 app-fs-3">
                                                <span class="text-primary bold"><strong>📞 </strong> <?php echo $LeadPhone; ?></span><br>
                                                <span class="text-secondary small"><strong>🏗 </strong> <?php echo $ProjectName ?? "Not Available"; ?></span>
                                            </p>
                                        </div>
                                        <div class="w-pr-25 text-right">
                                            <p class="mb-0 mt-3 bg-white br-5 shadow-sm text-center" style="line-height: 2.5vw !important;padding:0.55rem 0.75rem !important;position:absolute;margin-left:6vw !important;">
                                                <i class="fa fa-map-marker app-fs-4 text-success blink-data"></i><br>
                                                <span class="text-dark bold app-fs-2 bolder">
                                                    <?php echo date("d M, Y", strtotime($Reminder->leads_site_visit_schedule_date)); ?><br>
                                                    <?php echo date("h:i A", strtotime($Reminder->leads_site_visit_schedule_date)); ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-secondary app-fs-3 text-left">
                                        <i class="bi bi-chat-dots text-black"></i> <?php echo LimitText(SECURE($Reminder->leads_site_visit_notes, "d"), 0, 30); ?>
                                        <br>
                                        <span class="app-fs-4"><?php echo SiteVisitStatus($Reminder->leads_site_visit_status); ?></span>
                                    </p>
                                </a>
                                <div class="pull-right" style="margin-top: -9vw;">
                                    <div class="flex-s-b">
                                        <div class="flex-end w-100">
                                            <?php if ($Reminder->leads_site_visit_status == 1) { ?>
                                                <a class="btn btn-success m-1 btn-sm" onclick="SiteVisitController(`<?php echo $Reminder->leads_main_leads_id; ?>`,`<?php echo $Reminder->leads_site_visit_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`, `<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`, `<?php echo SECURE($Reminder->leads_site_visit_notes, 'd'); ?>`, `<?php echo FETCH($ProjectSQL, 'projects_name') ?? 'NOT AVAILABLE'; ?>`)"> Mark Done</a>
                                                <a class="btn btn-warning m-1 btn-sm" onclick="ReScheduleSiteVisit(`<?php echo $Reminder->leads_main_leads_id; ?>`,`<?php echo $Reminder->leads_site_visit_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`,`<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`)"><?php echo ART_ICON['clock']; ?> Re-Schedule</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php
                        }
                        echo AppPaginationFooter(TOTAL($GeneratedSQL), "index.php");
                    } else {
                        echo "<tr><td colspan='9'>
                                    <span class='alert alert-warning d-block mt-1 text-center'>No Site Visit Found!.</span>
                                    </td></tr>";
                    } ?>
                </div>
        </section>
    </main>

    <?php
    include_once __DIR__ . "/components/ReScheduleSiteVisit.php";
    include_once __DIR__ . "/components/CompleteSiteVisit.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>