<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";


if (isset($_POST["AddInstantFeedBackActivity"])) {
   $LeadsId = $_POST["leads_id"];

   if (DEVICE_TYPE == "MOBILE") {
      $DeviceType = "APP";
      $ActivityMethod = "MANUAL";
   } elseif (DEVICE_TYPE == "TABLET") {
      $DeviceType = "APP(T)";
      $ActivityMethod = "MANUAL";
   } else {
      $DeviceType = "CRM";
      $ActivityMethod = "MANUAL";
   }

   $leads_activities = [
      "leads_activity_main_leads_id" => $LeadsId,
      "leads_activity_type" => "OUTGOING",
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
   $Response = INSERT("leads_activities", $leads_activities);
   if ($Response == true) {
      $Update = SQL("UPDATE leads SET leads_sub_stages='" . $_POST["leads_acitivity_call_sub_status"] . "', leads_stages='" . $_POST["leads_acitivity_call_status"] . "', leads_call_status='" . $_POST["leads_acitivity_call_status"] . "', leads_call_sub_status='" . $_POST["leads_acitivity_call_sub_status"] . "' where leads_id='$LeadsId'");
   }

   if (isset($_POST["add_reminder"])) {
      if ($_POST["add_reminder"] == "1") {
         $leads_reminders = [
            "leads_reminder_name" => "Call Reminder",
            "leads_reminder_main_leads_id" => $LeadsId,
            "leads_reminder_date" => DATE_FORMATES("Y-m-d", $_POST["leads_reminder_date"]),
            "leads_reminder_time" => DATE_FORMATES("h:i:s A", $_POST["leads_reminder_date"]),
            "leads_reminder_notes" => SECURE($_POST["leads_activity_feedbacks"], "e"),
            "leads_reminder_user_id" => LOGIN_USER_ID,
            "leads_reminder_status" => 0,
            "leads_reminder_re_remind_time" => 10,
            "leads_reminder_created_at" => CURRENT_DATE_TIME,
            "leads_reminder_created_by" => LOGIN_USER_ID,
         ];
         $Response = INSERT("leads_reminders", $leads_reminders);
      }
   }

   if (isset($_POST["schedule_site_visit"])) {
      if ($_POST["schedule_site_visit"] == 1) {
         $leads_site_visits = [
            "leads_main_leads_id" => $LeadsId,
            "leads_site_visit_status" => 1,
            "leads_site_visit_schedule_date" => $_POST["site_visit_date"],
            "leads_site_visit_notes" => SECURE($_POST["leads_activity_feedbacks"], "e"),
            "leads_site_visit_added_by" => LOGIN_USER_ID,
            "leads_site_visit_added_on" => CURRENT_DATE_TIME,
            "leads_site_visit_handled_by" => LOGIN_USER_ID,
            "leads_site_visits_projects_id" => $_POST["ProjectsId"],
         ];
         $Response = INSERT("leads_site_visits", $leads_site_visits, true);
      }
   }

   RequestHandler($Response, [
      "true" => "Feedback is Added Successfully!",
      "false" => "Unable to Add Feedback At the moment!"
   ]);
}
