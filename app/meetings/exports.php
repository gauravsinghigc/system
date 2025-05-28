<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

if (isset($_GET["ExportSql"])) {

    $GenerateSQL = SECURE($_GET["ExportSql"], "d");

    // Order & limit (optional)
    $ExportLeadsSQL = $GenerateSQL . " ORDER BY DATE(leads_site_visit_schedule_date) DESC";

    $record = SET_SQL($ExportLeadsSQL, true);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Site_Visit_Report_' . date('d_M_Y_h_i_a') . '.csv"');
    $output = fopen('php://output', 'w');

    // CSV Header
    fputcsv($output, [
        'SNo.',
        'CustomerName',
        'PhoneNumber',
        'Project',
        'Site-VisitDate',
        'ManagedBy',
        'Remarks',
        'Status',
        'CreatedBy',
    ]);

    if ($record) {
        $serialNo = 0;
        foreach ($record as $Reminder) {
            $serialNo++;
            $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_main_leads_id . "'";
            $ProjectSQL = "SELECT projects_name from projects where projects_id='" . $Reminder->leads_site_visits_projects_id . "'";
            $ManagedBy = "SELECT UserFullName FROM users where UserId='" . $Reminder->leads_site_visit_handled_by . "'";

            fputcsv($output, [
                $serialNo,
                UpperCase(FETCH($LeadsSQL, "leads_full_name")),
                FETCH($LeadsSQL, "leads_phone_number"),
                FETCH($ProjectSQL, "projects_name"),
                DATE("d M Y", strtotime($Reminder->leads_site_visit_schedule_date)),
                "(UID:" . $Reminder->leads_site_visit_handled_by . ")-" . FETCH($ManagedBy, "UserFullName"),
                SECURE($Reminder->leads_site_visit_notes, "d"),
                SiteVisitStatus($Reminder->leads_site_visit_status, "text"),
                "(UID:" . $Reminder->leads_site_visit_added_by . ")-" . FETCH("SELECT UserFullName FROM users where UserId='" . $Reminder->leads_site_visit_added_by . "'", "UserFullName"),
            ]);
        }
    }

    fclose($output);
    exit;
}
LOCATION("info", "CSV Report if exported successfully!", APP_URL . "/meetings");
