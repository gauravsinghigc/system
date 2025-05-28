<section class="pop-section hidden" id="Update_<?php echo $Records->config_leads_resources_id; ?>">
    <div class="action-window w-75">
        <div class='container mt-3 mb-5'>
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/MasterDataController.php" method="POST">
                <?php echo FormPrimaryInputs(true, [
                    "config_leads_resources_id" => $Records->config_leads_resources_id
                ]); ?>
                <div class="col-md-12">
                    <h5 class="app-heading"><i class="bi bi-plus"></i> Update Resources</h5>
                </div>
                <div class="form-group col-md-6">
                    <label>Update <?php echo TYPE_OF_RECORDS; ?> Resources Name</label>
                    <input type="text" class="form-control" value="<?php echo $Records->config_leads_resources_name; ?>" name="config_leads_resources_name" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Status</label>
                    <select class="form-control" name="config_leads_resources_status" required>
                        <?php echo InputOptionsWithKey([
                            "" => "Select Status",
                            "1" => "Active",
                            "2" => "In-Active",
                        ], $Records->config_leads_resources_status); ?>
                    </select>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <hr>
                    <button type="submit" class="btn btn-dark btn-md" name="UpdateLeadsResouces">Update Resources <i class="bi bi-check text-success"></i></button>
                    <a class="btn btn-md btn-default" onclick="ControlForms('Update_<?php echo $Records->config_leads_resources_id; ?>')"><i class="bi bi-x-circle-fill"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>