<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

$PageName = "Soft Removed Leads";
// Add ORDER BY and LIMIT for optimization
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
    <link href="assets/leads.css" type="stylesheet">
    <style>
        .table-container {
            width: 100% !important;
            overflow-x: scroll !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            min-width: max-content !important;
            background: #fff !important;
        }

        table tr th {
            background: black !important;
            color: white !important;
            border-bottom: 1px solid #ddd !important;
        }

        table tr th,
        table tr td {
            font-size: 0.65rem !important;
            padding: 2px 5px !important;
        }

        .table-container table tr th,
        .table-container table tr td {
            font-size: 0.83rem !important;
            padding: 2px 5px !important;
        }
    </style>
</head>

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <?php
        include_once __DIR__ . "/components/HeaderSections.php";
        include_once __DIR__ . "/components/ClearAndApplyFilters.php";
        ?>

        <section class="section profile animate-fade-up">
            <div class="row">
                <div class="col-xl-12">
                    <?php include_once __DIR__ . "/components/AdvanceFilters.php"; ?>
                    <div class="card">
                        <div class="card-body">
                            <?php include __DIR__ . "/components/SearchAndActions.php"; ?>
                            <div class="table-container mt-4">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll" class="d-selection"></th>
                                            <th>SNo.</th>
                                            <th>Contact Name</th>
                                            <th>Phone Number</th>
                                            <th>Alt Phone</th>
                                            <th>Project</th>
                                            <th>Stage</th>
                                            <th>Source</th>
                                            <th>Assigned To</th>
                                            <th>Assigned On</th>
                                            <th>Type</th>
                                            <th>Priority</th>
                                            <th>Budget</th>
                                            <th>Manager</th>
                                            <th>Call Status</th>
                                            <th>Sub Status</th>
                                            <th>Created</th>
                                            <th>Prev Stage</th>
                                            <th>Prev Assigned To</th>
                                            <th>Assigned By</th>
                                            <th>Modified</th>
                                            <th>Modified By</th>
                                            <th>Insert Mode</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $StartFrom = START_FROM;
                                        $DisplayRecords = DEFAULT_RECORD_LISTING;

                                        //advance filters
                                        if (isset($_GET["ApplyAdvancefilters"])) {
                                            // Generate Filtered SQL
                                            $GenerateSQL = "SELECT * FROM leads WHERE";

                                            if ($_GET["leads_type"] == null || $_GET["leads_type"] == "") {
                                                $GenerateSQL .= " leads_type LIKE '%" . $_GET['leads_type'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " leads_type='" . $_GET['leads_type'] . "' ";
                                            }

                                            if ($_GET["leads_stages"] == null || $_GET["leads_stages"] == "") {
                                                $GenerateSQL .= " and leads_stages LIKE '%" . $_GET['leads_stages'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_stages='" . $_GET['leads_stages'] . "' ";
                                            }

                                            if ($_GET["leads_source"] == null || $_GET["leads_source"] == "") {
                                                $GenerateSQL .= " and leads_source LIKE '%" . $_GET['leads_source'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_source='" . $_GET['leads_source'] . "' ";
                                            }

                                            if ($_GET["leads_managed_by"] == null || $_GET["leads_managed_by"] == "") {
                                                $GenerateSQL .= " and leads_managed_by LIKE '%" . $_GET['leads_managed_by'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_managed_by='" . $_GET['leads_managed_by'] . "' ";
                                            }

                                            if ($_GET["leads_assigned_by"] == null || $_GET["leads_assigned_by"] == "") {
                                                $GenerateSQL .= " and leads_assigned_by LIKE '%" . $_GET['leads_assigned_by'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_assigned_by='" . $_GET['leads_assigned_by'] . "' ";
                                            }

                                            if ($_GET["leads_added_on_from_date"] == null || $_GET["leads_added_on_from_date"] == "") {
                                                $GenerateSQL .= " and DATE(leads_created_at) LIKE '%" . $_GET['leads_added_on_from_date'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_created_at) >= '" . $_GET['leads_added_on_from_date'] . "' ";
                                            }

                                            if ($_GET["leads_added_on_to_date"] == null || $_GET["leads_added_on_to_date"] == "") {
                                                $GenerateSQL .= " and DATE(leads_created_at) LIKE '%" . $_GET['leads_added_on_to_date'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_created_at) <= '" . $_GET['leads_added_on_to_date'] . "' ";
                                            }

                                            if ($_GET["leads_assigned_on_from_date"] == null || $_GET["leads_assigned_on_from_date"] == "") {
                                                $GenerateSQL .= " and DATE(leads_assigned_date) LIKE '%" . $_GET['leads_assigned_on_from_date'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_assigned_date) >= '" . $_GET['leads_added_on_from_date'] . "' ";
                                            }

                                            if ($_GET["leads_assigned_on_to_date"] == null || $_GET["leads_assigned_on_to_date"] == "") {
                                                $GenerateSQL .= " and DATE(leads_created_at) LIKE '%" . $_GET['leads_assigned_on_to_date'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_created_at) <= '" . $_GET['leads_assigned_on_to_date'] . "' ";
                                            }

                                            if ($_GET["leads_updated_at_from"] == null || $_GET["leads_updated_at_from"] == "") {
                                                $GenerateSQL .= " and DATE(leads_updated_at) LIKE '%" . $_GET['leads_updated_at_from'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_updated_at) >= '" . $_GET['leads_updated_at_from'] . "' ";
                                            }

                                            if ($_GET["leads_updated_at_to"] == null || $_GET["leads_updated_at_to"] == "") {
                                                $GenerateSQL .= " and DATE(leads_updated_at) LIKE '%" . $_GET['leads_updated_at_to'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_updated_at) <= '" . $_GET['leads_updated_at_to'] . "' ";
                                            }

                                            if ($_GET["leads_updated_at_from"] == null || $_GET["leads_updated_at_from"] == "") {
                                                $GenerateSQL .= " and DATE(leads_updated_at) LIKE '%" . $_GET['leads_updated_at_from'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_updated_at) >= '" . $_GET['leads_updated_at_from'] . "' ";
                                            }

                                            if ($_GET["leads_updated_at_to"] == null || $_GET["leads_updated_at_to"] == "") {
                                                $GenerateSQL .= " and DATE(leads_updated_at) LIKE '%" . $_GET['leads_updated_at_to'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and DATE(leads_updated_at) <= '" . $_GET['leads_updated_at_to'] . "' ";
                                            }

                                            if ($_GET["leads_uploaded_by"] == null || $_GET["leads_uploaded_by"] == "") {
                                                $GenerateSQL .= " and leads_uploaded_by LIKE '%" . $_GET['leads_uploaded_by'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_uploaded_by='" . $_GET['leads_uploaded_by'] . "' ";
                                            }

                                            if ($_GET["leads_acitivity_call_status"] == null || $_GET["leads_acitivity_call_status"] == "") {
                                                $GenerateSQL .= " and leads_call_status LIKE '%" . $_GET['leads_acitivity_call_status'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_call_status='" . $_GET['leads_acitivity_call_status'] . "' ";
                                            }

                                            if ($_GET["leads_acitivity_call_sub_status"] == null || $_GET["leads_acitivity_call_sub_status"] == "") {
                                                $GenerateSQL .= " and leads_call_sub_status LIKE '%" . $_GET['leads_acitivity_call_sub_status'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_call_sub_status='" . $_GET['leads_acitivity_call_sub_status'] . "' ";
                                            }

                                            if ($_GET["leads_other_sources_ads_id"] == null || $_GET["leads_other_sources_ads_id"] == "") {
                                                $GenerateSQL .= " and leads_other_sources_ads_id LIKE '%" . $_GET['leads_other_sources_ads_id'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_other_sources_ads_id='" . $_GET['leads_other_sources_ads_id'] . "' ";
                                            }

                                            if ($_GET["leads_entry_type"] == null || $_GET["leads_entry_type"] == "") {
                                                $GenerateSQL .= " and leads_entry_type LIKE '%" . $_GET['leads_entry_type'] . "%' ";
                                            } else {
                                                $GenerateSQL .= " and leads_entry_type='" . $_GET['leads_entry_type'] . "' ";
                                            }

                                            $GenerateSQL .= " AND leads_is_removed='1'";

                                            $PaginationTotalSQL = $GenerateSQL;
                                            $AllLeadsSQL = $GenerateSQL;

                                            //search phone number
                                        } else if (isset($_GET['Search_Phone_Number']) && !empty(trim($_GET['Search_Phone_Number']))) {
                                            $search = trim($_GET['Search_Phone_Number']);
                                            // Use parameterized query to prevent SQL injection
                                            if (AuthAppUser("UserType") == "ADMIN") {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_phone_number LIKE '%" . addslashes($search) . "%'  and leads_is_removed='1' ";
                                            } elseif (AuthAppUser("UserType") == "COORDINATOR") {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_is_created_by_admin!='1' and leads_phone_number LIKE '%" . addslashes($search) . "%'  and leads_is_removed='1' ";
                                            } else {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_managed_by='" . LOGIN_USER_ID . "' and leads_phone_number LIKE '%" . addslashes($search) . "%'  and leads_is_removed='1' ";
                                            }

                                            //lead stage search
                                        } else if (isset($_GET["leads_stages_dash"])) {
                                            $leads_stages = $_GET["leads_stages_dash"];

                                            // Use parameterized query to prevent SQL injection
                                            if (AuthAppUser("UserType") == "ADMIN") {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_stages='$leads_stages'  and leads_is_removed='1'";
                                            } elseif (AuthAppUser("UserType") == "COORDINATOR") {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_is_created_by_admin!='1' and leads_stages='$leads_stages'  and leads_is_removed='1'  ";
                                            } else {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_managed_by='" . LOGIN_USER_ID . "' and leads_stages='$leads_stages'  and leads_is_removed='1'";
                                            }

                                            //default 
                                        } else {
                                            // Use parameterized query to prevent SQL injection
                                            if (AuthAppUser("UserType") == "ADMIN") {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_is_removed='1'  ";
                                            } elseif (AuthAppUser("UserType") == "COORDINATOR") {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_is_created_by_admin!='1' and leads_is_removed='1'  ";
                                            } else {
                                                $AllLeadsSQL = "SELECT * FROM leads where leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed='1'  ";
                                            }
                                        }
                                        $PaginationTotalSQL = $AllLeadsSQL;
                                        $ProcessSQL = SET_SQL($AllLeadsSQL . " ORDER BY leads_id DESC LIMIT $DisplayRecords OFFSET $StartFrom", true);
                                        if ($ProcessSQL) {
                                            $SerialNo = SERIAL_NO;
                                            foreach ($ProcessSQL as $Records) {
                                                $SerialNo++;
                                                if ($Records->leads_gender == "Male") {
                                                    $ColorClass = "text-primary";
                                                } elseif ($Records->leads_gender == "Female") {
                                                    $ColorClass = "text-info";
                                                } else {
                                                    $ColorClass = "text-secondary";
                                                }
                                        ?>
                                                <tr>
                                                    <td><input type="checkbox" class="d-selection" name="SELECTED_LEADS[]" value="<?php echo $Records->leads_id; ?>"></td>
                                                    <td><?php echo $SerialNo; ?></td>
                                                    <td>
                                                        <a href="<?php echo APP_URL; ?>/leads/details?leadsid=<?php echo $Records->leads_id; ?>" class="text-primary bold">
                                                            <i class="bi bi-person-fill <?php echo $ColorClass; ?>"></i> <?php echo LimitText(UpperCase($Records->leads_full_name), 0, 30); ?>
                                                        </a>
                                                    </td>
                                                    <td class="bold"><?php echo $Records->leads_phone_number; ?></td>
                                                    <td class="bold"><?php echo $Records->leads_alternate_phone; ?></td>
                                                    <td><?php echo LimitText(FETCH("SELECT projects_name FROM projects where projects_id='" . $Records->leads_projects_id . "'", "projects_name"), 0, 20) ?: '<span class="text-muted">N/A</span>'; ?></td>
                                                    <td>
                                                        <span class="color-tags" style="background-color:<?php echo FETCH("SELECT config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages  . "'", "config_leads_stage_color_code"); ?>;color:black !important;">
                                                            <?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages . "'", "config_leads_stage_name"); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Records->leads_sub_stages . "'", "config_call_sub_status_name"); ?></td>
                                                    <td><?php echo FETCH("SELECT config_leads_source_name FROM config_leads_sources where config_leads_source_id='" . $Records->leads_source . "'", "config_leads_source_name"); ?></td>
                                                    <td><?php echo FETCH("SELECT config_leads_resources_name FROM config_leads_resources where config_leads_resources_id ='" . $Records->leads_re_source . "'", "config_leads_resources_name"); ?></td>
                                                    <td><?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Records->leads_managed_by . "'", "UserFullName"); ?></td>
                                                    <td><?php echo DATE_FORMATES("d M, Y", $Records->leads_assigned_date); ?></td>
                                                    <td><?php echo $Records->leads_type; ?></td>
                                                    <td><?php echo FETCH("SELECT config_priority_level_name FROM config_priority_levels where config_priority_level_id='" . $Records->leads_priority_level . "'", "config_priority_level_name") ?: '<span class="text-muted">N/A</span>'; ?></td>
                                                    <td><?php echo Price(FETCH("SELECT leads_requirement_budgets FROM leads_requirements where leads_main_id='" . $Records->leads_id . "'", "leads_requirement_budgets"), "text-success", "Rs."); ?></td>
                                                    <td><?php echo FETCH("SELECT UserFullName from users where UserId='" . FETCH("SELECT UserReportingManager FROM users where UserId='" . $Records->leads_managed_by . "'", "UserReportingManager") . "'", "UserFullName"); ?></td>
                                                    <td><?php echo DATE_FORMATES("d M, Y", $Records->leads_created_at); ?></td>
                                                    <td>
                                                        <?php
                                                        $leads_assigned_previous_stages = FETCH("SELECT leads_assigned_previous_stages FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previous_stages");
                                                        echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='$leads_assigned_previous_stages'", "config_leads_stage_name");
                                                        ?>
                                                    <td>
                                                        <?php
                                                        $leads_assigned_previously_to = FETCH("SELECT leads_assigned_previously_to FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_to");
                                                        echo FETCH("SELECT UserFullName FROM users where UserId='$leads_assigned_previously_to'", "UserFullName");
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $leads_assigned_previously_by = FETCH("SELECT leads_assigned_previously_by FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_by");
                                                        echo FETCH("SELECT UserFullName FROM users where UserId='$leads_assigned_previously_by'", "UserFullName");
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $leads_assigned_udpated_at = FETCH("SELECT leads_assigned_udpated_at FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_udpated_at");
                                                        echo DATE_FORMATES("d M, Y", $leads_assigned_udpated_at);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $leads_assigned_udpated_by = FETCH("SELECT leads_assigned_udpated_by FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_udpated_by");
                                                        echo FETCH("SELECT UserFullName FROM users where UserId='$leads_assigned_udpated_by'", "UserFullName");
                                                        ?>
                                                    </td>
                                                    <td><?php echo $Records->leads_entry_type; ?></td>
                                                    <td><?php echo $Records->leads_assign_status; ?></td>
                                                    <td>
                                                        <a class="btn btn-xs btn-dark" href="<?php echo APP_URL; ?>/leads/details?leadsid=<?php echo $Records->leads_id; ?>">
                                                            <i class="fa fa-eye text-success"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='25' class='text-center alert alert-warning'>No Leads Found!</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo PaginationFooter(TOTAL($PaginationTotalSQL), APP_URL . "/leads"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
    include $Dir . "/app/audits/components/AssignModal.php";
    include $Dir . "/app/audits/components/RemoveModal.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
    <script src="assets/leads.js" type="text/javascript"></script>
</body>

</html>