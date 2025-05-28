<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

//update profile image 
if (isset($_POST['updateprofileimage'])) {
    $UserId  = $_POST['updateprofileimage'];
    $UserProfileImage = UPLOAD_FILES("../../storage/users/$UserId/img", "null", "Profile_Photo_" . "_UID_" . $UserId, "UserProfileImage");
    $Update = SQL("UPDATE users SET UserProfileImage='$UserProfileImage' where UserId='$UserId'");
    RESPONSE($Update, "Profile Image Updated!", "Unable to update profile image!");

    //remove employee
} else if (isset($_GET['remove_team_member'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_team_member = SECURE($_GET['remove_team_member'], "d");

    if ($remove_team_member == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $delete = DELETE_FROM("users", "UserId='$control_id'");
        $delete = DELETE_FROM("user_addresses", "UserAddressUserId='$control_id'");
        $delete = DELETE_FROM("user_bank_details", "UserMainId='$control_id'");
        $delete = DELETE_FROM("user_documents", "UserMainId='$control_id'");
        $delete = DELETE_FROM("user_employment_details", "UserMainUserId='$control_id'");
    } else {
        $delete = false;
    }

    RESPONSE($delete, "Team member is removed successfully!", "Unable to remove team member!");

    //update primary data
} elseif (isset($_POST['UpdatePrimaryData'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    $primarydata = array(
        "UserSalutation" => $_POST['UserSalutation'],
        "UserFullName" => $_POST['UserFullName'],
        "UserPhoneNumber" => $_POST['UserPhoneNumber'],
        "UserUpdatedAt" => CURRENT_DATE_TIME,
        "UserNotes" => SECURE($_POST["UserNotes"], "e"),
        "UserDateOfBirth" => $_POST['UserDateOfBirth'],
    );

    $Update = UPDATE("users", $primarydata, "UserId='$UserId'");

    //update address 
    $Address = array(
        "UserAddressUserId" => $UserId,
        "UserStreetAddress" => $_POST["UserStreetAddress"],
        "UserLocality" => $_POST['UserLocality'],
        "UserCity" => $_POST['UserCity'],
        "UserState" => $_POST['UserState'],
        "UserCountry" => $_POST['UserCountry'],
        "UserPincode" => $_POST['UserPincode'],
    );

    $CheckAddress = CHECK("SELECT UserAddressUserId FROM user_addresses where UserAddressUserId='$UserId'");
    if ($CheckAddress == null) {
        $Update = INSERT("user_addresses", $Address);
    } else {
        $Update = UPDATE("user_addresses", $Address, "UserAddressUserId='$UserId'");
    }

    //save social media informations
    if (isset($_POST["FACEBOOK"]) != null) {
        if ($_POST["FACEBOOK"] != null) {
            $users_urls = [
                "user_url_main_user_id" => $UserId,
                "user_url_name" => "FACEBOOK",
                "user_url_icon" => "fa fa-facebook",
                "user_url_link" => $_POST["FACEBOOK"],
                "user_url_created_at" => CURRENT_DATE_TIME,
                "user_url_updated_at" => CURRENT_DATE_TIME,
                "user_url_created_by" => LOGIN_USER_ID,
                "user_url_updated_by" => LOGIN_USER_ID,
            ];
            $Check = CHECK("SELECT * FROM users_urls where user_url_main_user_id='$UserId' and user_url_name='FACEBOOK'");
            if ($Check == null) {
                $Update = INSERT("users_urls", $users_urls);
            } else {
                $Update = UPDATE("users_urls", $users_urls, "user_url_main_user_id='$UserId' and user_url_name='FACEBOOK'");
            }
        }
    }

    //INSTAGRAM
    if (isset($_POST["INSTAGRAM"]) != null) {
        if ($_POST["INSTAGRAM"] != null) {
            $users_urls = [
                "user_url_main_user_id" => $UserId,
                "user_url_name" => "INSTAGRAM",
                "user_url_icon" => "fa fa-instagram",
                "user_url_link" => $_POST["INSTAGRAM"],
                "user_url_created_at" => CURRENT_DATE_TIME,
                "user_url_updated_at" => CURRENT_DATE_TIME,
                "user_url_created_by" => LOGIN_USER_ID,
                "user_url_updated_by" => LOGIN_USER_ID,
            ];
            $Check = CHECK("SELECT * FROM users_urls where user_url_main_user_id='$UserId' and user_url_name='INSTAGRAM'");
            if ($Check == null) {
                $Update = INSERT("users_urls", $users_urls);
            } else {
                $Update = UPDATE("users_urls", $users_urls, "user_url_main_user_id='$UserId' and user_url_name='INSTAGRAM'");
            }
        }
    }
    //LINKEDIN
    if (isset($_POST["LINKEDIN"]) != null) {
        if ($_POST["LINKEDIN"] != null) {
            $users_urls = [
                "user_url_main_user_id" => $UserId,
                "user_url_name" => "LINKEDIN",
                "user_url_icon" => "fa fa-linkedin",
                "user_url_link" => $_POST["LINKEDIN"],
                "user_url_created_at" => CURRENT_DATE_TIME,
                "user_url_updated_at" => CURRENT_DATE_TIME,
                "user_url_created_by" => LOGIN_USER_ID,
                "user_url_updated_by" => LOGIN_USER_ID,
            ];
            $Check = CHECK("SELECT * FROM users_urls where user_url_main_user_id='$UserId' and user_url_name='LINKEDIN'");
            if ($Check == null) {
                $Update = INSERT("users_urls", $users_urls);
            } else {
                $Update = UPDATE("users_urls", $users_urls, "user_url_main_user_id='$UserId' and user_url_name='LINKEDIN'");
            }
        }
    }

    //OTHERS
    if (isset($_POST["OTHERS"]) != null) {
        if ($_POST["OTHERS"] != null) {
            $users_urls = [
                "user_url_main_user_id" => $UserId,
                "user_url_name" => "OTHERS",
                "user_url_icon" => "fa fa-globe",
                "user_url_link" => $_POST["OTHERS"],
                "user_url_created_at" => CURRENT_DATE_TIME,
                "user_url_updated_at" => CURRENT_DATE_TIME,
                "user_url_created_by" => LOGIN_USER_ID,
                "user_url_updated_by" => LOGIN_USER_ID,
            ];
            $Check = CHECK("SELECT * FROM users_urls where user_url_main_user_id='$UserId' and user_url_name='OTHERS'");
            if ($Check == null) {
                $Update = INSERT("users_urls", $users_urls);
            } else {
                $Update = UPDATE("users_urls", $users_urls, "user_url_main_user_id='$UserId' and user_url_name='OTHERS'");
            }
        }
    }

    RESPONSE($Update, $_POST['UserFullName'] . " profile is updated successfully!", "Unable to update profile at the moment!");

    //update address
} elseif (isset($_POST['UpdateAddress'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    $Address = array(
        "UserAddressUserId" => $UserId,
        "UserStreetAddress" => POST("UserStreetAddress"),
        "UserLocality" => $_POST['UserLocality'],
        "UserCity" => $_POST['UserCity'],
        "UserState" => $_POST['UserState'],
        "UserCountry" => $_POST['UserCountry'],
        "UserPincode" => $_POST['UserPincode'],
        "UserAddressType" => $_POST['UserAddressType'],
        "UserAddressContactPerson" => $_POST['UserAddressContactPerson'],
    );

    $CheckAddress = CHECK("SELECT * FROM user_addresses where UserAddressUserId='$UserId'");
    if ($CheckAddress == null) {
        $Update = INSERT("user_addresses", $Address);
    } else {
        $Update = UPDATE("user_addresses", $Address, "UserAddressUserId='$UserId'");
    }
    RESPONSE($Update, "Address details are updated successfully!", "Unable to update address details at the moment!");

    //Request for account verifications
} elseif (isset($_POST["RequestForAccountVerification"])) {
    $UserId = SECURE($_POST["UserId"], "d");
    $UserEmailId = FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserId'", "UserEmailId");
    $UserFullName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId'", "UserFullName");
    $UserPhoneNumber = FETCH("SELECT UserPhoneNumber FROM users WHERE UserId='$UserId'", "UserPhoneNumber");

    //Generate verification 6 digit code need to be fill at next screen.
    $VerificationCode = rand(111111, 999999);
    $user_verification_status = array(
        "UserVerificationCode" => $VerificationCode,
        "UserVerificationStatus" => "0",
        "user_main_id" => $UserId,
        "UserVerificationCodeCreatedAt" => CURRENT_DATE_TIME,
        "UserVerificationCodeValidity" => DATE("Y-m-d H:i:s", strtotime("+2 hours")),
    );
    $UpdateVerification = INSERT("user_verification_status", $user_verification_status);

    //Generate Sessions for Verification code and verification status
    $_SESSION['UserVerificationCode'] = $VerificationCode;
    $_SESSION['UserVerificationStatus'] = 0;

    //Send Mail to User
    $status =  SENDMAILS("Account Verification Code", "Dear " . $UserFullName . ",", $UserEmailId, "<br>
                            <p>
                            Your Account Verification Code is: <b>" . $VerificationCode . "</b> valid for next 2 hr only.<br>
                            <br>
                            <b>Note:</b> Please do not share this code with anyone.<br>
                            </p>");

    //Modify return url
    $access_url = $access_url . "&step=password&verification=enabled";
    RESPONSE($status, "Verification Code sent to " . $UserEmailId . " successfully!", "Unable to send verification code at the moment!");

    //verify account
} elseif (isset($_POST["VerifyUserAccountViaProfile"])) {
    $UserId = SECURE($_POST["UserId"], "d");
    $UserVerificationCode_SENT = $_POST['UserVerificationCode'];

    //sessional data
    $UserVerificationCode = $_SESSION['UserVerificationCode'];
    $UserVerificationStatus = $_SESSION['UserVerificationStatus'];

    //check if code is correct
    if ($UserVerificationCode == $UserVerificationCode_SENT && $UserVerificationStatus == 0) {
        $UpdateVerificationStatus = SQL("UPDATE user_verification_status SET UserVerificationStatus='1' WHERE UserVerificationCode='$UserVerificationCode_SENT' AND user_main_id='$UserId'");

        //Disable code and verification session or unset
        unset($_SESSION['UserVerificationCode']);
        unset($_SESSION['UserVerificationStatus']);

        //generate session for password update
        $_SESSION['CHANGE_PASSWORD_REQUEST'] = true;
        $_SESSION['CHANGE_PASSWORD_USER_ID'] = $UserId;

        RESPONSE($UpdateVerificationStatus, "Account verified successfully!", "Unable to verify account at the moment!");
    } else {
        RESPONSE(0, "Verification Code is incorrect or expired!", "Verification Code is incorrect or expired!");
    }

    //change password via profile verification
} elseif (isset($_POST["ChangeUserPassword"])) {
    $UserId = $_SESSION['CHANGE_PASSWORD_USER_ID'];

    $NewPassword = $_POST["NewPassword"];
    $ConfirmNewPassword = $_POST["ConfirmNewPassword"];

    //check if password is same
    if ($NewPassword == $ConfirmNewPassword) {
        $data = array(
            "UserPassword" => $NewPassword,
        );
        $Update = UPDATE("users", $data, "UserId='$UserId'");

        //unset session
        unset($_SESSION['CHANGE_PASSWORD_REQUEST']);
        unset($_SESSION['CHANGE_PASSWORD_USER_ID']);

        //update user via mail also for this password change activity
        $UserEmailId = FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserId'", "UserEmailId");
        $UserFullName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId'", "UserFullName");
        $status =  SENDMAILS(
            "Password Updated Successfully",
            "Dear " . $UserFullName . ",",
            $UserEmailId,
            "<br>
            <p>
            Your Password has been updated successfully.<br>
            <br>
            <b>Note:</b> Please remember to use this new password for your next login.<br>
            </p>"
        );

        //modify access url
        RESPONSE($Update, "Password is updated successfully!", "Unable to update password at the moment!");
    } else {
        RESPONSE(0, "Password is not same!", "Password is not same!");
    }

    //save new user records
} elseif (isset($_POST["SaveNewUserRecords"])) {
    $users = [
        "UserSalutation" => $_POST["UserSalutation"],
        "UserFullName" => $_POST["UserFullName"],
        "UserPhoneNumber" => $_POST["UserPhoneNumber"],
        "UserEmailId" => Lowercase($_POST["UserEmailId"]),
        "UserPassword" => $_POST["UserPassword"],
        "UserCreatedAt" => CURRENT_DATE_TIME,
        "UserUpdatedAt" => CURRENT_DATE_TIME,
        "UserStatus" => $_POST["UserStatus"],
        "UserNotes" => SECURE($_POST["UserNotes"], "e"),
        "UserCompanyName" => $_POST["UserCompanyName"],
        "UserDesignation" => $_POST["UserDesignation"],
        "UserType" => $_POST["UserType"],
        "UserDateOfBirth" => $_POST["UserDateOfBirth"],
        "UserReportingManager" => $_POST["UserReportingManager"]
    ];

    $Response = INSERT("users", $users);
    $UserId = FETCH("SELECT UserId from users ORDER BY UserId DESC LIMIT 1", "UserId");
    $UserProfileImage = UPLOAD_FILES("../../storage/users/$UserId/img", "", "ProfileImage", "UserProfileImage");
    $UpdateProfileImage = UPDATE("users", ["UserProfileImage" => $UserProfileImage], "UserId='$UserId'");

    //save address details
    $user_addresses = [
        "UserAddressUserId" => $UserId,
        "UserStreetAddress" => $_POST["UserStreetAddress"],
        "UserLocality" => $_POST["UserLocality"],
        "UserCity" => $_POST["UserCity"],
        "UserState" => $_POST["UserState"],
        "UserCountry" => $_POST["UserCountry"],
        "UserPincode" => $_POST["UserPincode"]
    ];
    $Response = INSERT("user_addresses", $user_addresses);

    //request handler
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["UserFullName"] . "</b> account is created successfull!",
        "false" => "Unable to create account"
    ]);

    //Update Primary profile
} elseif (isset($_POST["UpdatePrimaryProfile"])) {
    $UserId = SECURE($_POST["UserId"], "d");

    $users = [
        "UserSalutation" => $_POST["UserSalutation"],
        "UserFullName" => $_POST["UserFullName"],
        "UserPhoneNumber" => $_POST["UserPhoneNumber"],
        "UserEmailId" => Lowercase($_POST["UserEmailId"]),
        "UserCreatedAt" => CURRENT_DATE_TIME,
        "UserNotes" => SECURE($_POST["UserNotes"], "e"),
        "UserCompanyName" => $_POST["UserCompanyName"],
        "UserDesignation" => $_POST["UserDesignation"],
        "UserDateOfBirth" => $_POST["UserDateOfBirth"],
        "UserReportingManager" => $_POST["UserReportingManager"]
    ];

    $Response = UPDATE("users", $users, "UserId='$UserId'");
    $UserProfileImage = UPLOAD_FILES("../../storage/users/$UserId/img", "", "ProfileImage", "UserProfileImage");

    //check file is uploaded or not
    if ($UserProfileImage != "") {
        $UpdateProfileImage = UPDATE("users", ["UserProfileImage" => $UserProfileImage], "UserId='$UserId'");
    }

    //request handler
    RequestHandler($Response, [
        "true" => "<b>" . $_POST["UserFullName"] . "</b> profile is updated successfully!",
        "false" => "Unable to update profile"
    ]);

    //update user addresses
} elseif (isset($_POST["UpdateUserAddresses"])) {
    $UserAddressId = SECURE($_POST["UserAddressId"], "d");

    $user_addresses = [
        "UserStreetAddress" => $_POST["UserStreetAddress"],
        "UserLocality" => $_POST["UserLocality"],
        "UserCity" => $_POST["UserCity"],
        "UserState" => $_POST["UserState"],
        "UserCountry" => $_POST["UserCountry"],
        "UserPincode" => $_POST["UserPincode"]
    ];

    $Response = UPDATE("users", $user_addresses, "UserAddressId='$UserAddressId'");

    //request handler
    RequestHandler($Response, [
        "true" => "User address is updated successfully!",
        "false" => "Unable to update user address"
    ]);

    //update login security
} elseif (isset($_POST["UpdateSecurityForAppUsers"])) {
    $ForUserId = SECURE($_POST["ForUserId"], "d");
    $NewPassword = $_POST["NewPassword"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $CurrentPassword = $_POST["CurrentPassword"];

    if ($ConfirmPassword == $NewPassword && $NewPassword != null && $NewPassword != "") {
        if ($NewPassword == null || $NewPassword == "" || $NewPassword == " ") {
            $users = [
                "UserStatus" => $_POST["UserStatus"],
                "UserType" => $_POST["UserType"],
                "UserUpdatedAt" => CURRENT_DATE_TIME,
            ];
            $Response = UPDATE("users", $users, "UserId='$ForUserId'");
        } else {
            $users = [
                "UserPassword" => $_POST["NewPassword"],
                "UserStatus" => $_POST["UserStatus"],
                "UserType" => $_POST["UserType"],
                "UserUpdatedAt" => CURRENT_DATE_TIME,
            ];
            $Response = UPDATE("users", $users, "UserId='$ForUserId'");
        }
    } else {
       $users = [
                "UserStatus" => $_POST["UserStatus"],
                "UserType" => $_POST["UserType"],
                "UserUpdatedAt" => CURRENT_DATE_TIME,
            ];
            $Response = UPDATE("users", $users, "UserId='$ForUserId'");
    }

    //request handler
    RequestHandler($Response, [
        "true" => "Security settings are updated successfully!",
        "false" => "Unable to update security settings"
    ]);

    //update user status
} elseif (isset($_POST["UpdateUserStatus"])) {
    $UserId = SECURE($_POST["UserId"], "d");
    $UserStatus = $_POST["UserStatus"];

    if ($UserStatus == "true") {
        $UserStatus = 1;
    } else {
        $UserStatus = 0;
    }
    $Response = UPDATE("users", ["UserStatus" => $UserStatus], "UserId='$UserId'");
    $UserFullName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId'", "UserFullName");

    //request handler
    RequestHandler($Response, [
        "true" => "<b>" . $UserFullName . "</b> account is " . ($UserStatus == 1 ? "activated" : "deactivated") . " successfully!",
        "false" => "Unable to update user status"
    ]);


//remove user
} elseif (isset($_POST["RemoveUserRecords"])) {
    $UserId = SECURE($_POST["UserId"], "d");

    $Response = DELETE_FROM("users", "UserId='$UserId'");
    $Response = DELETE_FROM("leads_assignees", "leads_assigned_to='$UserId'");
    $Response = DELETE_FROM("users_urls", "user_url_main_user_id='$UserId'");
    $Response = DELETE_FROM("user_addresses", "UserAddressUserId='$UserId'");
    $Response = DELETE_FROM("user_password_change_requests", "UserIdForPasswordChange='$UserId'");
    $Response = DELETE_FROM("user_verification_status", "user_main_id='$UserId'");

    RequestHandler($Response, [
        "true" => "User Record Removed Completely!",
        "false" => "Unable to Remove User Record at the moment!"
    ]);
}
