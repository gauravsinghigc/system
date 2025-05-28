<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

$PageName = "Move Leads";

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
    <style>
        .table-container {
            width: 100%;
            overflow-x: scroll;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: max-content;
            background: #fff;
        }

        table tr th {
            background: black;
            color: white;
            border-bottom: 1px solid #ddd;
        }

        table tr th,
        table tr td {
            font-size: 0.9rem !important;
            padding: 10px 15px;
        }
    </style>
</head>

<body>
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="pagetitle animate-fade-up">
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
        </div>

        <div class="row">
            <div class="col-md-12 mx-auto mb-3">
                <?php echo ClearFilters("ApplyFilters", "index.php"); ?>
            </div>
        </div>
        <?php include "SearchForm.php"; ?>

        <?php if (isset($_GET["ApplyFilters"])) { ?>
            <div class="row">
                <?php
                $leads_full_name = IfRequested("GET", "leads_full_name", "", null);
                $leads_phone_number = IfRequested("GET", "leads_phone_number", "", null);
                $leads_alternate_phone = IfRequested("GET", "leads_alternate_phone", "", null);
                $leads_email_id = IfRequested("GET", "leads_email_id", "", null);
                $leads_gender = IfRequested("GET", "leads_gender", "", null);
                $leads_marital_status = IfRequested("GET", "leads_marital_status", "", null);
                $leads_project_id = IfRequested("GET", "leads_project_id", "", null);
                $leads_stages = IfRequested("GET", "leads_stages", "", null);
                $leads_type = IfRequested("GET", "leads_type", "", null);
                $leads_source = IfRequested("GET", "leads_source", "", null);
                $leads_re_source = IfRequested("GET", "leads_re_source", "", null);
                $leads_assigned_to = IfRequested("GET", "leads_assigned_to", "", null);
                $leads_assigned_by = IfRequested("GET", "leads_assigned_by", "", null);
                $leads_assigned_priority_level = IfRequested("GET", "leads_assigned_priority_level", "", null);
                $leads_uploaded_by = IfRequested("GET", "leads_uploaded_by", "", null);
                $order_by = IfRequested("GET", "order_by", "", null);

                //make query 
                $LeadsSQL = "SELECT * FROM leads where";
                $LeadsSQL .= " leads_full_name LIKE '%$leads_full_name%' and ";
                $LeadsSQL .= " leads_phone_number LIKE '%$leads_phone_number%' and ";
                $LeadsSQL .= " leads_alternate_phone LIKE '%$leads_alternate_phone%' and";
                $LeadsSQL .= " leads_email_id LIKE '%$leads_email_id%' and ";
                $LeadsSQL .= " leads_gender LIKE '%$leads_gender%' and ";
                $LeadsSQL .= " leads_marital_status LIKE '%$leads_marital_status%' and ";

                if ($leads_project_id == "" || $leads_project_id == " " || $leads_project_id == null) {
                    $LeadsSQL .= " leads_projects_id LIKE '%$leads_project_id%' and ";
                } else {
                    $LeadsSQL .= " leads_projects_id='$leads_project_id' and";
                }

                if ($leads_stages == "" || $leads_stages == " " || $leads_stages == null) {
                    $LeadsSQL .= " leads_stages LIKE '%$leads_stages%' and ";
                } else {
                    $LeadsSQL .= " leads_stages='$leads_stages' and ";
                }

                if ($leads_type == "" || $leads_type == " " || $leads_type == null) {
                    $LeadsSQL .= " leads_type LIKE '%$leads_type%' and ";
                } else {
                    $LeadsSQL .= " leads_type='$leads_type' and ";
                }

                if ($leads_source == "" || $leads_source == " " || $leads_source == null) {
                    $LeadsSQL .= " leads_source LIKE '%$leads_source%' and ";
                } else {
                    $LeadsSQL .= " leads_source='$leads_source' and ";
                }

                if ($leads_re_source == "" || $leads_re_source == " " || $leads_re_source == null) {
                    $LeadsSQL .= " leads_source LIKE '%$leads_re_source%' and ";
                } else {
                    $LeadsSQL .= " leads_source='$leads_re_source' and ";
                }

                if ($leads_assigned_to == "" || $leads_assigned_to == " " || $leads_assigned_to == null) {
                    $LeadsSQL .= " leads_managed_by LIKE '%$leads_assigned_to%' and ";
                } else {
                    $LeadsSQL .= " leads_managed_by='$leads_assigned_to' and ";
                }

                if ($leads_assigned_by == "" || $leads_assigned_by == " " || $leads_assigned_by == null) {
                    $LeadsSQL .= " leads_assigned_by LIKE '%$leads_assigned_by%' and ";
                } else {
                    $LeadsSQL .= " leads_assigned_by='$leads_assigned_by' and ";
                }

                if ($leads_uploaded_by == "" || $leads_uploaded_by == " " || $leads_uploaded_by == null) {
                    $LeadsSQL .= " leads_uploaded_by LIKE '%$leads_uploaded_by%' and ";
                } else {
                    $LeadsSQL .= " leads_uploaded_by='$leads_uploaded_by' and ";
                }

                if ($leads_assigned_priority_level == "" || $leads_assigned_priority_level == " " || $leads_assigned_priority_level == null) {
                    $LeadsSQL .= " leads_priority_level LIKE '%$leads_assigned_priority_level%' ";
                } else {
                    $LeadsSQL .= " leads_priority_level='$leads_assigned_priority_level' ";
                }

                $LeadsSQL .= " ORDER BY leads_id $order_by";
                ?>
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
                            $ProcessSQL = SET_SQL($LeadsSQL . " limit $StartFrom, $DisplayRecords", true);
                            if ($ProcessSQL) {
                                $SerialNo = SERIAL_NO;
                                foreach ($ProcessSQL as $Records) {
                                    $SerialNo++;
                            ?>
                                    <tr>
                                        <td><input type="checkbox" class="d-selection" name="SELECTED_LEADS[]" value="<?php echo $Records->leads_id; ?>"></td>
                                        <td><?php echo $SerialNo; ?></td>
                                        <td>
                                            <a href="<?php echo APP_URL; ?>/contacts/details?leadsid=<?php echo $Records->leads_id; ?>" class="text-primary bold">
                                                <?php echo $Records->leads_full_name; ?>
                                            </a>
                                        </td>
                                        <td class="bold"><?php echo $Records->leads_phone_number; ?></td>
                                        <td class="bold"><?php echo $Records->leads_alternate_phone; ?></td>
                                        <td><?php echo FETCH("SELECT projects_name FROM projects where projects_id='" . $Records->leads_projects_id . "'", "projects_name") ?: '<span class="text-muted">N/A</span>'; ?></td>
                                        <td><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages . "'", "config_leads_stage_name"); ?></td>
                                        <td><?php echo FETCH("SELECT config_leads_source_name FROM config_leads_sources where config_leads_source_id='" . $Records->leads_source . "'", "config_leads_source_name"); ?></td>
                                        <td><?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Records->leads_managed_by . "'", "UserFullName"); ?></td>
                                        <td><?php echo DATE_FORMATES("d M, Y", $Records->leads_assigned_date); ?></td>
                                        <td><?php echo $Records->leads_type; ?></td>
                                        <td><?php echo FETCH("SELECT config_priority_level_name FROM config_priority_levels where config_priority_level_id='" . $Records->leads_priority_level . "'", "config_priority_level_name") ?: '<span class="text-muted">N/A</span>'; ?></td>
                                        <td><?php echo Price(FETCH("SELECT leads_requirement_budgets FROM leads_requirements where leads_main_id='" . $Records->leads_id . "'", "leads_requirement_budgets"), "text-success", "Rs."); ?></td>
                                        <td><?php echo FETCH("SELECT UserFullName from users where UserId='" . FETCH("SELECT UserReportingManager FROM users where UserId='" . $Records->leads_managed_by . "'", "UserReportingManager") . "'", "UserFullName"); ?></td>
                                        <td><?php echo FETCH("SELECT config_leads_stages_name FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_call_status . "'", "config_leads_stages_name"); ?></td>
                                        <td><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Records->leads_call_sub_status . "'", "config_leads_stage_name"); ?></td>
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
                                        <td><?php echo StatusViewWithText($Records->leads_status); ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-dark" href="<?php echo APP_URL; ?>/contacts/details?leadsid=<?php echo $Records->leads_id; ?>">
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
                        <?php echo PaginationFooter(TOTAL($LeadsSQL), APP_URL . "/contacts/move"); ?>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-0 pb-0">No Data Found</h5>
                            <p class="card-text pt-0">Please apply some filters to get the desired results.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


    </main>

    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>

</body>

</html>