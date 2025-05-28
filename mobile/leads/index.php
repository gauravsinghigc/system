<?php
$Dir = "../..";

require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "contacts", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

// Secure input
$searchPhone = isset($_GET['Search_Phone_Number']) ? trim($_GET['Search_Phone_Number']) : null;

// Get filters
$LeadsStageId = ReturnSessionalValues("leads_stages", "ACTIVE_LEAD_STAGE", IfSessionExists("ACTIVE_LEAD_STAGE", "1"));
$LeadsSubStageId = ReturnSessionalValues("leads_call_sub_status", "ACTIVE_LEAD_SUB_STAGE", IfSessionExists("ACTIVE_LEAD_SUB_STAGE", ""));
$LeadsTypeViewOnly = ReturnSessionalValues("leads_type", "ACTIVE_LEAD_TYPE_VIEW_ONLY", IfSessionExists("ACTIVE_LEAD_TYPE_VIEW_ONLY", ""));

// Build dynamic filters
$filters = [
    "leads_stages = '$LeadsStageId'",
    "leads_type LIKE '%$LeadsTypeViewOnly%'",
    "leads_managed_by = '" . LOGIN_USER_ID . "'"
];

if (!empty(trim($LeadsSubStageId))) {
    $filters[] = "leads_sub_stages='$LeadsSubStageId'";
}

if (!empty($searchPhone)) {
    $filters[] = "leads_phone_number LIKE '%" . mysqli_real_escape_string(DBConnection, $searchPhone) . "%'";
}

// Final SQL
$whereClause = implode(' AND ', $filters);
$AllLeadsSQL = "SELECT leads_assigned_date, leads_assigned_by, leads_projects_id, leads_stages, leads_sub_stages, leads_phone_number, leads_full_name, leads_id, leads_type FROM leads WHERE $whereClause and leads_is_removed!='1'";
$UserLeadsSQL = "SELECT leads_id FROM leads where leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed!='1'";
$PaginationTotalSQL = $AllLeadsSQL;

