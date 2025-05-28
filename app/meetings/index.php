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
                                    <th>ProjectName</th>
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

                                        $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_main_leads_id . "'";
                                        $ProjectSQL = "SELECT projects_name from projects where projects_id='" . $Reminder->leads_site_visits_projects_id . "'";
                                        $ManagedBy = "SELECT UserFullName FROM users where UserId='" . $Reminder->leads_site_visit_handled_by . "'";
                                ?>
                                        <tr>
                                            <td><?php echo $SerialNo; ?></td>
                                            <td>
                                                <a href="<?php echo APP_URL . "/leads/details/?leadsid=$Reminder->leads_main_leads_id"; ?>" class="text-primary bold">
                                                    <i class="bi bi-person-fill text-info"></i> <?php echo FETCH($LeadsSQL, "leads_full_name"); ?>
                                                </a>
                                            </td>
                                            <td><?php echo PHONE(FETCH($LeadsSQL, "leads_phone_number"), "link", "text-success bold", "fa fa-phone text-primary"); ?></td>
                                            <td><?php echo FETCH($ProjectSQL, "projects_name") ?? "NOT AVAILABLE"; ?></td>
                                            <td><i class="fa fa-clock text-danger"></i> <?php echo date("d M, Y h:i A", strtotime($Reminder->leads_site_visit_schedule_date)); ?></td>
                                            <td>
                                                <a href="<?php echo APP_URL; ?>/reports/?SelectedUserId=<?php echo SECURE($Reminder->leads_site_visit_handled_by, "e"); ?>" class="text-primary bold text-decoration-underline">
                                                    (UID:<?php echo $Reminder->leads_site_visit_handled_by; ?>)- <?php echo FETCH($ManagedBy, "UserFullName"); ?>
                                                </a>
                                            </td>
                                            <td><?php echo SECURE($Reminder->leads_site_visit_notes, "d"); ?></td>
                                            <td><?php echo SiteVisitStatus($Reminder->leads_site_visit_status); ?></td>
                                            <td>
                                                <?php if ($Reminder->leads_site_visit_status == 1) { ?>
                                                    <a class="btn btn-xs btn-success" onclick="SiteVisitController(`<?php echo $Reminder->leads_main_leads_id; ?>`,`<?php echo $Reminder->leads_site_visit_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`, `<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`, `<?php echo SECURE($Reminder->leads_site_visit_notes, 'd'); ?>`, `<?php echo FETCH($ProjectSQL, 'projects_name') ?? 'NOT AVAILABLE'; ?>`)">✅ Mark Done</a>
                                                    <a class="btn btn-xs btn-warning" onclick="ReScheduleSiteVisit(`<?php echo $Reminder->leads_main_leads_id; ?>`,`<?php echo $Reminder->leads_site_visit_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`,`<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`)"><?php echo ART_ICON['clock']; ?> Re-Schedule</a>
                                                <?php } elseif ($Reminder->leads_site_visit_status == 2) { ?>
                                                    <a href="<?php echo APP_URL . "/leads/details/?leadsid=$Reminder->leads_main_leads_id"; ?>" class="btn btn-xs btn-primary">ℹ️ View Details</a>
                                                <?php } elseif ($Reminder->leads_site_visit_status == 3) { ?>
                                                    <span class="btn btn-xs btn-danger">❌ CANCELLED</span>
                                                <?php  } else { ?>
                                                    <span class="btn btn-xs btn-dark">🚫 MISSED </span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>
                                    <span class='alert alert-warning d-block mt-1 text-center'>No Site Visit Found!.</span>
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
    include_once __DIR__ . "/components/ReScheduleSiteVisit.php";
    include_once __DIR__ . "/components/CompleteSiteVisit.php";
    include_once __DIR__ . "/components/AddSiteVisitForm.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>