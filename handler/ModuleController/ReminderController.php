<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["DropReminder"])) {
    $leads_reminder_id = SECURE($_POST["leads_reminder_id"], "d");

    $leads_reminders = [
        "leads_reminder_status" => 2
    ];
    $Response = UPDATE("leads_reminders", $leads_reminders, "leads_reminder_id='$leads_reminder_id'");

    RequestHandler($Response, [
        "true" => "Reminder Dropped Successfully!",
        "false" => "Unable to Drop Reminder At the Moment!"
    ]);

    //add feedback via reminders
} elseif (isset($_POST["AddFeedBackViaReminders"])) {
    $LeadsId = $_POST["leads_main_id"];
    $ReminderId = $_POST["ReminderId"];

    if (DEVICE_TYPE == "MOBILE") {
        $DeviceType = "APP";
        $ActivityMethod = "MANUAL";
    } elseif (DEVICE_TYPE == "TABLET") {
        $DeviceType = "APP";
        $ActivityMethod = "MANUAL";
    } else {
        $DeviceType = "CRM";
        $ActivityMethod = "MANUAL";
    }

    $leads_activities = [
        "leads_activity_main_leads_id" => $LeadsId,
        "leads_activity_type" => "OUTGOING (REMINDER-CALL)",
        "leads_acitivity_call_status" => $_POST["leads_acitivity_call_status"],
        "leads_acitivity_call_sub_status" => $_POST["leads_acitivity_call_sub_status"],
        "leads_activity_feedbacks" => SECURE($_POST["leads_activity_feedbacks"], "e"),
        "leads_activity_added_by" => LOGIN_USER_ID,
        "leads_activity_added_on" => CURRENT_DATE_TIME,
        "leads_activity_created_at" => CURRENT_DATE_TIME,
        "leads_activity_created_by" => LOGIN_USER_ID,
        "leads_activity_call_source" => $DeviceType,
        "leads_activity_call_method" => $ActivityMethod,
        "leads_activity_date_time" => CURRENT_DATE_TIME
    ];
    $Response = INSERT("leads_activities", $leads_activities, true);
    $leads_reminders = [
        "leads_reminder_status" => 1
    ];
    $Response = UPDATE("leads_reminders", $leads_reminders, "leads_reminder_id='$ReminderId'");
    $Update = SQL("UPDATE leads SET leads_sub_stages='" . $_POST["leads_acitivity_call_sub_status"] . "', leads_stages='" . $_POST["leads_acitivity_call_status"] . "', leads_call_status='" . $_POST["leads_acitivity_call_status"] . "', leads_call_sub_status='" . $_POST["leads_acitivity_call_sub_status"] . "' where leads_id='$LeadsId'");

    RequestHandler($Response, [
        "true" => "Feedback is Added Successfully!",
        "false" => "Unable to Add Feedback At the moment!"
    ]);
}
