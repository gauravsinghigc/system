<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["SiteVisitCompleted"])) {
    // Retrieve and sanitize form inputs
    $SiteVisitIdForBackend = $_POST["SiteVisitIdForBackend"];
    $LeadsId = $_POST["LeadsId"];
    $photo_details = $_POST["photo_details"];
    $leads_site_visit_response = SECURE($_POST["leads_site_visit_response"], "e");
    $captured_photo = $_POST["captured_photo"];

    // Update leads_site_visits table
    $leads_site_visits = [
        "leads_site_visit_response" => $leads_site_visit_response,
        "leads_site_visit_status" => 2,
        "leads_site_visit_rescheduled_at" => CURRENT_DATE_TIME
    ];
    $Update = UPDATE("leads_site_visits", $leads_site_visits, "leads_site_visit_id='$SiteVisitIdForBackend'");

    // Process base64-encoded photo
    if (preg_match('/^data:image\/(\w+);base64,/', $captured_photo, $type)) {

        // Remove data URI prefix
        $captured_photo = substr($captured_photo, strpos($captured_photo, ',') + 1);
        $captured_photo = base64_decode($captured_photo);

        // Validate image type
        $imageType = strtolower($type[1]);

        // Generate unique filename
        $filename = 'site_visit_' . $SiteVisitIdForBackend . '_' . time() . '.' . $imageType;
        $uploadDir = "../../storage/leads/site-visits/$LeadsId/";
        $filePath = $uploadDir . $filename;

        // Create upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        // Extract geolocation data from photo_details
        $latitude = "";
        $longitude = "";
        $locationName = "Unknown Location";
        $photoDetailsLines = explode("\n", $photo_details);
        foreach ($photoDetailsLines as $line) {
            if (strpos($line, "Coordinates:") === 0) {
                list(, $coords) = explode(": ", $line);
                list($latitude, $longitude) = explode(", ", $coords);
            } elseif (strpos($line, "Location:") === 0) {
                $locationName = substr($line, strlen("Location: "));
            }
        }

        // Insert attachment details
        $Response = INSERT("leads_site_visits_attachements", [
            "leads_activity_main_id" => $SiteVisitIdForBackend,
            "leads_activity_attachement_type" => "IMAGES",
            "leads_activity_attached_file" => $filename,
            "leads_activity_attached_at" => CURRENT_DATE_TIME,
            "leads_activity_attachment_upload_by" => LOGIN_USER_ID,
            "leads_activity_signature" => $photo_details,
            "leads_activity_latitude" => $latitude,
            "leads_activity_longitude" => $longitude,
            "leads_activity_location_name" => $locationName,
        ]);
    }

    //save site visit feedback with or without image 
    //GetLeadsStages and Sub Stage
    if (DEVICE_TYPE == "MOBILE") {
        $DeviceType = "APP";
        $ActivityMethod = "MANUAL";
    } else {
        $DeviceType = "CRM";
        $ActivityMethod = "MANUAL";
    }
    $leads_acitivity_call_status = FETCH("SELECT leads_stages FROM leads WHERE leads_id='$LeadsId'", "leads_stages");
    $leads_acitivity_call_sub_status = FETCH("SELECT leads_sub_stages FROM leads WHERE leads_id='$LeadsId'", "leads_sub_stages");
    $leads_activities = [
        "leads_activity_main_leads_id" => $LeadsId,
        "leads_activity_type" => "🌍 SITE-VISIT-DONE",
        "leads_acitivity_call_status" => $leads_acitivity_call_status,
        "leads_acitivity_call_sub_status" => $leads_acitivity_call_sub_status,
        "leads_activity_feedbacks" => $leads_site_visit_response,
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
        $Update = SQL("UPDATE leads SET leads_remarks='$leads_site_visit_response' where leads_id='$LeadsId'");
    }

    //upload site visit other photos and files that are manually uploaded
    if (isset($_FILES["leads_activity_attached_file"]['name'])) {
        $total_count = count($_FILES["leads_activity_attached_file"]['name']);
        $UploadDir = "../../storage/leads/site-visits/$LeadsId";
        $non_pdf = 0;
        if ($total_count != 0) {
            for ($i = 0; $i < $total_count; $i++) {
                $FileName = $_FILES["leads_activity_attached_file"]['name'][$i];
                //$ProImageType = $_FILES["$FileFieldName"]['type'][$i];
                //$ProImageSize = $_FILES["$FileFieldName"]['size'][$i];
                $ProImageTmpName = $_FILES["leads_activity_attached_file"]['tmp_name'][$i];
                //$ProImageError = $_FILES["$FileFieldName"]['error'][$i];
                $ProImageExt = pathinfo($FileName, PATHINFO_EXTENSION);

                $FileName = "$Projects_Name" . "_" . $i . rand(000000, 999999) . date("d_m_Y_h_m_s_a_") . "." . $ProImageExt;
                $ProImagePath = $UploadDir . "/" . $FileName;
                $FileFieldName = $FileName;

                if ($ProImageExt == 'jpg' || $ProImageExt == 'jpeg' || $ProImageExt == 'png' || $ProImageExt == 'gif' || $ProImageExt == 'bmp') {
                    if (!file_exists("$UploadDir/")) {
                        mkdir("$UploadDir/", 0777, true);
                    }
                    move_uploaded_file($ProImageTmpName, $ProImagePath);
                    $Response = INSERT("leads_site_visits_attachements", [
                        "leads_activity_main_id" => $SiteVisitIdForBackend,
                        "leads_activity_attachement_type" => "IMAGES",
                        "leads_activity_attached_file" => $FileFieldName,
                        "leads_activity_attached_at" => CURRENT_DATE_TIME,
                        "leads_activity_attachment_upload_by" => LOGIN_USER_ID,
                    ]);
                } else {
                    $non_pdf++;
                }
            }
        }
        $Pdfs = $total_count - $non_pdf;
    }


    RequestHandler($Response, [
        "true" => "Site Visit Completion Details are saved successfully!",
        "false" => "Unable to save site visit completion details at the moment!"
    ]);

    //reschedule site visits
} else if (isset($_POST["ReScheduleSiteVisit"])) {
    $SiteVisitIdForBackend = $_POST["SiteVisitIdForBackend"];
    $leads_main_id = $_POST["leads_main_id"];

    $leads_site_visits = [
        "leads_site_visit_status" => 1,
        "leads_site_visit_schedule_date" => $_POST["leads_site_visit_schedule_date"],
        "leads_site_visit_added_by" => LOGIN_USER_ID,
        "leads_site_visit_added_on" => CURRENT_DATE_TIME,
        "leads_site_visit_handled_by" => $_POST["leads_site_visit_handled_by"],
    ];
    $Response = UPDATE("leads_site_visits", $leads_site_visits, "leads_site_visit_id='$SiteVisitIdForBackend'");

    //Check Reminder Options
    if (isset($_POST["CheckReminderOption"])) {
        if ($_POST["CheckReminderOption"] == "true") {
            $leads_reminders = [
                "leads_reminder_main_leads_id" => $leads_main_id,
                "leads_reminder_notes" => SECURE($_POST["Reminder_Message"], "e"),
                "leads_reminder_created_by" => LOGIN_USER_ID,
                "leads_reminder_created_at" => CURRENT_DATE_TIME,
                "leads_reminder_date" => $_POST["reminder_date"],
                "leads_reminder_time" => $_POST["reminder_time"],
                "leads_reminder_status" => 1,
                "leads_reminder_user_id" => $_POST["leads_site_visit_handled_by"],
            ];
            INSERT("leads_reminders", $leads_reminders);
        }
    }

    //Add Feedback Activity For this Side Visit Too
    //GetLeadsStages and Sub Stage
    if (DEVICE_TYPE == "MOBILE") {
        $DeviceType = "APP";
        $ActivityMethod = "MANUAL";
    } else {
        $DeviceType = "CRM";
        $ActivityMethod = "MANUAL";
    }
    $leads_acitivity_call_status = FETCH("SELECT leads_stages FROM leads WHERE leads_id='$leads_main_id'", "leads_stages");
    $leads_acitivity_call_sub_status = FETCH("SELECT leads_sub_stages FROM leads WHERE leads_id='$leads_main_id'", "leads_sub_stages");
    $leads_activities = [
        "leads_activity_main_leads_id" => $leads_main_id,
        "leads_activity_type" => "🌍 SITE-VISIT-RE-SCHEDULED",
        "leads_acitivity_call_status" => $leads_acitivity_call_status,
        "leads_acitivity_call_sub_status" => $leads_acitivity_call_sub_status,
        "leads_activity_feedbacks" => SECURE("Site Visit is Rescheduled by (" . AuthAppUser("UserType") . ") - UID:" . LOGIN_USER_ID . " @ " . AuthAppUser("UserFullName") . " - " . AuthAppUser("UserPhoneNumber"), "e"),
        "leads_activity_added_by" => LOGIN_USER_ID,
        "leads_activity_added_on" => CURRENT_DATE_TIME,
        "leads_activity_created_at" => CURRENT_DATE_TIME,
        "leads_activity_created_by" => LOGIN_USER_ID,
        "leads_activity_call_source" => $DeviceType,
        "leads_activity_call_method" => $ActivityMethod,
        "leads_activity_date_time" => CURRENT_DATE_TIME
    ];
    $Response = INSERT("leads_activities", $leads_activities);

    RequestHandler($Response, [
        "true" => "Site Visit Re-Scheduled Successfully!",
        "false" => "Unable to Re-Schedule Site Visit Details!"
    ]);
}
