<section class="pop-section hidden" id="Update_<?php echo $Records->config_leads_stages_id; ?>">
    <div class="action-window w-75">
        <div class='container mt-3 mb-5'>
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/MasterDataController.php" enctype="multipart/form-data" method="POST">
                <?php echo FormPrimaryInputs(true, [
                    "config_leads_stages_id" => $Records->config_leads_stages_id
                ]); ?>
                <div class="col-md-12">
                    <h5 class="app-heading"><i class="bi bi-plus"></i> Update Call Status</h5>
                </div>
                <div class="form-group col-md-4">
                    <label>Call Status Name</label>
                    <input type="text" class="form-control" name="config_leads_stages_name" value="<?php echo $Records->config_leads_stages_name; ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Colour Tags</label>
                    <input type="color" class="form-control" style="height:2.4rem !important;" name="config_leads_stages_color_code" value="<?php echo $Records->config_leads_stages_color_code; ?>" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select class="form-control" name="config_leads_stages_status" required>
                        <?php echo InputOptionsWithKey([
                            "" => "Select Status",
                            "1" => "Active",
                            "2" => "In-Active",
                        ], $Records->config_leads_stages_status); ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Order By</label>
                    <input type="number" minlength="1" min='1' class="form-control" name="config_leads_stages_sort_by_order" value="<?php echo $Records->config_leads_stages_sort_by_order; ?>" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Remarks/Notes</label>
                    <textarea class="form-control" rows="2" name="config_leads_stages_remarks"><?php echo SECURE($Records->config_leads_stages_remarks, "d"); ?></textarea>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <hr>
                    <button type="submit" class="btn btn-dark btn-md" name="UpdateCallStatus">Update Details <i class="bi bi-check text-success"></i></button>
                    <a class="btn btn-md btn-default" onclick="ControlForms('Update_<?php echo $Records->config_leads_stages_id; ?>')"><i class="bi bi-x-circle-fill"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>