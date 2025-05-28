<?php
$Dir = "..";
require_once $Dir . '/acm/SysFileAutoLoader.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Initialize response structure
$response = [
  'status' => 'error',
  'message' => '',
  'data' => null
];

// API Key validation
$ApiKey = SECURE(APP_NAME, "e");
$authentication_key = $_GET["authentication_key"] ?? null;

if (!$authentication_key) {
  $response['status'] = 'Authentication Failed';
  $response['message'] = 'No Authentication Key Found!';
  $response['data'] = "NA";
  http_response_code(401);
  echo json_encode($response);
  exit;
}

if ($authentication_key !== $ApiKey) {
  $response['status'] = 'Invalid Authentication Key';
  $response['message'] = 'Authentication Key is Invalid!';
  $response['data'] = "NA";
  http_response_code(401);
  echo json_encode($response);
  exit;
}

// Check Required Parameters
$leads_full_name = $_GET["leads_full_name"] ?? "";
$leads_phone_number = $_GET["leads_phone_number"] ?? "";
$leads_alternate_phone = $_GET["leads_alternate_phone"] ?? "";
$leads_email_id = $_GET["leads_email_id"] ?? "";
$leads_gender = $_GET["leads_gender"] ?? "";
$leads_type = $_GET["leads_type"] ?? "";
$leads_source = $_GET["leads_source"] ?? "Others";
$leads_re_source = $_GET["leads_re_source"] ?? "Others";
$leads_entry_type = $_GET["leads_entry_type"] ?? "";
$leads_projects_name = $_GET["leads_projects_name"] ?? "";
$leads_remarks = $_GET["leads_remarks"] ?? "";
$leads_date_of_birth = $_GET["leads_date_of_birth"] ?? "";
$budgets = $_GET["budgets"] ?? "";
$location = $_GET["location"] ?? "";
$duration = $_GET["duration"] ?? "";
$unit_type = $_GET["property_type"] ?? "";
$property_tags = $_GET["tags"] ?? "";

$leads_phone_number = ValidatePhoneNumber($leads_phone_number);

try {
  // Get leads source id from the database
  $config_leads_source_id = FETCH("SELECT config_leads_source_id FROM config_leads_sources WHERE config_leads_source_name LIKE '%$leads_source%' ORDER BY config_leads_source_id DESC LIMIT 1", "config_leads_source_id");
  if ($config_leads_source_id == null) {
    $config_leads_sources = [
      "config_leads_source_name" => $leads_source,
      "config_leads_source_created_at" => CURRENT_DATE_TIME,
      "config_leads_source_created_by" => 1,
      "config_leads_source_status" => 1
    ];
    $Save = INSERT("config_leads_sources", $config_leads_sources);
    if ($Save == true) {
      $config_leads_source_id = FETCH("SELECT config_leads_source_id FROM config_leads_sources ORDER BY config_leads_source_id DESC LIMIT 1", "config_leads_source_id");
    } else {
      $config_leads_source_id = 0;
    }
  }

  // Get leads re-sources from the database
  $config_leads_resources_id = FETCH("SELECT config_leads_resources_id FROM config_leads_resources WHERE config_leads_resources_name LIKE '%$leads_re_source%' ORDER BY config_leads_resources_id DESC LIMIT 1", "config_leads_resources_id");
  if ($config_leads_resources_id == null) {
    $config_leads_resources = [
      "config_leads_resources_name" => $leads_re_source,
      "config_leads_resources_status" => 1,
      "config_leads_resources_created_at" => CURRENT_DATE_TIME,
      "config_leads_resources_created_by" => 1
    ];
    $Save = INSERT("config_leads_resources", $config_leads_resources);
    if ($Save == true) {
      $config_leads_resources_id = FETCH("SELECT config_leads_resources_id FROM config_leads_resources ORDER BY config_leads_resources_id DESC LIMIT 1", "config_leads_resources_id");
    } else {
      $config_leads_resources_id = 0;
    }
  }

  // Get projects ids
  $projects_id = FETCH("SELECT projects_id FROM projects WHERE projects_name LIKE '%$leads_projects_name%' ORDER BY projects_id DESC limit 1", "projects_id");
  if ($projects_id == null) {
    $projects = [
      "projects_name" => $leads_projects_name,
      "projects_listing_status" => 1,
      "projects_created_at" => CURRENT_DATE_TIME,
      "projects_updated_at" => CURRENT_DATE_TIME,
      "projects_created_by" => 1,
      "projects_updated_by" => 1,
    ];
    $Response = INSERT("projects", $projects);
    if ($Response == true) {
      $projects_id = FETCH("SELECT projects_id FROM projects ORDER BY projects_id DESC LIMIT 1", "projects_id");
    } else {
      $projects_id = "";
    }
  }

  // Save leads details 
  $leads = [
    "leads_full_name" => $leads_full_name,
    "leads_phone_number" => $leads_phone_number,
    "leads_alternate_phone" => $leads_alternate_phone,
    "leads_email_id" => $leads_email_id,
    "leads_date_of_birth" => $leads_date_of_birth,
    "leads_gender" => $leads_gender,
    "leads_created_at" => CURRENT_DATE_TIME,
    "leads_created_by" => 1,
    "leads_type" => $leads_type,
    "leads_source" => $config_leads_source_id,
    "leads_re_source" => $config_leads_resources_id,
    "leads_entry_type" => "API",
    "leads_stages" => 1,
    "leads_sub_stages" => 1,
    "leads_status" => 0,
    "leads_priority_level" => 1,
    "leads_projects_id" => $projects_id,
    "leads_remarks" => SECURE($leads_remarks, "e"),
    "leads_fetched_status" => "API"
  ];
  if ($leads_phone_number != null && $leads_phone_number != "" && $leads_phone_number != " ") {
    $LeadsSave = INSERT("leads", $leads);
    if ($LeadsSave == true) {
      $leads_id = FETCH("SELECT leads_id FROM leads ORDER BY leads_id DESC LIMIT 1", "leads_id");

      // Budget and other details
      $leads_requirements = [
        "leads_main_id" => $leads_id,
        "leads_project_id" => $projects_id,
        "leads_requirement_budgets" => $budgets,
        "leads_requirement_preffered_location" => $location,
        "leads_requirement_duration" => $duration,
        "leads_requirement_type" => $unit_type,
        "leads_requirement_added_at" => CURRENT_DATE_TIME,
        "leads_requirement_added_by" => 1,
        "leads_requirement_remarks" => SECURE($leads_remarks, "e"),
        "leads_requirement_tags" => $property_tags,
      ];
      $Response = INSERT("leads_requirements", $leads_requirements);

      if ($Response == true) {
        $response['status'] = 'success';
        $response['message'] = 'Lead saved successfully';
        $response['data'] = ['leads_id' => $leads_id];
        http_response_code(201);
      } else {
        $response['status'] = 'Failed';
        $response['message'] = 'Unable to Save Record More Details in the Database';
        $response['data'] = "NA";
        http_response_code(401);
      }
    } else {
      $response['status'] = 'Failed';
      $response['message'] = 'Unable to Save Record in the Database';
      $response['data'] = "NA";
      http_response_code(401);
    }
  } else {
    $response['status'] = 'failed';
    $response['message'] = 'Empty OR Invalid Phone Number';
    $response['data'] = ['leads_id' => "NA"];
    http_response_code(201);
  }
} catch (Exception $e) {
  $response['message'] = 'Internal Server Error: ' . $e->getMessage();
  http_response_code(500);
}

echo json_encode($response);
