<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Integrations & Plugins Setup";
$PageDescription = "Configure and manage integrations for " . APP_NAME . " to enhance your automation capabilities";

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];
$PageName = "FACEBOOK APIs";

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
                    <h1><i class="bi bi-plug-fill text-primary bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="w-auto">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addFacebookModal" class="btn btn-primary"><i class="bi bi-plus"></i> Add FB Ads</a>
                </div>
            </div>
        </div><!-- End Page Title -->


        <section class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-container">
                        <table>
                            <thead>
                                <th>SNo</th>
                                <th>AccountName</th>
                                <th>AdAccountId</th>
                                <th>CampaignId</th>
                                <th>AdSetId</th>
                                <th>AdsId</th>
                                <th>Ref<?php echo LISTING_TYPES; ?></th>
                                <th>RefVendorName</th>
                                <th>AutoDistribution</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $AllFacebookAds = SET_SQL("SELECT * FROM config_facebook_accounts ORDER BY config_facebook_accounts_id DESC", true);
                                if ($AllFacebookAds != null) {
                                    $SerialNo = 0;
                                    foreach ($AllFacebookAds as $Facebook) {
                                        $SerialNo++; ?>
                                        <tr>
                                            <td><?php echo $SerialNo; ?></td>
                                            <td>
                                                <i class="fa fa-facebook text-primary"></i>
                                                <span class="bold text-primary"><?php echo UpperCase($Facebook->config_facebook_accounts_name); ?></span>
                                            </td>
                                            <td>
                                                <?php echo $Facebook->config_facebook_accounts_ad_account_id; ?>
                                            </td>
                                            <td>
                                                <?php echo $Facebook->config_facebook_accounts_campaigns_id; ?>
                                            </td>
                                            <td>
                                                <?php echo $Facebook->config_facebook_accounts_adsets_id; ?>
                                            </td>
                                            <td>
                                                <?php echo $Facebook->config_facebook_accounts_ads_id; ?>
                                            </td>
                                            <td>
                                                <?php echo FETCH("SELECT projects_name FROM projects where projects_id='" . $Facebook->config_facebook_accounts_projects_id . "'", "projects_name"); ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo FETCH("SELECT config_leads_resources_name FROM config_leads_resources where config_leads_resources_id='" . $Facebook->config_facebook_accounts_vendor_name . "'", "config_leads_resources_name");
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo StatusViewWithText($Facebook->config_facebook_accounts_auto_distributions); ?>
                                            </td>
                                            <td>
                                                <?php echo StatusViewWithText($Facebook->config_facebook_accounts__status); ?>
                                            </td>
                                            <td>
                                                <a data-bs-toggle="modal" data-bs-target="#UpdateFbModal_<?php echo $Facebook->config_facebook_accounts_id; ?>" class="btn btn-xs btn-dark"><i class="fa fa-edit"></i> Update</a>
                                                <?php echo CONFIRM_DELETE_POPUP(
                                                    "FacebookAds",
                                                    [
                                                        "RemoveFacebookAds" => true,
                                                        "config_facebook_accounts_id" => $Facebook->config_facebook_accounts_id
                                                    ],
                                                    CONTROLLER . "/ModuleController/RemoveFacebookApi.php",
                                                    "<i class='fa fa-trash'></i>",
                                                    "btn btn-xs btn-danger"
                                                ); ?>
                                                <div class="modal fade" id="UpdateFbModal_<?php echo $Facebook->config_facebook_accounts_id; ?>" tabindex="-1" aria-labelledby="addUserModalLabel_<?php echo $Facebook->config_facebook_accounts_id; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="app-heading"><i class="bi bi-facebook text-white"></i> Update Facebook Configuration</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="<?php echo CONTROLLER; ?>/SystemController/FbAdAccountController.php">
                                                                    <?php echo FormPrimaryInputs(true, [
                                                                        "config_facebook_accounts_id" => $Facebook->config_facebook_accounts_id
                                                                    ]); ?>
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label">Access Token</label>
                                                                            <input type="text" class="form-control" value="<?php echo $Facebook->config_facebook_accounts_access_token; ?>" name="config_facebook_accounts_access_token" maxlength="255" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Account Name</label>
                                                                            <input type="text" class="form-control" value="<?php echo $Facebook->config_facebook_accounts_name; ?>" name="config_facebook_accounts_name" maxlength="70" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Ad Account ID</label>
                                                                            <input type="text" class="form-control" value="<?php echo $Facebook->config_facebook_accounts_ad_account_id; ?>" name="config_facebook_accounts_ad_account_id" maxlength="100" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Campaigns ID</label>
                                                                            <input type="text" class="form-control" value="<?php echo $Facebook->config_facebook_accounts_campaigns_id; ?>" name="config_facebook_accounts_campaigns_id" maxlength="100">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Adsets ID</label>
                                                                            <input type="text" class="form-control" value="<?php echo $Facebook->config_facebook_accounts_adsets_id; ?>" name="config_facebook_accounts_adsets_id" maxlength="100">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Ads ID</label>
                                                                            <input type="text" class="form-control" name="config_facebook_accounts_ads_id" value="<?php echo $Facebook->config_facebook_accounts_ads_id; ?>" maxlength="100">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Bind Project With Ads API</label>
                                                                            <select class="form-select" name="config_facebook_accounts_projects_id" required="">
                                                                                <option value="">Select Project</option>
                                                                                <?php
                                                                                $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                                                                                if ($AllProjects != null) {
                                                                                    foreach ($AllProjects as $AllProject) {
                                                                                        $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                                                                                        $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                                                                                        $projects_id = $AllProject->projects_id;
                                                                                        $projects_name = $AllProject->projects_name;
                                                                                        $Selected = CheckEquality($Facebook->config_facebook_accounts_projects_id, $projects_id, "selected");
                                                                                        echo "<option value='$projects_id' $Selected>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                                                                                    }
                                                                                } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label class="form-label">Status</label>
                                                                            <select class="form-control" name="config_facebook_accounts__status" required>
                                                                                <?php echo InputOptionsWithKey([
                                                                                    "" => "Select Status",
                                                                                    "1" => "Active",
                                                                                    "2" => "Inactive"
                                                                                ], $Facebook->config_facebook_accounts__status); ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-8 mb-3">
                                                                            <label>Vendor/Resource Name</label>
                                                                            <select class="form-select form-control" name="config_facebook_accounts_vendor_name" required>
                                                                                <option value="">Select Vendor/Resouce Name</option>
                                                                                <?php
                                                                                $AllLeadsReSources = SET_SQL("SELECT config_leads_resources_name, config_leads_resources_id FROM config_leads_resources where config_leads_resources_status='1' ORDER by config_leads_resources_name ASC", true);
                                                                                if ($AllLeadsReSources != null) {
                                                                                    foreach ($AllLeadsReSources as $ReSources) {
                                                                                        $Selected = CheckEquality($Facebook->config_facebook_accounts_vendor_name, $ReSources->config_leads_resources_id, "selected");
                                                                                        echo "<option value='" . $ReSources->config_leads_resources_id . "' $Selected>" . $ReSources->config_leads_resources_name . "</option>";
                                                                                    }
                                                                                } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 mb-0 pt-2">
                                                                            <label class="form-label">Auto Distributions</label>
                                                                            <?php $DistributionStatus = $Facebook->config_facebook_accounts_auto_distributions; ?>
                                                                            <select name="config_facebook_accounts_auto_distributions" class="form-control">
                                                                                <?php echo InputOptionsWithKey([
                                                                                    "" => "Select Status",
                                                                                    "1" => "Active",
                                                                                    "2" => "Inactive"
                                                                                ], $DistributionStatus); ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <hr>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="UpdateFbAdsConfigurations" class="btn btn-primary">Update Configuration</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="addFacebookModal" tabindex="-1" aria-labelledby="addFacebookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="facebookConfigForm" method="POST" action="<?php echo CONTROLLER; ?>/SystemController/FbAdAccountController.php">
                    <?php echo FormPrimaryInputs(true); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFacebookModalLabel"><i></i> Add Fcebook Configuration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Account Name</label>
                                <input type="text" class="form-control" name="config_facebook_accounts_name" maxlength="70" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Access Token</label>
                                <input type="text" class="form-control" name="config_facebook_accounts_access_token" maxlength="255" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ad Account ID</label>
                                <input type="text" class="form-control" name="config_facebook_accounts_ad_account_id" maxlength="100" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Campaigns ID</label>
                                <input type="text" class="form-control" name="config_facebook_accounts_campaigns_id" maxlength="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adsets ID</label>
                                <input type="text" class="form-control" name="config_facebook_accounts_adsets_id" maxlength="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ads ID</label>
                                <input type="text" class="form-control" name="config_facebook_accounts_ads_id" maxlength="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bind Project With Ads API</label>
                                <select class="form-select" name="config_facebook_accounts_projects_id">
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="config_facebook_accounts__status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Vendor/Resource Name</label>
                                <select class="form-select form-control" name="config_facebook_accounts_vendor_name" required>
                                    <option value="">Select Vendor/Resouce Name</option>
                                    <?php
                                    $AllLeadsReSources = SET_SQL("SELECT config_leads_resources_name, config_leads_resources_id FROM config_leads_resources where config_leads_resources_status='1' ORDER by config_leads_resources_name ASC", true);
                                    if ($AllLeadsReSources != null) {
                                        foreach ($AllLeadsReSources as $ReSources) {
                                            echo "<option value='" . $ReSources->config_leads_resources_id . "'>" . $ReSources->config_leads_resources_name . "</option>";
                                        }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Auto Distributions</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        id="autoDistributionsSwitch"
                                        name="config_facebook_accounts_auto_distributions"
                                        value="1">
                                    <label class="form-check-label" for="autoDistributionsSwitch"
                                        id="autoDistributionLabel">
                                        Auto Distribution Disabled
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="SaveFbAdsConfigurations" class="btn btn-primary">Save Configuration</button>
                    </div>
                </form>
            </div>
        </div>

    </main><!-- End #main -->

    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const switchInput = document.getElementById('autoDistributionsSwitch');
            const switchLabel = document.getElementById('autoDistributionLabel');

            switchInput.addEventListener('change', function() {
                if (this.checked) {
                    switchLabel.textContent = 'Auto Distribution Enabled';
                } else {
                    switchLabel.textContent = 'Auto Distribution Disabled';
                }
            });
        });
    </script>

</body>

</html>