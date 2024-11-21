<?php
//initialize files
require "../../acm/SysFileAutoLoader.php";
require "../../acm/SystemReqHandler.php";

//start activity here
//login request

if (isset($_POST['LoginRequest'])) {
    $UserPassword = SECURE($_POST['UserPassword'], "e");
    $SubmittedPassword = $_POST['UserPassword'];
    $UserEmailId = $_POST['UserEmailId'];
    $CheckUsername = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId' and UserPassword='$UserPassword'");

    //get user details
    if ($CheckUsername == true) {
        $FetchUsersSql = "SELECT * FROM users where UserEmailId='$UserEmailId' and UserStatus='1'";
        $UserId = FETCH($FetchUsersSql, 'UserId');
        $UserName = FETCH($FetchUsersSql, "UserFullName");
        $UserStatus = FETCH($FetchUsersSql, "UserStatus");

        if ($UserStatus != "1") {
            LOCATION("warning", "You are not allowed to access the Application, account is restricted by the administrator! Please contact the administrator for more information!", APP_URL . "");
        } else {
            $_SESSION['LOGIN_USER_ID'] = $UserId;

            //send email to user about this login activity
            SENDMAILS(
                "New device login success!",
                "Hey User, ",
                $UserEmailId,
                "New device login request received! <br><br>login details are<br>" . "
                Email-Id: $UserEmailId" . "<br>
                Password: $SubmittedPassword" . "<br>
                Device Details: " . SYSTEM_MORE_INFO . "<br><br><br>
                <span>If login activity is not performed by you then please change password and check security details.</span>"
            );

            //response
            LOCATION("success", "Welcome $UserName, Login Successful!", DOMAIN . "/app");
        }
        //developer login
    } else {
        if ($UserEmailId == "dev@navix.in" && $UserPassword == AdminstratorPassword) {
            $_SESSION['LOGIN_USER_ID'] = 1;

            //response
            LOCATION("success", "Welcome " . $FetchUsers['UserFullName'] . ", Login Successful!", DOMAIN . "/app/index.php");

            //failed login 
        } else {
            //send email to user about this failed login activity
            SENDMAILS(
                "New device login failed!",
                "Hey User, ",
                $UserEmailId,
                "New device login is failed! <br><br>login details are<br>" . "
                Email-Id: $UserEmailId" . "<br>
                Password: $SubmittedPassword" . "<br>
                Device Details: " . SYSTEM_MORE_INFO . "<br><br><br>
                <span>If login activity is not performed by you then please change password and check security details.</span>"
            );

            //response
            LOCATION("warning", "Please check your Email-Id and Password. They are incorrect, Please try again with valid Email-ID and Password!", "$access_url");
        }
    }

    //update profile details
} elseif (isset($_POST['UpdateProfile'])) {
    $UserId = $_SESSION['LOGIN_USER_ID'];
    $UserName = $_POST['UserName'];
    $UserPhone = $_POST['UserPhone'];
    $UserEmailId = $_POST['UserEmailId'];
    $UserUpdatedAt = date("Y-m-d");

    $ErrorMsg = "Unable to Update Profile";
    //check phone number exisits or not
    $CheckPhoneNumber = CHECK("SELECT UserPhoneNumber FROM users where UserPhoneNumber='$UserPhoneNumber' and UserId!='$UserId'");
    if ($CheckPhoneNumber == null) {
        $Update = UPDATE_SQL("UPDATE users SET UserUpdatedAt='$UserUpdatedAt', UserFullName='$UserName', UserPhoneNumber='$UserPhone' where UserId='" . $UserId . "' ");
        $ErrorMsg = "Unable to Update Profile Phone Number";
    } else {
        $Update = false;
        $ErrorMsg = "Phone no: <b>$UserPhone</b> already exisits";
    }

    //check for emailid
    $CheckifitisEmailID = CHECK("SELECT UserEmailId FROM users where UserEmailId='$UserEmailId' and UserId!='$UserId'");
    if ($CheckifitisEmailID == null) {
        $Update = UPDATE_SQL("UPDATE users SET UserUpdatedAt='$UserUpdatedAt', UserFullName='$UserName', UserEmailId='$UserEmailId' where UserId='" . $UserId . "' ");
        $ErrorMsg = "Unable to Update Profile email-id";
    } else {
        $Update = false;
        $ErrorMsg = "Email-Id: <b>$UserEmailId</b> already exisits";
    }
    RESPONSE($Update, "Profile Updated!", $ErrorMsg);

    //update password 
} elseif (isset($_POST['UpdatePassword'])) {
    $UserPassword = $_POST['UserPassword'];
    $UserPassword_2 = $_POST['UserPassword_2'];
    if ($UserPassword != $UserPassword_2) {
        LOCATION("warning", "Unable to Update password!", "$access_url");
    } else {
        $update = UPDATE_SQL("UPDATE users SET UserPassword='$UserPassword' where UserId='" . $_SESSION['LOGIN_USER_ID'] . "'");
        RESPONSE($update, "Password Updated Successfully!", "Unable to Update Password!");
    }

    //recover account 
} elseif (isset($_POST['SearchAccountForPasswordReset'])) {
    $UserEmailId = $_POST['UserEmailId'];
    $UserExits = CHECK("SELECT UserEmailId FROM users where UserEmailId='$UserEmailId'");
    if ($UserExits != null) {
        $PasswordResetRequestAuthToken = rand(111111, 999999) . "- Date - " . date("Y-m-d h:m:s a") . " For" . APP_NAME;
        $_SESSION['CREATED_OTP'] = rand(11111, 999999);
        $_SESSION['REQUESTED_EMAIL'] = $UserEmailId;

        //create Password reset Token with expire limit
        $UserIdForPasswordChange = FETCH("SELECT * from users where UserEmailId='$UserEmailId'", "UserId");
        $PasswordChangeToken = SECURE($PasswordResetRequestAuthToken, "e");
        $PasswordChangeTokenExpireTime = date('d-m-Y H:i', strtotime("+10 min"));
        $PasswordChangeDeviceDetails = SECURE(SYSTEM_INFO, "e");
        $PasswordChangeRequestStatus = "Active";

        //mail template data
        $Allowedto = SECURE($UserEmailId, "e");
        $PasswordResetLink = DOMAIN . "/auth/?Authview=ResetPassword&token=$PasswordChangeToken";

        //save password change request information with link and password change token
        $user_password_change_requests = [
            "UserIdForPasswordChange" => $UserIdForPasswordChange,
            "PasswordChangeTokenExpireTime" => $PasswordChangeTokenExpireTime,
            "PasswordChangeToken" => $PasswordChangeToken,
            "PasswordChangeDeviceDetails" => $PasswordChangeDeviceDetails,
            "PasswordChangeRequestStatus" => $PasswordChangeRequestStatus
        ];
        $Save = INSERT("user_password_change_requests", $user_password_change_requests, false);

        //sent on mails
        $Mail = SENDMAILS("Password Reset Request Received!", "Verify Your Account!", $UserEmailId, "Your Password Reset Request is Received<br><br> You can change your password by clicking on the below link.<br><br> If this request is not sent by you then you may have to change your password immedietly.<br><br> $PasswordResetLink");
        //check mail status
        if ($Mail == true) {
            $access_url = DOMAIN . "/auth?Authview=VerifyAccount";
            LOCATION("success", "Password Change Link is sent on <b>$UserEmailId</b> Successfully!", "$access_url");
        } else {
            LOCATION("warning", "Unable to sent password reset link at the moment please try again after some time!", "$access_url");
        }
    } else {
        LOCATION("warning", "No any user is listed with $UserEmailId. Please check entered email id", "$access_url");
    }

    //check account verification request
} else if (isset($_POST['RequestAccountVerifications'])) {
    $SubmittedOTP = $_POST['SubmittedOTP'];
    if ($SubmittedOTP == $_SESSION['CREATED_OTP']) {
        $_SESSION['ACCOUNT_VERIFICATION_REQUEST'] = true;
        $_SESSION['ACCOUNT_VERIFICATION_REQUEST_EMAIL'] = $_SESSION['REQUESTED_EMAIL'];
        $access_url = DOMAIN . "/auth/?Authview=ResetPassword";
        LOCATION("success", "Account Verification Completed! Please change your password!", "$access_url");
    } else {
        LOCATION("warning", "Invalid OTP!", "$access_url");
    }

    //request for password change with requested otp
} elseif (isset($_POST['RequestForPasswordChange'])) {
    $Password1 = $_POST['Password1'];
    $Password2 = $_POST['Password2'];

    //token and user email-id
    $PasswordChangeToken = $_SESSION['SUBMITTED_PASSWORD_RESET_TOKEN'];

    if ($Password1 != $Password2) {
        LOCATION("warning", "Password Mismatch!", "$access_url");
    } else {
        $UserId = $_SESSION['REQUESTED_EMAIL_ID'];
        $UserExits = CHECK("SELECT UserEmailId FROM users where UserId='$UserId'");
        if ($UserExits != null) {
            $UserEmailId = FETCH("SELECT UserEmailId FROM users where UserId='$UserId'", "UserEmailId");
            $Password1 = SECURE($Password1, "e");
            $update = UPDATE_SQL("UPDATE users SET UserPassword='$Password1' where UserEmailId='$UserEmailId'");
            if ($update == true) {
                SENDMAILS("PASSWORD CHANGED", "Your Password has been changed!", $UserEmailId, "Your Password has been changed successfully. <br> <br> Thank You.");

                //expired the used session
                $PasswordChangeRequestStatus = "Expired";
                $Update = CUSTOM_COLUMN_UPDATE("user_password_change_requests", ["PasswordChangeRequestStatus"], "PasswordChangeToken='$PasswordChangeToken'");

                //redirect to login page
                $access_url = DOMAIN . "/auth?Authview=LoginForm";
                LOCATION("success", "Password Changed Successfully!", "$access_url");

                //check in case of incorrect
            } else {
                LOCATION("warning", "Unable to change password!", "$access_url");
            }
        } else {
            LOCATION("warning", "User Not Found at the time of Password Change Request, Please try again...", "$access_url");
        }
    }
}
