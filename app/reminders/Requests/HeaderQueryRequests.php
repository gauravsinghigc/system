<?php
//Mark all missed site visits as missed
$UpdateSQL = SQL("UPDATE leads_reminders SET leads_reminder_status='3' WHERE leads_reminder_status='0' and DATE(leads_reminder_date)<'" . DATE("Y-m-d") . "'");

//Check Who type of records need to be displayed
$ActiveLeadViewForTeamHead = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", ReturnSessionalValues("LeadViewByTeamHead", "ACTIVE_LEAD_FOR_TEAM_HEADS", "MY-LEADS"));


//Login Base Query Initialization
if (AuthAppUser("UserType") == "ADMIN") {
    $AllLeadsReminders = "SELECT * FROM leads_reminders, leads WHERE leads_reminders.leads_reminder_main_leads_id=leads.leads_id";
} elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
    if ($ActiveLeadViewForTeamHead == "MY-LEADS") {
        $_SESSION["ACTIVE_DASHBOARD_VIEW"] = "MY-DASHBOARD";
    } else {
        $_SESSION["ACTIVE_DASHBOARD_VIEW"] = "TEAM-DASHBOARD";
    }

    if ($_SESSION["ACTIVE_DASHBOARD_VIEW"] == "MY-DASHBOARD") {
        $AllLeadsReminders = "SELECT * FROM leads_reminders, leads WHERE leads_reminders.leads_reminder_main_leads_id=leads.leads_id AND leads_reminder_user_id='" . LOGIN_USER_ID . "'";
    } else {
        $AllLeadsReminders = "SELECT * FROM leads_reminders, users, leads WHERE leads_reminders.leads_reminder_main_leads_id=leads.leads_id AND leads_reminders.leads_reminder_user_id=users.UserId AND users.UserReportingManager='" . LOGIN_USER_ID . "'";
    }
} else {
    $AllLeadsReminders = "SELECT * FROM leads_reminders, leads WHERE leads_reminders.leads_reminder_main_leads_id=leads.leads_id AND leads_reminder_user_id='" . LOGIN_USER_ID . "'";
}

//Conditional Queries
$GeneratedSQL = $AllLeadsReminders;

if (isset($_GET["InstantReminderStatusView"])) {
    $GeneratedSQL .= " AND leads_reminder_status = '" . $_GET["InstantReminderStatusView"] . "'";
} else if (isset($_GET["InstantReminderStatusView"])) {
    $GeneratedSQL .= " AND DATE(leads_reminder_date) = '" . $_GET["InstantReminderStatusView"] . "'";
} else if (isset($_GET["AdvanceSiteVisitFilters"])) {

    $GeneratedSQL .= " AND leads_full_name LIKE '%" . $_GET["leads_full_name"] . "%'";
    $GeneratedSQL .= " AND leads_phone_number LIKE '%" . $_GET["leads_phone_number"] . "%'";

    if (!empty(trim($_GET['leads_reminder_date_from']))) {
        $GeneratedSQL .= " AND DATE(leads_reminder_date) >= '" . $_GET["leads_reminder_date_from"] . "'";
    }

    if (!empty(trim($_GET['leads_reminder_date_to']))) {
        $GeneratedSQL .= " AND DATE(leads_reminder_date) <= '" . $_GET["leads_reminder_date_to"] . "'";
    }

    if (!empty(trim($_GET['leads_reminder_status']))) {
        $GeneratedSQL .= " AND leads_reminder_status = '" . $_GET["leads_reminder_status"] . "'";
    }

    if (!empty(trim($_GET["leads_reminder_user_id"]))) {
        $GeneratedSQL .= " AND leads_reminder_user_id = '" . $_GET["leads_reminder_user_id"] . "'";
    }

    if (!empty(trim($_GET["leads_reminder_created_by"]))) {
        $GeneratedSQL .= " AND leads_reminder_created_by = '" . $_GET["leads_reminder_created_by"] . "'";
    }
}
