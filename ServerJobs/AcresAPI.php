<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";
$AcresAPI = _DB_COMMAND_("SELECT * FROM companies_api WHERE API_Status='1' and API_Name='99Acres'", true);
if ($AcresAPI != null) {
    foreach ($AcresAPI as $api) {
        $companyId = $api->CompanyID;
        $key = SECURE($api->API_KEY, "d");
        $id = SECURE($api->API_ID, "d");
        $URL = 'https://app.apnalead.com/handler/AutoRunner/AcresAPI.php?hash=&key=&fname=Akash&phone=&email=&message=&address=&min_budget=&max_budget=&location=&project=&leaddate=&city=&localityName=';
        if (isset($_GET['hash'])) {
            if (SECURE($_GET['hash'], "d") == $id) {
                if (SECURE($_GET['key'], "d") == $key) {
                    echo "----------------------working<br>";
                    $projectName = $_GET['project'] ?? '';
                    if (!empty($projectName)) {
                        $project = [
                            "ProjectName" => $projectName,
                            "ProjectDescriptions" => "null",
                            "ProjectCreatedAt" => CURRENT_DATE_TIME,
                            "CompanyID" => 36,
                        ];
                        $checkProject = CHECK("SELECT * FROM projects WHERE ProjectName LIKE '%$projectName%' AND CompanyID='36'");
                        if ($checkProject) {
                            $pid = FETCH("SELECT ProjectsId FROM projects WHERE ProjectName LIKE '%$projectName%' AND CompanyID='36'", "ProjectsId");
                        } else {
                            INSERT("projects", $project);
                            $pid = FETCH("SELECT ProjectsId FROM projects ORDER BY ProjectsId DESC LIMIT 1", "ProjectsId");
                        }
                    } else {
                        $pid = null;
                    }
                    $Phone = VALID_PHONE_NUMBER($_GET['phone'] ?? '');
                    $data = [
                        "LeadsName" => $_GET['fname'] ?? '',
                        "LeadsEmail" => $_GET['email'] ?? '',
                        "LeadsPhone" => $Phone,
                        "LeadsCity" => $_GET['location'] ?? '',
                        "LeadsSource" => '99Acres',
                        "UploadedOn" => CURRENT_DATE_TIME,
                        "LeadStatus" => "UPLOADED",
                        "LeadsUploadBy" => "NULL",
                        "LeadsUploadedfor" => "NULL",
                        "LeadsAddress" => $_GET['address'] ?? '',
                        "LeadsProfession" => "Null",
                        "LeadProjectsRef" => $pid,
                        "LeadsWhatsappPhoneNumber" => "Null",
                        "CompanyID" => 36,
                        "Upload_Source" => "99Acres",
                    ];
                    $check = CHECK("SELECT LeadsPhone FROM lead_uploads WHERE LeadsPhone='$Phone' AND CompanyID='$companyId'");

                    if ($check == false) {
                        $checkLeads = CHECK("SELECT LeadPersonPhoneNumber FROM leads WHERE LeadPersonPhoneNumber='$Phone' and CompanyID='$companyId'");

                        if ($checkLeads == false) {
                            $Save = INSERT("lead_uploads", $data);
                            echo "new lead added <br>";
                        } else {
                            echo "already exist in leads<br>";
                        }
                    } else {
                        echo "already uploaded!!<br>";
                    }
                } else {
                    echo "key not found<br>";
                }
            } else {
                echo "hash not found<br>";
            }
        } else {
            echo "no response<br>";
        }
    }
} else {
    echo "no API found!!<br>";
}
function getLastUserIndex($apiMainId, $companyId)
{
    $result = FETCH("SELECT last_user_index FROM equal_distribute WHERE api_main_id='$apiMainId' AND CompanyID='$companyId'", "last_user_index");
    if ($result != null && !empty($result)) {
        return $result;
    }
    return 0; // Default to 0 if no record is found
}
function updateLastUserIndex($apiMainId, $companyId, $lastUserIndex)
{
    $check = CHECK("SELECT * FROM equal_distribute WHERE api_main_id='$apiMainId' AND CompanyID='$companyId'");
    if ($check == true) {
        UPDATE("UPDATE equal_distribute SET last_user_index='$lastUserIndex' WHERE api_main_id='$apiMainId' AND CompanyID='$companyId'");
    } else {
        $data = [
            'last_user_index' => $lastUserIndex,
            'api_main_id' => $apiMainId,
            'CompanyID' => $companyId,
        ];
        INSERT("equal_distribute", $data);
    }
}
$AllCompanies = _DB_COMMAND_("SELECT * FROM config_companies WHERE company_status='1'", true);
if ($AllCompanies != null) {
    foreach ($AllCompanies as $company) {
        $companyId = $company->company_id;
        $check = CHECK("SELECT Autodistribute FROM companies_api WHERE Autodistribute='true' and CompanyID='$companyId' AND API_Name='99Acres'");
        if ($check == true) {
            $HousingAPIId = _DB_COMMAND_("SELECT * FROM companies_api WHERE Autodistribute='true' and CompanyID='$companyId' AND API_Name='99Acres'", true);
            foreach ($HousingAPIId as $H) {
                $LeadsSQL = "SELECT * FROM lead_uploads WHERE LeadStatus='UPLOADED' AND Upload_Source='99Acres' AND CompanyID='$companyId' ORDER BY leadsUploadId ASC";
                $FetchAllUploadedLeads = _DB_COMMAND_($LeadsSQL, true);
                // Check if leads are available
                if ($FetchAllUploadedLeads != null) {
                    $TotalLeads = TOTAL($LeadsSQL); // Total number of leads available
                    $GetAllUsers = _DB_COMMAND_("SELECT * FROM api_users WHERE API_MAIN_ID='" . $H->ID . "' AND CompanyID='$companyId'", true);
                    // Check if users are available
                    if ($GetAllUsers != null) {
                        foreach ($GetAllUsers as $user) {
                            $UserIds = explode(',', $user->API_Users);
                            $USERS = [];
                            if ($user->API_Users != null) {
                                foreach ($UserIds as $u) {
                                    $USERS[] = trim($u);
                                }
                            } else {
                                $USERS[] = FETCH("SELECT company_main_user_id FROM config_companies WHERE company_id='$companyId'", "company_main_user_id");
                            }

                            $totalUsers = count($USERS);
                            $userLeadCounts = array_fill(0, $totalUsers, 0); // Initialize array to count leads per user

                            $lastUserIndex = getLastUserIndex($H->ID, $companyId);

                            for ($i = 0; $i < $TotalLeads; $i++) {
                                $userIndex = ($lastUserIndex + $i) % $totalUsers; // Determine user index in a round-robin manner
                                $userLeadCounts[$userIndex]++;
                            }

                            $newLastUserIndex = ($lastUserIndex + $TotalLeads) % $totalUsers;
                            updateLastUserIndex($H->ID, $companyId, $newLastUserIndex);

                            // echo "Lead distribution:<br>";
                            for ($i = 0; $i < $totalUsers; $i++) {
                                // echo "User " . $USERS[$i] . " gets " . $userLeadCounts[$i] . " leads.<br>";
                                Distributeleads($USERS[$i], $userLeadCounts[$i], $companyId);
                            }
                        }
                    } else {

                        echo "No users found for API Main ID " . $H->ID . ".<br>";
                    }
                } else {
                    echo "No leads found for API Main ID " . $H->ID . ".<br>";
                }
            }
        }
    }
} else {
    echo "No active companies found!";
}
//distribute leads 
function Distributeleads($UserId, $TotalLeadstoDistribute, $companyId)
{
    $GetUploadedLeads = _DB_COMMAND_("SELECT * FROM lead_uploads WHERE CompanyId='$companyId' AND LeadStatus='UPLOADED' AND Upload_Source='99Acres' ORDER BY leadsUploadId ASC LIMIT 0, $TotalLeadstoDistribute", true);
    if ($GetUploadedLeads != null) {
        foreach ($GetUploadedLeads as $UploadedLead) {
            $data = array(
                "LeadSalutations" => "",
                "LeadPersonFullname" => $UploadedLead->LeadsName,
                "LeadPersonPhoneNumber" => VALID_PHONE_NUMBER($UploadedLead->LeadsPhone),
                "LeadPersonEmailId" => $UploadedLead->LeadsEmail,
                "LeadPersonAddress" => $UploadedLead->LeadsAddress,
                "LeadPersonCreatedBy" => "",
                "LeadPersonManagedBy" => $UserId,
                "LeadPersonStatus" => "FRESH LEAD",
                "LeadPriorityLevel" => "HIGH",
                "LeadPersonNotes" => "",
                "LeadPersonSubStatus" => "",
                "LeadForCountry" => "",
                "LeadLastQualification" => "",
                "LeadUniversityName" => "",
                "LeadPersonSource" => $UploadedLead->LeadsSource,
                "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
                "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
                "CompanyID" => $companyId,
                "Distribute_Type" => "AUTO",
                "Notify" => '1',
            );
            $save = INSERT("leads", $data);
            $LeadMainId = FETCH("SELECT LeadsId FROM leads where LeadPersonPhoneNumber='" . VALID_PHONE_NUMBER($UploadedLead->LeadsPhone) . "'", "LeadsId");

            $LeadRequirements = array(
                "LeadMainId" => $LeadMainId,
                "LeadRequirementDetails" => $UploadedLead->LeadProjectsRef,
                "LeadRequirementStatus" => "1",
                "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
                "LeadRequirementNotes" => "",
            );
            $Save = INSERT("lead_requirements", $LeadRequirements);
            $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED', Notify='0' WHERE leadsUploadId='" . $UploadedLead->leadsUploadId . "'");
        }
    }
    $UserName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId'AND UserStatus='1' AND Deleted_At IS NULL", "UserFullName");
    $UserEmail = FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserId'AND UserStatus='1' AND Deleted_At IS NULL", "UserEmailId");
    $replyto = FETCH("SELECT UserEmailId FROM users, config_companies WHERE users.UserId=config_companies.company_main_user_id AND company_id=' $companyId' AND UserStatus='1' AND Deleted_At IS NULL", "UserEmailId");
    SENDCOMPANYMAILS(
        $companyId,
        $TotalLeadstoDistribute . " New Leads Assigned From 99acres",
        "Dear " . $UserName . ",",
        $UserEmail,
        $replyto,
        "You have been assigned " . $TotalLeadstoDistribute . " new leads from 99acres.\n\n" .
            "Please log in to the CRM to review and manage your new leads.\n\n" .
            "CRM login link: https://app.apnalead.com\n"

    );
}
