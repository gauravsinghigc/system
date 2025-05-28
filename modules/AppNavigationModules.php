<?php
//sidebar
DEFINE("APP_SIDE_BARS", [
    "ADMIN" => [
        "icon" => "bi bi-person",
        "module" => "AdminSidebar.php"
    ],
    "USER" => [
        "icon" => "bi bi-person",
        "module" => "UserSidebar.php"
    ],
    "TEAM_HEAD" => [
        "icon" => "bi bi-person",
        "module" => "TeamHeadSidebar.php"
    ]
]);

DEFINE("ADMIN_SIDEBAR_MENUS", [
    "dashboard" => [
        "name" => "Dashboard",
        "icon" => "bi bi-grid",
        "url" => APP_URL . "/?menu=dashboard"
    ],
    "contacts" => [
        "name" => "All " . TYPE_OF_RECORDS,
        "icon" => "bi bi-person",
        "url" => APP_URL . "/leads?menu=contacts"
    ],
    "projects" => [
        "name" => "All " . LISTING_TYPES,
        "icon" => "bi bi-list-stars",
        "url" => APP_URL . "/projects?menu=projects"
    ],
    "meetings" => [
        "name" => "All Site Visits",
        "icon" => "bi bi-person-raised-hand",
        "url" => APP_URL . "/meetings?menu=meetings"
    ],
    "reminders" => [
        "name" => "All Reminders",
        "icon" => "bi bi-bell",
        "url" => APP_URL . "/reminders?menu=reminders"
    ],
    "users" => [
        "name" => "All " . TYPES_OF_USERS,
        "icon" => "bi bi-people",
        "url" => APP_URL . "/users?menu=users"
    ],
    "reports" => [
        "name" => "Teams Reports",
        "icon" => "bi bi-bar-chart-line",
        "url" => APP_URL . "/reports?menu=reports"
    ],
    "calender" => [
        "name" => "My Calendar",
        "icon" => "bi bi-calendar-event",
        "url" => APP_URL . "/calender?menu=calender"
    ],
    "settings" => [
        "name" => "System Configurations",
        "icon" => "bi bi-building-fill-gear",
        "url" => APP_URL . "/settings?menu=settings"
    ],
    "integration" => [
        "name" => "Integration & Plugins",
        "icon" => "bi bi-plugin",
        "url" => APP_URL . "/plugins?menu=integration"
    ],
    "support" => [
        "name" => "Help & Support",
        "icon" => "bi bi-patch-question-fill",
        "url" => APP_URL . "/support?menu=support"
    ],
    "audits" => [
        "name" => "Trash Records",
        "icon" => "bi bi-trash",
        "url" => APP_URL . "/audits?menu=audits"
    ],
    "profile" => [
        "name" => "My Profile",
        "icon" => "bi bi-person",
        "url" => APP_URL . "/profile?menu=profile"
    ],
    "logout" => [
        "name" => "Logout",
        "icon" => "bi bi-box-arrow-left",
        "url" => APP_URL . "/logout"
    ]
]);

DEFINE("TEAM_HEAD_SIDEBARS", [
    "dashboard" => [
        "name" => "Dashboard",
        "icon" => "bi bi-grid",
        "url" => APP_URL . "/?menu=dashboard"
    ],
    "contacts" => [
        "name" => "All " . TYPE_OF_RECORDS,
        "icon" => "bi bi-person",
        "url" => APP_URL . "/leads?menu=contacts"
    ],
    "projects" => [
        "name" => "All " . LISTING_TYPES,
        "icon" => "bi bi-list-stars",
        "url" => APP_URL . "/projects?menu=projects"
    ],
    "meetings" => [
        "name" => "All Site Visits",
        "icon" => "bi bi-person-raised-hand",
        "url" => APP_URL . "/meetings?menu=meetings"
    ],
    "reminders" => [
        "name" => "All Reminders",
        "icon" => "bi bi-bell",
        "url" => APP_URL . "/reminders?menu=reminders"
    ],
    "reports" => [
        "name" => "Teams Reports",
        "icon" => "bi bi-bar-chart-line",
        "url" => APP_URL . "/reports?menu=reports"
    ],
    "calender" => [
        "name" => "My Calendar",
        "icon" => "bi bi-calendar-event",
        "url" => APP_URL . "/calender?menu=calender"
    ],
    "support" => [
        "name" => "Help & Support",
        "icon" => "bi bi-patch-question-fill",
        "url" => APP_URL . "/support?menu=support"
    ],
    "profile" => [
        "name" => "My Profile",
        "icon" => "bi bi-person",
        "url" => APP_URL . "/profile?menu=profile"
    ],
    "logout" => [
        "name" => "Logout",
        "icon" => "bi bi-box-arrow-left",
        "url" => APP_URL . "/logout"
    ]
]);

