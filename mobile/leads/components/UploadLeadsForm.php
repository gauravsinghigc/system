<div id="uploadModal" class="modal">
    <div class="modal-content">
        <h4 class="app-heading">Upload Leads</h4>
        <form class="row" action="<?php echo CONTROLLER; ?>/Modulecontroller/LeadsController.php" method="POST" enctype="multipart/form-data">
            <?php echo FormPrimaryInputs(true); ?>
            <div class="form-group col-md-6">
                <label>Type</label>
                <select class="form-control" name="leads_upload_type" required>
                    <option value="">Select Type</option>
                    <option value="DATA" selected>Data</option>
                    <option value="LEADS">Leads</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Stage</label>
                <select class="form-control" name="leads_stages" required>
                    <option value="">Select Stage</option>
                    <?php
                    $AllLeadsStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                    foreach ($AllLeadsStages as $stage) {
                        $Selected = CheckEquality($stage->config_leads_stage_name, "FRESH", "selected");
                        echo "<option value='{$stage->config_leads_stages_id}' $Selected>{$stage->config_leads_stage_name}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-12">
                <label>Select CSV File</label>
                <input type="file" class="form-control" name="UploadedCsvFile" accept=".csv" required>
            </div>
            <div class="form-group col-md-12 text-center">
                <hr>
                <label>Download Format</label>
                <a href="<?php echo STORAGE_URL; ?>/ImportLeadsFormate.csv" download="ImportLeadsFormate.csv" class="btn btn-md btn-block btn-warning"><i class="bi bi-download"></i> Download CSV File</a>
            </div>
            <div class="col-md-12 text-right">
                <hr>
                <button type="submit" name="UploadCSVRecords" class="btn btn-primary btn-md"><i class="bi bi-upload text-success"></i> Upload</button>
                <button type="button" class="btn btn-default btn-md ml-2" onclick="closeModal('uploadModal')"><i class="bi bi-x-circle text-success"></i> Close</button>
            </div>
        </form>
    </div>
</div>
<script>
    function showUploadModal() {
        document.getElementById('uploadModal').style.display = 'block';
    }
</script>