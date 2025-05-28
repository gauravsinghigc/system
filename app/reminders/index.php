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

<body>
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="pagetitle animate-fade-up mb-0">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-calendar-event text-danger bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
                <?php if (AuthAppUser("UserType") == "TEAM_HEAD") { ?>
                    <div class="text-right">
                        <?php
                        foreach (TEAM_HEAD_LEAD_VIEW_OPTIONS as $Key => $Values) {
                            $ActiveLeadsView = CheckEquality($Key, $ActiveLeadViewForTeamHead, "btn-primary"); ?>
                            <a href="?LeadViewByTeamHead=<?php echo $Key; ?>&activeDashboard=<?php echo $Values; ?>" class="btn btn-md <?php echo $ActiveLeadsView; ?> btn-light"><?php echo $Key; ?> VISITS</a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div>
                    <button class="btn btn-danger btn-md" data-bs-toggle="modal" data-bs-target="#addSiteVisitModal">
                        <i class="bi bi-plus-circle me-1"></i> Add Site-Visit
                    </button>
                </div>
            </div>
            <?php require_once __DIR__ . "/components/CounterAndInstantFilter.php"; ?>
        </div>

        <section class="section">
            <?php require_once __DIR__ . "/components/AdvanceFilters.php"; ?>
            <div class="row mt-2">
                <div class="col-md-12">
                    <!-- Existing table modified for meetings -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>CustomerName</th>
                                    <th>PhoneNumber</th>
                                    <th>ReminderName</th>
                                    <th>DateTime</th>
                                    <th>ManagedBy</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $START_FROM = START_FROM;
                                $LISTING_LIMIT = DEFAULT_RECORD_LISTING;

                                $ReminderGETSQL = SET_SQL($GeneratedSQL . " LIMIT $LISTING_LIMIT OFFSET $START_FROM", true);
                                if ($ReminderGETSQL != null) {
                                    $SerialNo = SERIAL_NO;
                                    foreach ($ReminderGETSQL as $Reminder) {
                                        $SerialNo++;

                                        $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_reminder_main_leads_id . "'";
                                        $ManagedBy = "SELECT UserFullName FROM users where UserId='" . $Reminder->leads_reminder_user_id . "'";
                                ?>
                                        <tr>
                                            <td><?php echo $SerialNo; ?></td>
                                            <td>
                                                <a href="<?php echo APP_URL . "/leads/details/?leadsid=$Reminder->leads_reminder_main_leads_id"; ?>" class="text-primary bold">
                                                    <i class="bi bi-person-fill text-info"></i> <?php echo FETCH($LeadsSQL, "leads_full_name"); ?>
                                                </a>
                                            </td>
                                            <td><?php echo PHONE(FETCH($LeadsSQL, "leads_phone_number"), "link", "text-success bold", "fa fa-phone text-primary"); ?></td>
                                            <td><?php echo $Reminder->leads_reminder_name; ?></td>
                                            <td><i class="fa fa-clock text-danger"></i> <?php echo date("d M, Y h:i A", strtotime($Reminder->leads_reminder_date)); ?></td>
                                            <td>
                                                <a href="<?php echo APP_URL; ?>/reports/?SelectedUserId=<?php echo SECURE($Reminder->leads_reminder_user_id, "e"); ?>" class="text-primary bold text-decoration-underline">
                                                    (UID:<?php echo $Reminder->leads_reminder_user_id; ?>)- <?php echo FETCH($ManagedBy, "UserFullName"); ?>
                                                </a>
                                            </td>
                                            <td><?php echo SECURE($Reminder->leads_reminder_notes, "d"); ?></td>
                                            <td><?php echo ReminderStatus($Reminder->leads_reminder_status); ?></td>
                                            <td>
                                                <?php if ($Reminder->leads_reminder_status == 0) { ?>
                                                    <div class="flex-s-b">
                                                        <a class="btn btn-xs btn-success" onclick="AddFeedbackForReminders(`<?php echo $Reminder->leads_reminder_main_leads_id; ?>`,`<?php echo $Reminder->leads_reminder_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`, `<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`)">✅ Add FeedBack</a>
                                                        <form action="<?php echo CONTROLLER; ?>/ModuleController/ReminderController.php" method="POST">
                                                            <?php echo FormPrimaryInputs(true, [
                                                                "leads_reminder_id" => $Reminder->leads_reminder_id
                                                            ]); ?>
                                                            <button type="Submit" name="DropReminder" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> DROP REMINDER</button>
                                                        </form>
                                                    </div>
                                                <?php } elseif ($Reminder->leads_reminder_status == 1) { ?>
                                                    <a href="<?php echo APP_URL . "/leads/details/?leadsid=$Reminder->leads_reminder_main_leads_id"; ?>" class="btn btn-xs btn-primary">ℹ️ View Details</a>
                                                <?php } elseif ($Reminder->leads_reminder_status == 2) { ?>
                                                    <span class="btn btn-xs btn-danger">❌ DROPPED</span>
                                                <?php  } else { ?>
                                                    <span class="btn btn-xs btn-dark">🚫 MISSED </span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>
                                    <span class='alert alert-warning d-block mt-1 text-center'>No Reminder Found!.</span>
                                    </td></tr>";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php echo PaginationFooter(TOTAL($GeneratedSQL), "index.php"); ?>
            </div>
        </section>
    </main>

    <?php
    include_once __DIR__ . "/components/MarkDoneForReminder.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>