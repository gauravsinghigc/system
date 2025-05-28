<div id="uploadModal" class="modal">
    <div class="modal-content">
        <h4 class="app-heading">Upload Leads</h4>
        <form id="UploadLeadForms" class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" enctype="multipart/form-data">
            <?php echo FormPrimaryInputs(true); ?>
            <div class="form-group col-md-12 text-center">
                <label>Download Format</label>
                <a href="<?php echo STORAGE_URL; ?>/ImportLeadsFormate.csv" download="ImportLeadsFormate.csv" class="btn btn-md btn-block btn-warning"><i class="bi bi-download"></i> Download CSV File</a>
            </div>
            <div class="col-md-12 text-center">
                <p class="alert alert-danger">
                    🎯 You can Upload Max <?php echo number_format(MAX_NUMBER_OF_UPLOADING_RECODS); ?> records in a single upload smoothly.<br>
                    There is a IN-BUILT phone number sanitizer that sanitize phone number likes, +91-, incomplete phone number, empty spaces, text & characters and prepare a valid phone number for you.
                </p>
            </div>
            <div class="col-md-12 form-group">
                <label class="form-label">Upload Records For</label>
                <select class="form-select form-control" name="leads_managed_by">
                    <option value="<?php echo LOGIN_USER_ID; ?>" selected><?php echo AuthAppUser("UserFullName"); ?> (For Self)</option>
                    <?php
                    if (AuthAppUser("UserType") == "ADMIN") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
                    } else {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users WHERE UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    }
                    foreach ($AllUsers as $Users) {
                        $selected = CheckEquality(IfRequested("GET", "leads_managed_by"), $Users->UserId, "selected");
                        // Check if the user is a lead manager or admin
                        echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                    } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Initialize Phone Number Type</label>
                <select class="form-control" name="leads_upload_type" required>
                    <option value="">Select Type</option>
                    <option value="DATA" selected>Data</option>
                    <option value="LEAD">Leads</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Initiate Phone Number Stage</label>
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
                <input type="file" class="form-control" onchange="EnableSubmit()" name="UploadedCsvFile" accept=".csv" required>
            </div>
            <div class="col-md-12 text-center">
                <div id="UploadAnimationAndCount" style="display: none;">
                    <img src="https://imgvisuals.com/cdn/shop/files/loader-progress-animation-retro-game-play-8bit-entertainment-action-round-arcade-classic-ball-circle-fun-eat-computer-mouth.gif?v=1742549443" class="w-pr-20 img-fluid" title="Removing Invalid Numbers">
                    <img src="https://media.lordicon.com/icons/wired/outline/2-cloud-upload.gif" class="w-pr-15 img-fluid" title="Uploading Pure Phone Number On Server">
                    <h6 class="small text-primary blink-data"><i class="fa fa-refresh fa-spin text-danger"></i> Sanitizing Phone Numbers</h6>
                    <p class="text-center mt-0 pt-0 small2">
                        <span class="btn btn-md text-primary">🧮 Total Numbers : <b id="TotalRecords"></b></span> |
                        <span class="btn btn-md text-success">⬆️ Uploading Numbers : <b id="UploadedRecords"></b></span>
                        <br>
                        <span class="btn btn-sm text-danger"><i class="fa fa-gear fa-spin text-danger"></i> Please wait while uploading and processing phone numbers...</span>
                    </p>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <hr>
                <button type="submit" onclick="UploadAnimation()" id="UploadBtn" name="UploadCSVRecords" class="btn btn-primary btn-md" style="display:none;">
                    <i class="bi bi-upload text-success"></i> Upload
                </button>
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

