<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = "Leads Details";
$PageDescription = "Detailed view of lead activities and contact information for APP_NAME";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

$LeadsId = ReturnSessionalValues("leadsid", "ACTIVE_LEADS_ID", null);
$LeadsSQL = "SELECT * FROM leads where leads_id='$LeadsId'";
HandleInvalidData(TOTAL($LeadsSQL), "../");

//More Leads SQL
$LeadsAddressSQL = "SELECT * FROM leads_address where leads_main_id='$LeadsId'";
$LeadActivitySQL = "SELECT * FROM leads_activities where leads_activity_main_leads_id='$LeadsId'";
$LeadsAssignedSQL = "SELECT * FROM leads_assignees where leads_main_id='$LeadsId'";
$LeadsAttributesSQL = "SELECT * FROM leads_attributes where leads_main_id='$LeadsId'";
$LeadsReminderSQL = "SELECT * FROM leads_reminders where leads_reminder_main_leads_id='$LeadsId'";
$LeadsRequirementSQL = "SELECT * FROM leads_requirements where leads_main_id='$LeadsId'";
$ProjectsID = FETCH($LeadsRequirementSQL, "leads_project_id");
$ProjectSQL = "SELECT * FROM projects WHERE projects_id='$ProjectsID'";
$DeveloperID = FETCH($ProjectSQL, "projects_developed_by");
$DeveloperSQL = "SELECT * FROM projects_developers where projects_developers_id='$DeveloperID'";
$LeadsSiteVisitSQL = "SELECT * FROM leads_site_visits where leads_main_leads_id='$LeadsId'";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | APP_NAME</title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="APP_NAME">
    <meta name="description" content="<?php echo $PageDescription; ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inline CSS for Timeline Line (Bootstrap-only approach uses border-start) -->
    <style>
        .timeline {
            padding-left: 20px;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-point {
            z-index: 1;
        }

        .timeline-content {
            position: relative;
        }
    </style>


    <style>
        .voice-equalizer {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 1px;
        }

        .voice-equalizer span {
            width: 3px;
            height: 8px;
            background: #fff;
            animation: equalizer 0.5s infinite alternate;
        }

        .voice-equalizer span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .voice-equalizer span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes equalizer {
            0% {
                height: 4px;
            }

            100% {
                height: 8px;
            }
        }

        #voiceTypingBtn .voice-equalizer span {
            background: #007bff;
        }

        #startRecordingBtn .voice-equalizer span {
            background: #28a745;
        }
    </style>
</head>

