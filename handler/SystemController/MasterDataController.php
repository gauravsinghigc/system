<?php
//initialize files
require_once "../../acm/SysFileAutoLoader.php";
require_once "../../acm/SystemReqHandler.php";
require_once "../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["SaveLeadsStages"])) {
    $Response = INSERT("config_leads_stages", [
        "config_leads_stage_name" => UpperCase($_POST["config_leads_stage_name"]),
        "config_leads_stage_color_code" => $_POST["config_leads_stage_color_code"],
        "config_leads_stage_sort_by_order" => $_POST["config_leads_stage_sort_by_order"],
        "config_leads_stage_status" => $_POST["config_leads_stage_status"],
        "config_leads_stage_remarks" => SECURE($_POST["config_leads_stage_remarks"], "e"),
        "config_leads_stage_created_by" => LOGIN_USER_ID,
        "config_leads_stage_created_at" => CURRENT_DATE_TIME,
        "config_leads_stage_updated_by" => LOGIN_USER_ID,
        "config_leads_stage_updated_at" => CURRENT_DATE_TIME
    ]);
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_stage_name"] . " </b> Leads Stage is Saved Successfully!",
        "false" => "Failed to Save Leads Stage <b>" . $_POST["config_leads_stage_name"] . " </b> at the moment!"
    ]);

    //update leads stages
} elseif (isset($_POST["UpdateLeadsStages"])) {
    $Response = UPDATE(
        "config_leads_stages",
        [
            "config_leads_stage_name" => UpperCase($_POST["config_leads_stage_name"]),
            "config_leads_stage_color_code" => $_POST["config_leads_stage_color_code"],
            "config_leads_stage_sort_by_order" => $_POST["config_leads_stage_sort_by_order"],
            "config_leads_stage_status" => $_POST["config_leads_stage_status"],
            "config_leads_stage_remarks" => SECURE($_POST["config_leads_stage_remarks"], "e"),
            "config_leads_stage_updated_by" => LOGIN_USER_ID,
            "config_leads_stage_updated_at" => CURRENT_DATE_TIME
        ],
        "config_leads_stages_id='" . SECURE($_POST["config_leads_stages_id"], "d") . "'",
    );

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_stage_name"] . " </b> Leads Stage is Updated Successfully!",
        "false" => "Failed to Update Leads Stage <b>" . $_POST["config_leads_stage_name"] . " </b> at the moment!"
    ]);

    //remove leads stages
} elseif (isset($_POST["RemoveLeadsStageRecords"])) {
    $Response = DELETE_FROM("config_leads_stages", "config_leads_stages_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Leads Stage is Removed Successfully!",
        "false" => "Failed to Remove Leads Stage at the moment!"
    ]);

    //save leads sources
} elseif (isset($_POST["SaveLeadsSources"])) {
    $Response = INSERT(
        "config_leads_sources",
        [
            "config_leads_source_name" => $_POST["config_leads_source_name"],
            "config_leads_source_image" => UPLOAD_FILES("../../storage/sources", "", $_POST["config_leads_source_name"], "config_leads_source_image"),
            "config_leads_source_color" => $_POST["config_leads_source_color"],
            "config_leads_source_remarks" => SECURE($_POST["config_leads_source_remarks"], "e"),
            "config_leads_source_created_at" => CURRENT_DATE_TIME,
            "config_leads_source_updated_at" => CURRENT_DATE_TIME,
            "config_leads_source_created_by" => LOGIN_USER_ID,
            "config_leads_source_updated_by" => LOGIN_USER_ID,
            "config_leads_source_status" => $_POST["config_leads_source_status"],
        ]
    );
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_source_name"] . " </b> Leads Source is Saved Successfully!",
        "false" => "Failed to Save Leads Source <b>" . $_POST["config_leads_source_name"] . " </b> at the moment!"
    ]);

    //update leads sources
} elseif (isset($_POST["UpdateLeadsSources"])) {
    $Response = UPDATE(
        "config_leads_sources",
        [
            "config_leads_source_name" => $_POST["config_leads_source_name"],
            "config_leads_source_color" => $_POST["config_leads_source_color"],
            "config_leads_source_remarks" => SECURE($_POST["config_leads_source_remarks"], "e"),
            "config_leads_source_updated_at" => CURRENT_DATE_TIME,
            "config_leads_source_updated_by" => LOGIN_USER_ID,
            "config_leads_source_status" => $_POST["config_leads_source_status"],
        ],
        "config_leads_source_id='" . SECURE($_POST["config_leads_source_id"], "d") . "'",
    );

    // Check if a file is uploaded
    if (!empty($_FILES['config_leads_source_image']['name']) && $_FILES['config_leads_source_image']['size'] > 0) {
        $uploadedFilePath = UPLOAD_FILES("../../storage/sources", "", $_POST["config_leads_source_name"], "config_leads_source_image");

        if ($uploadedFilePath) {
            $Response = UPDATE(
                "config_leads_sources",
                [
                    "config_leads_source_image" => $uploadedFilePath,
                ],
                "config_leads_source_id='" . SECURE($_POST["config_leads_source_id"], "d") . "'"
            );
        }
    }

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_source_name"] . " </b> Leads Source is Updated Successfully!",
        "false" => "Failed to Update Leads Source <b>" . $_POST["config_leads_source_name"] . " </b> at the moment!"
    ]);

    //remove leads sources
} elseif (isset($_POST["RemoveLeadsSourcesRecords"])) {
    $Response = DELETE_FROM("config_leads_sources", "config_leads_source_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Leads Source is Removed Successfully!",
        "false" => "Failed to Remove Leads Source at the moment!"
    ]);

    //save leads priority levels
} elseif (isset($_POST["SaveLeadsPriorityLevel"])) {
    $Response = INSERT(
        "config_priority_levels",
        [
            "config_priority_level_name" => $_POST["config_priority_level_name"],
            "config_priority_level_remarks" => SECURE($_POST["config_priority_level_remarks"], "e"),
            "config_priority_level_created_at" => CURRENT_DATE_TIME,
            "config_priority_level_updated_at" => CURRENT_DATE_TIME,
            "config_priority_level_created_by" => LOGIN_USER_ID,
            "config_priority_level_updated_by" => LOGIN_USER_ID,
            "config_priority_level_status" => $_POST["config_priority_level_status"],
        ]
    );
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_priority_level_name"] . " </b> Leads Priority Level is Saved Successfully!",
        "false" => "Failed to Save Leads Priority Level <b>" . $_POST["config_priority_level_name"] . " </b> at the moment!"
    ]);

    //update leads priority levels
} elseif (isset($_POST["UpdateLeadsPriorityLevel"])) {
    $Response = UPDATE(
        "config_priority_levels",
        [
            "config_priority_level_name" => $_POST["config_priority_level_name"],
            "config_priority_level_remarks" => SECURE($_POST["config_priority_level_remarks"], "e"),
            "config_priority_level_updated_at" => CURRENT_DATE_TIME,
            "config_priority_level_updated_by" => LOGIN_USER_ID,
            "config_priority_level_status" => $_POST["config_priority_level_status"],
        ],
        "config_priority_level_id='" . SECURE($_POST["config_priority_level_id"], "d") . "'",
    );
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_priority_level_name"] . " </b> Leads Priority Level is Updated Successfully!",
        "false" => "Failed to Update Leads Priority Level <b>" . $_POST["config_priority_level_name"] . " </b> at the moment!"
    ]);

    //remove leads priority levels
} elseif (isset($_POST["RemoveLeadsPriorityLevel"])) {
    $Response = DELETE_FROM("config_priority_levels", "config_priority_level_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Leads Priority Level is Removed Successfully!",
        "false" => "Failed to Remove Leads Priority Level at the moment!"
    ]);

    //save call sub status
} elseif (isset($_POST["SaveCallSubStatus"])) {

    $config_call_sub_status_main_id = $_POST["config_call_sub_status_main_id"];

    //save sub status call status
    $Response = INSERT(
        "config_leads_sub_stages",
        [
            "config_call_sub_status_main_id" => $config_call_sub_status_main_id,
            "config_call_sub_status_name" => $_POST["config_call_sub_status_name"],
            "config_call_sub_status_status" => $_POST["config_call_sub_status_status"],
            "config_call_sub_status_remarks" => SECURE($_POST["config_call_sub_status_remarks"], "e"),
            "config_call_sub_status_updated_at" => CURRENT_DATE_TIME,
            "config_call_sub_status_updated_by" => LOGIN_USER_ID,
            "config_call_sub_status_created_at" => CURRENT_DATE_TIME,
            "config_call_sub_status_created_by" => LOGIN_USER_ID,
        ]
    );

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_call_sub_status_name"] . " </b> Call Sub Status is Saved Successfully!",
        "false" => "Failed to Save Call Sub Status <b>" . $_POST["config_call_sub_status_name"] . " </b> at the moment!"
    ]);

    //update sub status call status
} elseif (isset($_POST["UpdateCallSubStatus"])) {
    $config_call_sub_status_main_id = $_POST["config_call_sub_status_main_id"];

    $Response = UPDATE(
        "config_leads_sub_stages",
        [
            "config_call_sub_status_main_id" => $config_call_sub_status_main_id,
            "config_call_sub_status_name" => $_POST["config_call_sub_status_name"],
            "config_call_sub_status_status" => $_POST["config_call_sub_status_status"],
            "config_call_sub_status_remarks" => SECURE($_POST["config_call_sub_status_remarks"], "e"),
            "config_call_sub_status_updated_at" => CURRENT_DATE_TIME,
            "config_call_sub_status_updated_by" => LOGIN_USER_ID
        ],
        "config_call_sub_status_id ='" . SECURE($_POST["config_call_sub_status_id"], "d") . "'",
    );

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_stage_name"] . " </b> Call Sub Status is Updated Successfully!",
        "false" => "Failed to Update Call Sub Status <b>" . $_POST["config_leads_stage_name"] . " </b> at the moment!"
    ]);

    //remove sub status call status
} elseif (isset($_POST["RemoveCallSubStatusRecords"])) {
    $Response = DELETE_FROM("config_leads_sub_stages", "config_call_sub_status_id ='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Call Sub Status is Removed Successfully!",
        "false" => "Failed to Remove Call Sub Status at the moment!"
    ]);

    //save projects types
} elseif (isset($_POST["SaveProjectTypes"])) {
    $RequestedData = [
        "config_project_types_name" => $_POST["config_project_types_name"],
        "config_project_types_color_code" => $_POST["config_project_types_color_code"],
        "config_project_types_remarks" => SECURE($_POST["config_project_types_remarks"], "e"),
        "config_project_types_status" => $_POST["config_project_types_status"],
        "config_project_types_created_by" => LOGIN_USER_ID,
        "config_project_types_updated_by" => LOGIN_USER_ID,
        "config_project_types_created_at" => CURRENT_DATE_TIME,
        "config_project_types_updated_at" => CURRENT_DATE_TIME
    ];
    $Response = INSERT("config_project_types", $RequestedData);
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_project_types_name"] . " </b> Project Type is Saved Successfully!",
        "false" => "Failed to Save Project Type <b>" . $_POST["config_project_types_name"] . " </b> at the moment!"
    ]);

    //update projects types
} elseif (isset($_POST["UpdateProjectTypes"])) {
    $RequestedData = [
        "config_project_types_name" => $_POST["config_project_types_name"],
        "config_project_types_color_code" => $_POST["config_project_types_color_code"],
        "config_project_types_remarks" => SECURE($_POST["config_project_types_remarks"], "e"),
        "config_project_types_status" => $_POST["config_project_types_status"],
        "config_project_types_updated_by" => LOGIN_USER_ID,
        "config_project_types_updated_at" => CURRENT_DATE_TIME
    ];
    $Response = UPDATE("config_project_types", $RequestedData, "config_project_types_id='" . SECURE($_POST["config_project_types_id"], "d") . "'");
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_project_types_name"] . " </b> Project Type is Updated Successfully!",
        "false" => "Failed to Update Project Type <b>" . $_POST["config_project_types_name"] . " </b> at the moment!"
    ]);

    //remove projects types
} elseif (isset($_POST["RemoveProjectTypesRecords"])) {
    $Response = DELETE_FROM("config_project_types", "config_project_types_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Project Type is Removed Successfully!",
        "false" => "Failed to Remove Project Type at the moment!"
    ]);

    //save project stages
} elseif (isset($_POST["SaveProjectStages"])) {
    $RequestedData = [
        "config_projects_stages_name" => $_POST["config_projects_stages_name"],
        "config_projects_stages_color_code" => $_POST["config_projects_stages_color_code"],
        "config_projects_stages_sort_by_order" => $_POST["config_projects_stages_sort_by_order"],
        "config_projects_stages_remarks" => SECURE($_POST["config_projects_stages_remarks"], "e"),
        "config_projects_stages_status" => $_POST["config_projects_stages_status"],
        "config_projects_stages_created_by" => LOGIN_USER_ID,
        "config_projects_stages_updated_by" => LOGIN_USER_ID,
        "config_projects_stages_created_at" => CURRENT_DATE_TIME,
        "config_projects_stages_updated_at" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("config_projects_stages", $RequestedData);

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_projects_stages_name"] . " </b> Project Stage is Saved Successfully!",
        "false" => "Failed to Save Project Stage <b>" . $_POST["config_projects_stages_name"] . " </b> at the moment!"
    ]);

    //update project stages
} elseif (isset($_POST["UpdateProjectStages"])) {
    $RequestedData = [
        "config_projects_stages_name" => $_POST["config_projects_stages_name"],
        "config_projects_stages_color_code" => $_POST["config_projects_stages_color_code"],
        "config_projects_stages_sort_by_order" => $_POST["config_projects_stages_sort_by_order"],
        "config_projects_stages_remarks" => SECURE($_POST["config_projects_stages_remarks"], "e"),
        "config_projects_stages_status" => $_POST["config_projects_stages_status"],
        "config_projects_stages_updated_by" => LOGIN_USER_ID,
        "config_projects_stages_updated_at" => CURRENT_DATE_TIME
    ];
    $Response = UPDATE("config_projects_stages", $RequestedData, "config_projects_stages_id='" . SECURE($_POST["config_projects_stages_id"], "d") . "'");
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_projects_stages_name"] . " </b> Project Stage is Updated Successfully!",
        "false" => "Failed to Update Project Stage <b>" . $_POST["config_projects_stages_name"] . " </b> at the moment!"
    ]);

    //remove project stages
} elseif (isset($_POST["RemoveProjectStages"])) {
    $Response = DELETE_FROM("config_projects_stages", "config_projects_stages_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Project Stage is Removed Successfully!",
        "false" => "Failed to Remove Project Stage at the moment!"
    ]);

    //save project locations
} elseif (isset($_POST["SaveProjectLocations"])) {
    $RequestedData = [
        "config_projects_locations_name" => $_POST["config_projects_locations_name"],
        "config_projects_locations_color_code" => $_POST["config_projects_locations_color_code"],
        "config_projects_locations_remarks" => SECURE($_POST["config_projects_locations_remarks"], "e"),
        "config_projects_locations_status" => $_POST["config_projects_locations_status"],
        "config_projects_locations_created_by" => LOGIN_USER_ID,
        "config_projects_locations_updated_by" => LOGIN_USER_ID,
        "config_projects_locations_created_at" => CURRENT_DATE_TIME,
        "config_projects_locations_updated_at" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("config_projects_locations", $RequestedData);
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_projects_locations_name"] . " </b> Project Location is Saved Successfully!",
        "false" => "Failed to Save Project Location <b>" . $_POST["config_projects_locations_name"] . " </b> at the moment!"
    ]);

    //update project locations
} elseif (isset($_POST["UpdateProjectLocations"])) {
    $RequestedData = [
        "config_projects_locations_name" => $_POST["config_projects_locations_name"],
        "config_projects_locations_color_code" => $_POST["config_projects_locations_color_code"],
        "config_projects_locations_remarks" => SECURE($_POST["config_projects_locations_remarks"], "e"),
        "config_projects_locations_status" => $_POST["config_projects_locations_status"],
        "config_projects_locations_updated_by" => LOGIN_USER_ID,
        "config_projects_locations_updated_at" => CURRENT_DATE_TIME
    ];
    $Response = UPDATE("config_projects_locations", $RequestedData, "config_projects_locations_id='" . SECURE($_POST["config_projects_locations_id"], "d") . "'");
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_projects_locations_name"] . " </b> Project Location is Updated Successfully!",
        "false" => "Failed to Update Project Location <b>" . $_POST["config_projects_locations_name"] . " </b> at the moment!"
    ]);

    //remove project locations
} elseif (isset($_POST["RemoveProjectLocations"])) {
    $Response = DELETE_FROM("config_projects_locations", "config_projects_locations_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Project Location is Removed Successfully!",
        "false" => "Failed to Remove Project Location at the moment!"
    ]);

    //save project status
} elseif (isset($_POST["SaveProjectStatus"])) {
    $RequestedData = [
        "config_projects_status_name" => $_POST["config_projects_status_name"],
        "config_projects_status_color_code" => $_POST["config_projects_status_color_code"],
        "config_projects_status_remarks" => SECURE($_POST["config_projects_status_remarks"], "e"),
        "config_projects_status_status" => $_POST["config_projects_status_status"],
        "config_projects_status_created_by" => LOGIN_USER_ID,
        "config_projects_status_updated_by" => LOGIN_USER_ID,
        "config_projects_status_created_at" => CURRENT_DATE_TIME,
        "config_projects_status_updated_by" => LOGIN_USER_ID,
    ];
    $Response = INSERT("config_projects_status", $RequestedData);
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_projects_status_name"] . " </b> Project Status is Saved Successfully!",
        "false" => "Failed to Save Project Status <b>" . $_POST["config_projects_status_name"] . " </b> at the moment!"
    ]);

    //update project status
} elseif (isset($_POST["UpdateProjectStatus"])) {
    $RequestedData = [
        "config_projects_status_name" => $_POST["config_projects_status_name"],
        "config_projects_status_color_code" => $_POST["config_projects_status_color_code"],
        "config_projects_status_remarks" => SECURE($_POST["config_projects_status_remarks"], "e"),
        "config_projects_status_status" => $_POST["config_projects_status_status"],
        "config_projects_status_updated_by" => LOGIN_USER_ID,
        "config_projects_status_updated_at" => CURRENT_DATE_TIME
    ];
    $Response = UPDATE("config_projects_status", $RequestedData, "config_projects_status_id='" . SECURE($_POST["config_projects_status_id"], "d") . "'");
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_projects_status_name"] . " </b> Project Status is Updated Successfully!",
        "false" => "Failed to Update Project Status <b>" . $_POST["config_projects_status_name"] . " </b> at the moment!"
    ]);

    //remove project status
} elseif (isset($_POST["RemoveProjectStatus"])) {
    $Response = DELETE_FROM("config_projects_status", "config_projects_status_id='" . SECURE($_POST['RecordsId'], "d") . "'");
    RequestHandler($Response, [
        "true" => "Project Status is Removed Successfully!",
        "false" => "Failed to Remove Project Status at the moment!"
    ]);

    //add resources
} elseif (isset($_POST["SaveLeadsResouces"])) {
    $config_leads_resources = [
        "config_leads_resources_name" => $_POST["config_leads_resources_name"],
        "config_leads_resources_status" => $_POST["config_leads_resources_status"],
        "config_leads_resources_created_by" => LOGIN_USER_ID,
        "config_leads_resources_created_at" => CURRENT_DATE_TIME,
        "config_leads_resources_updated_at" => CURRENT_DATE_TIME,
        "config_leads_resources_updated_by" => LOGIN_USER_ID,
    ];
    $Response = INSERT("config_leads_resources", $config_leads_resources);

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_resources_name"] . " </b> Resource is Saved Successfully!",
        "false" => "Failed to Save Resource <b>" . $_POST["config_leads_resources_name"] . " </b> at the moment!"
    ]);

    //update resources
} elseif (isset($_POST["UpdateLeadsResouces"])) {
    $config_leads_resources = [
        "config_leads_resources_name" => $_POST["config_leads_resources_name"],
        "config_leads_resources_status" => $_POST["config_leads_resources_status"],
        "config_leads_resources_updated_at" => CURRENT_DATE_TIME,
        "config_leads_resources_updated_by" => LOGIN_USER_ID
    ];

    $Response = UPDATE("config_leads_resources", $config_leads_resources, "config_leads_resources_id='" . SECURE($_POST["config_leads_resources_id"], "d") . "'");

    RequestHandler($Response, [
        "true" => "<b>" . $_POST["config_leads_resources_name"] . " </b> Resource is Updated Successfully!",
        "false" => "Failed to Update Resource <b>" . $_POST["config_leads_resources_name"] . " </b> at the moment!"
    ]);

    //remove resources
} elseif (isset($_POST["RemoveLeadsResources"])) {
    $Response = DELETE_FROM("config_leads_resources", "config_leads_resources_id='" . SECURE($_POST["RecordsId"], "d") . "'");
    RequestHandler($Response, [
        "true" => "Resource is Removed Successfully!",
        "false" => "Failed to Remove Resource at the moment!"
    ]);
}
