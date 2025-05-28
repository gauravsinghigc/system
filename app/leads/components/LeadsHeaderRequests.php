<?php
$GetRecordsColumns = "leads_gender, leads_id, leads_full_name, leads_phone_number, leads_assign_status, leads_entry_type, leads_alternate_phone, leads_projects_id, leads_stages, leads_type, leads_sub_stages, leads_source, leads_re_source, leads_managed_by, leads_assigned_date, leads_priority_level, leads_created_at ";
//advance filters
if (isset($_GET["ApplyAdvancefilters"])) {
    if (AuthAppUser("UserType") == "ADMIN") {
        $GenerateSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_is_removed!='1'";
    } elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
        $CheckLeadViewType = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", "TEAM-LEADS");
        if ($CheckLeadViewType == "TEAM-LEADS") {
            $GenerateSQL = "SELECT $GetRecordsColumns FROM leads, users WHERE leads.leads_managed_by=users.UserId and UserReportingManager='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
        } else {
            $GenerateSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
        }
    } else {
        $GenerateSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
    }

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

    // Date Filters
    if (!empty(trim($_GET["leads_added_on_from_date"]))) {
        $GenerateSQL .= " AND DATE(leads_created_at) >= '" . trim($_GET["leads_added_on_from_date"]) . "'";
    }

    if (!empty(trim($_GET["leads_added_on_to_date"]))) {
        $GenerateSQL .= " AND DATE(leads_created_at) <= '" . trim($_GET["leads_added_on_to_date"]) . "'";
    }

    if (!empty(trim($_GET["leads_assigned_on_from_date"]))) {
        $GenerateSQL .= " AND DATE(leads_assigned_date) >= '" . trim($_GET["leads_assigned_on_from_date"]) . "'";
    }

    if (!empty(trim($_GET["leads_assigned_on_to_date"]))) {
        $GenerateSQL .= " AND DATE(leads_assigned_date) <= '" . trim($_GET["leads_assigned_on_to_date"]) . "'";
    }

    if (!empty(trim($_GET["leads_updated_at_from"]))) {
        $GenerateSQL .= " AND DATE(leads_updated_at) >= '" . trim($_GET["leads_updated_at_from"]) . "'";
    }

    if (!empty(trim($_GET["leads_updated_at_to"]))) {
        $GenerateSQL .= " AND DATE(leads_updated_at) <= '" . trim($_GET["leads_updated_at_to"]) . "'";
    }

    $PaginationTotalSQL = $GenerateSQL;
    $AllLeadsSQL = $GenerateSQL;
} else if (isset($_GET['Search_Phone_Number']) && !empty(trim($_GET['Search_Phone_Number']))) {
    $search = trim($_GET['Search_Phone_Number']);
    // Use parameterized query to prevent SQL injection

    if (AuthAppUser("UserType") == "ADMIN") {
        $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_phone_number LIKE '%" . addslashes($search) . "%' and leads_is_removed!= '1'";
    } elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
        $CheckLeadViewType = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", "TEAM-LEADS");
        if ($CheckLeadViewType == "TEAM-LEADS") {
            $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads, users WHERE leads.leads_managed_by=users.UserId and UserReportingManager='" . LOGIN_USER_ID . "' and leads_phone_number LIKE '%" . addslashes($search) . "%' and leads_is_removed!= '1'";
        } else {
            $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_phone_number LIKE '%" . addslashes($search) . "%' and leads_is_removed!= '1'";
        }
    } else {
        $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_phone_number LIKE '%" . addslashes($search) . "%' and leads_is_removed!= '1'";
    }

    //lead stage search
} else if (isset($_GET["leads_stages_dash"])) {
    $leads_stages = $_GET["leads_stages_dash"];

    // Use parameterized query to prevent SQL injection
    if (AuthAppUser("UserType") == "ADMIN") {
        $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_stages='$leads_stages' and leads_is_removed!= '1'";
    } elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
        $CheckLeadViewType = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", "TEAM-LEADS");
        if ($CheckLeadViewType == "TEAM-LEADS") {
            $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads, users WHERE leads.leads_managed_by=users.UserId and UserReportingManager='" . LOGIN_USER_ID . "' and leads_stages='$leads_stages'  and leads_is_removed!='1'";
        } else {
            $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_stages='$leads_stages'  and leads_is_removed!='1'";
        }
    } else {
        $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_stages='$leads_stages' and leads_is_removed!='1'";
    }

    //default 
} else {

    // Use parameterized query to prevent SQL injection
    if (AuthAppUser("UserType") == "ADMIN") {
        $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_is_removed!= '1'";
    } elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
        $CheckLeadViewType = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", "TEAM-LEADS");
        if ($CheckLeadViewType == "TEAM-LEADS") {
            $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads, users WHERE leads.leads_managed_by=users.UserId and UserReportingManager='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
        } else {
            $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
        }
    } else {
        $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
    }
}
