<section class="pop-section hidden" id="Update_<?php echo $Records->config_call_sub_status_id; ?>">
    <div class="action-window w-75">
        <div class='container mt-3 mb-5'>
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/MasterDataController.php" enctype="multipart/form-data" method="POST">
                <?php echo FormPrimaryInputs(true, [
                    "config_call_sub_status_id" => $Records->config_call_sub_status_id
                ]); ?>
                <div class="col-md-12">
                    <h5 class="app-heading"><i class="bi bi-plus"></i> Update Call Sub Status</h5>
                </div>
                <div class="form-group col-md-3">
                    <label>Select Call Stage </label>
                    <select class="form-control" onchange="NewCallStatusOption_<?php echo $Records->config_call_sub_status_id; ?>()" id='NewCallStatus_<?php echo $Records->config_call_sub_status_id; ?>' name="config_call_sub_status_main_id" required>
                        <option value="">Select Call Stage</option>
                        <?php
                        $AllMainCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages where config_leads_stage_status='1' ORDER BY config_leads_stage_sort_by_order ASC", true);
                        if ($AllMainCallStatus != null) {
                            foreach ($AllMainCallStatus as $CallStatus) {
                                $Selected = CheckEquality($CallStatus->config_leads_stages_id, $Records->config_call_sub_status_main_id, "selected");
                                echo "<option value='" . $CallStatus->config_leads_stages_id . "' $Selected>" . $CallStatus->config_leads_stage_name . "</option>";
                            }
                        } ?>

                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Call Sub Status Name</label>
                    <input type="text" class="form-control" value="<?php echo $Records->config_call_sub_status_name; ?>" name="config_call_sub_status_name" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Status</label>
                    <select class="form-control" name="config_call_sub_status_status" required>
                        <?php echo InputOptionsWithKey([
                            "" => "Select Status",
                            "1" => "Active",
                            "2" => "In-Active",
                        ], $Records->config_call_sub_status_status); ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Remarks/Notes</label>
                    <textarea class="form-control" rows="2" name="config_call_sub_status_remarks"><?php echo SECURE($Records->config_call_sub_status_remarks, "d"); ?></textarea>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <hr>
                    <button type="submit" class="btn btn-dark btn-md" name="UpdateCallSubStatus">Update Details <i class="bi bi-check text-success"></i></button>
                    <a class="btn btn-md btn-default" onclick="ControlForms('Update_<?php echo $Records->config_call_sub_status_id; ?>')"><i class="bi bi-x-circle-fill"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function NewCallStatusOption_<?php echo $Records->config_call_sub_status_id; ?>() {
        var FreshCallStatusOption_<?php echo $Records->config_call_sub_status_id; ?> = document.getElementById("FreshCallStatusOption_<?php echo $Records->config_call_sub_status_id; ?>");
        var NewCallStatus_<?php echo $Records->config_call_sub_status_id; ?> = document.getElementById("NewCallStatus_<?php echo $Records->config_call_sub_status_id; ?>");

        if (NewCallStatus_<?php echo $Records->config_call_sub_status_id; ?>.value == "NEW") {
            FreshCallStatusOption_<?php echo $Records->config_call_sub_status_id; ?>.style.display = "block";
        } else {
            FreshCallStatusOption_<?php echo $Records->config_call_sub_status_id; ?>.style.display = "none";
        }
    }
</script>