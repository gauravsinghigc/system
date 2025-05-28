<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["RemoveFacebookAds"])) {
 $Response = DELETE_FROM("config_facebook_accounts", "config_facebook_accounts_id='" . SECURE($_POST["config_facebook_accounts_id"], "d") . "'");

 RequestHandler($Response, [
  "true" => "Facebook Api Removed Successfully!",
  "false" => "Unable to Remove Facebook API at the moment!"
 ]);
}
