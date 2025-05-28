<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
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

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1><i class="bi bi-plus text-danger bold"></i> Add New Projects</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/projects">All Projects</a></li>
                    <li class="breadcrumb-item active">Add Projects</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <ul class="gsi-steps">
                                        <?php
                                        $ActiveProjectAddStep = ReturnSessionalValues("project_entry_step", "PROJECT_ENTRY_STEPS", "primary_info");
                                        foreach (PROJECT_ENTRY_STEPS as $StepKeys => $ProjectsSteps) {
                                            $ActiveStep = CheckEquality($ActiveProjectAddStep, $StepKeys, "active"); ?>
                                            <li class="<?php echo $ActiveStep; ?>">
                                                <span class="icon"><i class="<?php echo $ProjectsSteps['icon']; ?>"></i></span>
                                                <span class="title"><?php echo $ProjectsSteps['name']; ?></span>
                                            </li>
                                        <?php }
                                        $ActiveModule = PROJECT_ENTRY_STEPS[$ActiveProjectAddStep]['module'] ?>
                                    </ul>
                                </div>
                            </div>
                            <?php include __DIR__ . "/views/$ActiveModule"; ?>
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