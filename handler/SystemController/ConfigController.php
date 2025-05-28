<?php
//initialize files
require_once "../../acm/SysFileAutoLoader.php";
require_once "../../acm/SystemReqHandler.php";
require_once "../../handler/AuthController/AuthAccessController.php";

//update primary details
if (isset($_POST['UpdatePrimaryConfigurations'])) {
  $APP_NAME = $_POST['APP_NAME'];
  $TAGLINE = $_POST['TAGLINE'];
  $PRIMARY_PHONE = $_POST['PRIMARY_PHONE'];
  $PRIMARY_EMAIL = $_POST['PRIMARY_EMAIL'];
  $SHORT_DESCRIPTION = SECURE($_POST['SHORT_DESCRIPTION'], "e");
  $PRIMARY_ADDRESS = SECURE($_POST['PRIMARY_ADDRESS'], "e");
  $OWNER_NAME = $_POST['OWNER_NAME'];
  $SUPPORT_MAIL = $_POST['SUPPORT_MAIL'];
  $ENQUIRY_MAIL = $_POST['ENQUIRY_MAIL'];

  $Update = SQL("UPDATE configurations SET configurationvalue='$APP_NAME' where configurationname='APP_NAME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$TAGLINE' where configurationname='TAGLINE'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$PRIMARY_GST' where configurationname='GST_NO'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$PRIMARY_PHONE' where configurationname='PRIMARY_PHONE'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$PRIMARY_EMAIL' where configurationname='PRIMARY_EMAIL'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$SHORT_DESCRIPTION' where configurationname='SHORT_DESCRIPTION'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$PRIMARY_ADDRESS' where configurationname='PRIMARY_ADDRESS'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$OWNER_NAME' where configurationname='OWNER_NAME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$SUPPORT_MAIL' where configurationname='SUPPORT_MAIL'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$ENQUIRY_MAIL' where configurationname='ENQUIRY_MAIL'");

  GENERATE_APP_LOGS("C_PROFILE_UPDATED", "Company Profile Updated", "UPDATE");
  RESPONSE($Update, "Company Profile Updated!", "Unable to Update Company profile!");

  //Update Mail Features
} elseif (isset($_POST['UpdateMailConfigs'])) {
  $CONTROL_MAILS = $_POST['CONTROL_MAILS'];
  $SUPPORT_MAIL = $_POST['SUPPORT_MAIL'];
  $ENQUIRY_MAIL = $_POST['ENQUIRY_MAIL'];

  $Update = SQL("UPDATE configurations SET configurationvalue='$CONTROL_MAILS' where configurationname='CONTROL_MAILS'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$SUPPORT_MAIL' where configurationname='SUPPORT_MAIL'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$ENQUIRY_MAIL' where configurationname='ENQUIRY_MAIL'");

  GENERATE_APP_LOGS("MAIL_CONFIGS", "Mail Configurations Updated & Status: $CONTROL_MAILS", "MAIL_SETTINGS");
  RESPONSE($Update, "Mailing Configurations are Updated Successfully!", "Unable to update Mailing configurations");

  //Update Features
} elseif (isset($_POST['UpdateFeatures'])) {
  $CONTROL_WORK_ENV = $_POST['CONTROL_WORK_ENV'];
  $CONTROL_NOTIFICATION = $_POST['CONTROL_NOTIFICATION'];
  $CONTROL_MSG_DISPLAY_TIME = $_POST['CONTROL_MSG_DISPLAY_TIME'];
  $CONTROL_APP_LOGS = $_POST['CONTROL_APP_LOGS'];
  $CONTROL_NOTIFICATION_SOUND = $_POST['CONTROL_NOTIFICATION_SOUND'];
  $DEFAULT_RECORD_LISTING = $_POST['DEFAULT_RECORD_LISTING'];
  $SERVER_DOWN_CONTROL = $_POST['SERVER_DOWN_CONTROL'];
  $INTERNAL_CHAT_APP = $_POST['INTERNAL_CHAT_APP'];

  $Update = SQL("UPDATE configurations SET configurationvalue='$CONTROL_WORK_ENV' where configurationname='CONTROL_WORK_ENV'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$CONTROL_NOTIFICATION' where configurationname='CONTROL_NOTIFICATION'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$CONTROL_MSG_DISPLAY_TIME' where configurationname='CONTROL_MSG_DISPLAY_TIME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$CONTROL_APP_LOGS' where configurationname='CONTROL_APP_LOGS'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$CONTROL_NOTIFICATION_SOUND' where configurationname='CONTROL_NOTIFICATION_SOUND'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$DEFAULT_RECORD_LISTING' where configurationname='DEFAULT_RECORD_LISTING'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$SERVER_DOWN_CONTROL' where configurationname='SERVER_DOWN_CONTROL'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$INTERNAL_CHAT_APP' where configurationname='INTERNAL_CHAT_APP'");
  GENERATE_APP_LOGS("FEATURE_UPDATED", "WORK_ENV: $CONTROL_WORK_ENV, ALERT: $CONTROL_NOTIFICATION, ALERT_TIME: $CONTROL_MSG_DISPLAY_TIME, LOGS: $CONTROL_APP_LOGS", "FEATURE_UPDATED");
  RESPONSE($Update, "Selected features are Updated successfully!", "Unable to Update selected features!");

  //update logo 
} elseif (isset($_POST['UploadSystemLogo'])) {
  $CurrentFile = $_POST['UploadSystemLogo'];
  $APP_LOGO = UPLOAD_FILES("../../storage/logo/", $CurrentFile, APP_NAME . "", "APP_LOGO");
  $Update = SQL("UPDATE configurations SET configurationvalue='$APP_LOGO' where configurationname='APP_LOGO'");
  GENERATE_APP_LOGS("LOGO_CHANGED", "$APP_LOGO", "LOGO_UPDATED");
  RESPONSE($Update, "Logo Updated Successfully!", "Unable to Update Logo!");

  //update Menu Display Options
} elseif (isset($_POST["UpdateMenuDisplayOptions"])) {
  $TYPE_OF_CLOSING = $_POST['TYPE_OF_CLOSING'];
  $TYPE_OF_RECORDS = $_POST['TYPE_OF_RECORDS'];
  $LISTING_TYPES = $_POST['LISTING_TYPES'];
  $TYPES_OF_USERS = $_POST['TYPES_OF_USERS'];

  $Update = SQL("UPDATE configurations SET configurationvalue='$TYPE_OF_CLOSING' where configurationname='TYPE_OF_CLOSING'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$TYPE_OF_RECORDS' where configurationname='TYPE_OF_RECORDS'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$LISTING_TYPES' where configurationname='LISTING_TYPES'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$TYPES_OF_USERS' where configurationname='TYPES_OF_USERS'");

  //generate logs and send reponse
  GENERATE_APP_LOGS("MENU_DISPLAY_UPDATED", "TYPE_OF_CLOSING: $TYPE_OF_CLOSING, TYPE_OF_RECORDS: $TYPE_OF_RECORDS, LISTING_TYPES: $LISTING_TYPES, TYPES_OF_USERS: $TYPES_OF_USERS", "MENU_DISPLAY_UPDATED");
  RESPONSE($Update, "Menu Display Options Updated Successfully!", "Unable to Update Menu Display Options!");

  //update HR settings
} elseif (isset($_POST["UpdateHRSettings"])) {
  $OFFICE_START_TIME = $_POST["OFFICE_START_TIME"];
  $OFFICE_END_TIME = $_POST["OFFICE_END_TIME"];
  $LUNCH_TIME = $_POST["LUNCH_TIME"];
  $OFFICE_LUNCH_TIME = $_POST["OFFICE_LUNCH_TIME"];
  $OFFICE_LUNCH_END_TIME = $_POST["OFFICE_LUNCH_END_TIME"];
  $WEEKLY_OFF_DAY = $_POST["WEEKLY_OFF_DAY"];

  $Update = SQL("UPDATE configurations SET configurationvalue='$OFFICE_START_TIME' where configurationname='OFFICE_START_TIME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$OFFICE_END_TIME' where configurationname='OFFICE_END_TIME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$LUNCH_TIME' where configurationname='LUNCH_TIME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$OFFICE_LUNCH_TIME' where configurationname='OFFICE_LUNCH_TIME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$OFFICE_LUNCH_END_TIME' where configurationname='OFFICE_LUNCH_END_TIME'");
  $Update = SQL("UPDATE configurations SET configurationvalue='$WEEKLY_OFF_DAY' where configurationname='WEEKLY_OFF_DAY'");

  //generate logs and send response
  GENERATE_APP_LOGS("HR_SETTINGS_UPDATED", "OFFICE_START_TIME: $OFFICE_START_TIME, OFFICE_END_TIME: $OFFICE_END_TIME, LUNCH_TIME: $LUNCH_TIME, OFFICE_LUNCH_TIME: $OFFICE_LUNCH_TIME, OFFICE_LUNCH_END_TIME: $OFFICE_LUNCH_END_TIME, WEEKLY_OFF_DAY: $WEEKLY_OFF_DAY", "HR_SETTINGS_UPDATED");
  RESPONSE($Update, "HR Settings Updated Successfully!", "Unable to Update HR Settings!");
}
