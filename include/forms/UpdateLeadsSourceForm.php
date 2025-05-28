<section class="pop-section hidden" id="Update_<?php echo $Records->config_leads_source_id; ?>">
    <div class="action-window w-75">
        <div class='container mt-3 mb-5'>
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/MasterDataController.php" enctype="multipart/form-data" method="POST">
                <?php echo FormPrimaryInputs(true, [
                    "config_leads_source_id" => $Records->config_leads_source_id
                ]); ?>
                <div class="col-md-12">
                    <h5 class="app-heading"><i class="bi bi-plus"></i> Update New Source</h5>
                </div>
                <div class="form-group col-md-5">
                    <label><?php echo TYPE_OF_RECORDS; ?> Source Name</label>
                    <input type="text" class="form-control" name="config_leads_source_name" value="<?php echo $Records->config_leads_source_name; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Color Tags</label>
                    <input type="color" class="form-control" style="height:2.4rem !important;" name="config_leads_source_color" value="<?php echo $Records->config_leads_source_color; ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Status</label>
                    <select class="form-control" name="config_leads_source_status" required>
                        <?php echo InputOptionsWithKey([
                            "" => "Select Status",
                            "1" => "Active",
                            "2" => "In-Active",
                        ], $Records->config_leads_source_status); ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Source Image (optional)</label>
                    <input type="FILE" class="form-control" name="config_leads_source_image">
                </div>
                <div class="form-group col-md-12">
                    <label>Remarks/Notes</label>
                    <textarea class="form-control" rows="2" name="config_leads_source_remarks"><?php echo SECURE($Records->config_leads_source_remarks, "d"); ?></textarea>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <hr>
                    <button type="submit" class="btn btn-dark btn-md" name="UpdateLeadsSources">Update Sources <i class="bi bi-check text-success"></i></button>
                    <a class="btn btn-md btn-default" onclick="ControlForms('Update_<?php echo $Records->config_leads_source_id; ?>')"><i class="bi bi-x-circle-fill"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>