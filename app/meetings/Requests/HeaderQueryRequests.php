<?php
//Mark all missed site visits as missed
$UpdateSQL = SQL("UPDATE leads_site_visits SET leads_site_visit_status='4' WHERE leads_site_visit_status='1' and DATE(leads_site_visit_schedule_date)<'" . DATE("Y-m-d") . "'");

//Check Who type of records need to be displayed
$ActiveLeadViewForTeamHead = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", ReturnSessionalValues("LeadViewByTeamHead", "ACTIVE_LEAD_FOR_TEAM_HEADS", "MY-LEADS"));

//Login Base Query Initialization
if (AuthAppUser("UserType") == "ADMIN") {
    $SiteVisitSQL = "SELECT * FROM leads_site_visits, leads WHERE leads_site_visits.leads_main_leads_id=leads.leads_id";
} elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
    if ($ActiveLeadViewForTeamHead == "MY-LEADS") {
        $_SESSION["ACTIVE_DASHBOARD_VIEW"] = "MY-DASHBOARD";
    } else {
        $_SESSION["ACTIVE_DASHBOARD_VIEW"] = "TEAM-DASHBOARD";
    }
    if ($_SESSION["ACTIVE_DASHBOARD_VIEW"] == "MY-DASHBOARD") {
        $SiteVisitSQL = "SELECT * FROM leads_site_visits, leads WHERE leads_site_visits.leads_main_leads_id=leads.leads_id AND leads_site_visit_handled_by='" . LOGIN_USER_ID . "'";
    } else {
        $SiteVisitSQL = "SELECT * FROM leads_site_visits, users, leads WHERE leads_site_visits.leads_main_leads_id=leads.leads_id AND leads_site_visits.leads_site_visit_handled_by=users.UserId AND users.UserReportingManager='" . LOGIN_USER_ID . "'";
    }
} else {
    $SiteVisitSQL = "SELECT * FROM leads_site_visits, leads WHERE leads_site_visits.leads_main_leads_id=leads.leads_id AND leads_site_visit_handled_by='" . LOGIN_USER_ID . "'";
}

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
