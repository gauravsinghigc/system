<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = "All Reminders"; // Updated for meeting page
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
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
</head>

<body class="pb-5 mt-3">
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="pagetitle animate-fade-up mb-0">
            <?php require_once __DIR__ . "/components/CounterAndInstantFilter.php"; ?>
        </div>

        <section class="section">
            <div class="row mt-2">
                <div class="col-md-12">
                    <hr>
                    <h5 class="app-heading app-fs-3"><i class="bi bi-alarm-fill text-warning"></i> All Reminders</h5>
                    <?php
                    $START_FROM = START_FROM;
                    $LISTING_LIMIT = APP_RECORD_LISTING;

                    $ReminderGETSQL = SET_SQL($GeneratedSQL . " LIMIT $LISTING_LIMIT OFFSET $START_FROM", true);
                    if ($ReminderGETSQL != null) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ReminderGETSQL as $Reminder) {
                            $SerialNo++;
                            $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_reminder_main_leads_id . "'";
                            $ManagedBy = "SELECT UserFullName FROM users where UserId='" . $Reminder->leads_reminder_user_id . "'";
                            $ProjectSQL = "SELECT projects_name FROM projects WHERE projects_id='" . $Reminder->leads_projects_id . "'";
                            $LeadName = FETCH($LeadsSQL, "leads_full_name");
                            $LeadPhone = FETCH($LeadsSQL, "leads_phone_number");
                            $ProjectName = FETCH($ProjectSQL, "projects_name");
                    ?>
                            <div class="app-list-shadow">
                                <a href="<?php echo DOMAIN . "/mobile/leads/details/?leadsid=$Reminder->leads_reminder_main_leads_id"; ?>" class="d-block">
                                    <div class="flex-s-b" style="line-height: 1.35rem !important;">
                                        <div class="w-pr-75">
                                            <h6 class="bold app-fs-3 text-primary mb-0"><i class="fa fa-user text-success bold"></i> <?php echo $LeadName; ?></h6>
                                            <p class="mb-0 app-fs-3">
                                                <span class="text-primary-2 bold"><i class="fa fa-phone text-success app-fs-3"></i> +91-<?php echo $LeadPhone; ?></span><br>
                                                <span class="text-secondary small"><strong>🏗 </strong> <?php echo $ProjectName ?? "Not Available"; ?></span>
                                            </p>
                                        </div>
                                        <div class="w-pr-25 text-right">
                                            <p class="mb-0 mt-1 bg-white br-5 shadow-sm text-center" style="line-height: 2.5vw !important;padding:0.55rem 0.75rem !important;position:absolute;margin-left:6vw !important;">
                                                <i class="bi bi-bell-fill app-fs-4 text-danger blink-data"></i><br>
                                                <span class="text-dark bold app-fs-2 bolder">
                                                    <?php echo date("d M, Y", strtotime($Reminder->leads_reminder_date)); ?><br>
                                                    <?php echo date("h:i A", strtotime($Reminder->leads_reminder_date)); ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-secondary app-fs-3 text-left">
                                        <i class="bi bi-chat-dots-fill text-black"></i> <?php echo LimitText(SECURE($Reminder->leads_reminder_notes, "d"), 0, 60); ?>
                                        <br>
                                        <span class="app-fs-5"><?php echo ReminderStatus($Reminder->leads_reminder_status); ?></span>
                                    </p>
                                </a>
                                <div class="pull-right" style="margin-top: -9vw;">
                                    <div class="flex-s-b">
                                        <?php if ($Reminder->leads_reminder_status == 0) { ?>
                                            <a class="btn btn-success m-1 btn-md" onclick="AddFeedbackForReminders(`<?php echo $Reminder->leads_reminder_main_leads_id; ?>`,`<?php echo $Reminder->leads_reminder_id; ?>`, `<?php echo $LeadName; ?>`, `<?php echo $LeadPhone; ?>`)"> Add FeedBack</a>
                                            <form action="<?php echo CONTROLLER; ?>/ModuleController/ReminderController.php" method="POST">
                                                <?php echo FormPrimaryInputs(true, [
                                                    "leads_reminder_id" => $Reminder->leads_reminder_id
                                                ]); ?>
                                                <button type="Submit" name="DropReminder" class="btn btn-md btn-danger m-1"><i class="fa fa-trash small"></i> DROP</button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                    <?php
                        }
                        echo "<hr>";
                        echo AppPaginationFooter(TOTAL($GeneratedSQL), "index.php");
                    } else {
                        echo "<span class='alert alert-warning d-block mt-1 text-center'>No Reminder Found!.</span>";
                    } ?>
                </div>
        </section>
    </main>

    <?php
    include_once __DIR__ . "/components/MarkDoneForReminder.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>