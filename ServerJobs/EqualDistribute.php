<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";
function getLastUserIndex1($FacebookId, $companyId)
{
    $result = FETCH("SELECT last_index_user FROM config_facebook_accounts WHERE id='$FacebookId' AND CompanyID='$companyId'", "last_index_user");
    if ($result != null && !empty($result)) {
        return $result;
    }
    return 0; // Default to 0 if no record is found
}

function updateLastUserIndex1($FacebookId, $companyId, $lastUserIndex)
{
    UPDATE("UPDATE config_facebook_accounts SET last_index_user='$lastUserIndex' WHERE id='$FacebookId' AND CompanyID='$companyId'");
}
$AllCompanies = _DB_COMMAND_("SELECT * FROM config_companies WHERE company_status='1'", true);
if ($AllCompanies != null) {
    foreach ($AllCompanies as $company) {
        $companyId = $company->company_id;
        $check = CHECK("SELECT Autodistribute FROM config_facebook_accounts WHERE Autodistribute='true' and CompanyID='$companyId'");
        if ($check == true) {
            $Facebook = _DB_COMMAND_("SELECT * FROM config_facebook_accounts WHERE Autodistribute='true' and CompanyID='$companyId'", true);
            foreach ($Facebook as $H) {
                $LeadsSQL = "SELECT * FROM lead_uploads WHERE LeadStatus='UPLOADED' AND Upload_Source='FACEBOOK' AND CompanyID='$companyId' AND Fb_ad_id='" . $H->fb_ads_id . "' ORDER BY leadsUploadId ASC";
                $FetchAllUploadedLeads = _DB_COMMAND_($LeadsSQL, true);
                // Check if leads are available
                if ($FetchAllUploadedLeads != null) {
                    $TotalLeads = TOTAL($LeadsSQL); // Total number of leads available
                    $GetAllUsers = _DB_COMMAND_("SELECT * FROM config_facebook_accounts WHERE id='" . $H->id . "' AND CompanyID='$companyId'", true);
                    // Check if users are available
                    if ($GetAllUsers != null) {
                        foreach ($GetAllUsers as $user) {
                            $UserIds = explode(',', $user->user_list);
                            $USERS = [];
                            if ($user->user_list != null) {
                                foreach ($UserIds as $u) {
                                    $USERS[] = trim($u);
                                }
                            } else {
                                $USERS[] = FETCH("SELECT company_main_user_id FROM config_companies WHERE company_id='$companyId'", "company_main_user_id");
                            }
                            echo "Users for API Main ID " . $H->id . "-------" . $H->CompanyID . ":<br>";
                            print_r($USERS);
                            echo "<br>";
                            $totalUsers = count($USERS);
                            $userLeadCounts = array_fill(0, $totalUsers, 0); // Initialize array to count leads per user

                            $lastUserIndex = getLastUserIndex1($H->id, $companyId);

                            for ($i = 0; $i < $TotalLeads; $i++) {
                                $userIndex = ($lastUserIndex + $i) % $totalUsers; // Determine user index in a round-robin manner
                                $userLeadCounts[$userIndex]++;
                            }
                            $newLastUserIndex = ($lastUserIndex + $TotalLeads) % $totalUsers;
                            updateLastUserIndex1($H->id, $companyId, $newLastUserIndex);

                            echo "Lead distribution:<br>";
                            for ($i = 0; $i < $totalUsers; $i++) {
                                echo "User " . $USERS[$i] . " gets " . $userLeadCounts[$i] . " leads.<br>";
                                Distributeleads($USERS[$i], $userLeadCounts[$i], $companyId);
                            }
                        }
                    } else {
                        echo "No users found for Facebook ID " . $H->id . "------ " . $H->CompanyID . "<br>";
                    }
                } else {
                    echo "No leads found for Facebook ID " . $H->id . "---" . $H->CompanyID . "<br>";
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
    $GetUploadedLeads = _DB_COMMAND_("SELECT * FROM lead_uploads WHERE CompanyId='$companyId' AND LeadStatus='UPLOADED' AND Upload_Source='FACEBOOK' ORDER BY leadsUploadId ASC LIMIT 0, $TotalLeadstoDistribute", true);
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
    $SenderEmail = "noreply@apnalead.com";
    $LeadAssignedPerosnFullName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId' AND UserStatus='1'", "UserFullName");
    $LeadAssignedPerosnEmailId = FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserId' AND UserStatus='1'", "UserEmailId");
    SENDCOMPANYMAILS($companyId, "NEW " . $TotalLeadstoDistribute . ' ' . " - FACEBOOK Leads Assigned To You ", "Hello " . $LeadAssignedPerosnFullName, $LeadAssignedPerosnEmailId, $SenderEmail, "We would like to inform you that a new <b>" . $TotalLeadstoDistribute . " Leads </b> has been Assigned to you by <b> FACEBOOK </b><br>Please log in to your CRM account to view and manage the details.");
}