DEFINE("USER_SIDEBAR_MENUS", [
    "dashboard" => [
        "name" => "Dashboard",
        "icon" => "bi bi-grid",
        "url" => APP_URL . "/?menu=dashboard"
    ],
    "contacts" => [
        "name" => "All " . TYPE_OF_RECORDS,
        "icon" => "bi bi-person",
        "url" => APP_URL . "/leads?menu=contacts"
    ],
    "projects" => [
        "name" => "All " . LISTING_TYPES,
        "icon" => "bi bi-list-stars",
        "url" => APP_URL . "/projects?menu=projects"
    ],
    "meetings" => [
        "name" => "My Site Visits",
        "icon" => "bi bi-person-raised-hand",
        "url" => APP_URL . "/meetings?menu=meetings"
    ],
    "reminders" => [
        "name" => "All Reminders",
        "icon" => "bi bi-bell",
        "url" => APP_URL . "/reminders?menu=reminders"
    ],
    "reports" => [
        "name" => "Teams Reports",
        "icon" => "bi bi-people-fill",
        "url" => APP_URL . "/reports?menu=reports"
    ],
    "calender" => [
        "name" => "My Calendar",
        "icon" => "bi bi-calendar-event",
        "url" => APP_URL . "/calender?menu=calender"
    ],
    "support" => [
        "name" => "Help & Support",
        "icon" => "bi bi-patch-question-fill",
        "url" => APP_URL . "/support?menu=support"
    ],
    "profile" => [
        "name" => "My Profile",
        "icon" => "bi bi-person",
        "url" => APP_URL . "/profile?menu=profile"
    ],
    "logout" => [
        "name" => "Logout",
        "icon" => "bi bi-box-arrow-left",
        "url" => APP_URL . "/logout"
    ]
]);

define("MASTER_DATA_MENUS", [
    "stages" => [
        "name" => TYPE_OF_RECORDS . " Stages",
        "icon" => "bi bi-bar-chart-steps",
        "url" => APP_URL . "/settings/?master=stages",
        "module" => "stages_view.php"
    ],
    "calls_sub_status" => [
        "name" => TYPE_OF_RECORDS . " Sub Stages",
        "icon" => "bi bi-subtract",
        "url" => APP_URL . "/settings/?master=calls_sub_status",
        "module" => "call_sub_status.php"
    ],
    "sources" => [
        "name" => TYPE_OF_RECORDS . " Sources",
        "icon" => "bi bi-share",
        "url" => APP_URL . "/settings/?master=sources",
        "module" => "sources_view.php"
    ],
    "resources" => [
        "name" => TYPE_OF_RECORDS . " Resources",
        "icon" => "bi bi-people",
        "url" => APP_URL . "/settings/?master=resources",
        "module" => "resources_view.php"
    ],
    "priority_levels" => [
        "name" => TYPE_OF_RECORDS . " Priority Levels",
        "icon" => "bi bi-water",
        "url" => APP_URL . "/settings/?master=priority_levels",
        "module" => "priority_levels.php"
    ],
    "listing_types" => [
        "name" => LISTING_TYPES . " Types",
        "icon" => "bi bi-card-list",
        "url" => APP_URL . "/settings/?master=listing_types",
        "module" => "project_types.php"
    ],
    "listing_stages" => [
        "name" => LISTING_TYPES . " Stages",
        "icon" => "bi bi-list-stars",
        "url" => APP_URL . "/settings/?master=listing_stages",
        "module" => "project_stages.php"
    ],
    "listing_locations" => [
        "name" => LISTING_TYPES . " Locations",
        "icon" => "bi bi-geo-alt",
        "url" => APP_URL . "/settings/?master=listing_locations",
        "module" => "project_locations.php"
    ],
    "projects_status" => [
        "name" => LISTING_TYPES . " Status",
        "icon" => "bi bi-list",
        "url" => APP_URL . "/settings/?master=projects_status",
        "module" => "project_status.php"
    ]
]);

