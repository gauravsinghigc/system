<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

// Page variables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

// Checking User Has A Plan Or Not
$UserID = SECURE(ReturnSessionalValues("UserId", "ActiveDetailedUser", null), "d");

// Fetch user details SQL (you'll add the data fetching logic)
$UserSQL = "SELECT * FROM users WHERE UserID='$UserID'";
HandleInvalidData(FETCH($UserSQL, "UserId"), "../");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title>Profile : <?php echo FETCH($UserSQL, "UserFullName"); ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
    <style>

    </style>
</head>

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">
        <div class="pagetitle slide-in">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-building-gear text-danger fw-bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Success/Error Messages -->
                    <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success fade-in mb-4">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    }
                    if (isset($_SESSION['errors'])) {
                        echo '<div class="alert alert-danger fade-in mb-4"><ul>';
                        foreach ($_SESSION['errors'] as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                        echo '</ul></div>';
                        unset($_SESSION['errors']);
                    }
                    ?>

                    <!-- User Details Card -->
                    <div class="card profile-card fade-in mb-4">
                        <div class="card-body pt-4">
                            <h3 class="card-title app-sub-heading"><i class="bi bi-person-circle me-2"></i>User Profile</h3>
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center">
                                    <?php
                                    if (FETCH($UserSQL, "UserProfileImage") == null || FETCH($UserSQL, "UserProfileImage") == "" || FETCH($UserSQL, "UserProfileImage") == " " || FETCH($UserSQL, "UserProfileImage") == "Not Available") {
                                        $UserProfileImage = APP_LOGO;
                                    } else {
                                        $UserProfileImage = STORAGE_URL . "/users" . "/" . $UserID . "/img" . "/" . FETCH($UserSQL, "UserProfileImage");
                                    }
                                    ?>
                                    <img src="<?php echo $UserProfileImage; ?>" class="img-fluid rounded-circle img-circle mb-3" alt="Profile" style="max-width: 150px;">
                                    <h5 class="fw-bold"></h5>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-md-5">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Full Name:</strong> <span><?php echo FETCH($UserSQL, "UserSalutation"); ?> <?php echo FETCH($UserSQL, "UserFullName"); ?></span></li>
                                        <li class="list-group-item"><strong>Phone:</strong> <span><?php echo FETCH($UserSQL, "UserPhoneNumber"); ?></span></li>
                                        <li class="list-group-item"><strong>Email-ID:</strong> <span><?php echo FETCH($UserSQL, "UserEmailId"); ?></span></li>
                                        <li class="list-group-item"><strong>Company:</strong> <span><?php echo FETCH($UserSQL, "UserCompanyName"); ?></span></li>
                                        <li class="list-group-item"><strong>Designation:</strong> <span><?php echo FETCH($UserSQL, "UserDesignation"); ?></span></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Date Of Birth:</strong> <span><?php echo DATE_FORMATES("d M, Y", FETCH($UserSQL, "UserDateOfBirth")); ?></span></li>
                                        <li class="list-group-item"><strong>User Type:</strong> <span class="badge badge-success bg-success"><?php echo FETCH($UserSQL, "UserType"); ?></span></li>
                                        <li class="list-group-item"><strong>User Status:</strong> <span><?php echo StatusViewWithText(FETCH($UserSQL, "UserStatus")); ?></span></li>
                                        <li class="list-group-item"><strong>Reporting Manager:</strong> <span>
                                                <a href="../details/?UserId=<?php echo SECURE(FETCH($UserSQL, "UserReportingManager"), "e"); ?>">
                                                    (ID:<?php echo FETCH($UserSQL, "UserReportingManager"); ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($UserSQL, "UserReportingManager") . "'", "UserFullName"); ?>
                                                </a>
                                            </span></li>
                                        <li class="list-group-item"><strong>Created At:</strong> <span><?php echo DATE_FORMATES("d M, Y", FETCH($UserSQL, "UserCreatedAt")); ?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Form in Tabs -->
                    <div class="card profile-card fade-in mb-4">
                        <div class="card-body">
                            <h3 class="card-title mt-4 app-sub-heading"><i class="bi bi-pencil-square me-2"></i>Update Profile</h3>
                            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="primary-tab" data-bs-toggle="tab" data-bs-target="#primary" type="button" role="tab"><i class="bi bi-person me-2"></i>Primary Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab"><i class="bi bi-geo-alt me-2"></i>Update Address</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab"><i class="bi bi-lock me-2"></i>Login & Security</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs" type="button" role="tab"><i class="bi bi-clock-history me-2"></i>Login Logs</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="profileTabContent">
                                <!-- Primary Profile Tab -->
                                <div class="tab-pane fade show active" id="primary" role="tabpanel">
                                    <form method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/UserController.php" class="zoom-in" enctype="multipart/form-data">
                                        <?php echo FormPrimaryInputs(true, [
                                            "UserId" => $UserID
                                        ]); ?>
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Salutation</label>
                                                <select class="form-select" name="UserSalutation" required>
                                                    <?php echo InputOptionsWithKey(SALUTATION, FETCH($UserSQL, "UserSalutation")); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Full Name</label>
                                                <input type="text" class="form-control" value="<?php echo FETCH($UserSQL, "UserFullName"); ?>" name="UserFullName" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Phone Number <span id="PhoneMsg" class="text-danger"></span></label>
                                                <input type="tel" oninput="CheckPhoneNumber()" id="GetPhoneNumbers" class="form-control" name="UserPhoneNumber" value="<?php echo FETCH($UserSQL, "UserPhoneNumber"); ?>" required maxlength="5">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email <span id="EmailMsg" class="text-danger"></span></label>
                                                <input type="email" oninput="CheckEmailId()" id="GetEmailIds" class="form-control" value="<?php echo FETCH($UserSQL, "UserEmailId"); ?>" name="UserEmailId" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control" name="UserCompanyName" value="<?php echo FETCH($UserSQL, "UserCompanyName"); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Designation</label>
                                                <input type="text" class="form-control" name="UserDesignation" value="<?php echo FETCH($UserSQL, "UserDesignation"); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Reporting Manager Will Be</label>
                                                <select name="UserReportingManager" class="form-control" required="">
                                                    <option value="">Select Reporting Manager</option>
                                                    <?php
                                                    $GetAllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1' ORDER BY UserFullName", true);
                                                    if ($GetAllUsers != null) {
                                                        foreach ($GetAllUsers as $Users) {
                                                            $SelectedUser = CheckEquality($Users->UserId, FETCH($UserSQL, "UserReportingManager"), "selected");
                                                            echo '<option value="' . $Users->UserId . '" ' . $SelectedUser . '> ' . $Users->UserId . ' - ' . $Users->UserFullName . ' (' . $Users->UserPhoneNumber . ') </option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="UserDateOfBirth" value="<?php echo FETCH($UserSQL, "UserDateOfBirth"); ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">User Notes</label>
                                                <textarea class="form-control" name="UserNotes" rows="3"><?php echo SECURE(FETCH($UserSQL, "UserNotes"), "d"); ?></textarea>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Profile Image</label>
                                                <input type="file" class="form-control" onchange="PreviewImages('ProfileImage', 'PreviewOfProfile')" id="ProfileImage" name="UserProfileImage" accept="image/*">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="img-preview" id="PreviewOfProfile">
                                                    <img src="<?php echo $Dir; ?>/uploads/users/default.png" class="img-fluid" style="max-height: 100px;">
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <hr>
                                                <button type="submit" name="UpdatePrimaryProfile" class="btn btn-primary slide-in">Update Primary Profile <i class="bi bi-check-circle"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Update Address Tab -->
                                <div class="tab-pane fade" id="address" role="tabpanel">
                                    <form method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/UserController.php" class="zoom-in">
                                        <?php echo FormPrimaryInputs(true, [
                                            "UserAddressId" => UserAddress($UserID, "UserAddressId")
                                        ]); ?>
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Street Address</label>
                                                <textarea class="form-control" name="UserStreetAddress" rows="2"><?php echo UserAddress($UserID, "UserStreetAddress"); ?></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Locality</label>
                                                <input type="text" class="form-control" name="UserLocality" value="<?php echo UserAddress($UserID, "UserLocality"); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="UserCity" value="<?php echo UserAddress($UserID, "UserCity"); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control" name="UserState" value="<?php echo UserAddress($UserID, "UserState"); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Country</label>
                                                <input type="text" class="form-control" name="UserCountry" value="<?php echo UserAddress($UserID, "UserCountry"); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Pincode</label>
                                                <input type="text" class="form-control" name="UserPincode" maxlength="6" value="<?php echo UserAddress($UserID, "UserPincode"); ?>">
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <hr>
                                                <button type="submit" name="UpdateUserAddresses" class="btn btn-primary slide-in">Update Address <i class="bi bi-check-circle"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Login & Security Tab -->
                                <div class="tab-pane fade" id="security" role="tabpanel">
                                    <form method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/UserController.php" class="zoom-in">
                                        <?php echo FormPrimaryInputs(true, [
                                            "ForUserId" => $UserID
                                        ]); ?>
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Login Mail-id/UserName</label>
                                                <div class="input-group">
                                                    <input type="text" readonly="" class="form-control" value="<?php echo FETCH($UserSQL, "UserEmailId"); ?>" id="EmailidCurrent">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="copyPassword('EmailidCurrent')">
                                                        <i class="bi bi-clipboard"></i> Copy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Current Password <span id="CurrentPasswordMsg" class="text-danger"></span></label>
                                                <div class="input-group">
                                                    <input type="text" readonly="" class="form-control" value="<?php echo FETCH($UserSQL, "UserPassword"); ?>" name="CurrentPassword" id="CurrentPassword" oninput="CheckCurrentPassword()">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="copyPassword('CurrentPassword')">
                                                        <i class="bi bi-clipboard"></i> Copy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">New Password <span id="NewPasswordMsg" class="text-danger"></span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="NewPassword" id="NewPassword" oninput="CheckNewPassword()">
                                                    <span class="input-group-text password-toggle" onclick="togglePassword('NewPassword')"><i class="bi bi-eye"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Re-enter New Password <span id="ConfirmPasswordMsg" class="text-danger"></span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="ConfirmPassword" id="ConfirmPassword" oninput="CheckConfirmPassword()">
                                                    <span class="input-group-text password-toggle" onclick="togglePassword('ConfirmPassword')"><i class="bi bi-eye"></i></span>
                                                </div>
                                            </div>
                                            <!-- Rest of the form remains the same -->
                                            <div class="col-md-6">
                                                <label class="form-label">User Status</label>
                                                <select class="form-select" name="UserStatus" required>
                                                    <?php echo InputOptionsWithKey([
                                                        "" => "Select Status",
                                                        "1" => "Active",
                                                        "2" => "In-Active"
                                                    ], FETCH($UserSQL, "UserStatus")); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">User Type</label><br>
                                                <div class="btn-group" role="group">
                                                    <?php
                                                    $UserType = FETCH($UserSQL, "UserType");
                                                    foreach (APP_SIDE_BARS as $TypeKeys => $Access) {
                                                        $ActiveAccess = CheckEquality($TypeKeys, $UserType, "active text-white");
                                                        $Checked = CheckEquality($TypeKeys, $UserType, "checked"); ?>
                                                        <label class="btn btn-outline-danger user-type-btn mr-2 <?php echo $ActiveAccess; ?>" for="type<?php echo $TypeKeys; ?>">
                                                            <input type="radio" class="d-none" <?php echo $Checked; ?> name="UserType" value="<?php echo $TypeKeys; ?>" id="type<?php echo $TypeKeys; ?>">
                                                            <i class="<?php echo $Access['icon']; ?> me-1"></i><?php echo $TypeKeys; ?>
                                                        </label>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-right">
                                                <hr>
                                                <button type="submit" name="UpdateSecurityForAppUsers" class="btn btn-primary slide-in">Update Security <i class="bi bi-check-circle"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Login Logs Tab -->
                                <div class="tab-pane fade" id="logs" role="tabpanel">
                                    <div class="table-responsive zoom-in">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Title</th>
                                                    <th>Login Date</th>
                                                    <th>LogType</th>
                                                    <th>Env</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $AllLoginLogs = SET_SQL("SELECT * FROM systemlogs WHERE logbyUserId='$UserID'", true);
                                                if ($AllLoginLogs != null) {
                                                    $SerialNo = 0;
                                                    foreach ($AllLoginLogs as $logins) {
                                                        $SerialNo++; ?>
                                                        <tr>
                                                            <td><?php echo $SerialNo; ?></td>
                                                            <td><?php echo $logins->logTitle; ?></td>
                                                            <td><?php echo $logins->created_at; ?></td>
                                                            <td><?php echo $logins->logtype; ?></td>
                                                            <td><?php echo $logins->logenv; ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-xs btn-dark" onclick="ControlForms('LogDetails_<?php echo $logins->LogsId; ?>')">
                                                                    <i class="fa fa-eye"></i> View Details
                                                                </button>
                                                                <section class="pop-section hidden" id="LogDetails_<?php echo $logins->LogsId; ?>">
                                                                    <div class="action-window w-75">
                                                                        <div class="container mt-3 mb-3">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <h5 class="app-heading"><i class="bi bi-clock-history text-primary"></i> Login Log Details</h5>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="card shadow-sm border-0">
                                                                                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                                                            <span><?php echo $logins->logTitle; ?></span>
                                                                                            <button type="button" class="btn-close btn-close-white" onclick="ControlForms('LogDetails_<?php echo $logins->LogsId; ?>')" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="card-body bg-light">
                                                                                            <div class="row g-3">
                                                                                                <div class="col-md-6">
                                                                                                    <p><strong>Log ID:</strong> <?php echo $logins->LogsId; ?></p>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <p><strong>Login Date:</strong> <?php echo $logins->created_at; ?></p>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <p><strong>Log Type:</strong> <span class="badge bg-info"><?php echo $logins->logtype; ?></span></p>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <p><strong>Environment:</strong> <span class="badge bg-secondary"><?php echo $logins->logenv; ?></span></p>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <p><strong>Description:</strong> <?php echo SECURE($logins->logdesc, "d"); ?></p>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <p><strong>System Info:</strong>
                                                                                                    <pre class="bg-white p-2 rounded"><?php echo SECURE($logins->systeminfo, "d"); ?></pre>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="card-footer text-right bg-transparent">
                                                                                            <button class="btn btn-dark btn-md" onclick="ControlForms('LogDetails_<?php echo $logins->LogsId; ?>')"><i class="bi bi-x-circle"></i> Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } else {
                                                    echo "<tr><td colspan='6' align='center'>No Login Logs Found.</td></tr>";
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Single Modal (Add at the bottom of your body) -->
                                <div id="logModal" class="modal">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 id="modalTitle"></h5>
                                                <button type="button" class="close" onclick="closeModal()">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Log Description:</strong> <span id="modalDesc"></span></p>
                                                <p><strong>System Info:</strong> <span id="modalSysInfo"></span></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
    <script>
        // Validation Functions
        <?php
        $AllPhoneNumbers = SET_SQL("SELECT UserPhoneNumber FROM users ORDER BY UserPhoneNumber ASC", true);
        $PhoneNumber = "";
        if ($AllPhoneNumbers != null) {
            foreach ($AllPhoneNumbers as $PhoneNumbers) {
                $PhoneNumber .= "'" . $PhoneNumbers->UserPhoneNumber . "',";
            }
        }
        $AllEmailIds = SET_SQL("SELECT UserEmailId FROM users ORDER BY UserEmailId ASC", true);
        $EmailIds = "";
        if ($AllEmailIds != null) {
            foreach ($AllEmailIds as $EmailId) {
                $EmailIds .= "'" . $EmailId->UserEmailId . "',";
            }
        }
        ?>
        var PhoneNumbers = [<?php echo rtrim($PhoneNumber, ','); ?>];
        var EmailIds = [<?php echo rtrim($EmailIds, ','); ?>];

        function CheckPhoneNumber() {
            const phoneInput = document.getElementById('GetPhoneNumbers');
            const phoneMsg = document.getElementById('PhoneMsg');
            const phoneValue = phoneInput.value.trim();
            const phoneRegex = /^[0-9]{10}$/;
            if (phoneValue === '') {
                phoneMsg.innerHTML = 'Phone number is required';
                phoneInput.classList.add('is-invalid');
            } else if (!phoneRegex.test(phoneValue)) {
                phoneMsg.innerHTML = 'Enter exactly 10 digits';
                phoneInput.classList.add('is-invalid');
            } else if (PhoneNumbers.includes(phoneValue)) {
                phoneMsg.innerHTML = 'Phone number already exists';
                phoneInput.classList.add('is-invalid');
            } else {
                phoneMsg.innerHTML = '<i class="bi bi-check-circle text-success"></i>';
                phoneInput.classList.remove('is-invalid');
                phoneInput.classList.add('is-valid');
            }
        }

        function CheckEmailId() {
            const emailInput = document.getElementById('GetEmailIds');
            const emailMsg = document.getElementById('EmailMsg');
            const emailValue = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailValue === '') {
                emailMsg.innerHTML = 'Email is required';
                emailInput.classList.add('is-invalid');
            } else if (!emailRegex.test(emailValue)) {
                emailMsg.innerHTML = 'Invalid email format';
                emailInput.classList.add('is-invalid');
            } else if (EmailIds.includes(emailValue)) {
                emailMsg.innerHTML = 'Email already exists';
                emailInput.classList.add('is-invalid');
            } else {
                emailMsg.innerHTML = '<i class="bi bi-check-circle text-success"></i>';
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
            }
        }

        // Add this new function
        function copyPassword(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            // Optional: Add a temporary "Copied!" feedback
            const button = input.nextElementSibling;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check2"></i> Copied!';
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 5000);
        }

        function CheckNewPassword() {
            const newPw = document.getElementById('NewPassword');
            const newMsg = document.getElementById('NewPasswordMsg');
            const value = newPw.value.trim();
            const pwRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{7,}$/;
            if (value === '') {
                newMsg.innerHTML = '';
                newPw.classList.remove('is-invalid', 'is-valid');
            } else if (!pwRegex.test(value)) {
                newMsg.innerHTML = '';
                newPw.classList.add('');
            } else {
                newMsg.innerHTML = '<i class="bi bi-check-circle text-success"></i>';
                newPw.classList.remove('is-invalid');
                newPw.classList.add('is-valid');
            }
            CheckConfirmPassword();
        }

        function CheckConfirmPassword() {
            const newPw = document.getElementById('NewPassword');
            const confirmPw = document.getElementById('ConfirmPassword');
            const confirmMsg = document.getElementById('ConfirmPasswordMsg');
            const newValue = newPw.value.trim();
            const confirmValue = confirmPw.value.trim();
            if (confirmValue === '') {
                confirmMsg.innerHTML = '';
                confirmPw.classList.remove('is-invalid', 'is-valid');
            } else if (newValue !== confirmValue) {
                confirmMsg.innerHTML = 'Passwords do not match';
                confirmPw.classList.add('is-invalid');
            } else {
                confirmMsg.innerHTML = '<i class="bi bi-check-circle text-success"></i>';
                confirmPw.classList.remove('is-invalid');
                confirmPw.classList.add('is-valid');
            }
        }

        // Toggle Password Visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // User type button toggle
        document.querySelectorAll('.user-type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.user-type-btn').forEach(b => {
                    b.classList.remove('active', 'text-white');
                    b.classList.add('text-black');
                });
                this.classList.add('active', 'text-white');
                this.classList.remove('text-black');
            });
        });

        // Image Preview Function
        function PreviewImages(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 100px;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>