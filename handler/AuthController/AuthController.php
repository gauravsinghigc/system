<?php
//initialize files
require_once "../../acm/SysFileAutoLoader.php";
require_once "../../acm/SystemReqHandler.php";

//admin login request
if (isset($_POST['LoginRequest'])) {
    $UserPassword = $_POST['UserPassword'];
    $UserEmailId = $_POST['UserEmailId'];

    if (!filter_var($UserEmailId, FILTER_VALIDATE_EMAIL)) {
        LOCATION("warning", "Invalid Email format. Please enter a valid Email-ID!", "$access_url");
        exit;
    }

    $CheckUsername = CHECK("SELECT UserEmailId , UserPassword FROM users WHERE UserEmailId='$UserEmailId' AND UserPassword='$UserPassword'");

    if ($CheckUsername == true) {
        $Sql = "SELECT UserId, UserFullName FROM users WHERE UserEmailId='$UserEmailId' AND UserStatus='1'";
        $UserId = FETCH($Sql, "UserId");
        $UserFullName = FETCH($Sql, "UserFullName");

        // Logs
        GENERATE_APP_LOGS("CP_SUCCESS", "New Login Received @ User : $UserEmailId, Pass : " . SECURE($UserPassword, "d"), "LOGIN", $UserId);

        // Session
        $_SESSION['APP_LOGIN_USER_ID'] = $UserId;

        // Set 30-day cookie
        setcookie("LOGIN_USER_ID", $UserId, time() + (86400 * 30), "/", false, false); // 30 days

        LOCATION("success", "Welcome $UserFullName, Login Successful!", DOMAIN . "/app");
    } else {
        GENERATE_APP_LOGS("CP_BLOCK", "Login Failed @ $UserEmailId, Pass : " . SECURE($UserPassword, "d"), "LOGIN", "0");
        LOCATION("warning", "Please check your Email-Id and Password. They are incorrect!", "$access_url");
    }

    //search for account verification request
} elseif (isset($_POST['SearchAccountForPasswordReset'])) {
    $UserEmailId = $_POST['UserEmailId'];
    $UserExits = CHECK("SELECT UserEmailId FROM users where UserEmailId='$UserEmailId'");
    $CREATED_OTP = rand(111111, 999999);
    if ($UserExits != null) {
        $PasswordResetRequestAuthToken = rand(111111, 999999) . "- Date - " . date("Y-m-d h:i:s a") . " For" . APP_NAME;
        $PasswordChangeTokenization = SECURE($PasswordResetRequestAuthToken, "e");
        $_SESSION['CREATED_OTP'] = $CREATED_OTP;
        $_SESSION['REQUESTED_EMAIL'] = $UserEmailId;
        $UserId = FETCH("SELECT * from users where UserEmailId='$UserEmailId'", "UserId");

        //create Password reset Token with expire limit
        $PasswordReqData = array(
            "UserIdForPasswordChange" => $UserEmailId,
            "PasswordChangeTokenExpireTime" => date('d-m-Y H:i', strtotime("+10 min")),
            "PasswordChangeDeviceDetails" => SECURE(SYSTEM_INFO, "e"),
            "PasswordChangeToken" => $PasswordChangeTokenization,
            "PasswordChangeRequestStatus" => "Active"
        );
        //mail template data
        $Allowedto = SECURE($UserEmailId, "e");
        $PasswordResetLink = DOMAIN . "/auth/reset/?reset=true&token=$PasswordChangeTokenization&for=$Allowedto";
        $UpdatePreviousLinks = SQL("UPDATE user_password_change_requests SET PasswordChangeRequestStatus='Expired' where UserIdForPasswordChange='$UserId'");
        $Save = INSERT("user_password_change_requests", $PasswordReqData, false);

        //sent on mails
        $Mail = SENDMAILS("Password Reset Request Received!", "Verify Your Account!", $UserEmailId, "Your Password Reset Request is Received<br><br> You can change your password by clicking on the below link.<br><br> If this request is not sent by you then you may have to change your password immedietly.<br><br> $PasswordResetLink");

        //check mail status
        if ($Mail == true) {
            $access_url = DOMAIN . "/auth/verify/";
            LOCATION("success", "Password Change Link is sent on <b>$UserEmailId</b> Successfully!", "$access_url");
        } else {
            LOCATION("warning", "Unable to sent password reset link at the moment please try again after some time!", "$access_url");
        }
    } else {
        LOCATION("warning", "No any user is listed with " . $_POST['UserPhoneNumber'] . ". Please check entered email id", "$access_url");
    }

    //check account verification request

} elseif (isset($_POST['RequestForPasswordChange'])) {
    $Password1 = $_POST['Password1'];
    $Password2 = $_POST['Password2'];
    if ($Password1 != $Password2) {
        LOCATION("warning", "Password Mismatch!", "$access_url");
    } else {
        $UserEmailId = $_SESSION['REQUESTED_EMAIL_ID'];
        $PasswordChangeToken = $_SESSION['PASSWORD_RESET_TOKEN'];
        $UserExits = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId'");
        if ($UserExits != null) {
            $update = SQL("UPDATE users SET UserPassword='$Password1' where UserEmailId='$UserEmailId'");
            $UserId = FETCH("SELECT * FROM users where UserEmailId='$UserEmailId'", "UserId");
            if ($update == true) {
                SENDMAILS("PASSWORD CHANGED", "Your Password has been changed!", $UserEmailId, "Your Password has been changed successfully. <br> <br> Thank You.");
                GENERATE_APP_LOGS("PASSWORD-CHANGED", "Password changed for User : " . $UserEmailId . ", Pass : " . $Password2, "PASSWORD-RESET", $UserId);
                //token and user email-id
                $_SESSION['REQUESTED_EMAIL_ID'] = null;
                $_SESSION['PASSWORD_RESET_TOKEN'] = null;

                //expired the used session
                $data = array(
                    "PasswordChangeRequestStatus" => "Expired",
                );
                $Update = UPDATE("user_password_change_requests", $data, "PasswordChangeToken='$PasswordChangeToken'");

                //redirect to login page
                $access_url = DOMAIN . "/auth/login/";
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