<script>
    function EnableSubmit() {
        var uploadBtn = document.getElementById("UploadBtn");
        uploadBtn.style.display = "";
    }

    function UploadAnimation() {
        var uploadBtn = document.getElementById("UploadBtn");
        uploadBtn.innerHTML = "<i class='fa fa-spinner fa-spin'></i> Uploading...";
        uploadBtn.classList.remove("btn-primary");
        uploadBtn.classList.add("btn-success");
        var UploadAnimationAndCount = document.getElementById("UploadAnimationAndCount");
        var TotalRecords = document.getElementById("TotalRecords");
        var UploadedRecords = document.getElementById("UploadedRecords");

        // Get the uploaded file
        var fileInput = document.querySelector('input[name="UploadedCsvFile"]');
        var file = fileInput.files[0];

        UploadAnimationAndCount.style.display = "";

        if (file) {
            // Read the CSV file
            var reader = new FileReader();
            reader.onload = function(e) {
                var text = e.target.result;
                var rows = text.split('\n').map(row => row.split(','));

                // Count valid phone numbers in the second column (index 1)
                var phoneCount = 0;
                for (var i = 1; i < rows.length; i++) { // Skip header row
                    var rawPhone = rows[i][1] ? rows[i][1].trim() : '';
                    var digitsOnly = rawPhone.replace(/[^0-9]/g, ''); // Remove all non-digits

                    // Remove country code if present
                    if (digitsOnly.length > 10) {
                        if (digitsOnly.startsWith('91') && digitsOnly.length === 12) {
                            digitsOnly = digitsOnly.substring(2); // Remove '91'
                        } else if (digitsOnly.startsWith('0') && digitsOnly.length === 11) {
                            digitsOnly = digitsOnly.substring(1); // Remove leading '0'
                        } else if (digitsOnly.startsWith('91') && digitsOnly.length > 12) {
                            // Handles numbers like '+919812345678' or '9198123456789'
                            digitsOnly = digitsOnly.slice(-10); // Take last 10 digits
                        }
                    }

                    // Validate: Must be exactly 10 digits and start with 6-9 (common in India)
                    if (/^[6-9]\d{9}$/.test(digitsOnly)) {
                        phoneCount++;
                        // Optional: If you want to replace or store back the clean 10-digit number
                        rows[i][1] = digitsOnly;
                    } else {
                        // Optionally mark as invalid
                        // rows[i][1] = 'Invalid';
                    }
                }

                function estimatePerRecordTime(recordCount) {
                    const x1 = 10000,
                        y1 = 1358;
                    const x2 = <?php echo MAX_NUMBER_OF_UPLOADING_RECODS; ?>,
                        y2 = <?php echo round(MAX_NUMBER_OF_UPLOADING_RECODS / 100 * 7); ?>;

                    // Linear interpolation formula: y = y1 + (x - x1) * (y2 - y1) / (x2 - x1)
                    const estimatedTime = y1 + (recordCount - x1) * (y2 - y1) / (x2 - x1);

                    return estimatedTime;
                }

                function estimateTotalTime(recordCount) {
                    const perRecord = estimatePerRecordTime(recordCount);
                    return recordCount * perRecord; // Total time in milliseconds
                }

                // Cap the count at 20,000
                phoneCount = Math.min(phoneCount, <?php echo MAX_NUMBER_OF_UPLOADING_RECODS; ?>);
                TotalRecords.innerHTML = phoneCount.toLocaleString();

                // Calculate animation parameters
                var duration = Math.round((phoneCount * 2.75)); // max dynamic alloted time for 50k records
                var startCount = 0;
                var endCount = phoneCount;
                var increment = endCount / (duration / estimatePerRecordTime(phoneCount)); // Adjust increment for 100 updates over duration

                // Start counting animation
                var currentCount = startCount;
                var interval = setInterval(function() {
                    currentCount += increment;
                    if (currentCount >= endCount) {
                        currentCount = endCount;
                        clearInterval(interval);
                    }
                    UploadedRecords.innerHTML = Math.floor(currentCount).toLocaleString();
                }, estimatePerRecordTime(phoneCount) / <?php echo round(rand(3, 7)); ?>); // dynamic time intervals
            };
            reader.readAsText(file);
        } else {
            // If no file, proceed with default animation
            UploadedRecords.innerHTML = "No Record Found!";
        }
    }
</script>