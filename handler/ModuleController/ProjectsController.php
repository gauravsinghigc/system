<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["SavePrimaryProjectDetails"])) {

    //project location handling
    if ($_POST["projects_locations_id"] == "NEW") {
        $RequestedData = [
            "config_projects_locations_name" => $_POST["new_project_location"],
            "config_projects_locations_color_code" => "#FFFFFF",
            "config_projects_locations_remarks" => SECURE($_POST["new_project_location"], "e"),
            "config_projects_locations_status" => 1,
            "config_projects_locations_created_by" => LOGIN_USER_ID,
            "config_projects_locations_updated_by" => LOGIN_USER_ID,
            "config_projects_locations_created_at" => CURRENT_DATE_TIME,
            "config_projects_locations_updated_at" => CURRENT_DATE_TIME,
        ];
        $Response = INSERT("config_projects_locations", $RequestedData);
        if ($Response == true) {
            $projects_locations_id = FETCH("SELECT config_projects_locations_id FROM config_projects_locations ORDER BY config_projects_locations_id DESC LIMIT 1", "config_projects_locations_id");
        }
    } else {
        $projects_locations_id = $_POST["projects_locations_id"];
    }

    //project stages handling
    if ($_POST["projects_stages_id"] == "NEW") {
        $RequestedData = [
            "config_projects_stages_name" => $_POST["new_project_stage"],
            "config_projects_stages_color_code" => "#FFFFFF",
            "config_projects_stages_sort_by_order" => 0,
            "config_projects_stages_remarks" => SECURE($_POST["new_project_stage"], "e"),
            "config_projects_stages_status" => 1,
            "config_projects_stages_created_by" => LOGIN_USER_ID,
            "config_projects_stages_updated_by" => LOGIN_USER_ID,
            "config_projects_stages_created_at" => CURRENT_DATE_TIME,
            "config_projects_stages_updated_at" => CURRENT_DATE_TIME,
        ];
        $Response = INSERT("config_projects_stages", $RequestedData);
        if ($Response == true) {
            $projects_stages_id = FETCH("SELECT config_projects_stages_id FROM config_projects_stages ORDER BY config_projects_stages_id DESC LIMIT 1", "config_projects_stages_id");
        }
    } else {
        $projects_stages_id = $_POST["projects_stages_id"];
    }

    //projects types handling
    if ($_POST["projects_type_id"] == "NEW") {
        $RequestedData = [
            "config_project_types_name" => $_POST["new_project_types"],
            "config_project_types_color_code" => "#FFFFFF",
            "config_project_types_remarks" => SECURE($_POST["new_project_types"], "e"),
            "config_project_types_status" => 1,
            "config_project_types_created_by" => LOGIN_USER_ID,
            "config_project_types_updated_by" => LOGIN_USER_ID,
            "config_project_types_created_at" => CURRENT_DATE_TIME,
            "config_project_types_updated_at" => CURRENT_DATE_TIME
        ];
        $Response = INSERT("config_project_types", $RequestedData);
        if ($Response == true) {
            $projects_type_id = FETCH("SELECT config_project_types_id FROM config_project_types ORDER BY config_project_types_id DESC LIMIT 1 ", "config_project_types_id");
        }
    } else {
        $projects_type_id = $_POST["projects_type_id"];
    }

    //projects status handling
    if ($_POST["projects_status_id"] == "NEW") {
        $RequestedData = [
            "config_projects_status_name" => $_POST["new_project_status"],
            "config_projects_status_color_code" => "#FFFFFF",
            "config_projects_status_remarks" => SECURE($_POST["new_project_status"], "e"),
            "config_projects_status_status" => 1,
            "config_projects_status_created_by" => LOGIN_USER_ID,
            "config_projects_status_updated_by" => LOGIN_USER_ID,
            "config_projects_status_created_at" => CURRENT_DATE_TIME,
            "config_projects_status_updated_at" => CURRENT_DATE_TIME
        ];
        $Response = INSERT("config_projects_status", $RequestedData);
        if ($Response == true) {
            $projects_status_id = FETCH("SELECT config_projects_status_id FROM config_projects_status ORDER BY config_projects_status_id DESC LIMIT 1 ", "config_projects_status_id");
        }
    } else {
        $projects_status_id = $_POST["projects_status_id"];
    }

    //handle project details
    $projects = [
        "projects_name" => $_POST["projects_name"],
        "projects_area" => $_POST["projects_area"],
        "projects_area_measurement_unit" => $_POST["projects_area_measurement_unit"],
        "projects_locations_id" => $projects_locations_id,
        "projects_stages_id" => $projects_stages_id,
        "projects_status_id" => $projects_status_id,
        "projects_type_id" => $projects_type_id,
        "projects_introductions" => SECURE($_POST["projects_introductions"], "e"),
        "projects_listing_status" => $_POST["projects_listing_status"],
        "projects_age" => $_POST["projects_age"],
        "projects_created_at" => CURRENT_DATE_TIME,
        "projects_updated_at" => CURRENT_DATE_TIME,
        "projects_created_by" => LOGIN_USER_ID,
        "projects_updated_by" => LOGIN_USER_ID,
        "projects_listing_status" => $_POST["projects_listing_status"],
    ];
    $Response = INSERT("projects", $projects);
    if ($Response == true) {
        $_SESSION['PROJECT_SESSION_ID'] = FETCH("SELECT projects_id FROM projects ORDER BY projects_id DESC limit 1", "projects_id");
        $Save = true;
        $access_url = $access_url . "?project_entry_step=developer_info";
    } else {
        $Save = false;
    }

    //request handler
    RequestHandler($Save, [
        "true" => "Project Details Saved Successfully!",
        "false" => "Failed to Save Project Details!"
    ]);

    //save developer details
} elseif (isset($_POST["SaveProjectDeveloperDetails"])) {
    $projects_id = SECURE($_POST["projects_id"], "d");

    //save project developer details
    $projects_developers = [
        "projects_developers_name" => $_POST["projects_developers_name"],
        "projects_developers_logo" => UPLOAD_FILES("../../storage/projects/developers", "", $_POST["projects_developers_name"], "projects_developers_logo"),
        "projects_developers_address" => $_POST["projects_developers_address"],
        "projects_developer_phone_number" => $_POST["projects_developer_phone_number"],
        "projects_developer_primary_email_id" => $_POST["projects_developer_primary_email_id"],
        "project_developer_created_at" => CURRENT_DATE_TIME,
        "project_developer_updated_at" => CURRENT_DATE_TIME,
        "project_developer_created_by" => LOGIN_USER_ID,
        "project_developer_updated_by" => LOGIN_USER_ID,
        "project_developer_status" => $_POST["project_developer_status"],
        "projects_landing_page_url" => $_POST["projects_landing_page_url"]
    ];
    $Response = INSERT("projects_developers", $projects_developers);
    $projects_developers_id = FETCH("SELECT projects_developers_id FROM projects_developers ORDER BY projects_developers_id DESC limit 1", "projects_developers_id");
    $Update = SQL("UPDATE projects SET projects_developed_by='$projects_developers_id' where projects_id='$projects_id'");

    if ($Update == true) {
        $access_url = APP_URL . "/projects/add?project_entry_step=media";
    }
    RequestHandler($Update, [
        "true" => "Project Developer Details Saved Successfully!",
        "false" => "Failed to Save Project Developer Details!"
    ]);

    //upload images for projects
} elseif (isset($_POST["UploadImagesForProjects"])) {
    $projects_id = SECURE($_POST["projects_id"], "d");
    $Projects_Name = FETCH("SELECT projects_name from projects where projects_id='$projects_id'", "projects_name");
    $UploadDir = "../../storage/projects/$projects_id/media/";

    $total_count = count($_FILES["project_image"]['name']);
    if ($total_count != 0) {
        for ($i = 0; $i < $total_count; $i++) {
            $FileName = $_FILES["project_image"]['name'][$i];
            //$ProImageType = $_FILES["$FileFieldName"]['type'][$i];
            //$ProImageSize = $_FILES["$FileFieldName"]['size'][$i];
            $ProImageTmpName = $_FILES["project_image"]['tmp_name'][$i];
            //$ProImageError = $_FILES["$FileFieldName"]['error'][$i];
            $ProImageExt = pathinfo($FileName, PATHINFO_EXTENSION);

            $FileName = "$Projects_Name" . "_" . $i . rand(000000, 999999) . date("d_m_Y_h_m_s_a_") . "." . $ProImageExt;
            $ProImagePath = $UploadDir . $FileName;
            $FileFieldName = $FileName;

            if ($ProImageExt == 'jpg' || $ProImageExt == 'jpeg' || $ProImageExt == 'png' || $ProImageExt == 'gif' || $ProImageExt == 'bmp') {
                if (!file_exists("$UploadDir/")) {
                    mkdir("$UploadDir/", 0777, true);
                }
                move_uploaded_file($ProImageTmpName, $ProImagePath);
                $Response = INSERT("projects_media_files", [
                    "projects_media_files_main_project_id" => $projects_id,
                    "projects_media_files_types" => "images",
                    "projects_media_files_value" => $FileFieldName,
                    "project_media_files_created_at" => CURRENT_DATE_TIME,
                    "project_media_files_updated_at" => CURRENT_DATE_TIME,
                    "project_media_files_created_by" => LOGIN_USER_ID,
                    "projects_media_files_updated_by" => LOGIN_USER_ID
                ]);
            } else {
                $Response = false;
            }
        }
    }

    RequestHandler($Response, [
        "true" => "All <b>$total_count</b> Project Images Uploaded Successfully!",
        "false" => "Failed to Upload Project Images!"
    ]);

    //upload brochures only
} elseif (isset($_POST["UploadBrochureForProjects"])) {
    $projects_id = SECURE($_POST["projects_id"], "d");
    $Projects_Name = FETCH("SELECT projects_name from projects where projects_id='$projects_id'", "projects_name");
    $UploadDir = "../../storage/projects/$projects_id/media/";

    $total_count = count($_FILES["project_brochures"]['name']);
    $non_pdf = 0;
    if ($total_count != 0) {
        for ($i = 0; $i < $total_count; $i++) {
            $FileName = $_FILES["project_brochures"]['name'][$i];
            //$ProImageType = $_FILES["$FileFieldName"]['type'][$i];
            //$ProImageSize = $_FILES["$FileFieldName"]['size'][$i];
            $ProImageTmpName = $_FILES["project_brochures"]['tmp_name'][$i];
            //$ProImageError = $_FILES["$FileFieldName"]['error'][$i];
            $ProImageExt = pathinfo($FileName, PATHINFO_EXTENSION);

            $FileName = "$Projects_Name" . "_" . $i . rand(000000, 999999) . date("d_m_Y_h_m_s_a_") . "." . $ProImageExt;
            $ProImagePath = $UploadDir . $FileName;
            $FileFieldName = $FileName;

            if ($ProImageExt == 'pdf') {
                if (!file_exists("$UploadDir/")) {
                    mkdir("$UploadDir/", 0777, true);
                }
                move_uploaded_file($ProImageTmpName, $ProImagePath);
                $Response = INSERT("projects_media_files", [
                    "projects_media_files_main_project_id" => $projects_id,
                    "projects_media_files_types" => "files",
                    "projects_media_files_value" => $FileFieldName,
                    "project_media_files_created_at" => CURRENT_DATE_TIME,
                    "project_media_files_updated_at" => CURRENT_DATE_TIME,
                    "project_media_files_created_by" => LOGIN_USER_ID,
                    "projects_media_files_updated_by" => LOGIN_USER_ID
                ]);
            } else {
                $$non_pdf++;
                $Response = false;
            }
        }
    }
    $Pdfs = $total_count - $non_pdf;

    RequestHandler($Response, [
        "true" => "All <b>$Pdfs</b> Project Brochures Uploaded Successfully, and <b>$non_pdf</b> Non-PDF Files Skipped!",
        "false" => "Failed to Upload Project Brochures!"
    ]);

    //save youtube links
} elseif (isset($_POST["UploadYoutubeWatchIds"])) {
    $projects_id = SECURE($_POST["projects_id"], "d");
    $youtube_watch_ids = explode(",", $_POST["youtube_video_id"]);

    foreach ($youtube_watch_ids as $youtube_watch_id) {
        $Response = INSERT("projects_media_files", [
            "projects_media_files_main_project_id" => $projects_id,
            "projects_media_files_types" => "youtube",
            "projects_media_files_value" => $youtube_watch_id,
            "project_media_files_created_at" => CURRENT_DATE_TIME,
            "project_media_files_updated_at" => CURRENT_DATE_TIME,
            "project_media_files_created_by" => LOGIN_USER_ID,
            "projects_media_files_updated_by" => LOGIN_USER_ID
        ]);
    }
    RequestHandler($Response, [
        "true" => "Project Youtube Watch IDs Saved Successfully!",
        "false" => "Failed to Save Project Youtube Watch IDs!"
    ]);

    //add amenities to the project
} elseif (isset($_POST["AddMenitiesInTheProjects"])) {
    $project_amenities = [
        "project_amenities_project_main_id" => SECURE($_POST["projects_id"], "d"),
        "project_amenities_name" => $_POST["project_amenities_name"],
        "project_amenities_short_desc" => SECURE($_POST["project_amenities_short_desc"], "e"),
        "project_amenities_created_at" => CURRENT_DATE_TIME,
        "project_amenities_updated_at" => CURRENT_DATE_TIME,
        "project_amenities_created_by" => LOGIN_USER_ID,
        "project_amenities_updated_by" => LOGIN_USER_ID,
    ];
    $Response = INSERT("project_amenities", $project_amenities);

    //request handler
    RequestHandler($Response, [
        "true" => "Project Amenities Added Successfully!",
        "false" => "Failed to Add Project Amenities!"
    ]);

    //update project_amenities
} elseif (isset($_POST["UpdateAmenitiesRecords"])) {
    $project_amenities = [
        "project_amenities_name" => $_POST["project_amenities_name"],
        "project_amenities_short_desc" => SECURE($_POST["project_amenities_short_desc"], "e"),
        "project_amenities_updated_at" => CURRENT_DATE_TIME,
        "project_amenities_updated_by" => LOGIN_USER_ID,
    ];
    $Response = UPDATE("project_amenities", $project_amenities, "project_amenities_id='" . SECURE($_POST["project_amenities_id"], "d") . "'");

    //request handler
    RequestHandler($Response, [
        "true" => "Project Amenities Updated Successfully!",
        "false" => "Failed to Update Project Amenities!"
    ]);

    //delete project amenities
} elseif (isset($_POST["RemoveAmenitiesRecords"])) {
    $Response = DELETE_FROM("project_amenities", "project_amenities_id='" . SECURE($_POST["RecordsId"], "d") . "'");
    //request handler
    RequestHandler($Response, [
        "true" => "Project Amenities Deleted Successfully!",
        "false" => "Failed to Delete Project Amenities!"
    ]);

    //update primary project details
} elseif (isset($_POST["UpdatePrimaryProjectDetails"])) {

    //project location handling
    if ($_POST["projects_locations_id"] == "NEW") {
        $RequestedData = [
            "config_projects_locations_name" => $_POST["new_project_location"],
            "config_projects_locations_color_code" => "#FFFFFF",
            "config_projects_locations_remarks" => SECURE($_POST["new_project_location"], "e"),
            "config_projects_locations_status" => 1,
            "config_projects_locations_created_by" => LOGIN_USER_ID,
            "config_projects_locations_updated_by" => LOGIN_USER_ID,
            "config_projects_locations_created_at" => CURRENT_DATE_TIME,
            "config_projects_locations_updated_at" => CURRENT_DATE_TIME,
        ];
        $Response = INSERT("config_projects_locations", $RequestedData);
        if ($Response == true) {
            $projects_locations_id = FETCH("SELECT config_projects_locations_id FROM config_projects_locations ORDER BY config_projects_locations_id DESC LIMIT 1", "config_projects_locations_id");
        }
    } else {
        $projects_locations_id = $_POST["projects_locations_id"];
    }

    //project stages handling
    if ($_POST["projects_stages_id"] == "NEW") {
        $RequestedData = [
            "config_projects_stages_name" => $_POST["new_project_stage"],
            "config_projects_stages_color_code" => "#FFFFFF",
            "config_projects_stages_sort_by_order" => 0,
            "config_projects_stages_remarks" => SECURE($_POST["new_project_stage"], "e"),
            "config_projects_stages_status" => 1,
            "config_projects_stages_created_by" => LOGIN_USER_ID,
            "config_projects_stages_updated_by" => LOGIN_USER_ID,
            "config_projects_stages_created_at" => CURRENT_DATE_TIME,
            "config_projects_stages_updated_at" => CURRENT_DATE_TIME,
        ];
        $Response = INSERT("config_projects_stages", $RequestedData);
        if ($Response == true) {
            $projects_stages_id = FETCH("SELECT config_projects_stages_id FROM config_projects_stages ORDER BY config_projects_stages_id DESC LIMIT 1", "config_projects_stages_id");
        }
    } else {
        $projects_stages_id = $_POST["projects_stages_id"];
    }

    //projects types handling
    if ($_POST["projects_type_id"] == "NEW") {
        $RequestedData = [
            "config_project_types_name" => $_POST["new_project_types"],
            "config_project_types_color_code" => "#FFFFFF",
            "config_project_types_remarks" => SECURE($_POST["new_project_types"], "e"),
            "config_project_types_status" => 1,
            "config_project_types_created_by" => LOGIN_USER_ID,
            "config_project_types_updated_by" => LOGIN_USER_ID,
            "config_project_types_created_at" => CURRENT_DATE_TIME,
            "config_project_types_updated_at" => CURRENT_DATE_TIME
        ];
        $Response = INSERT("config_project_types", $RequestedData);
        if ($Response == true) {
            $projects_type_id = FETCH("SELECT config_project_types_id FROM config_project_types ORDER BY config_project_types_id DESC LIMIT 1 ", "config_project_types_id");
        }
    } else {
        $projects_type_id = $_POST["projects_type_id"];
    }

    //projects status handling
    if ($_POST["projects_status_id"] == "NEW") {
        $RequestedData = [
            "config_projects_status_name" => $_POST["new_project_status"],
            "config_projects_status_color_code" => "#FFFFFF",
            "config_projects_status_remarks" => SECURE($_POST["new_project_status"], "e"),
            "config_projects_status_status" => 1,
            "config_projects_status_created_by" => LOGIN_USER_ID,
            "config_projects_status_updated_by" => LOGIN_USER_ID,
            "config_projects_status_created_at" => CURRENT_DATE_TIME,
            "config_projects_status_updated_at" => CURRENT_DATE_TIME
        ];
        $Response = INSERT("config_projects_status", $RequestedData);
        if ($Response == true) {
            $projects_status_id = FETCH("SELECT config_projects_status_id FROM config_projects_status ORDER BY config_projects_status_id DESC LIMIT 1 ", "config_projects_status_id");
        }
    } else {
        $projects_status_id = $_POST["projects_status_id"];
    }

    //handle project details
    $projects = [
        "projects_name" => $_POST["projects_name"],
        "projects_area" => $_POST["projects_area"],
        "projects_area_measurement_unit" => $_POST["projects_area_measurement_unit"],
        "projects_locations_id" => $projects_locations_id,
        "projects_stages_id" => $projects_stages_id,
        "projects_status_id" => $projects_status_id,
        "projects_type_id" => $projects_type_id,
        "projects_introductions" => SECURE($_POST["projects_introductions"], "e"),
        "projects_listing_status" => $_POST["projects_listing_status"],
        "projects_age" => $_POST["projects_age"],
        "projects_updated_at" => CURRENT_DATE_TIME,
        "projects_updated_by" => LOGIN_USER_ID,
    ];

    //update projects
    $Save = UPDATE("projects", $projects, "projects_id='" . SECURE($_POST["projects_id"], "d") . "'");

    //request handler
    RequestHandler($Save, [
        "true" => "Project Details Updated Successfully!",
        "false" => "Failed to Update Project Details!"
    ]);

    //update developers details
} elseif (isset($_POST["UpdateProjectDeveloperDetails"])) {
    $projects_developers_id = SECURE($_POST["projects_developers_id"], "d");

    $projects_developers = [
        "projects_developers_name" => $_POST["projects_developers_name"],
        "projects_developers_address" => $_POST["projects_developers_address"],
        "projects_developer_phone_number" => $_POST["projects_developer_phone_number"],
        "projects_developer_primary_email_id" => $_POST["projects_developer_primary_email_id"],
        "project_developer_updated_at" => CURRENT_DATE_TIME,
        "project_developer_updated_by" => LOGIN_USER_ID,
        "project_developer_status" => $_POST["project_developer_status"],
        "projects_landing_page_url" => $_POST["projects_landing_page_url"]
    ];

    //update 
    $Save = UPDATE("projects_developers", $projects_developers, "projects_developers_id='" . $projects_developers_id . "'");

    // Check if a file is uploaded
    if (!empty($_FILES['projects_developers_logo']['name']) && $_FILES['projects_developers_logo']['size'] > 0) {
        $uploadedFilePath = UPLOAD_FILES("../../storage/projects/developers", "", $_POST["projects_developers_name"], "projects_developers_logo");

        if ($uploadedFilePath) {
            $Response = UPDATE(
                "projects_developers",
                [
                    "projects_developers_logo" => $uploadedFilePath,
                ],
                "projects_developers_id='" . SECURE($_POST["projects_developers_id"], "d") . "'"
            );
        }
    }

    //request handler
    RequestHandler($Save, [
        "true" => "Project Developer Details Updated Successfully!",
        "false" => "Failed to Update Project Developer Details!"
    ]);
}
