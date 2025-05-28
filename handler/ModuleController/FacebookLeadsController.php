<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["RefreshLeads"])) {

    $LeadsCounted = 0;
    $NewLeads = 0;
    $DupliCateLeads = 0;

    // Define reusable field mappings outside the loop
    $fieldMappings = [
        'first_name' => ['first_name', 'fname', 'FirstName', 'f_name'],
        'middle_name' => ['middel_name', 'mname', 'MiddelName', 'm_name'],
        'last_name' => ['lname', 'LastName', 'last_name', 'l_name'],
        'full_name' => ['fullName', 'full_name', 'fname', 'f_name', 'FULL_NAME'],
        'phone_number' => ['phone_number', 'phonenumber', 'mobile_number', 'PHONE'],
        'email' => ['email_id', 'emailid', 'email', 'primary_emailid', 'primaryemail', 'EMAIL']
    ];

    if ($_POST["AdsId"] == "ALL") {
        $GetFacebookPages = SET_SQL("SELECT * FROM config_facebook_accounts where config_facebook_accounts__status='1' ORDER BY config_facebook_accounts_id ASC", true);
    } else {
        $config_facebook_accounts_id = $_POST["AdsId"];
        $GetFacebookPages = SET_SQL("SELECT * FROM config_facebook_accounts where config_facebook_accounts_id='$config_facebook_accounts_id' and config_facebook_accounts__status='1' ORDER BY config_facebook_accounts_id ASC", true);
    }


    // Set timezone to India
    date_default_timezone_set('Asia/Kolkata');

    if ($GetFacebookPages) {
        foreach ($GetFacebookPages as $Facebook) {

            //Compare Time
            $LastFetchTime = $Facebook->config_facebook_accounts_last_fetched_at;
            // Compare current time with last fetch time
            $CurrentDateTime = date('Y-m-d H:i');
            $currentTimestamp = strtotime($CurrentDateTime);
            $lastFetchTimestamp = strtotime($LastFetchTime);

            // If current time is greater than last fetch time + 10 minutes (600 seconds)
            if ($currentTimestamp >= ($lastFetchTimestamp + 600)) {

                $fb_access_token = $Facebook->config_facebook_accounts_access_token;
                $fb_adaccounts_id = $Facebook->config_facebook_accounts_ad_account_id;
                $fb_campaigns_id = $Facebook->config_facebook_accounts_campaigns_id;
                $fb_adsets_id = $Facebook->config_facebook_accounts_adsets_id;
                $fb_ads_id = $Facebook->config_facebook_accounts_ads_id;
                $fb_project_Id = $Facebook->config_facebook_accounts_projects_id;
                $config_facebook_accounts_id = $Facebook->config_facebook_accounts_id;
                $config_facebook_accounts_vendor_name = $Facebook->config_facebook_accounts_vendor_name;

                // Setup CURL request
                $ch = curl_init();
                $url = "https://graph.facebook.com/v19.0/me?fields=id%2Cname%2Cadaccounts%7Baccount_id%2Cname%2Caccount_status%2Ccampaigns%7Bid%2Cname%2Cstatus%2Ccreated_time%2Cstart_time%2Cadsets%7Bid%2Cname%2Ccreated_time%2Cstart_time%2Cstatus%2Cads%7Bid%2Cname%2Ccreated_time%2Cleads%7D%7D%7D%7D&access_token=$fb_access_token";
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resp = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo curl_error($ch);
                    curl_close($ch);
                    continue;
                }
                curl_close($ch);

                $decoded = json_decode($resp);
                if (isset($decoded->adaccounts->data)) {
                    foreach ($decoded->adaccounts->data as $adAccount) {
                        if ($adAccount->account_id != $fb_adaccounts_id) continue;

                        foreach ($adAccount->campaigns->data as $adsCampaign) {
                            if ($adsCampaign->id != $fb_campaigns_id) continue;

                            foreach ($adsCampaign->adsets->data as $adSet) {
                                if ($adSet->id != $fb_adsets_id) continue;

                                foreach ($adSet->ads->data as $ad) {
                                    if ($ad->id != $fb_ads_id) continue;

                                    // Check if leads exist for this ad
                                    if (isset($ad->leads->data) && is_array($ad->leads->data)) {
                                        $LeadsCounted++;

                                        foreach ($ad->leads->data as $lead) {
                                            $leadData = [
                                                "FirstName" => "",
                                                "MiddleName" => "",
                                                "LastName" => "",
                                                "FullName" => "",
                                                "PhoneNumber" => "",
                                                "EmailId" => ""
                                            ];

                                            // Map fields based on defined mappings
                                            foreach ($lead->field_data as $leadsFieldData) {
                                                foreach ($fieldMappings as $key => $mapping) {
                                                    if (in_array($leadsFieldData->name, $mapping)) {
                                                        $leadData[$key] = $leadsFieldData->values[0] ?? ""; // Assuming single value
                                                        break;
                                                    }
                                                }
                                            }

                                            // Process the lead
                                            $leadName = !empty($leadData['full_name']) ? $leadData['full_name'] :
                                                trim(($leadData['first_name'] ?? "") . " " . ($leadData['middle_name'] ?? "") . " " . ($leadData['last_name'] ?? ""));
                                            $phone = VALID_PHONE_NUMBER($leadData['phone_number'] ?? "");

                                            $leadExists = CHECK("SELECT leads_phone_number FROM leads WHERE leads_phone_number='$phone'");
                                            if (!$leadExists) {

                                                //source
                                                $SourcesId = FETCH("SELECT config_leads_source_id FROM config_leads_sources where config_leads_source_name like '%facebook%'", "config_leads_source_id");
                                                $FaceBookLeads = [
                                                    "leads_full_name" => $leadName,
                                                    "leads_email_id" => $leadData['email'] ?? "",  // Ensure the key exists
                                                    "leads_phone_number" => $phone,
                                                    "leads_source" => $SourcesId,
                                                    "leads_created_at" => CURRENT_DATE_TIME,
                                                    "leads_entry_type" => "FB_API",
                                                    "leads_created_by" => 1,
                                                    "leads_fetched_status" => "1",
                                                    "leads_other_sources_name" => "FB_ADS_API",
                                                    "leads_other_sources_ads_id" => $config_facebook_accounts_id,
                                                    "leads_type" => "LEAD",
                                                    "leads_assign_status" => "FB_API_FETCHED",
                                                    "leads_projects_id" => $fb_project_Id,
                                                    "leads_re_source" => $config_facebook_accounts_vendor_name,
                                                    "leads_stages" => 1,
                                                ];

                                                // Save lead and its fields in a single transaction
                                                if ($Response = INSERT("leads", $FaceBookLeads)) {

                                                    $NewLeads++;
                                                    $leads_id = FETCH("SELECT leads_id FROM leads where leads_phone_number='$phone' ORDER BY leads_id lIMIT 1", "leads_id");
                                                    if ($leads_id) {
                                                        foreach ($lead->field_data as $field) {
                                                            $leads_uploaded_things = [
                                                                "leads_upload_header_name" => $field->name,
                                                                "leads_uploaded_value" => $field->values[0] ?? "",
                                                                "leads_upload_main_id" => $leads_id,
                                                                "leads_uploded_at" => CURRENT_DATE_TIME,
                                                                "leads_uploaded_by" => $config_facebook_accounts_id
                                                            ];
                                                            INSERT("leads_uploaded_things", $leads_uploaded_things);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


                // Set the timezone to India (Asia/Kolkata)
                date_default_timezone_set('Asia/Kolkata');

                // Get current date and time in Indian timezone
                $CurrentDateTime = date("Y-m-d H:i");

                // Set the timezone to India (Asia/Kolkata)
                date_default_timezone_set('Asia/Kolkata');

                // Calculate time after adding 40 minutes
                $NextRefreshTime = date("Y-m-d H:i", strtotime($CurrentDateTime . ' +40 minutes'));

                //update next leads Refresh Time
                SQL("UPDATE config_facebook_accounts SET config_facebook_accounts_last_fetched_at='$NextRefreshTime'");
                RequestHandler($Response, [
                    "true" => "<b>$NewLeads</b> new leads added!",
                    "false" => "No New leads found!"
                ]);

                //Time Left 
            } else {

                $remainingSeconds = ($lastFetchTimestamp) - $currentTimestamp; // Time left in seconds

                RequestHandler(false, [
                    "true" => "",
                    "false" => "<b>" . floor($remainingSeconds / 60) . " Min</b> Left in Next Submission!"
                ]);
            }
        }
    }
}
