<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];
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

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>

    <main id="main" class="main">
        <div class="pagetitle animate-fade-up">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-person text-danger bold"></i> Add New Contacts</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add New Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" enctype="multipart/form-data" class="row g-2" id="leadForm">
                            <?php echo FormPrimaryInputs(true); ?>

                            <!-- Personal Details -->
                            <div class="col-md-12">
                                <div class="card form-section">
                                    <div class="card-header" data-bs-toggle="collapse" data-bs-target="#personalDetails">
                                        <i class="bi bi-person-circle me-2"></i> Personal Details
                                    </div>
                                    <div id="personalDetails" class="collapse show">
                                        <div class="card-body pt-3">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="leads_full_name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" id="PhoneNumber" name="leads_phone_number" maxlength="10" pattern="[0-9]{10}" required>
                                                    <small id="phoneValidationMsg" class="form-text"></small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Alternative Phone Number</label>
                                                    <input type="tel" class="form-control" id="AltPhoneNumber" name="leads_alternate_phone" maxlength="10" pattern="[0-9]{10}">
                                                    <small id="altPhoneValidationMsg" class="form-text"></small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Email ID (optional)</label>
                                                    <input type="email" class="form-control" id="EmailId" name="leads_email_id">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Gender</label>
                                                    <select class="form-select" name="leads_gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Marital Status</label>
                                                    <select class="form-select" name="leads_marital_status">
                                                        <option value="">Select Status</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                        <option value="Widowed">Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Property Preferences -->
                            <div class="col-md-12">
                                <div class="card form-section">
                                    <div class="card-header" data-bs-toggle="collapse" data-bs-target="#propertyPreferences">
                                        <i class="bi bi-house-door me-2"></i> Property Preferences
                                    </div>
                                    <div id="propertyPreferences" class="collapse show">
                                        <div class="card-body pt-3">
                                            <div class="row g-2">
                                                <div class="col-md-3">
                                                    <label class="form-label">Select Project</label>
                                                    <select class="form-select" name="leads_project_id">
                                                        <option value="">Select Project</option>
                                                        <?php
                                                        $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                                                        if ($AllProjects != null) {
                                                            foreach ($AllProjects as $AllProject) {
                                                                $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                                                                $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                                                                $projects_id = $AllProject->projects_id;
                                                                $projects_name = $AllProject->projects_name;
                                                                echo "<option value='$projects_id'>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Budget Range</label>
                                                    <input type="text" class="form-control" name="leads_requirement_budgets" placeholder="e.g., 50L - 1Cr">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Preferred Location</label>
                                                    <select class="form-select" name="leads_requirement_preffered_location" required>
                                                        <option value="">Select Location</option>
                                                        <?php
                                                        $AllLocations = SET_SQL("SELECT config_projects_locations_id, config_projects_locations_name FROM config_projects_locations where config_projects_locations_status='1'", true);
                                                        if ($AllLocations != null) {
                                                            foreach ($AllLocations as $AllLocation) {
                                                                echo '<option value="' . $AllLocation->config_projects_locations_id . '">' . $AllLocation->config_projects_locations_name . '</option>';
                                                            }
                                                        } ?>
                                                        <option value="0">Others</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Purchase Duration</label>
                                                    <select class="form-select" name="leads_requirement_duration">
                                                        <option value="">Select Duration</option>
                                                        <option value="Within 1 Month">Within 1 Month</option>
                                                        <option value="2-3 Months">2-3 Months</option>
                                                        <option value="3-6 Months">3-6 Months</option>
                                                        <option value="6+ Months">6+ Months</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lead Details -->
                            <div class="col-md-12">
                                <div class="card form-section">
                                    <div class="card-header" data-bs-toggle="collapse" data-bs-target="#leadDetails">
                                        <i class="bi bi-briefcase me-2"></i> Lead Details
                                    </div>
                                    <div id="leadDetails" class="collapse show">
                                        <div class="card-body pt-3">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label">Lead Type</label>
                                                    <select class="form-select" name="leads_type" required>
                                                        <?php echo InputOptionsWithKey([
                                                            "" => "Select Status",
                                                            "DATA" => "DATA",
                                                            "LEAD" => "LEAD",
                                                        ], ""); ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Lead Source</label>
                                                    <select class="form-select" name="leads_source" required>
                                                        <option value="NEW">Select Source</option>
                                                        <?php
                                                        $AllLeadsSources = SET_SQL("SELECT config_leads_source_name, config_leads_source_id FROM config_leads_sources where config_leads_source_status='1' ORDER by config_leads_source_name ASC", true);
                                                        if ($AllLeadsSources != null) {
                                                            foreach ($AllLeadsSources as $Sources) {
                                                                echo "<option value='" . $Sources->config_leads_source_id . "'>" . $Sources->config_leads_source_name . "</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Resources/Vendor</label>
                                                    <select class="form-select form-control" name="leads_re_source" required>
                                                        <option value="NEW">Select Re Source</option>
                                                        <?php
                                                        $AllLeadsReSources = SET_SQL("SELECT config_leads_resources_name, config_leads_resources_id FROM config_leads_resources where config_leads_resources_status='1' ORDER by config_leads_resources_name ASC", true);
                                                        if ($AllLeadsReSources != null) {
                                                            foreach ($AllLeadsReSources as $ReSources) {
                                                                echo "<option value='" . $ReSources->config_leads_resources_id . "'>" . $ReSources->config_leads_resources_name . "</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Leads Assigned To</label>
                                                    <select class="form-select" name="leads_assigned_to" required>
                                                        <option value="0">Select User</option>
                                                        <?php
                                                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                                                        if ($AllUsers != null) {
                                                            foreach ($AllUsers as $Users) {
                                                                if ($Users->UserId == LOGIN_USER_ID) {
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Leads Created By</label>
                                                    <select class="form-select" name="leads_assigned_by" required>
                                                        <option value="0">Select User</option>
                                                        <?php
                                                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                                                        if ($AllUsers != null) {
                                                            foreach ($AllUsers as $Users) {
                                                                if ($Users->UserId == LOGIN_USER_ID) {
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions (Feedback, Reminder, Site Visit) -->
                            <div class="col-md-12">
                                <div class="card form-section">
                                    <div class="card-header">
                                        <i class="bi bi-gear me-2"></i> Actions
                                    </div>
                                    <div class="card-body pt-3">
                                        <ul class="nav nav-tabs action-tabs" id="actionTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" type="button" role="tab"><i class="bi bi-telephone me-1"></i> Add Call Feedback</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="reminder-tab" data-bs-toggle="tab" data-bs-target="#reminder" type="button" role="tab"><i class="bi bi-bell me-1"></i> Add Reminder</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sitevisit-tab" data-bs-toggle="tab" data-bs-target="#sitevisit" type="button" role="tab"><i class="bi bi-calendar-check me-1"></i> Add Site Visit</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="actionTabContent">
                                            <!-- Feedback Tab -->
                                            <div class="tab-pane fade show active animate-show" id="feedback" role="tabpanel">
                                                <div class="row g-2 pt-2">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Call Status</label>
                                                        <select class="form-select" name="leads_acitivity_call_status" id="callStatus">
                                                            <option value="">Select Status</option>
                                                            <?php
                                                            $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                                                            if ($AllLeadsStages != null) {
                                                                foreach ($AllLeadsStages as $Stages) {
                                                                    echo "<option value='" . $Stages->config_leads_stages_id . "'>" . $Stages->config_leads_stage_name . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Call Sub-Status</label>
                                                        <select class="form-select" name="leads_acitivity_call_sub_status" id="callSubStatus">
                                                            <option value="">Select Sub-Status</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control" name="leads_activity_feedbacks" id="feedbackRemarks" rows="2"></textarea>
                                                        <div class="voice-controls mt-2">
                                                            <button type="button" class="btn btn-sm btn-outline-primary" id="startSpeech"><i class="bi bi-mic"></i> Add Voice Input</button>
                                                            <button type="button" class="btn btn-sm btn-outline-success" id="startRecording"><i class="bi bi-record-circle"></i> Record Voice Note</button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" id="stopRecording" disabled><i class="bi bi-stop-circle"></i> Stop Recording</button>
                                                            <span class="recording-indicator" id="recordingIndicator" style="display: none;">Recording...</span>
                                                        </div>
                                                        <div class="voice-note-player mt-2" id="voiceNotePlayer" style="display: none;">
                                                            <audio controls id="recordedAudio"></audio>
                                                        </div>
                                                        <input type="file" name="leads_activity_voice_notes_file" id="voiceNoteInput" accept="audio/*" hidden>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Reminder Tab -->
                                            <div class="tab-pane fade animate-show" id="reminder" role="tabpanel">
                                                <div class="row g-2 pt-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Reminder Date & Time</label>
                                                        <input type="datetime-local" class="form-control" name="REMINDER_DATE_TIME">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Reminder Re-Remind Max Intervals</label>
                                                        <select class="form-control" name="leads_reminder_re_remind_time">
                                                            <option value="0">Select Interval</option>
                                                            <option value="0">No Re-Reminders</option>
                                                            <option value="15">15 Minutes</option>
                                                            <option value="30">30 Minutes</option>
                                                            <option value="45">45 Minutes</option>
                                                            <option value="60">1 Hour</option>
                                                            <option value="120">2 Hours</option>
                                                            <option value="180">3 Hours</option>
                                                            <option value="240">4 Hours</option>
                                                            <option value="480">8 Hours</option>
                                                            <option value="720">12 Hours</option>
                                                            <option value="1440">24 Hours</option>
                                                            <option value="2880">48 Hours</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control" name="REMINDER_REMARKS" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Site Visit Tab -->
                                            <div class="tab-pane fade animate-show" id="sitevisit" role="tabpanel">
                                                <div class="row g-2 pt-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Site Visit Date & Time</label>
                                                        <input type="datetime-local" class="form-control" name="SITE_VISIT_DATE_TIME">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Site Visit Status</label>
                                                        <select class="form-control" name="SITE_VISIT_STATUS">
                                                            <?php echo InputOptionsWithKey([
                                                                "1" => "Schedule Site Visit",
                                                                "2" => "Site Visit Done",
                                                                "3" => "Site Visit Cancelled"
                                                            ], "1"); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control" name="leads_site_visit_notes" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mt-4 mb-3">
                                                    <div class="col-md-4">
                                                        <label>Upload Site Visit Images (Multiple/Optional)</label>
                                                        <input type="file" class="form-control" onchange="PreviewImages('feedbackFilesInput', 'FeedBackImages')" name="leads_activity_attached_file[]" id="feedbackFilesInput" multiple accept="image/*">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="img-preview" id="FeedBackImages"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12 text-end">
                                <hr>
                                <button type="submit" class="btn btn-primary" name="AddNewContactRecords" id="submitBtn">Save This New Lead <i class="bi bi-check-circle"></i></button>
                                <a href="<?php echo DOMAIN; ?>" class="btn btn-secondary">Cancel <i class="bi bi-x-circle"></i></a>
                                <a href="#" class="btn btn-info" id="viewSavedLead" style="display: none;">View Saved Lead <i class="bi bi-eye"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    include_once "scripts.php";
    ?>
    <script src="add.js"></script>

</body>

</html>