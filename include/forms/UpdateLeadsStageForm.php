<section class="pop-section hidden" id="Update_<?php echo $Stages->config_leads_stages_id; ?>">
    <div class="action-window w-75">
        <div class='container mt-3 mb-5'>
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/MasterDataController.php" method="POST">
                <?php echo FormPrimaryInputs(true, [
                    "config_leads_stages_id" => $Stages->config_leads_stages_id
                ]); ?>
                <div class="col-md-12">
                    <h5 class="app-heading"><i class="bi bi-plus"></i> Update New Stage</h5>
                </div>
                <div class="form-group col-md-4">
                    <label><?php echo TYPE_OF_RECORDS; ?> Stage Name</label>
                    <input type="text" class="form-control" name="config_leads_stage_name" value="<?php echo $Stages->config_leads_stage_name; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Sort By Order</label>
                    <input type="number" class="form-control" min='1' minlength="1" name="config_leads_stage_sort_by_order" value="<?php echo $Stages->config_leads_stage_sort_by_order; ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Color Tags</label>
                    <input type="color" class="form-control" style="height:2.4rem !important;" name="config_leads_stage_color_code" value="<?php echo $Stages->config_leads_stage_color_code; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Status</label>
                    <select class="form-control" name="config_leads_stage_status" required>
                        <?php echo InputOptionsWithKey([
                            "" => "Select Status",
                            "1" => "Active",
                            "2" => "In-Active",
                        ], $Stages->config_leads_stage_status); ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Stage Remarks</label>
                    <textarea class="form-control" rows="2" name="config_leads_stage_remarks"><?php echo SECURE($Stages->config_leads_stage_remarks, "d"); ?></textarea>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <hr>
                    <button type="submit" class="btn btn-dark btn-md" name="UpdateLeadsStages">Update Stages <i class="bi bi-check text-success"></i></button>
                    <a class="btn btn-md btn-default" onclick="ControlForms('Update_<?php echo $Stages->config_leads_stages_id; ?>')"><i class="bi bi-x-circle-fill"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>