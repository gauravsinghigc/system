<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Integrations & Plugins Setup";
$PageDescription = "Configure and manage integrations for " . APP_NAME . " to enhance your automation capabilities";

// checking User Has A Plan Or Not
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
        <div class="pagetitle">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-plug-fill text-warning bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <!-- Facebook/Meta Ads Integration -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-facebook text-warning"></i> Facebook/Meta Ads</h5>
                            <p class="card-text">Integrate with Facebook and Meta Ads to capture leads directly from your campaigns.</p>
                            <a href="FacebookAPIs.php" class="btn btn-outline-primary w-100">Add & Update Facebook APIs</a>
                        </div>
                    </div>
                </div>

                <!-- Google Ads Integration -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-google text-danger"></i> Google Ads</h5>
                            <p class="card-text">Sync Google Ads to automate lead capture and conversion tracking.</p>
                            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#googleModal">Configure</button>
                        </div>
                    </div>
                </div>

                <!-- Webhook Integration -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-link-45deg text-success"></i> Webhook</h5>
                            <p class="card-text">Set up webhooks to connect with external systems seamlessly.</p>
                            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#webhookModal">Configure</button>
                        </div>
                    </div>
                </div>

                <!-- LinkedIn Ads Integration -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-linkedin text-info"></i> LinkedIn Ads</h5>
                            <p class="card-text">Automate lead generation from LinkedIn Ads campaigns.</p>
                            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#linkedinModal">Configure</button>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp API Integration -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-whatsapp text-success"></i> WhatsApp API</h5>
                            <p class="card-text">Send automated messages and manage leads via WhatsApp.</p>
                            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#whatsappModal">Configure</button>
                        </div>
                    </div>
                </div>

                <!-- SMS Integration -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-chat-text text-warning"></i> SMS</h5>
                            <p class="card-text">Integrate SMS services to send automated texts to leads.</p>
                            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#smsModal">Configure</button>
                        </div>
                    </div>
                </div>

                <!-- Custom Integration Request -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="app-heading mt-3"><i class="bi bi-gear-fill text-secondary"></i> 3rd Party Integration</h5>
                            <p class="card-text">Share API with Other to Fetch Leads From there to <b><?php echo APP_NAME; ?></b> CRM (This CRM & App). </p>
                            <a href="CustomAPIs.php" class="btn btn-outline-primary w-100">Configure Custom API</a>
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