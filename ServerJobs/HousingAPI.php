<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";

$HousingAPI = _DB_COMMAND_("SELECT * FROM companies_api WHERE API_Status='1' and API_Name='Housing'", true);

if ($HousingAPI != null) {
    foreach ($HousingAPI as $api) {
        $companyId = $api->CompanyID;
        $key = $api->API_KEY;
        $id = $api->API_ID;

        $startTime = strtotime(date("Y-m-d 00:00:00"));
        $endTime = time();
        $currentTime = time();
        $hash = hash_hmac('sha256', $currentTime, $key);

        $url = "https://pahal.housing.com/api/v0/get-builder-leads?start_date=" . $startTime . "&end_date=" . $endTime . "&current_time=" . $currentTime . "&hash=" . $hash . "&id=" . $id;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $responseData = json_decode($response, true);

        if ($responseData && isset($responseData['data'])) {
            foreach ($responseData['data'] as $lead) {
                $leadDate = date('Y-m-d H:i:s', $lead['lead_date']);
                $apartmentNames = $lead['apartment_names'];
                $countryCode = $lead['country_code'];
                $serviceType = $lead['service_type'];
                $categoryType = $lead['category_type'];
                $localityName = isset($lead['locality_name']) ? $lead['locality_name'] : '';
                $cityName = isset($lead['city_name']) ? $lead['city_name'] : '';
                $leadName = $lead['lead_name'];
                $leadEmail = $lead['lead_email'];
                $leadPhone = $lead['lead_phone'];
                $minPrice = isset($lead['min_price']) ? $lead['min_price'] : null;
                $maxPrice = isset($lead['max_price']) ? $lead['max_price'] : null;
                $projectId = isset($lead['project_id']) ? $lead['project_id'] : '';
                $projectName = isset($lead['project_name']) ? $lead['project_name'] : '';
                $propertyField = isset($lead['property_field']) ? implode(',', $lead['property_field']) : '';

                $project = [
                    "ProjectName" => $projectName,
                    "ProjectDescriptions" => $projectId,
                    "ProjectCreatedAt" => CURRENT_DATE_TIME,
                    "CompanyID" => $companyId,
                ];

                $checkProject = CHECK("SELECT * FROM projects WHERE ProjectName LIKE '%$projectName%' AND CompanyID='$companyId'");

                if ($checkProject == true) {
                    $pid = FETCH("SELECT ProjectsId FROM projects WHERE ProjectName LIKE '%$projectName%' AND CompanyID='$companyId'", "ProjectsId");
                } else {
                    $savepid = INSERT("projects", $project);
                    $pid =  FETCH("SELECT ProjectsId FROM projects ORDER BY ProjectsId LIMIT 1", "ProjectsId");
                }

                $Phone = VALID_PHONE_NUMBER($leadPhone);

                $HousingLeads = [
                    "LeadsName" => $leadName,
                    "LeadsEmail" => $leadEmail,
                    "LeadsPhone" => $Phone,
                    "LeadsCity" => $cityName,
                    "LeadsSource" => "Housing",
                    "UploadedOn" => CURRENT_DATE_TIME,
                    "LeadStatus" => "UPLOADED",
                    "LeadsUploadBy" => "null",
                    "LeadsUploadedfor" => "NULL",
                    "LeadsAddress" => $categoryType . " , " . $localityName . " , " . $cityName,
                    "LeadsProfession" => "Null",
                    "LeadProjectsRef" => $pid,
                    "LeadType" => "LEAD",
                    "LeadsWhatsappPhoneNumber" => "Null",
                    "CompanyID" => $companyId,
                    "Upload_Source" => "HOUSING",
                    "Notify" => '1',
                ];

                $check = CHECK("SELECT LeadsPhone FROM lead_uploads WHERE LeadsPhone='$Phone' AND CompanyID='$companyId'");

                if ($check == false) {
                    $checkLeads = CHECK("SELECT LeadPersonPhoneNumber FROM leads WHERE LeadPersonPhoneNumber='$Phone' and CompanyID='$companyId'");

                    if ($checkLeads == false) {
                        $Save = INSERT("lead_uploads", $HousingLeads);
                        echo "new lead added <br>";
                    } else {
                        echo "already exist in leads<br>";
                    }
                } else {
                    echo "already uploaded!!<br>";
                }
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
        $check = CHECK("SELECT Autodistribute FROM companies_api WHERE Autodistribute='true' and CompanyID='$companyId' AND API_Name='Housing'");
        if ($check == true) {
            $HousingAPIId = _DB_COMMAND_("SELECT * FROM companies_api WHERE Autodistribute='true' and CompanyID='$companyId' AND API_Name='Housing'", true);
            foreach ($HousingAPIId as $H) {
                $LeadsSQL = "SELECT * FROM lead_uploads WHERE LeadStatus='UPLOADED' AND Upload_Source='HOUSING' AND CompanyID='$companyId' ORDER BY leadsUploadId ASC";
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
                            echo "Users for API Main ID " . $H->ID . ":<br>";
                            print_r($USERS);
                            echo "<br>";

                            $totalUsers = count($USERS);
                            $userLeadCounts = array_fill(0, $totalUsers, 0); // Initialize array to count leads per user

                            $lastUserIndex = getLastUserIndex($H->ID, $companyId);

                            for ($i = 0; $i < $TotalLeads; $i++) {
                                $userIndex = ($lastUserIndex + $i) % $totalUsers; // Determine user index in a round-robin manner
                                $userLeadCounts[$userIndex]++;
                            }

                            $newLastUserIndex = ($lastUserIndex + $TotalLeads) % $totalUsers;
                            updateLastUserIndex($H->ID, $companyId, $newLastUserIndex);

                            echo "Lead distribution:<br>";
                            for ($i = 0; $i < $totalUsers; $i++) {
                                echo "User " . $USERS[$i] . " gets " . $userLeadCounts[$i] . " leads.<br>";
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
    $GetUploadedLeads = _DB_COMMAND_("SELECT * FROM lead_uploads WHERE CompanyId='$companyId' AND LeadStatus='UPLOADED' AND Upload_Source='HOUSING' ORDER BY leadsUploadId ASC LIMIT 0, $TotalLeadstoDistribute", true);
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
            $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED',Notify='0' WHERE leadsUploadId='" . $UploadedLead->leadsUploadId . "'");
        }
    }
    $UserName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId'AND UserStatus='1' AND Deleted_At IS NULL", "UserFullName");
    $UserEmail = FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserId'AND UserStatus='1' AND Deleted_At IS NULL", "UserEmailId");
    $replyto = FETCH("SELECT UserEmailId FROM users, config_companies WHERE users.UserId=config_companies.company_main_user_id AND company_id=' $companyId' AND UserStatus='1' AND Deleted_At IS NULL", "UserEmailId");
    SENDCOMPANYMAILS(
        $companyId,
        $TotalLeadstoDistribute . " New Leads Assigned From Housing",
        "Dear " . $UserName . ",",
        $UserEmail,
        $replyto,
        "You have been assigned " . $TotalLeadstoDistribute . " new leads from Housing.\n\n" .
            "Please log in to the CRM to review and manage your new leads.\n\n" .
            "CRM login link: https://app.apnalead.com\n"

    );
}
