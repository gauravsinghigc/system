<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["AddNewContactRecords"])) {
    if (LOGIN_USER_ID == 1) {
        $leads_is_created_by_admin = 1;
    } else {
        $leads_is_created_by_admin = 0;
    }
    $leads = [
        "leads_full_name" => $_POST["leads_full_name"],
        "leads_phone_number" => $_POST["leads_phone_number"],
        "leads_alternate_phone" => $_POST["leads_alternate_phone"],
        "leads_email_id" => $_POST["leads_email_id"],
        "leads_gender" => $_POST["leads_gender"],
        "leads_marital_status" => $_POST["leads_marital_status"],
        "leads_created_by" => LOGIN_USER_ID,
        "leads_updated_by" => LOGIN_USER_ID,
        "leads_created_at" => CURRENT_DATE_TIME,
        "leads_updated_at" => CURRENT_DATE_TIME,
        "leads_type" => $_POST["leads_type"],
        "leads_source" => $_POST["leads_source"],
        "leads_is_created_by_admin" => $leads_is_created_by_admin,
        "leads_entry_type" => "CREATED",
        "leads_stages" => $_POST["leads_acitivity_call_status"],
        "leads_sub_stages" => $_POST["leads_acitivity_call_sub_status"],
        "leads_status" => "ACTIVE",
        "leads_assign_status" => 0,
        "leads_managed_by" => $_POST["leads_assigned_to"],
        "leads_re_source" => $_POST["leads_re_source"],
        "leads_assigned_by" => $_POST["leads_assigned_by"],
        "leads_projects_id" => $_POST["leads_project_id"]
    ];

    $LeadSQL = "SELECT leads_id FROM leads where leads_phone_number='" . $_POST['leads_phone_number'] . "'";
    $CheckPhoneNumber = null;

    if ($CheckPhoneNumber == null) {
        $Response = INSERT("leads", $leads);

        //get leads id
        $leads_id = FETCH("SELECT leads_id FROM leads where leads_phone_number='" . $_POST['leads_phone_number'] . "'", "leads_id");

        //leads 
        $leads_requirements = [
            "leads_main_id" => $leads_id,
            "leads_project_id" => $_POST["leads_project_id"],
            "leads_requirement_budgets" => $_POST["leads_requirement_budgets"],
            "leads_requirement_preffered_location" => $_POST["leads_requirement_preffered_location"],
            "leads_requirement_duration" => $_POST["leads_requirement_duration"],
            "leads_requirement_added_by" => LOGIN_USER_ID,
            "leads_requirement_added_at" => CURRENT_DATE_TIME,
            "leads_requirement_modified_at" => CURRENT_DATE_TIME,
            "leads_requirement_modified_by" => LOGIN_USER_ID,
            "leads_requirement_added_by_admin" => $leads_is_created_by_admin,
            "leads_requirement_added_by_admin_at" => CURRENT_DATE_TIME,
        ];
        INSERT("leads_requirements", $leads_requirements);


        //leads assigned to
        if (isset($_POST["leads_acitivity_call_status"])) {
            $leads_assignees = [
                "leads_main_id" => $leads_id,
                "leads_assigned_to" => $_POST["leads_assigned_to"],
                "leads_assigned_by" => $_POST["leads_assigned_by"],
                "leads_assigned_on" => CURRENT_DATE_TIME,
                "leads_assigned_stages" => $_POST["leads_acitivity_call_status"],
                "leads_assigned_priority_level" => $_POST["leads_assigned_priority_level"],
            ];
            INSERT("leads_assignees", $leads_assignees);
        }


        //check file uploaded or not or empty 
        if (!empty($_FILES['leads_activity_voice_notes_file']['name']) && $_FILES['leads_activity_voice_notes_file']['size'] > 0) {
            $leads_activity_voice_notes_file = UPLOAD_FILES("../../storage/leads/audios/$leads_id", "", $_POST['leads_phone_number'], "leads_activity_voice_notes_file");
            $leads_activity_have_voice_notes = 1;
            $leads_activity_voice_notes_file = $leads_activity_voice_notes_file;
        } else {
            $leads_activity_have_voice_notes = 0;
            $leads_activity_voice_notes_file = "";
        }
        $leads_activities = [
            "leads_activity_main_leads_id" => $leads_id,
            "leads_activity_type" => "FEEDBACK",
            "leads_acitivity_call_status" => $_POST["leads_acitivity_call_status"],
            "leads_acitivity_call_sub_status" => $_POST["leads_acitivity_call_sub_status"],
            "leads_activity_feedbacks" => SECURE($_POST["leads_activity_feedbacks"], "e"),
            "leads_activity_added_by" => LOGIN_USER_ID,
            "leads_activity_added_on" => CURRENT_DATE_TIME,
            "leads_activity_created_at" => CURRENT_DATE_TIME,
            "leads_activity_created_by" => LOGIN_USER_ID,
            "leads_activity_have_voice_notes" => $leads_activity_have_voice_notes,
            "leads_activity_voice_notes_file" => $leads_activity_voice_notes_file,
            "leads_activity_call_source" => "CRM",
            "leads_activity_call_method" => "MANUAL"
        ];
        INSERT("leads_activities", $leads_activities);

        //save reminder if have
        if (isset($_POST["REMINDER_DATE_TIME"]) != null) {
            if ($_POST["REMINDER_DATE_TIME"] != null) {
                $leads_reminders = [
                    "leads_reminder_main_leads_id" => $leads_id,
                    "leads_reminder_notes" => htmlspecialchars($_POST["REMINDER_REMARKS"]),
                    "leads_reminder_created_by" => LOGIN_USER_ID,
                    "leads_reminder_created_at" => CURRENT_DATE_TIME,
                    "leads_reminder_date" => $_POST["REMINDER_DATE_TIME"],
                    "leads_reminder_time" => $_POST["REMINDER_DATE_TIME"],
                    "leads_reminder_status" => 1,
                    "leads_reminder_user_id" => LOGIN_USER_ID,
                ];
                INSERT("leads_reminders", $leads_reminders);
            }
        }

        //if have site visits feedbacks too
        if (isset($_POST["SITE_VISIT_DATE_TIME"]) != null) {
            if ($_POST["SITE_VISIT_DATE_TIME"] != null) {
                $leads_site_visits = [
                    "leads_main_leads_id" => $leads_id,
                    "leads_site_visit_status" => $_POST["SITE_VISIT_STATUS"],
                    "leads_site_visit_schedule_date" => $_POST["SITE_VISIT_DATE_TIME"],
                    "leads_site_visit_notes" => htmlspecialchars($_POST["SITE_VISIT_REMARKS"]),
                    "leads_site_visit_added_by" => LOGIN_USER_ID,
                    "leads_site_visit_added_on" => CURRENT_DATE_TIME,
                    "leads_site_visit_handled_by" => LOGIN_USER_ID
                ];
                INSERT("leads_site_visits", $leads_site_visits);
                $leads_site_visit_id = FETCH("SELECT leads_site_visit_id FROM leads_site_visits ORDER BY leads_site_visit_id DESC limit 1", "leads_site_visit_id");

                //upload site visit photos
                $total_count = count($_FILES["leads_activity_attached_file"]['name']);
                $UploadDir = "../../storage/leads/site-visits/";
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
                                "leads_activity_main_id" => $leads_site_visit_id,
                                "leads_activity_attachement_type" => "IMAGES",
                                "leads_activity_attached_file" => $FileFieldName,
                                "leads_activity_attached_at" => CURRENT_DATE_TIME,
                                "leads_activity_attachment_upload_by" => LOGIN_USER_ID,
                            ]);
                        } else {
                            $non_pdf++;
                            $Response = false;
                        }
                    }
                }
                $Pdfs = $total_count - $non_pdf;
            }
        }
    }

    //request handler
    RequestHandler($Response, [
        "true" => "Leads created successfully!",
        "false" => "Unable to create leads"
    ]);

    //upload csv files
} elseif (isset($_POST["UploadCSVRecords"])) {
    $csv_file_path = $_FILES['UploadedCsvFile']['tmp_name'];
    $csv_file = fopen($csv_file_path, "r");

    if ($csv_file !== FALSE) {
        // Read the first row (headers) but do NOT use it for mapping
        $csv_headers = fgetcsv($csv_file); // Ignore header names

        // Initialize counters
        $inserted_count = 0;
        $error_count = 0;
        $skipped_count = 0;

        // Set admin flag
        $leads_is_created_by_admin = (LOGIN_USER_ID == 1) ? 1 : 0;

        // Read each row and process
        $InitialRecord = 0;
        while (($row = fgetcsv($csv_file)) !== FALSE) {
            $InitialRecord++;
            $ProjectName = $row[8];
            $Sources = $row[9];

            //project id
            $GetProjectId = FETCH("SELECT projects_id FROM projects where projects_name like '%$ProjectName%'", "projects_id");
            if ($GetProjectId == null) {
                //handle project details
                $projects = [
                    "projects_name" => $ProjectName,
                    "projects_listing_status" => 1,
                    "projects_created_at" => CURRENT_DATE_TIME,
                    "projects_updated_at" => CURRENT_DATE_TIME,
                    "projects_created_by" => LOGIN_USER_ID,
                    "projects_updated_by" => LOGIN_USER_ID,
                ];
                $Response = INSERT("projects", $projects);
                $ProjectName = FETCH("SELECT projects_id FROM projects ORDER BY projects_id DESC limit 1", "projects_id");
            } else {
                $ProjectName = $GetProjectId;
            }

            //source
            $SourcesId = FETCH("SELECT config_leads_source_id FROM config_leads_sources where config_leads_source_name like '%$Sources%'", "config_leads_source_id");
            if ($SourcesId == null) {
                $Response = INSERT(
                    "config_leads_sources",
                    [
                        "config_leads_source_name" => $Sources,
                        "config_leads_source_created_at" => CURRENT_DATE_TIME,
                        "config_leads_source_updated_at" => CURRENT_DATE_TIME,
                        "config_leads_source_created_by" => LOGIN_USER_ID,
                        "config_leads_source_updated_by" => LOGIN_USER_ID,
                        "config_leads_source_status" => 1,
                    ]
                );
                $SourcesId = FETCH("SELECT config_leads_source_id FROM config_leads_sources where config_leads_source_name like '%$Sources%' ORDER BY config_leads_source_id DESC LIMIT 1", "config_leads_source_id");
            }

            $leads_managed_by = $_POST["leads_managed_by"];

            $phone = ValidatePhoneNumber(trim($row[1] ?? ""));

            if (!empty($phone)) {
                // Ensure all indexes exist before assigning
                $leads = [
                    "leads_full_name"           => trim($row[0] ?? ""),  // Name
                    "leads_phone_number"        => $phone,               // Phone Number
                    "leads_alternate_phone"     => trim($row[2] ?? ""),  // Alternate Phone Number
                    "leads_email_id"            => trim($row[3] ?? ""),  // Email-Id
                    "leads_date_of_birth"       => trim($row[4] ?? ""),  // Date of birth
                    "leads_anniversary_date"    => trim($row[5] ?? ""),  // Anniversary Date
                    "leads_marital_status"      => trim($row[6] ?? ""),  // Marital Status
                    "leads_gender"              => trim($row[7] ?? ""),  // Gender
                    "leads_created_by"          => LOGIN_USER_ID,
                    "leads_updated_by"          => LOGIN_USER_ID,
                    "leads_created_at"          => CURRENT_DATE_TIME,
                    "leads_updated_at"          => CURRENT_DATE_TIME,
                    "leads_type"                => $_POST["leads_upload_type"] ?? "",
                    "leads_source"              => $SourcesId,
                    "leads_is_created_by_admin" => $leads_is_created_by_admin,
                    "leads_entry_type"          => "CSV_UPLOADED",
                    "leads_stages"              => $_POST["leads_stages"] ?? "1",
                    "leads_status"              => "UPLOADED",
                    "leads_assign_status"       => 0,
                    "leads_priority_level"      => 1,
                    "leads_assigned_by"         => LOGIN_USER_ID,
                    "leads_projects_id"         => $ProjectName,
                    "leads_managed_by"          => $leads_managed_by,
                    "leads_remarks"             => SECURE($row[10] ?? "", "e"),
                ];

                if ($InitialRecord == MAX_NUMBER_OF_UPLOADING_RECODS) {
                    //request handler
                    RequestHandler($Response, [
                        "true" => "Leads created successfully! (<b>$inserted_count</b> Leads Inserted, <b>$skipped_count</b> is Skipped Number Already existed!)",
                        "false" => $err
                    ]);
                } else {
                    // Check if phone number already exists
                    $Response = INSERT("leads", $leads);

                    if ($Response) {
                        $inserted_count++;
                    } else {
                        $error_count++;
                    }
                }
            }
        }

        fclose($csv_file);
        echo "Inserted: $inserted_count, Errors: $error_count, Skipped: $skipped_count";
    } else {
        echo "Unable to process uploaded file.";
    }

    //request handler
    RequestHandler($Response, [
        "true" => "Leads created successfully! (<b>$inserted_count</b> Leads Inserted, <b>$skipped_count</b> is Skipped Number Already existed!)",
        "false" => $err
    ]);

    //assign selected leads
} elseif (isset($_POST["AssignSelectedLeads"])) {
    $leads_managed_by = $_POST["leads_managed_by"];
    $leads_stages = $_POST["leads_stages"];

    foreach ($_POST["selected_leads_id"] as $LeadsId) {
        $LeadsSQL = "SELECT leads_managed_by, leads_stages, leads_priority_level, leads_assigned_by, leads_assigned_date FROM leads where leads_id='$LeadsId'";
        $FetchPreviousAssignedId = FETCH($LeadsSQL, "leads_managed_by");
        $PreviousStages = FETCH($LeadsSQL, "leads_stages");
        $PreviousPriorityLevel = FETCH($LeadsSQL, "leads_priority_level");
        $PreviousAssignedBy = FETCH($LeadsSQL, "leads_assigned_by");
        $PreviousLeadsAssignedDate = FETCH($LeadsSQL, "leads_assigned_date");

        $leads_assignees = [
            "leads_main_id" => $LeadsId,
            "leads_assigned_to" => $leads_managed_by,
            "leads_assigned_previously_to" => $FetchPreviousAssignedId,
            "leads_assigned_by" => LOGIN_USER_ID,
            "leads_assigned_previously_by" => $PreviousAssignedBy,
            "leads_assigned_on" => CURRENT_DATE_TIME,
            "leads_assigned_previously_on" => $PreviousLeadsAssignedDate,
            "leads_assigned_stages" => $leads_stages,
            "leads_assigned_previous_stages" => $PreviousStages,
            "leads_assigned_previous_priority_level" => $PreviousPriorityLevel,
            "leads_assigned_udpated_by" => LOGIN_USER_ID,
            "leads_assigned_udpated_at" => CURRENT_DATE_TIME
        ];
        $Save = INSERT("leads_assignees", $leads_assignees);

        if ($Save == true) {
            $leads = [
                "leads_managed_by" => $leads_managed_by,
                "leads_assigned_by" => LOGIN_USER_ID,
                "leads_assigned_date" => CURRENT_DATE_TIME,
                "leads_stages" => $leads_stages,
                "leads_assign_status" => "ASSIGNED",
                "leads_status" => 1,
                "leads_type" => $_POST["leads_type"]
            ];
            $Response = UPDATE("leads", $leads, "leads_id='$LeadsId'");
        }
    }

    RequestHandler($Response, [
        "true" => "Leads Assigned Successfully!",
        "false" => "Unable to Assign Leads!"
    ]);

    //move selected leads
} elseif (isset($_POST["MovesSelectedLeads"])) {
    $leads_managed_by = $_POST["leads_managed_by"];
    $leads_stages = $_POST["leads_stages"];
    $leads_assigned_priority_level = $_POST["leads_assigned_priority_level"];

    foreach ($_POST["selected_leads_id"] as $LeadsId) {
        $LeadsSQL = "SELECT leads_managed_by, leads_stages, leads_priority_level, leads_assigned_by, leads_assigned_date FROM leads where leads_id='$LeadsId'";
        $FetchPreviousAssignedId = FETCH($LeadsSQL, "leads_managed_by");
        $PreviousStages = FETCH($LeadsSQL, "leads_stages");
        $PreviousPriorityLevel = FETCH($LeadsSQL, "leads_priority_level");
        $PreviousAssignedBy = FETCH($LeadsSQL, "leads_assigned_by");
        $PreviousLeadsAssignedDate = FETCH($LeadsSQL, "leads_assigned_date");

        $leads_assignees = [
            "leads_main_id" => $LeadsId,
            "leads_assigned_to" => $leads_managed_by,
            "leads_assigned_previously_to" => $FetchPreviousAssignedId,
            "leads_assigned_by" => LOGIN_USER_ID,
            "leads_assigned_previously_by" => $PreviousAssignedBy,
            "leads_assigned_on" => CURRENT_DATE_TIME,
            "leads_assigned_previously_on" => $PreviousLeadsAssignedDate,
            "leads_assigned_stages" => $leads_stages,
            "leads_assigned_previous_stages" => $PreviousStages,
            "leads_assigned_priority_level" => $leads_assigned_priority_level,
            "leads_assigned_previous_priority_level" => $PreviousPriorityLevel,
            "leads_assigned_udpated_by" => LOGIN_USER_ID,
            "leads_assigned_udpated_at" => CURRENT_DATE_TIME
        ];
        $Save = INSERT("leads_assignees", $leads_assignees);

        if ($Save == true) {
            $leads = [
                "leads_managed_by" => $leads_managed_by,
                "leads_priority_level" => $leads_assigned_priority_level,
                "leads_assigned_by" => LOGIN_USER_ID,
                "leads_assigned_date" => CURRENT_DATE_TIME,
                "leads_stages" => $leads_stages,
                "leads_assign_status" => "MOVED",
            ];
            $Response = UPDATE("leads", $leads, "leads_id='$LeadsId'");
        }
    }

    RequestHandler($Response, [
        "true" => "Leads Assigned Successfully!",
        "false" => "Unable to Assign Leads!"
    ]);

    //update leads details
} elseif (isset($_POST["UpdateLeadsDetails"])) {
    $leads_id = SECURE($_POST["leads_id"], "d");

    $leads = [
        "leads_full_name" => $_POST["leads_full_name"],
        "leads_phone_number" => $_POST["leads_phone_number"],
        "leads_alternate_phone" => $_POST["leads_alternate_phone"],
        "leads_email_id" => $_POST["leads_email_id"],
        "leads_date_of_birth" => $_POST["leads_date_of_birth"],
        "leads_anniversary_date" => $_POST["leads_anniversary_date"],
        "leads_gender" => $_POST["leads_gender"],
        "leads_marital_status" => $_POST["leads_marital_status"],
        "leads_type" => $_POST["leads_type"],
        "leads_source" => $_POST["leads_source"],
        "leads_re_source" => $_POST["leads_re_source"],
        "leads_projects_id" => $_POST["leads_projects_id"],
        "leads_updated_at" => CURRENT_DATE_TIME,
        "leads_updated_by" => LOGIN_USER_ID,
    ];
    $CheckPhoneNumber = CHECK("SELECT leads_phone_number FROM leads where leads_id='$leads_id' and leads_phone_number!='" . $_POST["leads_phone_number"] . "'");
    if ($CheckPhoneNumber == null) {
        $Response = UPDATE("leads", $leads, "leads_id='$leads_id'");

        //update address details
        $leads_address = [
            "leads_address_line1" => $_POST["leads_address_line1"],
            "leads_address_area" => $_POST["leads_address_area"],
            "leads_address_city" => $_POST["leads_address_city"],
            "leads_address_state" => $_POST["leads_address_state"],
            "leads_address_country" => $_POST["leads_address_country"],
            "leads_address_pincode" => $_POST["leads_address_pincode"],
            "leads_address_type" => $_POST["leads_address_type"],
            "leads_main_id" => $leads_id
        ];
        $CheckAddress = CHECK("SELECT * FROM leads_address where leads_main_id='$leads_id'");
        if ($CheckAddress == null) {
            $Response = INSERT("leads_address", $leads_address);
        } else {
            $Response = UPDATE("leads_address", $leads_address, "leads_main_id='$leads_id'");
        }

        //update proect and requirement details
        $leads_requirements = [
            "leads_main_id" => $leads_id,
            "leads_project_id" => $_POST["leads_project_id"],
            "leads_requirement_budgets" => $_POST["leads_requirement_budgets"],
            "leads_requirement_preffered_location" => $_POST["leads_requirement_preffered_location"],
            "leads_requirement_duration" => $_POST["leads_requirement_duration"],
            "leads_requirement_added_by" => LOGIN_USER_ID,
            "leads_requirement_added_at" => CURRENT_DATE_TIME,
            "leads_requirement_modified_at" => CURRENT_DATE_TIME,
            "leads_requirement_modified_by" => CURRENT_DATE_TIME,
        ];
        $CheckRequirements = CHECK("SELECT * FROM leads_requirements where leads_main_id='$leads_id'");
        if ($CheckRequirements == null) {
            $Response = INSERT("leads_requirements", $leads_requirements);
        } else {
            $Response = UPDATE("leads_requirements", $leads_requirements, "leads_main_id='$leads_id'");
        }
    } else {
        $Response = false;
    }

    RequestHandler($Response, [
        "true" => "Leads Details Updated Successfully!",
        "false" => "Unable to Update Leads Details!"
    ]);

    //leads feedbacks
} elseif (isset($_POST["SaveCallFeedBack"])) {
    $leads_activity_main_leads_id = SECURE($_POST["LeadsId"], "d");

    //check file uploaded or not or empty 
    if (!empty($_FILES['leads_activity_voice_notes_file']['name']) && $_FILES['leads_activity_voice_notes_file']['size'] > 0) {
        $leads_activity_voice_notes_file = UPLOAD_FILES("../../storage/leads/audios/$leads_activity_main_leads_id", "", $_POST['leads_phone_number'], "leads_activity_voice_notes_file");
        $leads_activity_have_voice_notes = 1;
    } else {
        $leads_activity_have_voice_notes = 0;
        $leads_activity_voice_notes_file = "";
    }

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
        "leads_activity_main_leads_id" => $leads_activity_main_leads_id,
        "leads_activity_type" => $_POST["leads_activity_type"],
        "leads_acitivity_call_status" => $_POST["leads_acitivity_call_status"],
        "leads_acitivity_call_sub_status" => $_POST["leads_acitivity_call_sub_status"],
        "leads_activity_feedbacks" => SECURE($_POST["leads_activity_feedbacks"], "e"),
        "leads_activity_added_by" => LOGIN_USER_ID,
        "leads_activity_added_on" => CURRENT_DATE_TIME,
        "leads_activity_created_at" => CURRENT_DATE_TIME,
        "leads_activity_created_by" => LOGIN_USER_ID,
        "leads_activity_have_voice_notes" => $leads_activity_have_voice_notes,
        "leads_activity_voice_notes_file" => $leads_activity_voice_notes_file,
        "leads_activity_call_source" => $DeviceType,
        "leads_activity_call_method" => $ActivityMethod,
        "leads_activity_date_time" => CURRENT_DATE_TIME
    ];
    $Response = INSERT("leads_activities", $leads_activities);
    if ($Response == true) {
        $Update = SQL("UPDATE leads SET leads_sub_stages='" . $_POST["leads_acitivity_call_sub_status"] . "', leads_stages='" . $_POST["leads_acitivity_call_status"] . "', leads_call_status='" . $_POST["leads_acitivity_call_status"] . "', leads_call_sub_status='" . $_POST["leads_acitivity_call_sub_status"] . "' where leads_id='$leads_activity_main_leads_id'");
    }
    RequestHandler($Response, [
        "true" => "Call Feedback Saved Successfully!",
        "false" => "Unable to Save Call Feedback!"
    ]);

    //add leads reminder
} elseif (isset($_POST["AddLeadReminders"])) {

    $leads_reminders = [
        "leads_reminder_name" => $_POST["leads_reminder_name"],
        "leads_reminder_main_leads_id" => SECURE($_POST["leads_id"], "d"),
        "leads_reminder_date" => $_POST["leads_reminder_date"],
        "leads_reminder_time" => $_POST["leads_reminder_time"],
        "leads_reminder_notes" => SECURE($_POST["leads_reminder_notes"], "e"),
        "leads_reminder_user_id" => LOGIN_USER_ID,
        "leads_reminder_status" => 0,
        "leads_reminder_re_remind_time" => $_POST["leads_reminder_re_remind_time"],
        "leads_reminder_created_at" => CURRENT_DATE_TIME,
        "leads_reminder_created_by" => LOGIN_USER_ID,
    ];
    $Response = INSERT("leads_reminders", $leads_reminders);

    //request handler
    RequestHandler($Response, [
        "true" => "Lead Reminder Added Successfully!",
        "false" => "Unable to Add Lead Reminder!"
    ]);

    //add site visit
} elseif (isset($_POST["AddSiteVisitRecords"])) {
    $leads_main_id = SECURE($_POST["leads_Id"], "d");
    $leads_id = $leads_main_id;

    $leads_site_visits = [
        "leads_main_leads_id" => $leads_id,
        "leads_site_visit_status" => $_POST["leads_site_visit_status"],
        "leads_site_visit_schedule_date" => $_POST["leads_site_visit_schedule_date"],
        "leads_site_visit_notes" => SECURE($_POST["leads_site_visit_notes"], "e"),
        "leads_site_visit_added_by" => LOGIN_USER_ID,
        "leads_site_visit_added_on" => CURRENT_DATE_TIME,
        "leads_site_visit_handled_by" => $_POST["leads_site_visit_handled_by"],
        "leads_site_visit_response" => SECURE($_POST["leads_site_visit_notes"], "e"),
        "leads_site_visits_projects_id" => $_POST["leads_site_visits_projects_id"],
    ];
    $Response = INSERT("leads_site_visits", $leads_site_visits, true);
    $leads_site_visit_id = FETCH("SELECT leads_site_visit_id FROM leads_site_visits ORDER BY leads_site_visit_id DESC limit 1", "leads_site_visit_id");

    //upload site visit photos
    $total_count = count($_FILES["leads_activity_attached_file"]['name']);
    $UploadDir = "../../storage/leads/site-visits/$leads_id";
    $Projects_Name = FETCH("SELECT projects_name from projects where projects_id='$leads_site_visits_projects_id'", "projects_name");

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
                INSERT("leads_site_visits_attachements", [
                    "leads_activity_main_id" => $leads_site_visit_id,
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

    //Check Reminder Options
    if (isset($_POST["CheckReminderOption"])) {
        if ($_POST["CheckReminderOption"] == "true") {
            $leads_reminders = [
                "leads_reminder_main_leads_id" => $leads_id,
                "leads_reminder_notes" => SECURE($_POST["Reminder_Message"], "e"),
                "leads_reminder_created_by" => LOGIN_USER_ID,
                "leads_reminder_created_at" => CURRENT_DATE_TIME,
                "leads_reminder_date" => $_POST["reminder_date"],
                "leads_reminder_time" => $_POST["reminder_time"],
                "leads_reminder_status" => 1,
                "leads_reminder_user_id" => $_POST["set_reminder_for"],
            ];
            INSERT("leads_reminders", $leads_reminders);
        }
    }

    RequestHandler($Response, [
        "true" => "Site Visit Details Added Successfully!",
        "false" => "Unable to Add Site Visit Details!"
    ]);

    //remove leads records
} elseif (isset($_POST["RemoveLeadsRecordsRequests"])) {
    $Response = SQL("UPDATE leads SET leads_is_removed='1' where leads_id='" . SECURE($_POST["RecordsId"], "d") . "'");
    RequestHandler($Response, [
        "true" => "Record Removed Successfully!",
        "false" => "Unable to Remove Records!"
    ]);

    //remove bulk records
} elseif (isset($_POST["RemoveSelectedLeads"])) {

    foreach ($_POST["selected_leads_id"] as $LeadsId) {
        $Response = SQL("UPDATE leads SET leads_is_removed='1' where leads_id='$LeadsId'");
    }
    RequestHandler($Response, [
        "true" => "Record Removed Successfully!",
        "false" => "Unable to Remove Records!"
    ]);

    //re-assing leads
} elseif (isset($_POST["ReAssignSelectedLeads"])) {

    $leads_managed_by = $_POST["leads_managed_by"];
    $leads_stages = $_POST["leads_stages"];

    foreach ($_POST["selected_leads_id"] as $LeadsId) {
        $LeadsSQL = "SELECT leads_managed_by, leads_stages, leads_priority_level, leads_assigned_by, leads_assigned_date FROM leads where leads_id='$LeadsId'";
        $FetchPreviousAssignedId = FETCH($LeadsSQL, "leads_managed_by");
        $PreviousStages = FETCH($LeadsSQL, "leads_stages");
        $PreviousPriorityLevel = FETCH($LeadsSQL, "leads_priority_level");
        $PreviousAssignedBy = FETCH($LeadsSQL, "leads_assigned_by");
        $PreviousLeadsAssignedDate = FETCH($LeadsSQL, "leads_assigned_date");

        $leads_assignees = [
            "leads_main_id" => $LeadsId,
            "leads_assigned_to" => $leads_managed_by,
            "leads_assigned_previously_to" => $FetchPreviousAssignedId,
            "leads_assigned_by" => LOGIN_USER_ID,
            "leads_assigned_previously_by" => $PreviousAssignedBy,
            "leads_assigned_on" => CURRENT_DATE_TIME,
            "leads_assigned_previously_on" => $PreviousLeadsAssignedDate,
            "leads_assigned_stages" => $leads_stages,
            "leads_assigned_previous_stages" => $PreviousStages,
            "leads_assigned_previous_priority_level" => $PreviousPriorityLevel,
            "leads_assigned_udpated_by" => LOGIN_USER_ID,
            "leads_assigned_udpated_at" => CURRENT_DATE_TIME
        ];
        $Save = INSERT("leads_assignees", $leads_assignees);

        $leads = [
            "leads_managed_by" => $leads_managed_by,
            "leads_priority_level" => $leads_assigned_priority_level,
            "leads_assigned_by" => LOGIN_USER_ID,
            "leads_assigned_date" => CURRENT_DATE_TIME,
            "leads_stages" => $leads_stages,
            "leads_assign_status" => "RE-ASSIGNED",
            "leads_status" => 1,
            "leads_is_removed" => "",
            "leads_type" => $_POST["leads_type"]
        ];
        $Response = UPDATE("leads", $leads, "leads_id='$LeadsId'");
    }

    RequestHandler($Response, [
        "true" => "Leads is Active Now and Re-Assigned Successfully!",
        "false" => "Unable to Re-Assign Leads!"
    ]);

    //remove leads permanently
} elseif (isset($_POST["RemoveSelectedLeadsPermanently"])) {

    foreach ($_POST["selected_leads_id"] as $LeadsId) {
        $Response = DELETE_FROM("leads", "leads_id='$LeadsId'");
        $Response = DELETE_FROM("leads_activities", "leads_activity_main_leads_id='$LeadsId'");
        $Response = DELETE_FROM("leads_address", "leads_main_id='$LeadsId'");
        $Response = DELETE_FROM("leads_assignees", "leads_main_id='$LeadsId'");
        $Response = DELETE_FROM("leads_reminders", "leads_reminder_main_leads_id='$LeadsId'");
        $Response = DELETE_FROM("leads_site_visits", "leads_main_leads_id='$LeadsId'");
        $Response = DELETE_FROM("leads_requirements", "leads_main_id='$LeadsId'");
    }
    RequestHandler($Response, [
        "true" => "Record Removed Permanently Successfully!",
        "false" => "Unable to Remove Records! Permanently"
    ]);


    //add instant activity handler 
}
