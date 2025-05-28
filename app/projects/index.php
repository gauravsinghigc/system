<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

if (isset($_GET["reset_previous_project_record"])) {
    unset($_SESSION['PROJECT_ENTRY_STEPS']);
}

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

        <div class="pagetitle">
            <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="<?php echo APP_URL; ?>/projects/add" class="btn btn-md btn-danger"><i class="bi bi-plus"></i> Add Projects</a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>S.N.</th>
                                                    <th>Image</th>
                                                    <th>ProjectName</th>
                                                    <th>ProjectType</th>
                                                    <th>Location</th>
                                                    <th>DeveloperName</th>
                                                    <th>LaunchDate</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $GetAllProjects = SET_SQL("SELECT * FROM projects ORDER BY projects_id DESC", true);
                                                if ($GetAllProjects != null) {
                                                    $SerialNo = 0;
                                                    foreach ($GetAllProjects as $Projects) {
                                                        $SerialNo++;
                                                        $projects_id = $Projects->projects_id;
                                                        $projects_media_files_value = FETCH("SELECT projects_media_files_value FROM projects_media_files where projects_media_files_types='images' and projects_media_files_main_project_id='$projects_id' ORDER BY projects_media_files_id DESC limit 1", "projects_media_files_value"); ?>
                                                        <tr>
                                                            <td><?php echo $SerialNo; ?></td>
                                                            <td>
                                                                <img src="<?php echo STORAGE_URL; ?>/projects/<?php echo $projects_id; ?>/media/<?php echo $projects_media_files_value; ?>" class="list-icon img-fluid">
                                                            </td>
                                                            <td>
                                                                <a class="bold text-primary" href="details?projectsId=<?php echo SECURE($projects_id, "e"); ?>">
                                                                    <?php echo $Projects->projects_name; ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?php echo FETCH("SELECT config_project_types_name from config_project_types WHERE config_project_types_id='" . $Projects->projects_type_id . "'", "config_project_types_name"); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo FETCH("SELECT config_projects_locations_name from config_projects_locations WHERE config_projects_locations_id='" . $Projects->projects_locations_id . "'", "config_projects_locations_name"); ?>
                                                            </td>
                                                            <td class="text-primary">
                                                                <?php echo FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $Projects->projects_developed_by . "'", "projects_developers_name"); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo DATE_FORMATES("d M, Y", $Projects->projects_age); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo StatusViewWithText($Projects->projects_listing_status); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <a href="details?projectsId=<?php echo SECURE($projects_id, "e"); ?>" class="btn btn-xs btn-dark">
                                                                    <i class="bi bi-eye-fill text-success"></i> View Details</i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } else {
                                                    echo '<tr><td colspan="11">No projects found.</td></tr>';
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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