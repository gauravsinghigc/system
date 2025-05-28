<section class="pop-section hidden" id="AddCallSubStatus">
    <div class="action-window w-75">
        <div class='container mt-3 mb-5'>
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/MasterDataController.php" enctype="multipart/form-data" method="POST">
                <?php echo FormPrimaryInputs(true); ?>
                <div class="col-md-12">
                    <h5 class="app-heading"><i class="bi bi-plus"></i> Add New Call Sub Stages</h5>
                </div>
                <div class="form-group col-md-3">
                    <label>Select Lead Stage </label>
                    <select class="form-control" id='NewCallStatus' name="config_call_sub_status_main_id" required>
                        <option value="">Select Call Stages</option>
                        <?php
                        $AllMainCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages where config_leads_stage_status='1' ORDER BY config_leads_stage_sort_by_order ASC", true);
                        if ($AllMainCallStatus != null) {
                            foreach ($AllMainCallStatus as $CallStatus) {
                                echo "<option value='" . $CallStatus->config_leads_stages_id . "'>" . $CallStatus->config_leads_stage_name . "</option>";
                            }
                        } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Call Sub Status Name</label>
                    <input type="text" class="form-control" name="config_call_sub_status_name" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Status</label>
                    <select class="form-control" name="config_call_sub_status_status" required>
                        <?php echo InputOptionsWithKey([
                            "" => "Select Status",
                            "1" => "Active",
                            "2" => "In-Active",
                        ], "1"); ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Remarks/Notes</label>
                    <textarea class="form-control" rows="2" name="config_call_sub_status_remarks"></textarea>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <hr>
                    <button type="submit" class="btn btn-dark btn-md" name="SaveCallSubStatus">Save Details <i class="bi bi-check text-success"></i></button>
                    <a class="btn btn-md btn-default" onclick="ControlForms('AddCallSubStatus')"><i class="bi bi-x-circle-fill"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function NewCallStatusOption() {
        var FreshCallStatusOption = document.getElementById("FreshCallStatusOption");
        var NewCallStatus = document.getElementById("NewCallStatus");

        if (NewCallStatus.value == "NEW") {
            FreshCallStatusOption.style.display = "block";
        } else {
            FreshCallStatusOption.style.display = "none";
        }
    }
</script>