<body>
    <?php include_once $Dir . "/include/Header.php"; ?>
    <?php include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-12 col-md-4">
                    <h1 class="fw-bold"><i class="bi bi-person-lines-fill text-primary"></i> Leads Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/contacts">Leads</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo FETCH($LeadsSQL, "leads_full_name"); ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-8 text-md-end action-buttons">
                    <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                        <i class="bi bi-pencil-square"></i> Update Profile
                    </button>
                </div>
            </div>

            <div class="row">
                <!-- Leads Details (col-md-3) -->
                <div class="col-md-5">
                    <?php include "views/LeadsDetailedView.php"; ?>
                </div>

                <div class="col-md-7">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="call-feedback-tab" data-bs-toggle="tab" data-bs-target="#call-feedback" type="button" role="tab" aria-controls="call-feedback" aria-selected="true">
                                        <i class="bi bi-telephone-fill me-2"></i>Call Feedback
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reminders-tab" data-bs-toggle="tab" data-bs-target="#reminders" type="button" role="tab" aria-controls="reminders" aria-selected="false">
                                        <i class="bi bi-bell-fill me-2"></i>Reminders
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="site-visits-tab" data-bs-toggle="tab" data-bs-target="#site-visits" type="button" role="tab" aria-controls="site-visits" aria-selected="false">
                                        <i class="bi bi-geo-alt-fill me-2"></i>Site Visits
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3" id="activityTabContent">
                                <!-- Call Feedback Tab -->
                                <div class="tab-pane fade show active" id="call-feedback" role="tabpanel" aria-labelledby="call-feedback-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="app-sub-heading text-primary fw-bold"><i class="bi bi-telephone-fill me-2"></i>Call Feedback</h5>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCallFeedbackModal">
                                            <i class="bi bi-plus-circle me-1"></i>Add Call
                                        </button>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-4">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-muted">Total Calls</strong><br>
                                                <span class="display-6 text-primary fw-bold">
                                                    <?php echo TOTAL($LeadActivitySQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-muted">Incoming Calls</strong><br>
                                                <span class="display-6 text-success fw-bold">
                                                    <?php echo TOTAL($LeadActivitySQL . " and leads_activity_type='INCOMING'"); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-muted">Outgoing Calls</strong><br>
                                                <span class="display-6 text-info fw-bold">
                                                    <?php echo TOTAL($LeadActivitySQL . " and leads_activity_type='OUTGOING'"); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="timeline list-unstyled position-relative" style="max-height: 50rem; overflow-y: auto;">
                                        <?php
                                        $AllCalFeedBacks = SET_SQL($LeadActivitySQL . " ORDER BY leads_acitivity_id ASC", true);
                                        if ($AllCalFeedBacks != null) {
                                            foreach ($AllCalFeedBacks as $Calls) { ?>
                                                <li class="timeline-item mb-4 position-relative">
                                                    <div class="d-flex align-items-start">
                                                        <!-- Milestone Point (Date and Time) -->
                                                        <div class="flex-shrink-0 me-3 text-center">
                                                            <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $Calls->leads_activity_date_time); ?></span><br>
                                                            <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?></small>
                                                            <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 10px; left: 1px;"></div>
                                                        </div>
                                                        <!-- Timeline Content -->
                                                        <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <?php if (UpperCase($Calls->leads_activity_type) == "OUTGOING") { ?>
                                                                    <strong class="text-info m-1"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                                                                <?php } else { ?>
                                                                    <strong class="text-primary m-1"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                                                                <?php } ?>
                                                                <span class="badge bg-primary m-1"><?php echo FETCH("SELECT config_leads_stages_name FROM config_leads_stages where config_leads_stages_id='" . $Calls->leads_acitivity_call_status . "'", "config_leads_stages_name"); ?></span>
                                                                <span class="badge bg-success m-1"><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Calls->leads_acitivity_call_sub_status . "'", "config_leads_stage_name"); ?></span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="detail-title fw-bold">Duration/Time:</span>
                                                                <?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?>
                                                                <span class="text-right pull-right shadow-sm br-1 p-1">
                                                                    <span class="text-primary"><?php echo $Calls->leads_activity_call_source; ?></span>
                                                                    <span class="text-info"><?php echo $Calls->leads_activity_call_method; ?></span>
                                                                </span>
                                                                <br>
                                                                <span class="detail-title fw-bold">By:</span>
                                                                (UID<?php echo $Calls->leads_activity_created_by; ?>)-
                                                                <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Calls->leads_activity_created_by . "'", "UserFullName"); ?>
                                                                <br>
                                                                <span class="detail-title fw-bold">Remarks:</span>
                                                                <?php echo SECURE($Calls->leads_activity_feedbacks, "d"); ?>
                                                                <!-- Voice Note Playback -->
                                                                <?php if ($Calls->leads_activity_have_voice_notes == 1) {
                                                                    $VoiceNoteFile = $Calls->leads_activity_voice_notes_file;
                                                                    $StoragePath =  "../../../storage/leads/audios/$LeadsId";
                                                                    $VoiceNoteFullPath = "$StoragePath/$VoiceNoteFile";
                                                                ?>
                                                                    <div class="mt-2">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <audio controls class="w-100">
                                                                                <source src="<?php echo $VoiceNoteFullPath; ?>" type="audio/mp3">
                                                                                <source src="<?php echo $VoiceNoteFullPath; ?>" type="audio/mp3">
                                                                            </audio>
                                                                        </div>
                                                                        <small class="text-muted d-block mt-1">Attached Voice Note (<?php echo $VoiceNoteFile; ?>)</small>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation"></i>
                                                No Activity Found!
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>

                                <!-- Reminders Tab -->
                                <div class="tab-pane fade" id="reminders" role="tabpanel" aria-labelledby="reminders-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="app-sub-heading text-primary fw-bold"><i class="bi bi-bell-fill me-2"></i>Reminders</h5>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addReminderModal">
                                            <i class="bi bi-plus-circle me-1"></i>Add Reminder
                                        </button>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-4">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-primary">All Reminders</strong><br>
                                                <span class="display-6 text-primary fw-bold">
                                                    <?php echo TOTAL($LeadsReminderSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-success">Scheduled Reminders</strong><br>
                                                <span class="display-6 text-success fw-bold">
                                                    <?php echo TOTAL($LeadsReminderSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-danger">Missed Reminders</strong><br>
                                                <span class="display-6 text-danger fw-bold">
                                                    <?php echo TOTAL($LeadsReminderSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="timeline list-unstyled position-relative" style="max-height: 50rem; overflow-y: auto;">
                                        <?php
                                        $AllReminderList = SET_SQL($LeadsReminderSQL . " ORDER BY leads_reminder_id DESC", true);
                                        if ($AllReminderList != null) {
                                            foreach ($AllReminderList as $Reminders) { ?>
                                                <li class="timeline-item mb-4 position-relative">
                                                    <div class="d-flex align-items-start">
                                                        <!-- Milestone Point (Date and Time) -->
                                                        <div class="flex-shrink-0 me-3 text-center">
                                                            <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $Reminders->leads_reminder_created_at); ?></span><br>
                                                            <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $Reminders->leads_reminder_created_at); ?></small>
                                                            <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 10px; left: 1px;"></div>
                                                        </div>
                                                        <!-- Timeline Content -->
                                                        <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <strong class="text-primary m-1"><?php echo UpperCase($Reminders->leads_reminder_name); ?></strong>
                                                                <span class="badge bg-danger m-1">
                                                                    <?php echo StatusViewWithText($Reminders->leads_reminder_status); ?>
                                                                </span>
                                                                <span class="badge bg-primary m-1"><?php echo DATE_FORMATES("d M, Y", $Reminders->leads_reminder_date); ?></span>
                                                                <span class="badge bg-success m-1"><i class="bi bi-bell"></i> <?php echo DATE_FORMATES("h:i A", $Reminders->leads_reminder_time); ?></span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="detail-title fw-bold">Scheduled For :</span>
                                                                <?php echo DATE_FORMATES("d M, y", $Reminders->leads_reminder_date); ?>
                                                                <?php echo DATE_FORMATES("h:i A", $Reminders->leads_reminder_time); ?>
                                                                <span class="text-right pull-right shadow-sm br-1 p-1">
                                                                    Re-Reminder @ <span class="text-primary"><?php echo $Reminders->leads_reminder_re_remind_time; ?></span>
                                                                </span>
                                                                <br>
                                                                <span class="detail-title fw-bold">By:</span>
                                                                (UID<?php echo $Reminders->leads_reminder_created_by; ?>)-
                                                                <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Reminders->leads_reminder_created_by . "'", "UserFullName"); ?>
                                                                <br>
                                                                <span class="detail-title fw-bold">Reminder Note:</span>
                                                                <?php echo SECURE($Reminders->leads_reminder_notes, "d"); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation"></i>
                                                No Reminders Found!
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>

                                <!-- Site Visits Tab -->
                                <div class="tab-pane fade" id="site-visits" role="tabpanel" aria-labelledby="site-visits-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="app-sub-heading text-primary fw-bold"><i class="bi bi-geo-alt-fill me-2"></i>Site Visits</h5>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSiteVisitModal">
                                            <i class="bi bi-plus-circle me-1"></i>Add Visit
                                        </button>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6 mb-2">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-primary">All Site Visits</strong><br>
                                                <span class="display-6 text-primary fw-bold">
                                                    <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-info">Scheduled Site Visits</strong><br>
                                                <span class="display-6 text-info fw-bold">
                                                    <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-success">Completed Site Visits</strong><br>
                                                <span class="display-6 text-success fw-bold">
                                                    <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                                <strong class="text-danger">Cancelled Site Visits</strong><br>
                                                <span class="display-6 text-danger fw-bold">
                                                    <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="timeline list-unstyled position-relative" style="max-height: 50rem; overflow-y: auto;">
                                        <?php
                                        $AllSiteVisits = SET_SQL($LeadsSiteVisitSQL . " ORDER BY leads_site_visit_id ASC", true);
                                        if ($AllSiteVisits != null) {
                                            foreach ($AllSiteVisits as $SiteVisits) { ?>
                                                <li class="timeline-item mb-4 position-relative">
                                                    <div class="d-flex align-items-start">
                                                        <!-- Milestone Point (Date and Time) -->
                                                        <div class="flex-shrink-0 me-3 text-center">
                                                            <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $SiteVisits->leads_site_visit_added_on); ?></span><br>
                                                            <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $SiteVisits->leads_site_visit_added_on); ?></small>
                                                            <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 10px; left: 1px;"></div>
                                                        </div>
                                                        <!-- Timeline Content -->
                                                        <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <strong class="text-primary m-1"><?php echo UpperCase(FETCH("SELECT projects_name FROM projects where projects_id='" . $SiteVisits->leads_site_visits_projects_id . "'", "projects_name")); ?></strong>
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="detail-title fw-bold">Scheduled For :</span>
                                                                <?php echo DATE_FORMATES("d M, y", $SiteVisits->leads_site_visit_schedule_date); ?>
                                                                <br>
                                                                <span class="detail-title fw-bold">By:</span>
                                                                (UID<?php echo $SiteVisits->leads_site_visit_handled_by; ?>)-
                                                                <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $SiteVisits->leads_site_visit_handled_by . "'", "UserFullName"); ?>
                                                                <br>
                                                                <span class="detail-title fw-bold">Reminder Note:</span>
                                                                <?php echo $SiteVisits->leads_site_visit_notes; ?>
                                                                <br>
                                                                <?php
                                                                $SiteVisitImages = SET_SQL("SELECT * FROM leads_site_visits_attachements where leads_activity_main_id='" . $SiteVisits->leads_site_visit_id . "'", true);
                                                                if ($SiteVisitImages != null) {
                                                                    foreach ($SiteVisitImages as $SiteVisitImage) {
                                                                ?>
                                                                        <a href="<?php echo STORAGE_URL; ?>/leads/site-visits/<?php echo $LeadsId . "/" . $SiteVisitImage->leads_activity_attached_file; ?>" target="_blank">
                                                                            <img src="<?php echo STORAGE_URL; ?>/leads/site-visits/<?php echo $LeadsId . "/" . $SiteVisitImage->leads_activity_attached_file; ?>" style="width:100px;height:100px;">
                                                                        </a>
                                                                <?php
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation"></i>
                                                No Site Visit Found!
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>

                            </div>

                            <!-- Site Visits Modal -->
                            <div class="modal fade" id="addSiteVisitModal" tabindex="-1" aria-labelledby="addSiteVisitModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header app-heading">
                                            <h5 class="modal-title" id="addSiteVisitModalLabel">Add Site Visit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" enctype="multipart/form-data">
                                                <?php echo FormPrimaryInputs(true, [
                                                    "leads_Id" => $LeadsId
                                                ]); ?>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Select Project For Visit</label>
                                                    <select class="form-select" name="leads_site_visits_projects_id" required>
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
                                                <div class="col-md-6 mb-3">
                                                    <label>Site Visit Status</label>
                                                    <select class="form-control" onchange="SiteVisitControll()" id='SiteVisitStatus' name="leads_site_visit_status">
                                                        <?php echo InputOptionsWithKey([
                                                            "1" => "Schedule Site Visit",
                                                            "2" => "Site Visit Done",
                                                            "3" => "Site Visit Re-Scheduled",
                                                            "4" => "Site Visit Cancelled"
                                                        ], "1"); ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="visitDate" class="form-label">Site Visit Date</label>
                                                    <input type="date" name="leads_site_visit_schedule_date" class="form-control" id="visitDate" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="visitRemarks" class="form-label">Remarks</label>
                                                    <textarea class="form-control" name="leads_site_visit_notes" id="visitRemarks" rows="3" placeholder="Enter remarks" required></textarea>
                                                </div>
                                                <div class="hidden" id='UploadImages'>
                                                    <div class="row mt-4 mb-3">
                                                        <div class="col-md-12 mb-3">
                                                            <label>Site Visit Response</label>
                                                            <textarea class="form-control" name="leads_site_visit_response" rows="2"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>Upload Site Visit Images (Multiple/Optional)</label>
                                                            <input type="file" class="form-control" onchange="PreviewImages('feedbackFilesInput', 'FeedBackImages')" name="leads_activity_attached_file[]" id="feedbackFilesInput" multiple accept="image/*">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="img-preview" id="FeedBackImages"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="AddSiteVisitRecords" class="btn btn-primary">Save Visit <i class="bi bi-check-circle text-success"></i></button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <script>
        function SiteVisitControll() {
            var SiteVisitStatus = document.getElementById("SiteVisitStatus");
            var UploadImages = document.getElementById("UploadImages");
            var inputs = UploadImages.getElementsByTagName("input"); // Get all input elements inside UploadImages

            if (SiteVisitStatus.value == "2") {
                UploadImages.style.display = "block";
                // Make all inputs required
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].setAttribute("required", "required");
                }
            } else {
                UploadImages.style.display = "none";
                // Remove required attribute from all inputs
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].removeAttribute("required");
                }
            }
        }
    </script>

    <!-- Update Profile Button -->
    <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
        <i class="bi bi-pencil-square"></i> Update Profile
    </button>

    <!-- Reminders Modal -->
    <div class="modal fade" id="addReminderModal" tabindex="-1" aria-labelledby="addReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header app-heading">
                    <h5 class="modal-title" id="addReminderModalLabel">Add Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST">
                        <?php echo FormPrimaryInputs(true, [
                            "leads_id" => $LeadsId,
                        ]); ?>
                        <div class="mb-3">
                            <label for="reminderName" class="form-label">Reminder Name</label>
                            <input type="text" name="leads_reminder_name" required class="form-control" id="reminderName" placeholder="e.g., Follow-up Call">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="reminderDate" class="form-label">Date</label>
                            <input type="date" min="<?php echo DATE('Y-m-d'); ?>" required min="<?php echo DATE('Y-m-d'); ?>" name="leads_reminder_date" class="form-control" id="reminderDate">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="reminderTime" class="form-label">Time</label>
                            <input type="time" name="leads_reminder_time" required min="<?php echo DATE('h:i A'); ?>" minlength="<?php echo DATE('h:i A'); ?>" class="form-control" id="reminderTime">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Re-Remind Before/Repeating</label>
                            <select class="form-control" name="leads_reminder_re_remind_time" required>
                                <option value="0">Select Interval</option>
                                <option value="0">No Re-Reminders</option>
                                <option value="15 Minutes">15 Minutes</option>
                                <option value="30 Minutes">30 Minutes</option>
                                <option value="45 Minutes">45 Minutes</option>
                                <option value="60 Minutes">1 Hour</option>
                                <option value="24 Hours">24 Hours</option>
                                <option value="48 Hours">48 Hour</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reminderNote" class="form-label">Reminder Note</label>
                            <textarea class="form-control" name="leads_reminder_notes" required id="reminderNote" rows="3" placeholder="Enter reminder details"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="AddLeadReminders" class="btn btn-primary">Save Reminder</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Call Feedback Modal -->
    <div class="modal fade" id="addCallFeedbackModal" tabindex="-1" aria-labelledby="addCallFeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header app-heading">
                    <h5 class="modal-title" id="addCallFeedbackModalLabel"><i class="bi bi-phone text-success"></i> Add Call Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" id="callFeedbackForm" enctype="multipart/form-data">
                        <?php echo FormPrimaryInputs(true, [
                            "Leads_Stage_Current" => FETCH($LeadsSQL, "leads_stages"),
                            "LeadsId" => $LeadsId
                        ]); ?>
                        <!-- Call Type Radio Buttons -->
                        <div class="mb-3">
                            <label class="form-label">Call Type</label>
                            <div class="d-flex gap-3">
                                <div class="form-check flex-fill">
                                    <input class="form-check-input" type="radio" name="leads_activity_type" id="callTypeIncoming" value="Incoming" checked>
                                    <label class="form-check-label" for="callTypeIncoming">Incoming</label>
                                </div>
                                <div class="form-check flex-fill">
                                    <input class="form-check-input" type="radio" name="leads_activity_type" id="callTypeOutgoing" value="Outgoing">
                                    <label class="form-check-label" for="callTypeOutgoing">Outgoing</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Add Call Status</label>
                            <select class="form-select" name="leads_acitivity_call_status" id="callStatus">
                                <option value="">Select Status</option>
                                <?php
                                $AllCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stages_name FROM config_leads_stages where config_leads_stages_status='1' ORDER BY config_leads_stages_id ASC", true);
                                if ($AllCallStatus != null) {
                                    foreach ($AllCallStatus as $CallStatus) {
                                        echo "<option value='" . $CallStatus->config_leads_stages_id . "'>" . $CallStatus->config_leads_stages_name . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">All Call Sub-Status</label>
                            <select class="form-select" name="leads_acitivity_call_sub_status" id="callSubStatus">
                                <option value="">Select Sub-Status</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Update Lead Stage</label>
                            <select class="form-select" name="leads_stages" required>
                                <option value="">Select Stage</option>
                                <?php
                                $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                                if ($AllLeadsStages != null) {
                                    foreach ($AllLeadsStages as $Stages) {
                                        $Selected = CheckEquality(FETCH($LeadsSQL, "leads_stages"), $Stages->config_leads_stages_id, "selected");
                                        echo "<option value='" . $Stages->config_leads_stages_id . "' $Selected>" . $Stages->config_leads_stage_name . "</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="callFeedback" class="form-label">Feedback</label>
                            <textarea class="form-control" name="leads_activity_feedbacks" id="callFeedback" rows="3" placeholder="Enter feedback"></textarea>
                        </div>

                        <!-- Voice Input Features -->
                        <div class="mb-3">
                            <div class="d-flex gap-2 position-relative">
                                <!-- Voice Typing Button -->
                                <button type="button" class="btn btn-outline-primary position-relative" id="voiceTypingBtn">
                                    <i class="bi bi-mic"></i> Voice Typing
                                    <div class="voice-equalizer d-none" id="voiceTypingEqualizer">
                                        <span></span><span></span><span></span>
                                    </div>
                                </button>

                                <!-- Voice Recording Button -->
                                <button type="button" class="btn btn-outline-success position-relative" id="startRecordingBtn">
                                    <i class="bi bi-record-circle"></i> Record Voice Note
                                    <div class="voice-equalizer d-none" id="recordingEqualizer">
                                        <span></span><span></span><span></span>
                                    </div>
                                </button>

                                <!-- Stop Recording Button (hidden initially) -->
                                <button type="button" class="btn btn-outline-danger d-none" id="stopRecordingBtn">
                                    <i class="bi bi-stop-circle"></i> Stop Recording
                                </button>
                            </div>

                            <!-- Recording Preview Section (hidden initially) -->
                            <div class="mt-3 d-none" id="recordingPreview">
                                <div class="d-flex align-items-center gap-2">
                                    <audio controls id="audioPreview" class="flex-grow-1"></audio>
                                    <button type="button" class="btn btn-sm btn-danger p-1" id="removeRecording" title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success p-1" id="reRecordBtn" title="Re-Record">
                                        <i class="bi bi-record-circle"></i>
                                    </button>
                                </div>
                                <small class="text-muted text-center d-block mt-2" id="recordingMessage">Recording audio is already attached in feedback for team head and admin. No need to re-attach, just submit.</small>
                            </div>

                            <!-- Hidden file input for storing recording -->
                            <input type="file" name="leads_activity_voice_notes_file" id="voiceRecordingInput" class="d-none" accept="audio/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="SaveCallFeedBack" form="callFeedbackForm" class="btn btn-primary" id="submitFeedback">Add FeedBack <i class="bi bi-plus text-success"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Voice Typing (unchanged)
        const voiceTypingBtn = document.getElementById('voiceTypingBtn');
        const callFeedback = document.getElementById('callFeedback');
        const voiceTypingEqualizer = document.getElementById('voiceTypingEqualizer');
        let recognition;
        let voiceTimeout;

        if ('webkitSpeechRecognition' in window) {
            recognition = new webkitSpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;

            recognition.onresult = function(event) {
                clearTimeout(voiceTimeout);
                let transcript = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    transcript += event.results[i][0].transcript;
                }
                callFeedback.value = transcript + ' ';
                voiceTimeout = setTimeout(checkVoiceInput, 5000);
            };

            recognition.onend = function() {
                voiceTypingBtn.innerHTML = '<i class="bi bi-mic"></i> Voice Typing';
                voiceTypingBtn.classList.remove('btn-primary');
                voiceTypingBtn.classList.add('btn-outline-primary');
                voiceTypingEqualizer.classList.add('d-none');
                clearTimeout(voiceTimeout);
            };

            function checkVoiceInput() {
                recognition.stop();
                alert('No voice input found! Please start saying feedback after clicking.');
            }

            voiceTypingBtn.addEventListener('click', function() {
                if (voiceTypingBtn.classList.contains('btn-outline-primary')) {
                    recognition.start();
                    voiceTypingBtn.innerHTML = '<i class="bi bi-mic-mute"></i> Stop Voice Typing';
                    voiceTypingBtn.classList.remove('btn-outline-primary');
                    voiceTypingBtn.classList.add('btn-primary');
                    voiceTypingEqualizer.classList.remove('d-none');
                    voiceTimeout = setTimeout(checkVoiceInput, 5000);
                } else {
                    recognition.stop();
                }
            });
        }

        // Voice Recording
        const startRecordingBtn = document.getElementById('startRecordingBtn');
        const stopRecordingBtn = document.getElementById('stopRecordingBtn');
        const recordingPreview = document.getElementById('recordingPreview');
        const audioPreview = document.getElementById('audioPreview');
        const removeRecording = document.getElementById('removeRecording');
        const reRecordBtn = document.getElementById('reRecordBtn');
        const voiceRecordingInput = document.getElementById('voiceRecordingInput');
        const recordingEqualizer = document.getElementById('recordingEqualizer');
        let mediaRecorder;
        let audioChunks = [];
        let isRecording = false;

        navigator.mediaDevices.getUserMedia({
                audio: true
            })
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);

                // Collect audio data as it becomes available
                mediaRecorder.ondataavailable = event => {
                    if (event.data.size > 0) { // Only push if there's actual data
                        audioChunks.push(event.data);
                    }
                };

                // Handle stopping the recording
                mediaRecorder.onstop = () => {
                    recordingEqualizer.classList.add('d-none');
                    startRecordingBtn.classList.remove('d-none');
                    stopRecordingBtn.classList.add('d-none');
                    isRecording = false;

                    if (audioChunks.length > 0 && audioChunks[0].size > 0) {
                        const audioBlob = new Blob(audioChunks, {
                            type: 'audio/ogg'
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        audioPreview.src = audioUrl;

                        // Generate filename with date-time, lead_id, and random string
                        const dateTime = new Date().toISOString().replace(/[:.]/g, '-');
                        const leadId = '<?php echo FETCH($LeadsSQL, "leads_id"); ?>'; // Assuming leads_id is available
                        const randomStr = Math.random().toString(36).substring(2, 8);
                        const fileName = `recording_${dateTime}_${leadId}_${randomStr}.mp3`;

                        // Convert Blob to File and attach to hidden input
                        const audioFile = new File([audioBlob], fileName, {
                            type: 'audio/ogg'
                        });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(audioFile);
                        voiceRecordingInput.files = dataTransfer.files;

                        // Show preview
                        recordingPreview.classList.remove('d-none');
                        alert('Recording attached with feedback.');
                    } else {
                        alert('No audio recorded! Please speak while recording.');
                    }
                    audioChunks = []; // Reset chunks after processing
                };

                // Start recording
                startRecordingBtn.addEventListener('click', () => {
                    if (!isRecording) {
                        audioChunks = [];
                        mediaRecorder.start(1000); // Collect data every 1 second
                        startRecordingBtn.classList.add('d-none');
                        stopRecordingBtn.classList.remove('d-none');
                        recordingEqualizer.classList.remove('d-none');
                        isRecording = true;
                    }
                });

                // Stop recording
                stopRecordingBtn.addEventListener('click', () => {
                    if (isRecording) {
                        mediaRecorder.stop();
                    }
                });

                // Remove recording
                removeRecording.addEventListener('click', () => {
                    recordingPreview.classList.add('d-none');
                    voiceRecordingInput.value = '';
                    audioPreview.src = '';
                    audioChunks = [];
                });

                // Re-record
                reRecordBtn.addEventListener('click', () => {
                    if (!isRecording) {
                        audioChunks = [];
                        mediaRecorder.start(1000); // Collect data every 1 second
                        recordingPreview.classList.add('d-none');
                        startRecordingBtn.classList.add('d-none');
                        stopRecordingBtn.classList.remove('d-none');
                        recordingEqualizer.classList.remove('d-none');
                        isRecording = true;
                    }
                });
            })
            .catch(err => {
                console.error('Error accessing microphone:', err);
                alert('Unable to access microphone. Please check permissions.');
            });
    </script>

    <script>
        // Call Status and Sub-Status Data
        const subStatusData = {
            <?php
            $AllCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stages_name FROM config_leads_stages WHERE config_leads_stages_status='1' ORDER BY config_leads_stages_id ASC", true);
            if ($AllCallStatus != null) {
                $output = [];
                foreach ($AllCallStatus as $MainCallStatus) {
                    $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_leads_stage_name FROM config_leads_sub_stages WHERE config_leads_sub_stages_main_id='" . $MainCallStatus->config_leads_stages_id . "'", true);
                    if ($AllCallSubStatus != null) {
                        $subStatusArray = [];
                        foreach ($AllCallSubStatus as $SubCallStatus) {
                            $subStatusArray[] = "{id: '" . $SubCallStatus->config_call_sub_status_id  . "', name: '" . $SubCallStatus->config_leads_stage_name . "'}";
                        }
                        $output[] = "'" . $MainCallStatus->config_leads_stages_id . "': [" . implode(',', $subStatusArray) . "]";
                    }
                }
                echo implode(',', $output);
            }
            ?>
        };

        // DOM Elements for Call Status
        const callStatusSelect = document.getElementById('callStatus');
        const callSubStatusSelect = document.getElementById('callSubStatus');

        // Populate Sub-Status based on Call Status
        callStatusSelect.addEventListener('change', function() {
            const selectedStatus = this.value;
            console.log('Selected Status:', selectedStatus, 'Data:', subStatusData[selectedStatus]);
            callSubStatusSelect.innerHTML = '<option value="">Select Sub-Status</option>';
            if (subStatusData[selectedStatus] && Array.isArray(subStatusData[selectedStatus])) {
                subStatusData[selectedStatus].forEach(subStatus => {
                    const option = new Option(subStatus.name, subStatus.id);
                    callSubStatusSelect.appendChild(option);
                });
                callSubStatusSelect.required = true;
            } else {
                callSubStatusSelect.required = false;
            }
        });
    </script>

    <?php include_once $Dir . "/include/Footer.php"; ?>
    <?php include_once $Dir . "/assets/FooterScripts.php"; ?>

</body>