//project entry steps
DEFINE("PROJECT_ENTRY_STEPS", [
    "primary_info" => [
        "name" => "Project Details",
        "icon" => "bi bi-building-exclamation",
        "module" => "project_details.php"
    ],
    "developer_info" => [
        "name" => "Developer Details",
        "icon" => "bi bi-person",
        "module" => "developer_details.php"
    ],
    "media" => [
        "name" => "Images/Video/Brochures",
        "icon" => "bi bi-camera-video",
        "module" => "media_upload.php"
    ],
    "amenities" => [
        "name" => "Project Amenities",
        "icon" => "bi bi-list-stars",
        "module" => "amenities_view.php"
    ]
]);

//app bottom navbar
DEFINE("APP_BOTTOM_NAVBAR", [
    "app_dashboard" => [
        "name" => "Dashboard",
        "icon" => "bi bi-speedometer",
        "dir" => DOMAIN . "/mobile?app_view=app_dashboard"
    ],
    "app_leads" => [
        "name" => "Leads",
        "icon" => "bi bi-star-fill",
        "dir" => DOMAIN . "/mobile/leads?app_view=app_leads",
    ],
    "app_reminders" => [
        "name" => "Reminders",
        "icon" => "bi bi-alarm-fill",
        "dir" => DOMAIN . "/mobile/reminders?app_view=app_reminders",
    ],
    "app_visits" => [
        "name" => "Site-Visits",
        "icon" => "bi bi-geo-alt-fill",
        "dir" => DOMAIN . "/mobile/meetings?app_view=app_visits",
    ],
    "app_teams" => [
        "name" => "My Team",
        "icon" => "bi bi-person-lines-fill",
        "dir" => DOMAIN . "/mobile/teams?app_view=app_teams",
    ]
]);


DEFINE("TEAM_REPORTS_NAV_LINKS", [
    "leads" => [
        "name" => "All Leads",
        "icon" => "bi bi-person",
        "module" => "TeamLeads.php"
    ],
    "calls" => [
        "name" => "Call History",
        "icon" => "bi bi-clock-history",
        "module" => "TeamCalls.php"
    ],
    "meetings" => [
        "name" => "Site Visits",
        "icon" => "bi bi-person-rolodex",
        "module" => "TeamMeetings.php"
    ],
    "teammembers" => [
        "name" => "Team Members",
        "icon" => "bi bi-person",
        "module" => "TeamMembers.php"
    ],
    "logins" => [
        "name" => "Login Logs",
        "icon" => "bi bi-list-stars",
        "module" => "TeamLogins.php"
    ],
]);


DEFINE("DASHBOARD_VIEW_FOR_TEAM_HEADS", [
    "MY-DASHBOARD" => "CounterWidgets.php",
    "TEAM-DASHBOARD" => "TeamCounterWidgets.php"
]);

DEFINE("TEAM_HEAD_LEAD_VIEW_OPTIONS", [
    "MY-LEADS" => "MY-DASHBOARD",
    "TEAM-LEADS" => "TEAM-DASHBOARD"
]);

DEFINE("CALENDER_ACTIVITY", [
    "leads" => [
        "name" => "All Leads",
        "icon" => "fa fa-star",
        "module" => "AllLeads.php"
    ],
    "allcalls" => [
        "name" => "All Calls",
        "icon" => "fa fa-phone",
        "module" => "AllCalls.php"
    ],
    "sitevisits" => [
        "name" => "All Site Visits",
        "icon" => "fa fa-map-marker",
        "module" => "AllSiteVisits.php"
    ],
    "reminders" => [
        "name" => "All Reminders",
        "icon" => "fa fa-bell",
        "module" => "Reminders.php"
    ],
]);
