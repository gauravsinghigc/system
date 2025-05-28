<div class="row mb-4">
    <?php
    $DefaultActiveMonths = ReturnSessionalValues("GET", "ActiveMonths", IfRequested("GET", "ActiveMonths", DATE('Y-m'), null));

    // Fetch all stages at once
    $AllStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC", true);
    if ($AllStages != null) {
        if (AuthAppUser("UserType") == "ADMIN") {
            $LoginLevelConditions = "leads_managed_by LIKE '%%'";
        } else {
            $LoginLevelConditions = "leads_managed_by = '" . LOGIN_USER_ID . "' ";
        }

        // Optimize: Fetch all counts in one query using GROUP BY
        $StageCountsQuery = "SELECT leads_stages, SUM(leads_type = 'LEAD') AS total_leads, SUM(leads_type = 'DATA') AS total_data, COUNT(*) AS total_records FROM leads WHERE $LoginLevelConditions GROUP BY leads_stages";
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
            <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                <div class="app-widget-counter p-3 pb-2" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>">
                    <a href="<?php echo DOMAIN; ?>/app/leads?leads_stages_dash=<?php echo $stage_id; ?>">
                        <div class="bg-white d-block rounded-3 p-2 pt-1 pb-1 mb-2">
                            <div class="days-counts pull-right mt-1 text-secondary small" style="line-height: 0.85rem !important;font-size:0.8rem !important;">
                                <span class="small">DATA : <b><?php echo $TotalData; ?></b></span><br>
                                <span class="small">LEAD : <b><?php echo $TotalLeads; ?></b></span>
                            </div>
                            <h1 class="text-primary bold mb-0 pb-0"><?php echo number_format($TotalRecords); ?></h1>
                            <p class="text-secondary mt-0 pt-0"><?php echo $Stages->config_leads_stage_name; ?> RECORDS</p>
                        </div>
                    </a>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>