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

<body class="pb-5 mb-5">
    <?php include_once $Dir . "/include/Header.php"; ?>
    <?php include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main p-0 mt-4 pt-5">
        <div class="container-fluid mt-0">
            <div class="row mt-0">
                <div class="col-12 col-md-12 text-md-end action-buttons mb-2">
                    <div class="d-flex justify-content-md-end gap-2">
                        <button class="btn btn-danger flex-fill btn-sm" data-bs-toggle="modal" data-bs-target="#addCallFeedbackModal">
                            <i class="bi bi-plus-circle me-1"></i>Add Feedback
                        </button>
                        <button class="btn btn-danger flex-fill btn-sm" data-bs-toggle="modal" data-bs-target="#addReminderModal">
                            <i class="bi bi-plus-circle me-1"></i>Add Reminder
                        </button>
                        <button class="btn btn-danger flex-fill btn-sm" data-bs-toggle="modal" data-bs-target="#addSiteVisitModal">
                            <i class="bi bi-plus-circle me-1"></i>Add Visit
                        </button>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <?php include "views/LeadsDetailedView.php"; ?>
                </div>
                <!-- Leads Details (col-md-3) -->
                <div class="col-md-12 mt-2">
                    <!-- Tabs Navigation -->
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link active w-100" style="font-size: 0.85rem; padding: 0.25rem 0.85rem; border-radius: 10rem !important;" id="call-feedback-tab" data-bs-toggle="tab" data-bs-target="#call-feedback" type="button" role="tab" aria-controls="call-feedback" aria-selected="true">
                                <i class="bi bi-telephone-fill me-2"></i>Call Activities
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" style="font-size: 0.85rem; padding: 0.25rem 0.85rem; border-radius: 10rem !important;" id="reminders-tab" data-bs-toggle="tab" data-bs-target="#reminders" type="button" role="tab" aria-controls="reminders" aria-selected="false">
                                <i class="bi bi-bell-fill me-2"></i>Reminders
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" style="font-size: 0.85rem; padding: 0.25rem 0.85rem;border-radius: 10rem !important;" id="site-visits-tab" data-bs-toggle="tab" data-bs-target="#site-visits" type="button" role="tab" aria-controls="site-visits" aria-selected="false">
                                <i class="bi bi-geo-alt-fill me-2"></i>Site Visits
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="activityTabContent">
                        <?php
                        include "CallActivities.php";
                        include "Reminders.php";
                        include "SiteVisits.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include_once $Dir . "/include/Footer.php"; ?>
    <?php include_once $Dir . "/assets/FooterScripts.php"; ?>

</body>