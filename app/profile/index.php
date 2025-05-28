<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
require_once $Dir . "/app/profile/components/HeaderRequests.php";

//pagevariables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
</head>

<body class="pb-5 mb-5">
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1><i class="bi bi-person bold"></i> Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card br-1">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="<?php echo AuthAppUser("UserProfileImage"); ?>" alt="<?php echo AuthAppUser("UserFullName"); ?>" title="<?php echo AuthAppUser("UserFullName"); ?>" class="rounded-circle">
                            <h2><?php echo UpperCase(AuthAppUser("UserSalutation")); ?>. <?php echo AuthAppUser("UserFullName"); ?></h2>
                            <h5 class="h5 text-secondary"><?php echo AuthAppUser("UserDesignation"); ?></h5>
                            <h3><?php echo AuthAppUser("UserType"); ?></h3>
                            <h6><i class="fa fa-cake text-danger"></i> <?php echo DATE_FORMATES("d M, Y", AuthAppUser("UserDateOfBirth")); ?></h6>
                            <div class="social-links">
                                <?php
                                $FetchAllUserLinks = SET_SQL("SELECT user_url_icon, user_url_link FROM users_urls WHERE user_url_main_user_id='" . LOGIN_USER_ID . "'", true);
                                if ($FetchAllUserLinks != NULL) {
                                    foreach ($FetchAllUserLinks as $Links) { ?>
                                        <a href="<?php echo $Links->user_url_link; ?>" target="_blank" class="sc-icons"><i class="<?php echo $Links->user_url_icon; ?>"></i></a>
                                <?php }
                                } ?>
                            </div>
                            <a href="tel:<?php echo AuthAppUser("UserPhoneNumber"); ?>" class="btn btn-block btn-outline-success w-100 btn-md"><i class="bi bi-phone"></i> <?php echo AuthAppUser("UserPhoneNumber"); ?></a>
                            <a href="mailto:<?php echo AuthAppUser("UserEmailId"); ?>" class="btn btn-block btn-outline-primary w-100 btn-md mt-2"><i class="bi bi-envelope-check"></i> <?php echo AuthAppUser("UserEmailId"); ?></a>

                            <hr>
                            <a href="<?php echo APP_URL; ?>/logout/" class="btn btn-xs btn-danger"><i class="bi bi-lock"></i> Logout </a>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item" style="margin:0.25rem !important;">
                                    <button style="font-size:0.75rem !important;padding:0.25rem 0.75rem !important;" class="nav-link <?php echo $overview; ?>" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item" style="margin:0.25rem !important;">
                                    <button style="font-size:0.75rem !important;padding:0.25rem 0.75rem !important;" class="nav-link <?php echo $profile; ?>" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>

                                <li class="nav-item" style="margin:0.25rem !important;">
                                    <a style="font-size:0.75rem !important;padding:0.25rem 0.75rem !important;" class="nav-link <?php echo $password; ?>" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</a>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade <?php echo $overview; ?> profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Overview</h5>
                                    <p class="small fst-italic"><?php echo SECURE(AuthAppUser("UserNotes"), "d"); ?></p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8"><?php echo UpperCase(AuthAppUser("UserSalutation")); ?>. <?php echo AuthAppUser("UserFullName"); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Company</div>
                                        <div class="col-lg-9 col-md-8"><?php echo AuthAppUser("UserCompanyName"); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Work Profile</div>
                                        <div class="col-lg-9 col-md-8"><?php echo AuthAppUser("UserDesignation"); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Country</div>
                                        <div class="col-lg-9 col-md-8"><?php echo UserAddress(LOGIN_USER_ID, "UserCountry"); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo UserAddress(LOGIN_USER_ID, "UserStreetAddress"); ?>,
                                            <?php echo UserAddress(LOGIN_USER_ID, "UserLocality"); ?>,
                                            <?php echo UserAddress(LOGIN_USER_ID, "UserCity"); ?>,
                                            <?php echo UserAddress(LOGIN_USER_ID, "UserState"); ?>,
                                            <?php echo UserAddress(LOGIN_USER_ID, "UserCountry"); ?> -
                                            <?php echo UserAddress(LOGIN_USER_ID, "UserPincode"); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade profile-edit pt-3 <?php echo $profile; ?>" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="<?php echo AuthAppUser("UserProfileImage"); ?>" alt="<?php echo AuthAppUser("UserFullName"); ?>" title="<?php echo AuthAppUser("UserFullName"); ?>" class="shadow-md">
                                            <div class="pt-2">
                                                <form class="form m-t-3" action="<?php echo CONTROLLER . "/ModuleController/UserController.php"; ?>" method="POST" enctype="multipart/form-data">
                                                    <input type="text" name="updateprofileimage" value="<?php echo LOGIN_USER_ID; ?>" hidden="">
                                                    <?php FormPrimaryInputs(true); ?>
                                                    <label for="UploadProfileimg">
                                                        <span class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></span>
                                                    </label>
                                                    <input type="file" class="hidden" onchange="form.submit()" hidden="" name="UserProfileImage" id="UploadProfileimg" value="<?php echo AuthAppUser("UserProfileImage"); ?>" accept="images/*">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="<?php echo CONTROLLER . "/ModuleController/UserController.php"; ?>" method="POST">
                                        <?php echo FormPrimaryInputs(true, [
                                            "UserId" => LOGIN_USER_ID
                                        ]); ?>
                                        <div class="row mb-3">
                                            <label for="Salutation" class="col-md-4 col-lg-3 col-form-label">Salutations</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="UserSalutation" class="form-control">
                                                    <?php echo InputOptionsWithKey(SALUTATION, AuthAppUser("UserSalutation")); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserFullName" type="text" class="form-control" id="fullName" value="<?php echo AuthAppUser("UserFullName"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="UserNotes" class="col-md-4 col-lg-3 col-form-label">About</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="UserNotes" class="form-control" id="UserNotes" rows="3"><?php echo SECURE(AuthAppUser("UserNotes"), "d"); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserDateOfBirth" class="col-md-4 col-lg-3 col-form-label">Date of Birth</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserDateOfBirth" type="date" class="form-control" id="UserDateOfBirth" value="<?php echo AuthAppUser("UserDateOfBirth"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="UserCompanyName" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserCompanyName" type="text" class="form-control" id="UserCompanyName" value="<?php echo AuthAppUser("UserCompanyName"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="UserDesignation" class="col-md-4 col-lg-3 col-form-label">Work Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserDesignation" type="text" class="form-control" id="UserDesignation" value="<?php echo AuthAppUser("UserDesignation"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="UserStreetAddress" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserStreetAddress" type="text" class="form-control" id="UserStreetAddress" value="<?php echo UserAddress(LOGIN_USER_ID, "UserStreetAddress"); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserLocality" class="col-md-4 col-lg-3 col-form-label">Area Locality</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserLocality" type="text" class="form-control" id="UserLocality" value="<?php echo UserAddress(LOGIN_USER_ID, "UserLocality"); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserCity" class="col-md-4 col-lg-3 col-form-label">City</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserCity" type="text" class="form-control" id="UserCity" value="<?php echo UserAddress(LOGIN_USER_ID, "UserCity"); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserState" class="col-md-4 col-lg-3 col-form-label">State</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserState" type="text" class="form-control" id="UserState" value="<?php echo UserAddress(LOGIN_USER_ID, "UserState"); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserPincode" class="col-md-4 col-lg-3 col-form-label">Pincode</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserPincode" type="text" class="form-control" id="UserPincode" value="<?php echo UserAddress(LOGIN_USER_ID, "UserPincode"); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserCountry" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserCountry" type="text" class="form-control" id="UserCountry" value="<?php echo UserAddress(LOGIN_USER_ID, "UserCountry"); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="UserPhoneNumber" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="UserPhoneNumber" type="text" class="form-control" id="UserPhoneNumber" value="<?php echo AuthAppUser("UserPhoneNumber"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="FACEBOOK" class="col-md-4 col-lg-3 col-form-label">Facebook </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="FACEBOOK" type="url" class="form-control" id="FACEBOOK" value="<?php echo FETCH("SELECT user_url_link FROM users_urls where user_url_name='FACEBOOK' and user_url_main_user_id='" . LOGIN_USER_ID . "'", "user_url_link"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="LINKEDIN" class="col-md-4 col-lg-3 col-form-label">Linkedin</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="LINKEDIN" type="url" class="form-control" id="LINKEDIN" value="<?php echo FETCH("SELECT user_url_link FROM users_urls where user_url_name='LINKEDIN' and user_url_main_user_id='" . LOGIN_USER_ID . "'", "user_url_link"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="INSTAGRAM" class="col-md-4 col-lg-3 col-form-label">Instagram</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="INSTAGRAM" type="url" class="form-control" id="INSTAGRAM" value="<?php echo FETCH("SELECT user_url_link FROM users_urls where user_url_name='INSTAGRAM' and user_url_main_user_id='" . LOGIN_USER_ID . "'", "user_url_link"); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="OTHERS" class="col-md-4 col-lg-3 col-form-label">Website/Others Link</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="OTHERS" type="url" class="form-control" id="OTHERS" value="<?php echo FETCH("SELECT user_url_link FROM users_urls where user_url_name='OTHERS' and user_url_main_user_id='" . LOGIN_USER_ID . "'", "user_url_link"); ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="UpdatePrimaryData" class="btn btn-dark btn-md"><i class="fa fa-check-circle text-success"></i> Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade pt-3 <?php echo $password; ?>" id="profile-change-password">
                                    <?php if (isset($_SESSION['UserVerificationCode']) && isset($_SESSION['UserVerificationStatus'])) { ?>
                                        <form action="<?php echo CONTROLLER . "/ModuleController/UserController.php"; ?>" method="POST">
                                            <?php echo FormPrimaryInputs(true, [
                                                "UserId" => LOGIN_USER_ID
                                            ]); ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="app-heading">Enter 6-Digit Verification code.</h5>
                                                    <p>We've sent a 6-digit verification code to your registered email. Please check your inbox and enter the code below to verify your account.</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <input type="text" name="UserVerificationCode" class="form-control" placeholder="Enter 6-Digit Verification Code" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="text-center">
                                                    <button type="submit" name="VerifyUserAccountViaProfile" class="btn btn-dark btn-md"><i class="fa fa-check-circle text-success"></i> Verify Account</button>
                                                </div>
                                            </div>
                                        </form>
                                        <form id='CodeVerificationForm' action="<?php echo CONTROLLER . "/ModuleController/UserController.php"; ?>" method="POST">
                                            <?php echo FormPrimaryInputs(true, [
                                                "UserId" => LOGIN_USER_ID
                                            ]); ?>
                                            <div class="row mb-3">
                                                <div class="text-center">
                                                    <button type="submit" id='ResendButtonControl' name="RequestForAccountVerification" class="btn btn-secondary btn-sm"> Request New Code</button>
                                                    <span class="text-secondary" id='ResendTextMsg'> Resend in 30 sec</span>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } elseif (isset($_SESSION['CHANGE_PASSWORD_REQUEST']) && isset($_SESSION['CHANGE_PASSWORD_USER_ID'])) { ?>
                                        <form id='PassChangeForm' action="<?php echo CONTROLLER . "/ModuleController/UserController.php"; ?>" method="POST">
                                            <?php echo FormPrimaryInputs(true); ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="app-heading">Change Password</h5>
                                                    <p>Enter a new password that meets the security requirements.</p>
                                                    <span id="PasswordUpdateMsg" style="font-weight: bold;"></span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <input type="text" name="NewPassword" oninput="ValidatePassword()" id='Pass1' minlength="7" class="form-control" placeholder="Enter New Password" required>
                                                    <small id="passwordStrengthMsg"></small>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <input type="text" name="ConfirmNewPassword" oninput="ValidatePassword()" id='Pass2' minlength="7" class="form-control" placeholder="Confirm New Password" required>
                                                    <small id="passwordMatchMsg"></small>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="text-center">
                                                    <button type="submit" id='PassChangeButton' name="ChangeUserPassword" class="btn btn-dark btn-md" disabled>
                                                        <i class="fa fa-check-circle text-success"></i> Request for Change Password
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <script>
                                            function ValidatePassword() {
                                                let pass1 = document.getElementById("Pass1").value;
                                                let pass2 = document.getElementById("Pass2").value;
                                                let strengthMsg = document.getElementById("passwordStrengthMsg");
                                                let matchMsg = document.getElementById("passwordMatchMsg");
                                                let updateMsg = document.getElementById("PasswordUpdateMsg");
                                                let submitButton = document.getElementById("PassChangeButton");

                                                // Password Strength Criteria
                                                let hasUpper = /[A-Z]/.test(pass1);
                                                let hasLower = /[a-z]/.test(pass1);
                                                let hasNumber = /\d{4,}/.test(pass1);
                                                let hasSpecial = /[\W_]/.test(pass1);
                                                let minLength = pass1.length >= 7;

                                                let strength = hasUpper && hasLower && hasNumber && hasSpecial && minLength;

                                                // Update Strength Message
                                                if (pass1.length === 0) {
                                                    strengthMsg.innerHTML = "";
                                                } else if (!strength) {
                                                    strengthMsg.innerHTML = "Password must contain: 1 Uppercase, 1 Lowercase, 1 Special Character, & 4 Numbers.";
                                                    strengthMsg.style.color = "red";
                                                } else {
                                                    strengthMsg.innerHTML = "Strong Password ✔";
                                                    strengthMsg.style.color = "green";
                                                }

                                                // Password Match Validation
                                                if (pass2.length === 0) {
                                                    matchMsg.innerHTML = "";
                                                } else if (pass1 !== pass2) {
                                                    matchMsg.innerHTML = "Passwords do not match ❌";
                                                    matchMsg.style.color = "red";
                                                } else {
                                                    matchMsg.innerHTML = "Passwords match ✔";
                                                    matchMsg.style.color = "green";
                                                }

                                                // Enable Button Only If Everything Is Correct
                                                if (strength && pass1 === pass2) {
                                                    submitButton.removeAttribute("disabled");
                                                    updateMsg.innerHTML = "Password is strong and ready to submit ✔";
                                                    updateMsg.style.color = "green";
                                                } else {
                                                    submitButton.setAttribute("disabled", "true");
                                                    updateMsg.innerHTML = "Ensure password meets all requirements.";
                                                    updateMsg.style.color = "red";
                                                }
                                            }
                                        </script>
                                    <?php } else { ?>
                                        <!-- Change Password Form -->
                                        <form action="<?php echo CONTROLLER . "/ModuleController/UserController.php"; ?>" method="POST">
                                            <?php echo FormPrimaryInputs(true, [
                                                "UserId" => LOGIN_USER_ID
                                            ]); ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="app-heading">Request for Password Change</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <h6 class="bold">You have to verify your account for change password via profile section.</h6>
                                                <p>Click below button to verify you account, after verification password reset will be enabled.</p>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" name="RequestForAccountVerification" class="btn btn-dark btn-md"><i class="fa fa-shield text-success"></i> Request Account Verifications</button>
                                            </div>
                                        </form><!-- End Change Password Form -->
                                    <?php } ?>
                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let resendButton = document.getElementById("ResendButtonControl");
            let resendText = document.getElementById("ResendTextMsg");

            function startCountdown() {
                let timeLeft = 30;
                resendButton.setAttribute("disabled", "true");
                resendButton.setAttribute("type", "button"); // Prevent form submission
                resendButton.style.display = "none"; // Hide button
                resendText.style.display = "inline"; // Show countdown text

                let timer = setInterval(function() {
                    resendText.innerText = `Resend in ${timeLeft} sec`;
                    timeLeft--;

                    if (timeLeft < 0) {
                        clearInterval(timer);
                        resendButton.removeAttribute("disabled");
                        resendButton.setAttribute("type", "submit"); // Allow form submission
                        resendButton.style.display = "inline"; // Show button
                        resendText.style.display = "none"; // Hide countdown text
                    }
                }, 1000);
            }

            // Start countdown on page load
            startCountdown();
        });
    </script>


    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
</body>

</html>