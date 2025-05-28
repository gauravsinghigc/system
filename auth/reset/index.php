<?php
require_once '../../acm/SysFileAutoLoader.php';

if (isset($_SESSION['APP_LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo APP_NAME; ?> | Reset</title>
    <meta content="width=device-width, initial-scale=0.95, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <?php include_once "../../assets/HeaderStyleSheets.php"; ?>
</head>

<?php if (DEVICE_TYPE == "MOBILE") { ?>

    <body style="background-image:url('https://images.unsplash.com/photo-1524230572899-a752b3835840?q=80&w=1936&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') !important;background-size:fill;height:100%;background-position:center;">
        <section class="container">
            <div class="row">
                <div class="col-md-12 text-center pt-5">
                    <img src="<?php echo APP_LOGO; ?>" class="w-25 img-fluid rounded-circle">
                    <h2 class="bold text-danger mt-4"><?php echo APP_NAME; ?></h2>
                </div>
                <div class="col-md-12 mt-4 text-left">
                    <div class="p-2">
                        <h4 class="bold text-center text-primary">Change Password!</h4>
                        <div class="card-body p-0">
                            <?php if (isset($_GET['token'])) {
                                $ReceivedToken = $_GET['token'];
                                $for = SECURE($_GET['for'], "d");
                                $UserIdForPasswordChange = $for;
                                $RequiredToken = CHECK("SELECT * FROM user_password_change_requests where PasswordChangeToken='$ReceivedToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                                $PasswordChangeTokenExpireTime = FETCH("SELECT * FROM user_password_change_requests where PasswordChangeToken='$ReceivedToken' and UserIdForPasswordChange='$UserIdForPasswordChange'", "PasswordChangeTokenExpireTime");
                                $PasswordChangeTokenExpireTime = date("d-m-y h:i", strtotime($PasswordChangeTokenExpireTime));
                                $CurrentDateTime = date("d-m-y h:i");
                                $_SESSION['SUBMITTED_PASSWORD_RESET_TOKEN'] = $RequiredToken;
                                $_SESSION['REQUESTED_EMAIL_ID'] = $for;

                                if ($CurrentDateTime <= $PasswordChangeTokenExpireTime) {
                                    if ($RequiredToken == $ReceivedToken) { ?>
                                        <form role="form" action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php" method="POST">
                                            <?php FormPrimaryInputs($url = RUNNING_URL); ?>
                                            <div class="form-group">
                                                <label for="inputUsernameEmail">New Password</label>
                                                <input type="password" minlength="8" name="Password1" value="" id="Pass1" required="" class="form-control form-control-lg app-form-control outline-danger">
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="inputUsernameEmail">Re-Enter New Password</label>
                                                <input type="password" minlength="8" name="Password2" id="Pass2" value="" required="" class="form-control form-control-lg app-form-control" oninput="CheckPassMatch()">
                                            </div>
                                            <br>
                                            <button type="submit" name="RequestForPasswordChange" class="btn btn btn-dark fixed-bottom rounded-circle circle p-3 fs-4 mb-3 w-100 btn-lg p-2 fs-18">
                                                <i class="fa fa-edit fs-18 text-success"></i> Change Password
                                            </button>
                                        </form>
                                    <?php } else {
                                        $PasswordChangeRequestStatus = "Expired";
                                        $PasswordChangeToken = $RequiredToken;
                                        $UpdateTable = [
                                            "PasswordChangeRequestStatus" => $PasswordChangeRequestStatus,
                                        ];
                                        UPDATE("user_password_change_requests", $UpdateTable, "PasswordChangeToken='$PasswordChangeToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                                    ?>
                                        <h4>Sorry! Token Expired</h4>
                                        <p>Password link is expired. Please re create link or re-send password change request!</p>
                                        <div class="flex-s-b">
                                            <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-dark btn-lg w-100 mb-2">Password Reset <i class="fa fa-arrow-right text-success"></i></a><br>
                                            <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-secondary btn-lg w-100"><i class="fa fa-arrow-left text-success"></i> Back to Login</a>
                                        </div>
                                    <?php }
                                } else {
                                    $PasswordChangeRequestStatus = "Expired";
                                    $PasswordChangeToken = $RequiredToken;
                                    $UpdateTable = [
                                        "PasswordChangeRequestStatus" => $PasswordChangeRequestStatus,
                                    ];
                                    UPDATE("user_password_change_requests", $UpdateTable, "PasswordChangeToken='$PasswordChangeToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                                    ?>
                                    <h4 class="text-center"><i class="fa fa-warning text-danger"></i> Token Expired</h4>
                                    <p class="text-center mb-3">Received Password change token is not valid or may be expired. You have to create new one by following below links.</p>
                                    <div class="flex-s-b">
                                        <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-dark btn-lg w-100 mb-2">Password Reset <i class="fa fa-arrow-right text-success"></i></a><br>
                                        <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-secondary btn-lg w-100"><i class="fa fa-arrow-left text-success"></i> Back to Login</a>
                                    </div>
                                <?php }
                            } else { ?>
                                <h5><b>Ooopsss......</b></h5>
                                <p>Password reset access token are missing. Please check the link it may be broken or incorrect.</p>
                                <p>You can also generate password reset link again. </p>
                                <div class="flex-s-b">
                                    <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-dark btn-lg w-100 mb-2">Password Reset <i class="fa fa-arrow-right text-success"></i></a><br>
                                    <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-secondary btn-lg w-100"><i class="fa fa-arrow-left text-success"></i> Back to Login</a>
                                </div>
                            <?php } ?>
                            <script>
                                function CheckPassMatch() {
                                    var Pass1 = document.getElementById("Pass1").value;
                                    var Pass2 = document.getElementById("Pass2").value;
                                    if (Pass1 != Pass2) {
                                        document.getElementById("msg1").innerHTML = "<span class='text-danger'><i class='fa fa-warning'></i> Password Mismatch</span>";
                                        document.getElementById("msg2").innerHTML = "<span class='text-danger'><i class='fa fa-warning'></i> Password Mismatch</span>";
                                        document.getElementById("Pass1").style.borderColor = "red";
                                        document.getElementById("Pass2").style.borderColor = "red";
                                        document.getElementById("Pass1").style.backgroundColor = "rgba(255, 0, 0, 0.1)";
                                        document.getElementById("Pass2").style.backgroundColor = "rgba(255, 0, 0, 0.1)";
                                        document.getElementById("Pass1").style.color = "red";
                                        document.getElementById("Pass2").style.color = "red";
                                        document.getElementById("Pass1").style.boxShadow = "0 0 0 0.2rem rgba(255, 0, 0, 0.5)";
                                        document.getElementById("Pass2").style.boxShadow = "0 0 0 0.2rem rgba(255, 0, 0, 0.5)";
                                        document.getElementById("Pass1").style.transition = "0.5s";
                                        document.getElementById("Pass2").style.transition = "0.5s";
                                        document.getElementById("Pass1").style.borderRadius = "0.25rem";
                                        document.getElementById("Pass2").style.borderRadius = "0.25rem";
                                        document.getElementById("Pass1").style.fontSize = "1rem";
                                        document.getElementById("btn").classList.add("disabled");
                                    } else {
                                        document.getElementById("msg1").innerHTML = "";
                                        document.getElementById("msg2").innerHTML = "";
                                        document.getElementById("Pass1").style.borderColor = "green";
                                        document.getElementById("Pass2").style.borderColor = "green";
                                        document.getElementById("Pass1").style.backgroundColor = "rgba(0, 255, 0, 0.1)";
                                        document.getElementById("Pass2").style.backgroundColor = "rgba(0, 255, 0, 0.1)";
                                        document.getElementById("Pass1").style.color = "green";
                                        document.getElementById("Pass2").style.color = "green";
                                        document.getElementById("Pass1").style.boxShadow = "0 0 0 0.2rem rgba(0, 255, 0, 0.5)";
                                        document.getElementById("Pass2").style.boxShadow = "0 0 0 0.2rem rgba(0, 255, 0, 0.5)";
                                        document.getElementById("Pass1").style.transition = "0.5s";
                                        document.getElementById("Pass2").style.transition = "0.5s";
                                        document.getElementById("Pass1").style.borderRadius = "0.25rem";
                                        document.getElementById("Pass2").style.borderRadius = "0.25rem";
                                        document.getElementById("Pass1").style.fontSize = "1rem";
                                        document.getElementById("btn").classList.remove("disabled");
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

<?php } else { ?>

    <body class="app-login-bg">
        <main>
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">
                                <div class="card mb-3 border-radius-1 box-shadow-1">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-left py-4">
                                            <a href="<?php echo DOMAIN; ?>" class="logo d-flex align-items-center w-auto">
                                                <img src="<?php echo APP_LOGO; ?>" alt="<?php echo APP_NAME; ?>" title="<?php echo APP_NAME; ?>">
                                                <span><?php echo APP_NAME; ?></span>
                                            </a>
                                        </div>
                                        <div class="pt-0 mt-1 pb-2">
                                            <h5 class="card-title text-left pb-0 pt-0 fs-5"><i class="fa fa-edit text-success"></i> Generate New Password!</h5>
                                            <p class="text-left small text-secondary">Please enter new password for your account!</p>
                                        </div>
                                        <div class="card-body p-0">
                                            <?php if (isset($_GET['token'])) {
                                                $ReceivedToken = $_GET['token'];
                                                $for = SECURE($_GET['for'], "d");
                                                $UserIdForPasswordChange = $for;
                                                $RequiredToken = CHECK("SELECT * FROM user_password_change_requests where PasswordChangeToken='$ReceivedToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                                                $PasswordChangeTokenExpireTime = FETCH("SELECT * FROM user_password_change_requests where PasswordChangeToken='$ReceivedToken' and UserIdForPasswordChange='$UserIdForPasswordChange'", "PasswordChangeTokenExpireTime");
                                                $PasswordChangeTokenExpireTime = date("d-m-y h:i", strtotime($PasswordChangeTokenExpireTime));
                                                $CurrentDateTime = date("d-m-y h:i");
                                                $_SESSION['SUBMITTED_PASSWORD_RESET_TOKEN'] = $RequiredToken;
                                                $_SESSION['REQUESTED_EMAIL_ID'] = $for;

                                                if ($CurrentDateTime <= $PasswordChangeTokenExpireTime) {
                                                    if ($RequiredToken == $ReceivedToken) { ?>
                                                        <form role="form" action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php" method="POST">
                                                            <?php FormPrimaryInputs($url = RUNNING_URL); ?>
                                                            <div class="form-group">
                                                                <label for="inputUsernameEmail">New Password</label>
                                                                <input type="password" minlength="8" name="Password1" value="" id="Pass1" required="" class="form-control form-control-lg app-form-control outline-danger">
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <label for="inputUsernameEmail">Re-Enter New Password</label>
                                                                <input type="password" minlength="8" name="Password2" id="Pass2" value="" required="" class="form-control form-control-lg app-form-control" oninput="CheckPassMatch()">
                                                            </div>
                                                            <br>
                                                            <button type="submit" name="RequestForPasswordChange" class="btn btn btn-dark w-100 btn-lg p-2 fs-18">
                                                                <i class="fa fa-edit fs-18 text-success"></i> Change Password
                                                            </button>
                                                        </form>
                                                    <?php } else {
                                                        $PasswordChangeRequestStatus = "Expired";
                                                        $PasswordChangeToken = $RequiredToken;
                                                        $UpdateTable = [
                                                            "PasswordChangeRequestStatus" => $PasswordChangeRequestStatus,
                                                        ];
                                                        UPDATE("user_password_change_requests", $UpdateTable, "PasswordChangeToken='$PasswordChangeToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                                                    ?>
                                                        <h4>Sorry! Token Expired</h4>
                                                        <p>Password link is expired. Please re create link or re-send password change request!</p>
                                                        <div class="flex-s-b">
                                                            <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-dark btn-lg w-100 mb-2">Password Reset <i class="fa fa-arrow-right text-success"></i></a><br>
                                                            <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-secondary btn-lg w-100"><i class="fa fa-arrow-left text-success"></i> Back to Login</a>
                                                        </div>
                                                    <?php }
                                                } else {
                                                    $PasswordChangeRequestStatus = "Expired";
                                                    $PasswordChangeToken = $RequiredToken;
                                                    $UpdateTable = [
                                                        "PasswordChangeRequestStatus" => $PasswordChangeRequestStatus,
                                                    ];
                                                    UPDATE("user_password_change_requests", $UpdateTable, "PasswordChangeToken='$PasswordChangeToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                                                    ?>
                                                    <h4 class="text-center"><i class="fa fa-warning text-danger"></i> Token Expired</h4>
                                                    <p class="text-center mb-3">Received Password change token is not valid or may be expired. You have to create new one by following below links.</p>
                                                    <div class="flex-s-b">
                                                        <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-dark btn-lg w-100 mb-2">Password Reset <i class="fa fa-arrow-right text-success"></i></a><br>
                                                        <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-secondary btn-lg w-100"><i class="fa fa-arrow-left text-success"></i> Back to Login</a>
                                                    </div>
                                                <?php }
                                            } else { ?>
                                                <h5><b>Ooopsss......</b></h5>
                                                <p>Password reset access token are missing. Please check the link it may be broken or incorrect.</p>
                                                <p>You can also generate password reset link again. </p>
                                                <div class="flex-s-b">
                                                    <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-dark btn-lg w-100 mb-2">Password Reset <i class="fa fa-arrow-right text-success"></i></a><br>
                                                    <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-secondary btn-lg w-100"><i class="fa fa-arrow-left text-success"></i> Back to Login</a>
                                                </div>
                                            <?php } ?>
                                            <script>
                                                function CheckPassMatch() {
                                                    var Pass1 = document.getElementById("Pass1").value;
                                                    var Pass2 = document.getElementById("Pass2").value;
                                                    if (Pass1 != Pass2) {
                                                        document.getElementById("msg1").innerHTML = "<span class='text-danger'><i class='fa fa-warning'></i> Password Mismatch</span>";
                                                        document.getElementById("msg2").innerHTML = "<span class='text-danger'><i class='fa fa-warning'></i> Password Mismatch</span>";
                                                        document.getElementById("Pass1").style.borderColor = "red";
                                                        document.getElementById("Pass2").style.borderColor = "red";
                                                        document.getElementById("Pass1").style.backgroundColor = "rgba(255, 0, 0, 0.1)";
                                                        document.getElementById("Pass2").style.backgroundColor = "rgba(255, 0, 0, 0.1)";
                                                        document.getElementById("Pass1").style.color = "red";
                                                        document.getElementById("Pass2").style.color = "red";
                                                        document.getElementById("Pass1").style.boxShadow = "0 0 0 0.2rem rgba(255, 0, 0, 0.5)";
                                                        document.getElementById("Pass2").style.boxShadow = "0 0 0 0.2rem rgba(255, 0, 0, 0.5)";
                                                        document.getElementById("Pass1").style.transition = "0.5s";
                                                        document.getElementById("Pass2").style.transition = "0.5s";
                                                        document.getElementById("Pass1").style.borderRadius = "0.25rem";
                                                        document.getElementById("Pass2").style.borderRadius = "0.25rem";
                                                        document.getElementById("Pass1").style.fontSize = "1rem";
                                                        document.getElementById("btn").classList.add("disabled");
                                                    } else {
                                                        document.getElementById("msg1").innerHTML = "";
                                                        document.getElementById("msg2").innerHTML = "";
                                                        document.getElementById("Pass1").style.borderColor = "green";
                                                        document.getElementById("Pass2").style.borderColor = "green";
                                                        document.getElementById("Pass1").style.backgroundColor = "rgba(0, 255, 0, 0.1)";
                                                        document.getElementById("Pass2").style.backgroundColor = "rgba(0, 255, 0, 0.1)";
                                                        document.getElementById("Pass1").style.color = "green";
                                                        document.getElementById("Pass2").style.color = "green";
                                                        document.getElementById("Pass1").style.boxShadow = "0 0 0 0.2rem rgba(0, 255, 0, 0.5)";
                                                        document.getElementById("Pass2").style.boxShadow = "0 0 0 0.2rem rgba(0, 255, 0, 0.5)";
                                                        document.getElementById("Pass1").style.transition = "0.5s";
                                                        document.getElementById("Pass2").style.transition = "0.5s";
                                                        document.getElementById("Pass1").style.borderRadius = "0.25rem";
                                                        document.getElementById("Pass2").style.borderRadius = "0.25rem";
                                                        document.getElementById("Pass1").style.fontSize = "1rem";
                                                        document.getElementById("btn").classList.remove("disabled");
                                                    }
                                                }
                                            </script>
                                        </div>

                                        <?php include_once "../../include/Login-Footer.php"; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </section>

            </div>
        </main><!-- End #main -->
    </body>
<?php } ?>
<?php include_once "../../assets/FooterScripts.php"; ?>

</html>