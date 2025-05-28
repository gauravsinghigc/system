<?php
$GetLoginPersonType = UpperCase(AuthAppUser("UserType"));

//Store Sidebar in session as per login person permission and access level
$SessionalActiveSidebar = IfSessionExists("ACTIVE_SIDEBAR", $GetLoginPersonType);
$SidebarValidation = APP_SIDE_BARS[$SessionalActiveSidebar]['module'];
include __DIR__ . "/sidebar/$SidebarValidation";