$PageName = FETCH("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stages_id='$LeadsStageId'", "config_leads_stage_name");
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
    <style>
        .list-container {
            max-width: 100%;
        }

        .lead-item {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            padding: 10px;
        }

        .lead-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
        }

        .lead-name {
            font-size: 0.85rem;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        .lead-name:hover {
            text-decoration: underline;
        }

        .details-row,
        .extra-details {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            font-size: 0.65rem;
        }

        .details-row span,
        .extra-details span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .call-action {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-size: 0.75rem;
            background: #28a745;
            border: none;
        }

        .call-action:hover {
            background: #218838;
        }

        .call-action i {
            font-size: 14px;
            color: #fff;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-success {
            color: #28a745 !important;
        }
    </style>
</head>

<body class="mb-5 pb-5 h-auto" style="height:100% !important;">
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main" style="height:100% !important;">
        <!-- Widget Counters -->
        <div class="row mb-1 animate-fade-up">
            <div class="col-md-11 mx-auto">
                <?php echo ClearFilters("Search_Phone_Number", "index.php"); ?>
            </div>
        </div>
        <div class="row mt-0 mb-1">
            <div class="col-md-12 mb-2">
                <form action="" method="GET">
                    <input type="number" class='form-control form-control-lg app-fs-3' value='<?php echo IfRequested("GET", "Search_Phone_Number", "", ""); ?>' name='Search_Phone_Number' placeholder="Search Phone Number...">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="sub-stage-counters">
                    <?php
                    $DefaultActiveMonths = ReturnSessionalValues("GET", "ActiveMonths", IfRequested("GET", "ActiveMonths", DATE('Y-m'), null));
                    // Fetch all stages at once
                    $AllStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC", true);

                    if ($AllStages != null) {
                        $ActiveColor = "";
                        foreach ($AllStages as $Stages) {
                            $stage_id = $Stages->config_leads_stages_id;
                            if ($LeadsStageId == $stage_id) {
                                $ActiveColor = $Stages->config_leads_stage_color_code;
                            }
                    ?>
                            <div class="app-widget-counter mb-2" style="max-width:17rem !important;min-width:17rem !important;">
                                <a href="<?php echo DOMAIN; ?>/mobile/leads?leads_stages=<?php echo $stage_id; ?>&leads_call_sub_status=">
                                    <div class="d-block pt-3 rounded-3 p-2 pb-0 mb-0 w-100" style="max-width:16rem !important;min-width:16rem !important;">
                                        <p class="text-secondary app-fs-2 mt-2 mb-0 p-1 circle bold w-100 d-block" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>">
                                            <span class="ml-2 text-black"><i class="fa fa-info-circle text-primary"></i> <?php echo $Stages->config_leads_stage_name; ?></span>
                                        </p>
                                        <h3 class="text-primary bold app-fs-5 mt-2"><?php echo TOTAL($UserLeadsSQL . " and leads_stages='$stage_id'"); ?></h3>
                                        <p class="text-muted pb-0 flex-s-b app-fs-2">
                                            <span class="w-50"><b>DATA :</b> <b><?php echo TOTAL($UserLeadsSQL . " and leads_stages='$stage_id' and leads_type='DATA'"); ?></b></span><br>
                                            <span class="w-50"><b>LEAD :</b> <b><?php echo TOTAL($UserLeadsSQL . " and leads_stages='$stage_id' and leads_type='LEAD'"); ?></b></span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="sub-stage-counters">
                    <?php
                    $SubStageSQL = SET_SQL("SELECT config_call_sub_status_id , config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_main_id='$LeadsStageId'", true);
                    if ($SubStageSQL != null) {
                        foreach ($SubStageSQL as $SubStage) { ?>
                            <div class="app-widget-counter" style="max-width:17rem !important;min-width:17rem !important;">
                                <a href="?leads_stages=<?php echo $LeadsStageId; ?>&leads_call_sub_status=<?php echo $SubStage->config_call_sub_status_id; ?>&leads_type=">
                                    <div class="d-block rounded-3 p-2 pb-0 mb-0" style="max-width:16rem !important;min-width:16rem !important;">
                                        <small class="text-secondary small mb-0 bold app-fs-2 bold p-1 circle w-100 d-block" style="background-color:<?php echo $ActiveColor; ?>">
                                            <span class="ml-1 mr-1"><i class="fa fa-info-circle text-primary"></i> <?php echo $SubStage->config_call_sub_status_name; ?></span>
                                        </small>
                                        <h3 class="text-primary bold app-fs-5 bold"><?php echo TOTAL($UserLeadsSQL . " and leads_stages='$LeadsStageId' and leads_sub_stages='" . $SubStage->config_call_sub_status_id  . "'"); ?></h3>
                                        <p class="text-muted pb-0 flex-s-b app-fs-2">
                                            <span><b>DATA :</b> <b><?php echo TOTAL($UserLeadsSQL . " and leads_stages='$LeadsStageId' and leads_sub_stages='" . $SubStage->config_call_sub_status_id  . "' and leads_type='DATA'"); ?></b></span><br>
                                            <span><b>LEAD :</b> <b><?php echo TOTAL($UserLeadsSQL . " and leads_stages='$LeadsStageId' and leads_sub_stages='" . $SubStage->config_call_sub_status_id  . "' and leads_type='LEAD'"); ?></b></span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>

        <div class="row mb-1 mt-3">
            <div class="col-md-6 col-6 col-sm-6">
                <a href="?leads_stages=<?php echo $LeadsStageId; ?>&leads_call_sub_status=<?php echo $LeadsSubStageId; ?>&leads_type=DATA" class="app-fs-3 btn-block bg-dark w-100 text-center d-block text-white p-2 br-1"><i class="bi bi-file-earmark-excel text-success"></i> DATA (<?php echo TOTAL($UserLeadsSQL . " and leads_stages='" . $LeadsStageId . "' and leads_type='DATA'"); ?>)</a>
            </div>
            <div class="col-md-6 col-6 col-sm-6">
                <a href="?leads_stages=<?php echo $LeadsStageId; ?>&leads_call_sub_status=<?php echo $LeadsSubStageId; ?>&leads_type=LEAD" class="app-fs-3 btn-block bg-primary d-block text-center text-white w-100 p-2 br-1"> <i class="fa fa-star text-warning"></i> LEADS (<?php echo TOTAL($UserLeadsSQL . " and leads_stages='" . $LeadsStageId . "' and leads_type='LEAD'"); ?>)</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="text-center mt-1 text-primary-2 mb-0">Latest Assigned Records are on top</p>
                <div class="list-container mt-2">
                    <?php
                    $StartFrom = APP_START_FROM;
                    $DisplayRecords = APP_RECORD_LISTING;
                    $ProcessSQL = SET_SQL($AllLeadsSQL . " ORDER BY DATE(leads_assigned_date) DESC limit $DisplayRecords OFFSET $StartFrom", true);
                    if ($ProcessSQL) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ProcessSQL as $Records) {
                            $SerialNo++;
                            $StageName = FETCH("SELECT config_leads_stage_name FROM config_leads_stages WHERE config_leads_stages_id='" . $Records->leads_stages . "'", "config_leads_stage_name");
                            $SubStageName = FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_id='" . $Records->leads_sub_stages . "'", "config_call_sub_status_name");
                            $ProjectName = FETCH("SELECT projects_name FROM projects WHERE projects_id='" . $Records->leads_projects_id . "'", "projects_name") ?: 'N/A';
                    ?>
                            <div class="lead-item shadow-sm rounded-4 p-2 mb-2 bg-light" style="line-height: 1.4rem !important;box-shadow:0px 0px 1px grey !important;">
                                <div class="position-relative">
                                    <!-- 📞 Call Button (Right Aligned & Vertically Centered) -->
                                    <div class="position-absolute end-0 top-50 translate-middle-y" style="margin-top: -0.4rem !important;">
                                        <a href="tel:<?php echo $Records->leads_phone_number; ?>" onclick="InstantFeedBackFormHandler('<?php echo $Records->leads_id; ?>','<?php echo $Records->leads_full_name; ?>', '<?php echo $Records->leads_phone_number; ?>', '<?php echo $Records->leads_type; ?>','<?php echo $StageName; ?>','<?php echo $SubStageName; ?>', '<?php echo $ProjectName; ?>', '<?php echo $Records->leads_projects_id; ?>')" class="app-fs-10 text-success" style="border-radius:50rem !important;">
                                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/call.png" loading="lazy" style="width:3.75rem;height:3.75rem;">
                                        </a>
                                        <a href="whatsapp://send?phone=<?php echo $Records->leads_phone_number; ?>&text=Hey *<?php echo $Records->leads_full_name; ?>* Sir, " onclick="InstantFeedBackFormHandler('<?php echo $Records->leads_id; ?>','<?php echo $Records->leads_full_name; ?>', '<?php echo $Records->leads_phone_number; ?>', '<?php echo $Records->leads_type; ?>','<?php echo $StageName; ?>','<?php echo $SubStageName; ?>', '<?php echo $ProjectName; ?>', '<?php echo $Records->leads_projects_id; ?>')" class="app-fs-10 text-success" style="border-radius:50rem !important;">
                                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/whatsapp.png" loading="lazy" style="width:3.75rem;height:3.75rem;">
                                        </a>
                                    </div>

                                    <!-- Row 1: Full Name + Assigned To (Right) -->
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <a href="<?php echo DOMAIN; ?>/mobile/leads/details?leadsid=<?php echo $Records->leads_id; ?>" class="text-primary fw-bold text-decoration-none" style="font-size: 16px !important;padding:0.2rem !important;line-height:1.4rem !important;">
                                            <?php if ($Records->leads_type == "LEAD") {
                                                $Color = "red";
                                            } else {
                                                $Color = "black";
                                            } ?>
                                            <span class="app-fs-2" style="color:<?php echo $Color; ?>;position:absolute;right:0.25rem;margin-top:-0.1rem;">
                                                <?php echo $Records->leads_type; ?> <span class="text-secondary">| <i class="fa fa-calendar me-1"></i><?php echo DATE_FORMATES("d M, Y", $Records->leads_assigned_date); ?></span>
                                            </span>
                                            <span class="app-fs-3 pl-0 ml-0 mb-0 text-primary bold"><i class="fa app-fs-3 fa-user text-success"></i> <?php echo $Records->leads_full_name; ?></span><br>
                                            <span class="app-fs-3 mb-0 mt-0 bold text-primary-2"><i class="fa fa-phone me-1 text-success app-fs-3"></i>+91-<?php echo $Records->leads_phone_number; ?></span>
                                        </a>
                                    </div>

                                    <!-- Row 2: Stage, Sub Stage Badges + Project + Budget -->
                                    <div class="d-flex flex-wrap align-items-center mb-1">
                                        <span class="badge tag-warning app-fs-2 mr-1">
                                            <?php echo $StageName; ?>
                                        </span>
                                        <span class="badge tag-success app-fs-2 ml-1">
                                            <?php echo $SubStageName; ?>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center mb-1 mt-2">
                                        <span class="badge tag-secondary text-secondary me-2 mb-1 app-fs-2">
                                            <i class="fa fa-folder"></i>
                                            <?php echo $ProjectName; ?>
                                        </span>
                                        <span class="badge bg-success text-white mb-1 app-fs-2">
                                            <i class="fa fa-rupee-sign me-1"></i><?php echo Price(FETCH("SELECT leads_requirement_budgets FROM leads_requirements WHERE leads_main_id='" . $Records->leads_id . "'", "leads_requirement_budgets"), "text-white", "") ?: '0'; ?>
                                        </span>
                                    </div>
                                    <p class="mb-0 bold app-fs-3 small mt-0" style="line-height: 1.3rem !important;"> <b><i class="bi bi-chat-dots-fill text-black bold"></i></b>
                                        <small class="text-secondary">
                                            <?php $LastFeedBack = FETCH("SELECT leads_activity_feedbacks FROM leads_activities where leads_activity_main_leads_id='" . $Records->leads_id . "' ORDER BY leads_acitivity_id DESC", "leads_activity_feedbacks") ?? SECURE("No Last Feedback Found!", "e");
                                            echo LimitText(SECURE($LastFeedBack, "d"), 0, 50); ?>
                                        </small>
                                    </p>

                                    <!-- Row 3: Phone + Call Status + Created At -->
                                    <div class="text-muted pull-right" style="margin-top:-2.35rem !important;">
                                        <span class="text-grey app-fs-2" style="padding:0.2rem !important;line-height:1.5 !important;font-style:italic;">
                                            <i class="fa fa-user me-1"></i> By <?php echo FETCH("SELECT UserFullName FROM users WHERE UserId='" . $Records->leads_assigned_by . "'", "UserFullName"); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                    } else {
                        ?>
                        <div class="text-center alert alert-warning p-3 rounded">
                            No <?php echo $LeadsTypeViewOnly ?? "Records"; ?> Found!
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="row">
                    <?php if ($ProcessSQL != null) {
                        echo AppPaginationFooter(TOTAL($PaginationTotalSQL), DOMAIN . "/mobile/leads");
                    }; ?>
                </div>
            </div>
        </div>

    </main>
    <section class="Instant-Feedback-Form" id="InstantFeedBackForms" style="zoom:0.8 !important;">
        <form class="feedback-container" action="<?php echo CONTROLLER; ?>/ModuleController/SaveInstantFeedBack.php" method="POST">
            <?php echo FormPrimaryInputs(true); ?>
            <input type="hidden" name="leads_id" id="InstantLeadsId">
            <input type="hidden" name="ProjectsId" id="InstantProjectsId">
            <button type="button" onclick="ControlForms('InstantFeedBackForms')" class="btn btn-lg app-fs-5 circle btn-danger pull-right"><i class="fa fa-times app-fs-4"></i> Cancel</button>
            <div class="f-head">
                <h3 class="app-heading app-fs-5" style="padding:1rem !important;"><i class="bi bi-ticket-detailed text-warning"></i> Add Instant Feedback</h3>
            </div>
            <div class="f-body">
                <div class="f-details">
                    <h5 class="mb-0 pt-0 pb-0 mt-0 text-danger app-fs-5 bold"><i class="fa fa-user text-success"></i> <span id="InstantFullName"></span> <span class='pull-right text-muted small h6 small2' id="InstantLeadType">LEAD</span></h5>
                    <h6 class="mb-1 pt-0 pb-0 mt-0 text-primary app-fs-5 bold"><i class="fa fa-phone text-success"></i> <span id="InstantPhoneNumber">9876543210</span></h6>
                    <p class="mb-0 pt-0 pb-0 mt-0">
                        <span class="flex-start">
                            <span class='btn-sm btn-warning btn bold' id="InstantStage1">Stage1</span>
                            <span class="btn-sm btn-info btn bold" id="InstantStage2">Stage2</span>
                        </span>
                        <span class="flex-start">
                            <span class='btn-sm btn-secondary bold btn' id="InstantProjectName">Project Name</span>
                        </span>
                    </p>
                </div>
                <div class="form-group mt-4">
                    <div class="w-100">
                        <label class="app-sub-heading w-100 d-block">Update Call Status</label>
                        <?php
                        $AllLeadStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id!='1' and config_leads_stage_status='1' ORDER BY config_leads_stage_sort_by_order ASC", true);
                        if ($AllLeadStages != null) {
                            foreach ($AllLeadStages as $Stages) { ?>
                                <label class="btn btn-md m-1 text-black" onclick="showSubStages('SubStagesFor_<?php echo $Stages->config_leads_stages_id; ?>')" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                    <input type="radio" required style='margin-top:3px;' name="leads_acitivity_call_status" value="<?php echo $Stages->config_leads_stages_id; ?>">
                                    <span class="bold app-fs-4" style="font-weight: bolder !important;"><?php echo $Stages->config_leads_stage_name; ?></span>
                                </label>
                        <?php }
                        } ?>
                    </div>

                    <div class="w-100 mt-3">
                        <label class="app-sub-heading w-100 d-block">Update Call Sub Status</label>
                        <?php
                        if ($AllLeadStages != null) {
                            foreach ($AllLeadStages as $Stages) {
                                $CallSubStages = SET_SQL("SELECT config_call_sub_status_id, config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_status='1' and config_call_sub_status_main_id='" . $Stages->config_leads_stages_id . "'", true);
                                if ($CallSubStages != null) { ?>
                                    <div class="sub-stage-box" id="SubStagesFor_<?php echo $Stages->config_leads_stages_id; ?>" style="display:none;">
                                        <?php foreach ($CallSubStages as $SubStages) { ?>
                                            <label class="btn btn-md m-1 text-black" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                                <input type="radio" required style='margin-top:3px;' name="leads_acitivity_call_sub_status" value="<?php echo $SubStages->config_call_sub_status_id; ?>">
                                                <span class="bold app-fs-4" style="font-weight: bolder !important;"><?php echo $SubStages->config_call_sub_status_name; ?></span>
                                            </label>
                                        <?php } ?>
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <div class="flex-s-b">
                        <div class="form-group">
                            <label class="btn btn-sm m-1 btn-info text-white app-fs-4">
                                <input type="checkbox" name="add_reminder" value="1" onchange="toggleFields('reminder-fields', this)"> Add Reminder
                            </label>
                            <!-- Reminder Fields -->
                            <div id="reminder-fields" class="action-section" style="display:none;">
                                <div class="form-group mt-2">
                                    <label class="app-fs-3">Reminder Time</label>
                                    <input type="datetime-local" class="form-control form-control-lg" style="font-size:4vw !important;" name="leads_reminder_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="btn btn-sm m-1 btn-secondary text-white app-fs-4">
                                <input type="checkbox" name="schedule_site_visit" value="1" onchange="toggleFields('sitevisit-fields', this)"> Schedule Site Visit
                            </label>
                            <!-- Site Visit Fields -->
                            <div id="sitevisit-fields" class="action-section" style="display:none;">
                                <div class="form-group mt-2">
                                    <label class="app-fs-3">Schedule Date</label>
                                    <input type="datetime-local" class="form-control form-control-lg" style="font-size:4vw !important;" name="site_visit_date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-1 pt-2">
                    <label class="app-fs-4">Enter Feedback/Remarks</label>
                    <div class="input-group">
                        <textarea name="leads_activity_feedbacks" required id="feedbackTextarea" rows="2" class="form-control form-control-lg" style="font-size:5vw !important;" placeholder="Speak or type your feedback..."></textarea>
                        <div class="input-group-append" style="position: absolute; right: 0.1rem; top: -3.5rem;">
                            <button class="btn btn-sm btn-outline-secondary app-fs-3" type="button" onclick="startVoiceInput()" id="micBtn">
                                🎤 Speak
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="f-foot mb-5 pb-3">
                <div class="flex-s-b mt-2">
                    <a class="mr-5" href="tel:" id="InstantCallPhoneNumber">
                        <img src="<?php echo STORAGE_URL_D; ?>/tool-img/call.png" loading="lazy" style="width:5rem;height:5rem;">
                    </a>
                    <button type="submit" name="AddInstantFeedBackActivity" class="btn btn-lg circle btn-success bt-block app-fs-6 bold"><i class="fa fa-check text-warning app-fs-5"></i> Add Feedback</button>
                    <a class="ml-5" id="InstantWhatsappChat" href="whatsapp://send?phone=&text=Hello, this side *<?php echo AuthAppUser("UserFullName"); ?>* from *<?php echo APP_NAME; ?>*, ">
                        <img src="<?php echo STORAGE_URL_D; ?>/tool-img/whatsapp.png" loading="lazy" style="width:5rem;height:5rem;">
                    </a>
                </div>
            </div>
        </form>
    </section>

    <script>
        function startVoiceInput() {
            // Check if browser supports Web Speech API
            const isBrowser = typeof window.SpeechRecognition !== "undefined" || typeof window.webkitSpeechRecognition !== "undefined";

            if (isBrowser) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                const recognition = new SpeechRecognition();

                recognition.lang = 'en-IN';
                recognition.interimResults = false;
                recognition.maxAlternatives = 1;

                recognition.onstart = () => {
                    document.getElementById("micBtn").innerText = "🎙️ Listening...";
                    document.getElementById("micBtn").classList.remove("btn-outline-secondary");
                    document.getElementById("micBtn").classList.add("btn-primary");
                };

                recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript;
                    document.getElementById("feedbackTextarea").value = transcript;
                };

                recognition.onerror = (event) => {
                    console.error("Speech recognition error:", event.error);
                    alert("Error during speech recognition: " + event.error);
                };

                recognition.onend = () => {
                    document.getElementById("micBtn").innerText = "🎤 Speak";
                    document.getElementById("micBtn").classList.remove("btn-primary");
                    document.getElementById("micBtn").classList.add("btn-outline-secondary");
                };

                recognition.start();
            } else if (typeof Android !== 'undefined' && Android.startSpeechRecognition) {
                // WebView fallback to native Android
                Android.startSpeechRecognition();
            } else {
                alert("Speech recognition not supported on this device.");
            }
        }
    </script>


    <script>
        function toggleFields(id, checkbox) {
            const section = document.getElementById(id);
            section.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
    <script>
        function InstantFeedBackFormHandler(LeadsId, FullName, PhoneNumber, LeadsType, StageName, SubStageName, ProjectName, ProjectId) {
            var InstantFeedBackForms = document.getElementById("InstantFeedBackForms");
            var InstantCallPhoneNumber = document.getElementById("InstantCallPhoneNumber");
            var InstantWhatsappChat = document.getElementById("InstantWhatsappChat");

            document.getElementById("InstantLeadsId").value = LeadsId;
            document.getElementById("InstantFullName").innerHTML = FullName;
            document.getElementById("InstantLeadType").innerHTML = LeadsType;
            document.getElementById("InstantPhoneNumber").innerHTML = PhoneNumber;
            document.getElementById("InstantStage2").innerHTML = SubStageName;
            document.getElementById("InstantStage1").innerHTML = StageName;
            document.getElementById("InstantProjectName").innerHTML = ProjectName;
            document.getElementById("InstantProjectsId").value = ProjectId;

            // ✅ Inject Phone Number in HREFs
            InstantCallPhoneNumber.href = "tel:" + PhoneNumber;

            const userName = "<?php echo urlencode(AuthAppUser('UserFullName')); ?>";
            const appName = "<?php echo urlencode(APP_NAME); ?>";
            const encodedMessage = `Hello, this side *${userName}* from *${appName}*`;

            InstantWhatsappChat.href = `whatsapp://send?phone=${PhoneNumber}&text=${encodedMessage}`;

            // Toggle Feedback Form Display
            InstantFeedBackForms.style.display = (InstantFeedBackForms.style.display === "block") ? "none" : "block";
        }
    </script>


    <!-- Add this JS script to handle show/hide -->
    <script>
        function showSubStages(id) {
            // Hide all sub-stage divs first
            document.querySelectorAll('.sub-stage-box').forEach(function(div) {
                div.style.display = 'none';
            });

            // Show the selected one
            document.getElementById(id).style.display = 'block';
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all sub-stage-counters containers
            const subStageContainers = document.querySelectorAll('.sub-stage-counters');

            subStageContainers.forEach((container, index) => {
                // Unique key for each container's scroll position
                const storageKey = `subStageScrollPosition_${index}`;

                // Restore scroll position for this container
                const savedScrollPosition = localStorage.getItem(storageKey);
                if (savedScrollPosition !== null) {
                    container.scrollLeft = parseInt(savedScrollPosition);
                }

                // Save scroll position on scroll
                container.addEventListener('scroll', function() {
                    localStorage.setItem(storageKey, container.scrollLeft);
                });

                // Save scroll position when clicking any counter link in this container
                const counterLinks = container.querySelectorAll('.app-widget-counter a');
                counterLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        localStorage.setItem(storageKey, container.scrollLeft);
                    });
                });
            });
        });
    </script>
    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>