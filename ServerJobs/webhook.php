<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";

$INCKEY = SECURE("APNA_WEB_2025", "e");


$URL = 'http://localhost/apnalead/handler/AutoRunner/webhook.php?key=&name=&phone=&email=&message=&address=&project=';

if (isset($_GET['key'])) {
    if (SECURE($_GET['key'], "d") == "APNA_WEB_2025") {
        $projectName = $_GET['project'] ?? '';
        if ($projectName != '' || $projectName != NULL) {
            $project = [
                "ProjectName" => $projectName,
                "ProjectDescriptions" => "null",
                "ProjectCreatedAt" => CURRENT_DATE_TIME,
                "CompanyID" => 57,
            ];
            $checkProject = CHECK("SELECT ProjectName FROM projects WHERE ProjectName LIKE '%$projectName%' AND CompanyID=57");
            if ($checkProject) {
                $pid = FETCH("SELECT ProjectsId FROM projects WHERE ProjectName LIKE '%$projectName%' AND CompanyID=57", "ProjectsId");
            } else {
                INSERT("projects", $project);
                $pid = FETCH("SELECT ProjectsId FROM projects ORDER BY ProjectsId DESC LIMIT 1", "ProjectsId"); // Corrected query
            }
        } else {
            $pid = null;
        }
        $data = [
            "LeadsName" => $_GET['name'] ?? '',
            "LeadsEmail" => $_GET['email'] ?? '',
            "LeadsPhone" => VALID_PHONE_NUMBER($_GET['phone'] ?? ''),
            "LeadsSource" => 'Website',
            "UploadedOn" => CURRENT_DATE_TIME,
            "LeadStatus" => "UPLOADED",
            "LeadsUploadBy" => "NULL",
            "LeadsUploadedfor" => "NULL",
            "LeadsAddress" => $_GET['address'] ?? '',
            "LeadsProfession" => "Null",
            "LeadProjectsRef" => $pid,
            "LeadsWhatsappPhoneNumber" => "Null",
            "LeadType" => "LEAD",
            "Upload_Source" => "WEBSITE",
            "CompanyID" => 57,
        ];
        // echo "<pre>";
        // print_r($data);
        $Phone = VALID_PHONE_NUMBER($_GET['phone']);
        if ($_GET['phone'] != null && $_GET['phone'] != '') {
            $checkPhone = CHECK("SELECT LeadsPhone FROM lead_uploads WHERE LeadsPhone='$Phone'");
            if ($checkPhone == false) {
                INSERT("lead_uploads", $data);
                echo "success";
            } else {
                echo "Phone Number already exist";
            }
        } else {
            echo "Phone Number is required";
        }
    } else {
        echo "key not Match";
    }
} else {
    echo "URL IS NOT SET";
}
