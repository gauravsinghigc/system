<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

$AllLeadsSQL = "SELECT * FROM leads ORDER BY leads_call_sub_status DESC";
$ProcessSQL = SET_SQL($AllLeadsSQL, true);
if ($ProcessSQL != null) {
    $SerialNo = SERIAL_NO;
    foreach ($ProcessSQL as $Records) {
        $SerialNo++;
        $Lead = "";
        $Lead .= "=>" . $SerialNo . "</b> " . $Records->leads_id . " -   ";
        $Lead .= "<b>Name:</b> " . $Records->leads_full_name . " -  ";
        $Lead .= "<b>Stage:</b> (" . $Records->leads_stages . ") " . FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages . "'", "config_leads_stage_name") . "-  ";
        $Lead .= "<b>SubStage:</b> (" . $Records->leads_sub_stages . ") " . FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Records->leads_sub_stages . "'", "config_call_sub_status_name") . "-  ";
        $Lead .= "<b>CallId:</b> " . $Records->leads_call_status . " -  ";
        $Lead .= "<b>CallSubId:</b> " . $Records->leads_call_sub_status . " -  ";
        if ($Records->leads_call_sub_status == 0) {
            SQL("UPDATE leads SET leads_stages='1' where leads_id='" . $Records->leads_id . "'");
        } else {
            SQL("UPDATE leads SET leads_stages='" . $Records->leads_call_status . "', leads_sub_stages='" . $Records->leads_call_sub_status . "' where leads_id='" . $Records->leads_id . "'");
        }
        echo $Lead . "<br>";
    }
}
