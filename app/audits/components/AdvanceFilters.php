<?php if (isset($_GET["ApplyAdvancefilters"])) {
    $FilterForm = "block";
} else {
    $FilterForm = "none";
}

?>

<div id="AdvanceFilters" style='display:<?php echo $FilterForm; ?>;'>
    <div class="card">
        <div class="card-body pt-2">
            <form class="row">
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Type</label>
                    <select class="form-select form-control" name="leads_type">
                        <?php echo InputOptionsWithKey([
                            "" => "All Records",
                            "LEAD" => "All LEAD",
                            "DATA" => "All DATA",
                        ], IfRequested("GET", "leads_type", "", null)); ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label class="form-label">Leads Stage</label>
                    <select class="form-select form-control" name="leads_stages" id="callStatus">
                        <option value="">All Calls</option>
                        <?php
                        $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                        if ($AllLeadsStages != null) {
                            foreach ($AllLeadsStages as $Stages) {
                                $Selected = CheckEquality(IfRequested("GET", "leads_stages"), $Stages->config_leads_stages_id, "selected");
                                echo "<option value='" . $Stages->config_leads_stages_id . "' $Selected>" . $Stages->config_leads_stage_name . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label class="form-label">Lead Sub-Stages</label>
                    <select class="form-select form-control" name="leads_sub_stages" id="callSubStatus">
                        <option value="">All Leads</option>
                        <?php if (isset($_GET["leads_sub_stages"])) {
                            if ($_GET["leads_sub_stages"] != null || $_GET["leads_sub_stages"] != "" || $_GET["leads_sub_stages"] != " ") {
                                $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_main_id='" . $_GET["leads_sub_stages"] . "'", true);
                                if ($AllCallSubStatus != null) {
                                    foreach ($AllCallSubStatus as $SubCallStatus) {
                                        $Selected = CheckEquality(IfRequested("GET", "leads_sub_stages"), $SubCallStatus->config_call_sub_status_id, "selected");
                                        echo "<option value='" . $SubCallStatus->config_call_sub_status_id . "' $Selected>" . $SubCallStatus->config_call_sub_status_name . "</option>";
                                    }
                                }
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 app-advance-filter form-group">
                    <label class="form-label">Select Project</label>
                    <select class="form-select form-control" name="leads_project_id">
                        <option value="">All Projects</option>
                        <?php
                        $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                        if ($AllProjects != null) {
                            foreach ($AllProjects as $AllProject) {
                                $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                                $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                                $projects_id = $AllProject->projects_id;
                                $projects_name = $AllProject->projects_name;
                                $Selected = CheckEquality(IfRequested("GET", "leads_project_id"), $projects_id, "selected");
                                echo "<option value='$projects_id' $Selected>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Sources</label>
                    <select class="form-select form-control" name="leads_source">
                        <option value="">All Sources</option>
                        <?php
                        $AllLeadsSources = SET_SQL("SELECT config_leads_source_name, config_leads_source_id FROM config_leads_sources where config_leads_source_status='1' ORDER by config_leads_source_name ASC", true);
                        if ($AllLeadsSources != null) {
                            foreach ($AllLeadsSources as $Sources) {
                                $Selected = CheckEquality(IfRequested("GET", "leads_source"), $Sources->config_leads_source_id, "selected");
                                echo "<option value='" . $Sources->config_leads_source_id . "' $Selected>" . $Sources->config_leads_source_name . "</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label class="form-label">Resources/Vendor</label>
                    <select class="form-select form-control" name="leads_re_source">
                        <option value="">All Re-Source/Vendors</option>
                        <?php
                        $AllLeadsReSources = SET_SQL("SELECT config_leads_resources_name, config_leads_resources_id FROM config_leads_resources where config_leads_resources_status='1' ORDER by config_leads_resources_name ASC", true);
                        if ($AllLeadsReSources != null) {
                            foreach ($AllLeadsReSources as $ReSources) {
                                $selected = CheckEquality(IfRequested("GET", "leads_re_source"), $ReSources->config_leads_resources_id, "selected");
                                echo "<option value='" . $ReSources->config_leads_resources_id . "' $selected>" . $ReSources->config_leads_resources_name . "</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label class="form-label">Leads Assigned To</label>
                    <select class="form-select form-control" name="leads_managed_by">
                        <option value="">All Users</option>
                        <?php
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                        if ($AllUsers != null) {
                            foreach ($AllUsers as $Users) {
                                $selected = CheckEquality(IfRequested("GET", "leads_managed_by"), $Users->UserId, "selected");
                                // Check if the user is a lead manager or admin
                                echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label class="form-label">Leads Created By</label>
                    <select class="form-select form-control" name="leads_assigned_by">
                        <option value="">All Users</option>
                        <?php
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                        if ($AllUsers != null) {
                            foreach ($AllUsers as $Users) {
                                $selected = CheckEquality(IfRequested("GET", "leads_assigned_by"), $Users->UserId, "selected");
                                // Check if the user is a lead manager or admin
                                echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Added On (From)</label>
                    <input accept="date" type="date" class="form-control" name="leads_added_on_from_date" value="<?php echo IfRequested("GET", "leads_added_on_from_date", "", null); ?>">
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Added On (To)</label>
                    <input accept="date" type="date" class="form-control" name="leads_added_on_to_date" value="<?php echo IfRequested("GET", "leads_added_on_to_date", "", null); ?>">
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Assigned On (From)</label>
                    <input accept="date" type="date" class="form-control" name="leads_assigned_on_from_date" value="<?php echo IfRequested("GET", "leads_assigned_on_from_date", "", null); ?>">
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Assigned On (To)</label>
                    <input accept="date" type="date" class="form-control" name="leads_assigned_on_to_date" value="<?php echo IfRequested("GET", "leads_assigned_on_to_date", "", null); ?>">
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Updated On (From)</label>
                    <input accept="date" type="date" class="form-control" name="leads_updated_at_from" value="<?php echo IfRequested("GET", "leads_updated_at_from", "", null); ?>">
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>Leads Updated On (To)</label>
                    <input accept="date" type="date" class="form-control" name="leads_updated_at_to" value="<?php echo IfRequested("GET", "leads_updated_at_to", "", null); ?>">
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label class="form-label">Leads Uploaded By</label>
                    <select class="form-select form-control" name="leads_uploaded_by">
                        <option value="">All Users</option>
                        <?php
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                        if ($AllUsers != null) {
                            foreach ($AllUsers as $Users) {
                                $selected = CheckEquality(IfRequested("GET", "leads_uploaded_by"), $Users->UserId, "selected");
                                // Check if the user is a lead manager or admin
                                echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter">
                    <label>FB Ads </label>
                    <select name="leads_other_sources_ads_id" class="form-control">
                        <option value="">All FB Ads</option>
                        <?php
                        $AllFacebookAds = SET_SQL("SELECT config_facebook_accounts_id, config_facebook_accounts_name, config_facebook_accounts_last_fetched_at FROM config_facebook_accounts WHERE config_facebook_accounts__status='1' ORDER BY config_facebook_accounts_last_fetched_at DESC", true);
                        if ($AllFacebookAds != null) { ?>
                            <option value="">All FB Ads</option>
                            <?php foreach ($AllFacebookAds as $FbAds) { ?>
                                <option value="<?php echo $FbAds->config_facebook_accounts_id; ?>">
                                    <?php echo $FbAds->config_facebook_accounts_name; ?>
                                </option>
                        <?php }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2 form-group app-advance-filter pt-4">
                    <button type="submit" value="true" name="ApplyAdvancefilters" class="btn btn-sm btn-dark"><i class="bi bi-filter"></i> Apply Filters</button>
                </div>
                <div class="col-md-2 form-group app-advance-filter pt-4">
                    <a href="index.php" class="btn btn-sm btn-danger" onclick="ControlForms('AdvanceFilters')"><i class="bi bi-x"></i> Close Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Call Status and Sub-Status Handling Script -->
    <script>
        // Call Status and Sub-Status Data
        const subStatusData = {
            <?php
            $AllCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages WHERE config_leads_stage_status='1' ORDER BY config_leads_stages_id ASC", true);
            if ($AllCallStatus != null) {
                $output = [];
                foreach ($AllCallStatus as $MainCallStatus) {
                    $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_main_id='" . $MainCallStatus->config_leads_stages_id . "'", true);
                    if ($AllCallSubStatus != null) {
                        $subStatusArray = [];
                        foreach ($AllCallSubStatus as $SubCallStatus) {
                            $subStatusArray[] = "{id: '" . $SubCallStatus->config_call_sub_status_id  . "', name: '" . $SubCallStatus->config_call_sub_status_name . "'}";
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
            callSubStatusSelect.innerHTML = '<option value="">All Leads</option>';
            if (subStatusData[selectedStatus] && Array.isArray(subStatusData[selectedStatus])) {
                subStatusData[selectedStatus].forEach(subStatus => {
                    const option = new Option(subStatus.name, subStatus.id);
                    callSubStatusSelect.appendChild(option);
                });

            }
        });
    </script>
</div>