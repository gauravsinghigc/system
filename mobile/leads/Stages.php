<div class="col-md-12">
    <div class="sub-stage-counters">
        <?php
        $DefaultActiveMonths = ReturnSessionalValues("GET", "ActiveMonths", IfRequested("GET", "ActiveMonths", DATE('Y-m'), null));

        // Fetch all stages at once
        $AllStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC", true);
        if ($AllStages != null) {
            $LoginLevelConditions = "leads_managed_by='" . LOGIN_USER_ID . "'";

            // Optimize: Fetch all counts in one query using GROUP BY
            $StageCountsQuery = "SELECT leads_stages, SUM(leads_type='LEAD') AS total_leads, SUM(leads_type='DATA') AS total_data, COUNT(leads_id) AS total_records FROM leads WHERE $LoginLevelConditions GROUP BY leads_stages";
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
                <div class="app-widget-counter mb-2">
                    <a href="<?php echo DOMAIN; ?>/mobile/leads?leads_stages=<?php echo $stage_id; ?>&leads_call_sub_status=">
                        <div class="d-block pt-3 rounded-3 p-2 pb-0 mb-0">
                            <p class="text-secondary app-fs-2 mt-2 mb-0 p-1 circle bold" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>">
                                <span class="ml-2 bold"><i class="fa fa-info-circle text-primary"></i> <?php echo $Stages->config_leads_stage_name; ?></span>
                            </p>
                            <h3 class="text-primary bold app-fs-6"><?php echo $TotalRecords; ?></h3>
                            <p class="text-muted pb-0 flex-s-b app-fs-2 mt-1">
                                <span><b>DATA :</b> <b><?php echo TOTAL($UserLeadsSQL . " and leads_stages='" . $stage_id . "' and leads_type='DATA'"); ?></b></span><br>
                                <span><b>LEAD :</b> <b><?php echo TOTAL($UserLeadsSQL . " and leads_stages='" . $stage_id . "' and leads_type='LEAD'"); ?></b></span>
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