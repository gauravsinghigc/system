<?php

//initialize files
require_once "../../acm/SysFileAutoLoader.php";
require_once "../../acm/SystemReqHandler.php";
require_once "../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["SaveFbAdsConfigurations"])) {
    $config_facebook_accounts = [
        "config_facebook_accounts_name" => $_POST["config_facebook_accounts_name"],
        "config_facebook_accounts_access_token" => $_POST["config_facebook_accounts_access_token"],
        "config_facebook_accounts_ad_account_id" => $_POST["config_facebook_accounts_ad_account_id"],
        "config_facebook_accounts_campaigns_id" => $_POST["config_facebook_accounts_campaigns_id"],
        "config_facebook_accounts_adsets_id" => $_POST["config_facebook_accounts_adsets_id"],
        "config_facebook_accounts_ads_id" => $_POST["config_facebook_accounts_ads_id"],
        "config_facebook_accounts_projects_id" => $_POST["config_facebook_accounts_projects_id"],
        "config_facebook_accounts__status" => $_POST["config_facebook_accounts__status"],
        "config_facebook_accounts_added_by" => LOGIN_USER_ID,
        "config_facebook_accounts_added_at" => CURRENT_DATE_TIME,
        "config_facebook_accounts_auto_distributions" => $_POST["config_facebook_accounts_auto_distributions"],
        "config_facebook_accounts_last_fetched_at" => "null",
        "config_facebook_accounts_vendor_name" => $_POST["config_facebook_accounts_vendor_name"]
    ];
    $Response = INSERT("config_facebook_accounts", $config_facebook_accounts);

    //request handler
    RequestHandler($Response, [
        "true" => "Facebook Ads API is added!",
        "false" => "Unable to Add Facebook ADS API at the moment!",
    ]);

    //update facebook leads API
} elseif (isset($_POST["UpdateFbAdsConfigurations"])) {
    $config_facebook_accounts_id = SECURE($_POST["config_facebook_accounts_id"], "d");

    $config_facebook_accounts = [
        "config_facebook_accounts_name" => $_POST["config_facebook_accounts_name"],
        "config_facebook_accounts_access_token" => $_POST["config_facebook_accounts_access_token"],
        "config_facebook_accounts_ad_account_id" => $_POST["config_facebook_accounts_ad_account_id"],
        "config_facebook_accounts_campaigns_id" => $_POST["config_facebook_accounts_campaigns_id"],
        "config_facebook_accounts_adsets_id" => $_POST["config_facebook_accounts_adsets_id"],
        "config_facebook_accounts_ads_id" => $_POST["config_facebook_accounts_ads_id"],
        "config_facebook_accounts_projects_id" => $_POST["config_facebook_accounts_projects_id"],
        "config_facebook_accounts__status" => $_POST["config_facebook_accounts__status"],
        "config_facebook_accounts_added_at" => CURRENT_DATE_TIME,
        "config_facebook_accounts_auto_distributions" => $_POST["config_facebook_accounts_auto_distributions"],
        "config_facebook_accounts_vendor_name" => $_POST["config_facebook_accounts_vendor_name"]
    ];
    $Response = UPDATE("config_facebook_accounts", $config_facebook_accounts, "config_facebook_accounts_id='$config_facebook_accounts_id'");

    //request handler
    RequestHandler($Response, [
        "true" => "Facebook Ads API is Updated!",
        "false" => "Unable to Update Facebook ADS API at the moment!",
    ]);
}
