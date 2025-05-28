<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = "Site Visits"; // Updated for meeting page
$PageDescription = "Manage and schedule meetings for " . APP_NAME;
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

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s ease-out;
        }

        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-dark {
            background: linear-gradient(45deg, #343a40, #495057);
            border: none;
            transition: all 0.3s;
        }

        .btn-dark:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #212529, #343a40);
        }

        .calendar-box {
            min-height: 300px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
    </style>
</head>

<body class="pb-5 mb-5">
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <section class="section animate-fade-up">

            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-danger w-100 btn-block btn-sm" data-bs-toggle="modal" data-bs-target="#addSiteVisitModal">
                        <i class="bi bi-plus-circle me-1"></i>Add Visit
                    </button>

                    <!-- Existing table modified for meetings -->
                    <?php $LeadsSiteVisitSQL = "SELECT * FROM leads_site_visits where leads_site_visit_handled_by='" . LOGIN_USER_ID . "'"; ?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="row mb-4">
                                <div class="col-6 mb-2">
                                    <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                        <strong class="text-primary small2">All Site Visits</strong><br>
                                        <span class="display-6 text-primary fw-bold">
                                            <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                                        <strong class="text-success small2">Completed</strong><br>
                                        <span class="display-6 text-success fw-bold">
                                            <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <ul class="timeline list-unstyled position-relative" style="max-height: 50rem; overflow-y: auto;">
                                <?php
                                $AllSiteVisits = SET_SQL($LeadsSiteVisitSQL . " ORDER BY leads_site_visit_id DESC", true);
                                if ($AllSiteVisits != null) {
                                    foreach ($AllSiteVisits as $SiteVisits) {
                                        $LeadsSQL = "SELECT * FROM leads where leads_id='" . $SiteVisits->leads_main_leads_id . "'"; ?>
                                        <li class="timeline-item mb-4 position-relative">
                                            <div class="">
                                                <!-- Milestone Point (Date and Time) -->
                                                <div class="flex-shrink-0 me-3 text-left w-100">
                                                    <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $SiteVisits->leads_site_visit_added_on); ?></span>
                                                    <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $SiteVisits->leads_site_visit_added_on); ?></small>
                                                    <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 10px; left: 1px;"></div>
                                                </div>
                                                <!-- Timeline Content -->
                                                <div class="timeline-content p-3 mt-1 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <strong class="btn btn-xs btn-warning text-white"><?php echo UpperCase(FETCH("SELECT projects_name FROM projects where projects_id='" . $SiteVisits->leads_site_visits_projects_id . "'", "projects_name")); ?></strong>
                                                    </div>
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <p class="mb-0 pt-1 pb-0">
                                                            <span>Name: <b><?php echo FETCH($LeadsSQL, "leads_full_name"); ?></b></span><br>
                                                            <span>Phone Number: <b><?php echo FETCH($LeadsSQL, "leads_phone_number"); ?></b></span>
                                                        </p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <span class="detail-title fw-bold">Scheduled For :</span>
                                                        <?php echo DATE_FORMATES("d M, Y", $SiteVisits->leads_site_visit_schedule_date); ?>
                                                        <br>
                                                        <span class="detail-title fw-bold">By:</span>
                                                        (UID<?php echo $SiteVisits->leads_site_visit_handled_by; ?>)-
                                                        <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $SiteVisits->leads_site_visit_handled_by . "'", "UserFullName"); ?>
                                                        <br>
                                                        <span class="detail-title fw-bold">Reminder Note:</span>
                                                        <?php echo SECURE($SiteVisits->leads_site_visit_notes, "d"); ?>
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
                </div>

                <!-- Mobile-Optimized CSS -->

            </div>
        </section>
    </main>

    <!-- Site Visits Modal -->
    <div class="modal fade" id="addSiteVisitModal" tabindex="-1" aria-labelledby="addSiteVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header app-heading">
                    <h5 class="modal-title" id="addSiteVisitModalLabel">Add Site Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" enctype="multipart/form-data">
                        <?php echo FormPrimaryInputs(true); ?>
                        <div class="col-md-12 mb-3 form-group">
                            <label>Select Leads/Person Name</label>
                            <input type="search" placeholder="Search Leads Person..." class="form-control" id="LeadsTriggerred" oninput="SearchData('LeadsTriggerred', 'LeadsRecords')">
                            <div class="pt-3 mt-3 mb-3 pb-3 shadow-md p-2 br-1" style="max-height: 20rem;overflow-y:scroll;">
                                <?php
                                $AllLeads = SET_SQL("SELECT leads_id, leads_full_name, leads_phone_number FROM leads where leads_managed_by='" . LOGIN_USER_ID . "'", true);
                                if ($AllLeads != null) {
                                    foreach ($AllLeads as $Lead) { ?>
                                        <label class='shadow-sm p-1 br-1 LeadsRecords w-100 mb-2'>
                                            <input type="radio" required name="leads_Id" value="<?php echo SECURE($Lead->leads_id, "e"); ?>">
                                            <b><?php echo $Lead->leads_full_name; ?></b> (<?php echo $Lead->leads_phone_number; ?>)
                                        </label>
                                <?php  }
                                } ?>
                            </div>
                        </div>
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
                                    "3" => "Site Visit Cancelled"
                                ], "1"); ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="visitDate" class="form-label">Site Visit Date</label>
                            <input type="date" name="leads_site_visit_schedule_date" class="form-control" id="visitDate" required>
                        </div>

                        <div class="mb-3">
                            <label for="visitRemarks" class="form-label">Site Visit Remarks</label>
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
                    <a href="<?php echo DOMAIN; ?>/mobile/leads/add" class="btn btn-danger btn-md" style="float:left;">Add New Lead</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="AddSiteVisitRecords" class="btn btn-primary">Save Visit <i class="bi bi-check-circle text-success"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>

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
    <?php include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>