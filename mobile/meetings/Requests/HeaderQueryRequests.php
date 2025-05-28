<?php
//Mark all missed site visits as missed
$TodayDateTime = DATE("Y-m-d");

//check today or previously active site visit that are untouched by users
$TotalActiveSiteVisits = TOTAL("SELECT leads_site_visit_schedule_date FROM leads_site_visits where leads_site_visit_status='1' and DATE(leads_site_visit_schedule_date)<'$TodayDateTime'");
if ($TotalActiveSiteVisits != null) {
    SQL("UPDATE leads_site_visits SET leads_site_visit_status='4' WHERE leads_site_visit_status='1' and DATE(leads_site_visit_schedule_date)<'$TodayDateTime'");
}
$SiteVisitSQL = "SELECT leads_site_visit_id, leads_site_visit_status, leads_site_visit_notes, leads_site_visit_schedule_date, leads_site_visits_projects_id, leads_main_leads_id FROM leads_site_visits, leads WHERE leads_site_visits.leads_main_leads_id=leads.leads_id AND leads_site_visit_handled_by='" . LOGIN_USER_ID . "'";


//Conditional Queries
$GeneratedSQL = $SiteVisitSQL;

if (isset($_GET["InstantSiteVisitStatus"])) {
    $GeneratedSQL .= " AND leads_site_visit_status = '" . $_GET["InstantSiteVisitStatus"] . "'";
} else if (isset($_GET["getSiteVisitFor"])) {
    $GeneratedSQL .= " AND DATE(leads_site_visit_schedule_date) = '" . $_GET["getSiteVisitFor"] . "'";
} else if (isset($_GET["AdvanceSiteVisitFilters"])) {

    $GeneratedSQL .= " AND leads_full_name LIKE '%" . $_GET["leads_full_name"] . "%'";
    $GeneratedSQL .= " AND leads_phone_number LIKE '%" . $_GET["leads_phone_number"] . "%'";

    if (!empty(trim($_GET['leads_site_visit_schedule_date_from']))) {
        $GeneratedSQL .= " AND DATE(leads_site_visit_schedule_date) >= '" . $_GET["leads_site_visit_schedule_date_from"] . "'";
    }

    if (!empty(trim($_GET['leads_site_visit_schedule_date_to']))) {
        $GeneratedSQL .= " AND DATE(leads_site_visit_schedule_date) <= '" . $_GET["leads_site_visit_schedule_date_to"] . "'";
    }

    if (!empty(trim($_GET['leads_site_visits_projects_id']))) {
        $GeneratedSQL .= " AND leads_site_visits_projects_id = '" . $_GET["leads_site_visits_projects_id"] . "'";
    }

    if (!empty(trim($_GET['leads_site_visit_status']))) {
        $GeneratedSQL .= " AND leads_site_visit_status = '" . $_GET["leads_site_visit_status"] . "'";
    }

    if (!empty(trim($_GET["leads_site_visit_handled_by"]))) {
        $GeneratedSQL .= " AND leads_site_visit_handled_by = '" . $_GET["leads_site_visit_handled_by"] . "'";
    }

    if (!empty(trim($_GET["leads_site_visit_created_by"]))) {
        $GeneratedSQL .= " AND leads_site_visit_added_by = '" . $_GET["leads_site_visit_created_by"] . "'";
    }
}
