<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

if (isset($_GET["ExportRecords"])) {
    if (isset($_GET["ApplyAdvancefilters"])) {
        $GenerateSQL = "SELECT * FROM leads WHERE leads_is_removed != '1'";
        $filters = [
            "leads_type",
            "leads_stages",
            "leads_sub_stages",
            "leads_source",
            "leads_managed_by",
            "leads_assigned_by",
            "leads_uploaded_by",
            "leads_projects_id",
            "leads_re_source"
        ];

        foreach ($filters as $field) {
            if (!empty(trim($_GET[$field]))) {
                $GenerateSQL .= " AND {$field} = '" . trim($_GET[$field]) . "'";
            }
        }

        // Date filters
        $dateFilters = [
            "leads_added_on_from_date" => "leads_created_at >= ",
            "leads_added_on_to_date" => "leads_created_at <= ",
            "leads_assigned_on_from_date" => "leads_assigned_date >= ",
            "leads_assigned_on_to_date" => "leads_assigned_date <= ",
            "leads_updated_at_from" => "leads_updated_at >= ",
            "leads_updated_at_to" => "leads_updated_at <= "
        ];

        foreach ($dateFilters as $key => $condition) {
            if (!empty(trim($_GET[$key]))) {
                $GenerateSQL .= " AND DATE(" . explode(' ', $condition)[0] . ") " . explode(' ', $condition)[1] . " '" . trim($_GET[$key]) . "'";
            }
        }

        // Order & limit (optional)
        $ExportLeadsSQL = $GenerateSQL . " ORDER BY leads_id DESC";

        $record = SET_SQL($ExportLeadsSQL, true);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="leads_report_' . date('d_M_Y_h_i_a') . '.csv"');
        $output = fopen('php://output', 'w');

        // CSV Header
        fputcsv($output, [
            'SNo.',
            'Contact Name',
            'Phone Number',
            'Alt Phone',
            'Project',
            'Stage',
            'SubStage',
            'Source',
            'ReSource',
            'Assigned To',
            'Assigned On',
            'Type',
            'Priority',
            'Budget',
            'Manager',
            'Created',
            'PrevStage',
            'PrevAssignedTo',
            'AssignedBy',
            'Modified',
            'ModifiedBy',
            'InsertMode',
            'Status'
        ]);

        if ($record) {
            $serialNo = 0;
            foreach ($record as $row) {
                $serialNo++;
                fputcsv($output, [
                    $serialNo,
                    UpperCase($row->leads_full_name),
                    $row->leads_phone_number,
                    $row->leads_alternate_phone,
                    FETCH("SELECT projects_name FROM projects WHERE projects_id='" . $row->leads_projects_id . "'", "projects_name"),
                    FETCH("SELECT config_leads_stage_name FROM config_leads_stages WHERE config_leads_stages_id='" . $row->leads_stages . "'", "config_leads_stage_name"),
                    FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_id='" . $row->leads_sub_stages . "'", "config_call_sub_status_name"),
                    FETCH("SELECT config_leads_source_name FROM config_leads_sources WHERE config_leads_source_id='" . $row->leads_source . "'", "config_leads_source_name"),
                    FETCH("SELECT config_leads_resources_name FROM config_leads_resources WHERE config_leads_resources_id='" . $row->leads_re_source . "'", "config_leads_resources_name"),
                    FETCH("SELECT UserFullName FROM users WHERE UserId='" . $row->leads_managed_by . "'", "UserFullName"),
                    DATE_FORMATES("d M, Y", $row->leads_assigned_date),
                    $row->leads_type,
                    FETCH("SELECT config_priority_level_name FROM config_priority_levels WHERE config_priority_level_id='" . $row->leads_priority_level . "'", "config_priority_level_name"),
                    FETCH("SELECT leads_requirement_budgets FROM leads_requirements WHERE leads_main_id='" . $row->leads_id . "'", "leads_requirement_budgets"),
                    FETCH("SELECT UserFullName FROM users WHERE UserId='" . FETCH("SELECT UserReportingManager FROM users WHERE UserId='" . $row->leads_managed_by . "'", "UserReportingManager") . "'", "UserFullName"),
                    DATE_FORMATES("d M, Y", $row->leads_created_at),
                    FETCH("SELECT config_leads_stage_name FROM config_leads_stages WHERE config_leads_stages_id='" . FETCH("SELECT leads_assigned_previous_stages FROM leads_assignees WHERE leads_main_id='" . $row->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previous_stages") . "'", "config_leads_stage_name"),
                    FETCH("SELECT UserFullName FROM users WHERE UserId='" . FETCH("SELECT leads_assigned_previously_to FROM leads_assignees WHERE leads_main_id='" . $row->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_to") . "'", "UserFullName"),
                    FETCH("SELECT UserFullName FROM users WHERE UserId='" . FETCH("SELECT leads_assigned_previously_by FROM leads_assignees WHERE leads_main_id='" . $row->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_by") . "'", "UserFullName"),
                    DATE_FORMATES("d M, Y", FETCH("SELECT leads_assigned_udpated_at FROM leads_assignees WHERE leads_main_id='" . $row->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_udpated_at")),
                    FETCH("SELECT UserFullName FROM users WHERE UserId='" . FETCH("SELECT leads_assigned_udpated_by FROM leads_assignees WHERE leads_main_id='" . $row->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_udpated_by") . "'", "UserFullName"),
                    $row->leads_entry_type,
                    $row->leads_assign_status
                ]);
            }
        }

        fclose($output);
        exit;
    }
}
LOCATION("info", "CSV Report if exported successfully!", APP_URL . "/leads");
