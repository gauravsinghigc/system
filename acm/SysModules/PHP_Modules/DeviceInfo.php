<?php

//More Requirements
$ip_address = IP_ADDRESS;
$device_type = DEVICE_TYPE;
date_default_timezone_set("Asia/Calcutta");
$date_time_c = date("Y-m-d h:m:s a");
$System_more_Info = $_SERVER['HTTP_USER_AGENT'];
$PAGE_LOCATION = GET_URL();
$SYSTEM_CONFIGURATIONS = "
    Date Time: $date_time_c
    Page_Location: $PAGE_LOCATION
    System Information : $System_more_Info";
define("SYSTEM_MORE_INFO", $System_more_Info);
define("SYSTEM_INFO", SECURE($SYSTEM_CONFIGURATIONS, "e"));
define("VALIDATOR_REQ", SECURE(hash('sha256', random_bytes(16)), "e"));
