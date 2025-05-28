<div class="row mt-2">
    <div class="col-md-12">
        <h4 class="app-heading"><i class="bi bi-person"></i> Team Dashboard</h4>
    </div>
    <?php
    $DefaultActiveMonths = ReturnSessionalValues("GET", "ActiveMonths", IfRequested("GET", "ActiveMonths", DATE('Y-m'), null));

    // Fetch all stages at once
    if (AuthAppUser("UserType") == "ADMIN") {
        $AllStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC", true);
    } else {
        $AllStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC", true);
    }
    if ($AllStages != null) {

        // Optimize: Fetch all counts in one query using GROUP BY
        $StageCountsQuery = "SELECT leads_stages, SUM(leads_type = 'LEAD') AS total_leads, SUM(leads_type = 'DATA') AS total_data, COUNT(leads_id) AS total_records FROM leads, users WHERE leads.leads_managed_by=users.UserId and users.UserReportingManager='" . LOGIN_USER_ID . "' GROUP BY leads_stages";
        $StageCountsResult = SET_SQL($StageCountsQuery, true);

        // Convert results into an associative array for faster lookups
        $StageCounts = [];
        if ($StageCountsResult) {
            foreach ($StageCountsResult as $Row) {
                $StageCounts[$Row->leads_stages] = [
                    'total_leads' => $Row->total_leads,
                    'total_data' => $Row->total_data,
                    'total_records' => $Row->total_records,
                ];
            }
        }

        foreach ($AllStages as $Stages) {
            $stage_id = $Stages->config_leads_stages_id;
            $TotalLeads = isset($StageCounts[$stage_id]) ? $StageCounts[$stage_id]['total_leads'] : 0;
            $TotalData = isset($StageCounts[$stage_id]) ? $StageCounts[$stage_id]['total_data'] : 0;
            $TotalRecords = isset($StageCounts[$stage_id]) ? $StageCounts[$stage_id]['total_records'] : 0;
    ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
                <div class="app-widget-counter shadow-sm p-0" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                    <a href="<?php echo DOMAIN; ?>/mobile/leads?leads_stages=<?php echo $stage_id; ?>&leads_call_sub_status=">
                        <div class="d-block rounded-4 p-3 pt-3 pb-1 mb-0" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>">
                            <p class="text-black app-fs-3 mb-0 bold">
                                <small class="bold" style="font-weight: 900 !important;"><i class="fa fa-info-circle text-primary"></i> <?php echo $Stages->config_leads_stage_name; ?></small>
                            </p>
                            <h3 class="text-primary bold app-fs-5"><?php echo $TotalRecords; ?></h3>
                            <p class="text-secondary pull-right app-fs-2 mr-2" style="margin-top:-8.5vw !important;line-height:1rem;">
                                <span><b>DATA :</b> <b><?php echo $TotalData; ?></b></span><br>
                                <span><b>LEAD :</b> <b><?php echo $TotalLeads; ?></b></span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>