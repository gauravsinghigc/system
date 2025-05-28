<div class="row">
    <div class="col-md-12">
        <div class="flex-s-b mb-3">
            <h5 class="mb-0 pb-0 app-sub-heading w-pr-80"><i class="<?php echo MASTER_DATA_MENUS[$ActiveMasterMenu]['icon']; ?>"></i> <?php echo MASTER_DATA_MENUS[$ActiveMasterMenu]['name']; ?></h5>
            <a class="btn btn-md btn-danger mb-0 w-pr-20 ml-1" onclick="ControlForms('LeadStageForm')"><i class="bi bi-plus"></i> Add Stage</a>
        </div>
    </div>

    <div class="col-md-12">
        <?php
        $StageSQL = "SELECT * FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC";
        $GetAllStages = SET_SQL($StageSQL, true);
        $SerialNo = 0;
        if ($GetAllStages != null) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th><span class="d-heading active text-left">S No</span></th>
                            <th> <span class="d-heading active text-left">Stage Name</span></th>
                            <th><span class="d-heading active text-left">Colour Code</span></th>
                            <th><span class="d-heading active text-left">Status</span></th>
                            <th><span class="d-heading active text-left">CreatedAt</span></th>
                            <th><span class="d-heading active">SortOrder</span></th>
                            <th><span class="d-heading active text-right">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GetAllStages as $Stages) {
                            $SerialNo++; ?>
                            <tr>
                                <td>
                                    <span class="text-left data"><?php echo $SerialNo; ?></span>
                                </td>
                                <td>
                                    <span class="bold"><?php echo $Stages->config_leads_stage_name; ?></span>
                                </td>
                                <td>
                                    <span class="color-tags" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                        <?php echo $Stages->config_leads_stage_color_code; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo StatusViewWithText($Stages->config_leads_stage_status); ?>
                                </td>
                                <td>
                                    <span class="text-left data"><?php echo DATE_FORMATES("d M, Y h:m A", $Stages->config_leads_stage_created_at); ?></span>
                                </td>
                                <td>
                                    <span class="text-left data"><?php echo $Stages->config_leads_stage_sort_by_order; ?></span>
                                </td>
                                <td>
                                    <button type="button" onclick="ControlForms('Update_<?php echo $Stages->config_leads_stages_id; ?>')" class="btn btn-outline-dark btn-xs"><i class="bi bi-pencil-fill"></i> Edit</button>
                                    <?php echo CONFIRM_DELETE_POPUP(
                                        'LeadsStages',
                                        [
                                            "RemoveLeadsStageRecords" => "true",
                                            "RecordsId" => $Stages->config_leads_stages_id
                                        ],
                                        CONTROLLER . "/SystemController/MasterDataController.php",
                                        "<i class='fa fa-trash'></i>",
                                        "btn btn-xs btn-outline-danger"
                                    ); ?>
                                    <?php include __DIR__ . "/../../../include/forms/UpdateLeadsStageForm.php"; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "<div class='alert alert-warning'><i class='bi bi-exclamation-triangle'></i> No Stage Found</div>";
        } ?>
    </div>
</div>

<?php include __DIR__ . "/../../../include/forms/AddLeadsStageForm.php"; ?>