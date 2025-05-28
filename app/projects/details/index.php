<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';

//pagevariables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

$ProjectsId = SECURE(ReturnSessionalValues("projectsId", "ACTIVE_PROJECTS_ID", null), "d");

$ProjectSQL = "SELECT * FROM projects where projects_id='$ProjectsId'";
HandleInvalidData(TOTAL($ProjectSQL), "../");
$ProjectsImagesSQL = "SELECT projects_media_files_value FROM projects_media_files where projects_media_files_types='images' and projects_media_files_main_project_id='$ProjectsId' ORDER BY projects_media_files_id DESC";
$ProjectsBrochureSQL = "SELECT projects_media_files_value FROM projects_media_files where projects_media_files_types='files' and projects_media_files_main_project_id='$ProjectsId' ORDER BY projects_media_files_id DESC";
$ProjectsYoutubeLinks = "SELECT projects_media_files_value FROM projects_media_files where projects_media_files_types='youtube' and projects_media_files_main_project_id='$ProjectsId' ORDER BY projects_media_files_id DESC";
$ProjectsFeaturedImage = FETCH($ProjectsImagesSQL . " limit 1", "projects_media_files_value");

$ProjectStatusSQL = "SELECT * from config_projects_status where config_projects_status_id='" . FETCH($ProjectSQL, "projects_status_id") . "'";
$ProjectStagesSQL = "SELECT * from config_projects_stages where config_projects_stages_id='" . FETCH($ProjectSQL, "projects_stages_id") . "'";
$ProjectTypesSQL = "SELECT * from config_project_types where config_project_types_id='" . FETCH($ProjectSQL, "projects_type_id") . "'";
$ProjectLocationsSQL = "SELECT * from config_projects_locations where config_projects_locations_id='" . FETCH($ProjectSQL, "projects_locations_id") . "'";

$DeveloperSQL = "SELECT * FROM projects_developers where projects_developers_id='" . FETCH($ProjectSQL, "projects_developed_by") . "'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo FETCH($ProjectSQL, "projects_name"); ?> | <?php echo APP_NAME; ?></title>
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

        <div class="pagetitle">
            <h1><i class="bi bi-list-stars text-danger bold"></i> Projects : <b><?php echo FETCH($ProjectSQL, "projects_name"); ?></b></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/projects">All Projects</a></li>
                    <li class="breadcrumb-item active"><b><?php echo FETCH($ProjectSQL, "projects_name"); ?></b></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body profile-card pt-4 d-flex flex-column">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6><?php echo StatusViewWithText(FETCH($ProjectSQL, "projects_listing_status")); ?></h6>
                                    <div class="p-2 shadow-sm br-1">
                                        <img src="<?php echo STORAGE_URL; ?>/projects/<?php echo $ProjectsId; ?>/media/<?php echo $ProjectsFeaturedImage; ?>" alt="<?php echo FETCH($ProjectSQL, "projects_name"); ?>" title="<?php echo FETCH($ProjectSQL, "projects_name"); ?>" class="rounded-circle">
                                    </div>
                                    <h2><?php echo FETCH($ProjectSQL, "projects_name"); ?></h2>
                                    <h5 class="h5 text-secondary"><?php echo FETCH($ProjectTypesSQL, "config_project_types_name"); ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-0 pb-0 bold">Project Details</h6>
                                    <hr class="mt-2">
                                    <h6>
                                        <span class="small text-secondary">Project Area</span><br>
                                        <?php echo FETCH($ProjectSQL, "projects_area"); ?>
                                        <?php echo FETCH($ProjectSQL, "projects_area_measurement_unit"); ?>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Launch Date</span><br>
                                        <?php echo DATE_FORMATES("d M, Y", FETCH($ProjectSQL, "projects_age")); ?>
                                        <span class='text-secondary pull-right'>( <?php echo GetYearDifference(FETCH($ProjectSQL, "projects_age"), date("Y-m-d")); ?> Days )</span>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Project Stage</span><br>
                                        <?php echo FETCH($ProjectStagesSQL, "config_projects_stages_name"); ?>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Project Status</span><br>
                                        <?php echo FETCH($ProjectStatusSQL, "config_projects_status_name"); ?>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Project Locations</span><br>
                                        <?php echo FETCH($ProjectLocationsSQL, "config_projects_locations_name"); ?>
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-0 pb-0 bold">Developer Details</h6>
                                    <hr class="mt-2">
                                    <h6>
                                        <span class="small text-secondary">Developer Name</span><br>
                                        <?php echo FETCH($DeveloperSQL, "projects_developers_name"); ?>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Phone Number</span><br>
                                        <a href="tel:<?php echo FETCH($DeveloperSQL, "projects_developer_phone_number"); ?>" class="text-success"><i class="bi bi-phone"></i> <?php echo FETCH($DeveloperSQL, "projects_developer_phone_number"); ?></a>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Email-Id</span><br>
                                        <a href="mailto:<?php echo FETCH($DeveloperSQL, "projects_developer_primary_email_id"); ?>" class="text-danger"><i class="bi bi-envelope"></i> <?php echo FETCH($DeveloperSQL, "projects_developer_primary_email_id"); ?></a>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Address</span><br>
                                        <?php echo FETCH($DeveloperSQL, "projects_developers_address"); ?>
                                    </h6>
                                    <h6>
                                        <span class="small text-secondary">Landing Page</span><br>
                                        <a href="<?php echo FETCH($DeveloperSQL, "projects_landing_page_url"); ?>" class="text-primary small"><i class="bi bi-link"></i> <?php echo FETCH($DeveloperSQL, "projects_landing_page_url"); ?></a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <?php
                                $ActiveProjectAddStep = ReturnSessionalValues("details_steps", "PROJECT_DETAILED_STEPS", "primary_info");
                                foreach (PROJECT_ENTRY_STEPS as $StepKeys => $ProjectsSteps) {
                                    $ActiveSteps = CheckEquality($ActiveProjectAddStep, $StepKeys, "active"); ?>
                                    <li class="nav-item">
                                        <a href="?details_steps=<?php echo $StepKeys; ?>" class="nav-link <?php echo $ActiveSteps; ?>">
                                            <i class="<?php echo $ProjectsSteps['icon']; ?>"></i>
                                            <?php echo $ProjectsSteps['name']; ?>
                                        </a>
                                    </li>
                                <?php }
                                $ActiveModule = PROJECT_ENTRY_STEPS[$ActiveProjectAddStep]['module'] ?>
                            </ul>
                            <div class="tab-content pt-2">
                                <?php include __DIR__ . "/views/$ActiveModule"; ?>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->


    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
</body>

</html>