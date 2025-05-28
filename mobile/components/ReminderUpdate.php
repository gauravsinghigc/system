<section class="site-visit-container" id="AddFeedBackForm" style="display: none;padding:0px !important;">
    <form class="data-container pt-3" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/ReminderController.php" style="width: 100% !important;bottom:0px !important;position:absolute !important;">
        <?php echo FormPrimaryInputs(true); ?>
        <input type="hidden" name="ReminderId" id="ReminderListid" value="">
        <input type="hidden" name="leads_main_id" id="LeadsReIdDash" value="">
        <a class="btn btn-lg br-5 mb-2 btn-danger pull-right" onclick="ControlForms('AddFeedBackForm')"><i class="fa fa-times"></i> Cancel</a>
        <h1 class="app-heading app-fs-4"><i class="fa fa-plus text-success"></i> Add Feedback For Reminder</h1>
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0 app-fs-4"><?php echo isset(ART_ICON['guest']) ? ART_ICON['guest'] : 'Guest'; ?> <span id="PersonName"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0 app-fs-4"><?php echo isset(ART_ICON['call']) ? ART_ICON['call'] : 'Call'; ?> <span id="PersonPhoneNumber"></span></h6>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="w-100">
                    <label class="app-sub-heading w-100 d-block">Update Call Status</label>
                    <?php
                    $AllLeadStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id!='1' and config_leads_stage_status='1' ORDER BY config_leads_stage_sort_by_order ASC", true);
                    if ($AllLeadStages != null) {
                        foreach ($AllLeadStages as $Stages) { ?>
                            <label class="btn btn-sm text-black m-1" onclick="showSubStages('SubStagesFor_<?php echo $Stages->config_leads_stages_id; ?>')" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                <input type="radio" required style='margin-top:3px;' name="leads_acitivity_call_status" value="<?php echo $Stages->config_leads_stages_id; ?>">
                                <span class="bold app-fs-3"><?php echo $Stages->config_leads_stage_name; ?></span>
                            </label>
                    <?php }
                    } ?>
                </div>

                <div class="w-100 mt-3">
                    <label class="app-sub-heading w-100 d-block">Update Call Sub Status</label>
                    <?php
                    if ($AllLeadStages != null) {
                        foreach ($AllLeadStages as $Stages) {
                            $CallSubStages = SET_SQL("SELECT config_call_sub_status_id, config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_status='1' and config_call_sub_status_main_id='" . $Stages->config_leads_stages_id . "'", true);
                            if ($CallSubStages != null) { ?>
                                <div class="sub-stage-box" id="SubStagesFor_<?php echo $Stages->config_leads_stages_id; ?>" style="display:none;">
                                    <?php foreach ($CallSubStages as $SubStages) { ?>
                                        <label class="btn btn-sm text-black m-1" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                            <input type="radio" required style='margin-top:3px;' name="leads_acitivity_call_sub_status" value="<?php echo $SubStages->config_call_sub_status_id; ?>">
                                            <span class="bold app-fs-3"><?php echo $SubStages->config_call_sub_status_name; ?></span>
                                        </label>
                                    <?php } ?>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group mt-3">
                <label class="app-fs-3">Enter Feedback/Remarks</label>
                <div class="input-group">
                    <textarea name="leads_activity_feedbacks" style="font-size:4vw !important;" required id="feedbackTextarea" rows="2" class="form-control form-control-lg" placeholder="type your feedback..."></textarea>
                </div>
                <hr>
            </div>

            <div class="col-md-12 text-center">
                <div class="w-50 mx-auto text-center">
                    <div class="f-activity">
                        <a class="mr-5" href="tel:" id="InstantCallPhoneNumber">
                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/call.png" loading="lazy" style="width:5rem;height:5rem;">
                        </a>
                        <span>OR</span>
                        <a class="ml-5" id="InstantWhatsappChat" href="whatsapp://send?phone=&text=Hello, this side *<?php echo AuthAppUser("UserFullName"); ?>* from *<?php echo APP_NAME; ?>*, ">
                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/whatsapp.png" loading="lazy" style="width:5rem;height:5rem;">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-3">
            <hr>
            <button type="submit" name="AddFeedBackViaReminders" class="btn btn-success br-5 btn-lg app-fs-4">Save FeedBack <i class="fa fa-check text-warning"></i></button>
        </div>
    </form>

    <script>
        function toggleFields(id, checkbox) {
            const section = document.getElementById(id);
            section.style.display = checkbox.checked ? 'block' : 'none';
        }

        function AddFeedbackForReminders(LeadsReId, SiteVisitId, PersonName, PersonPhoneNumber) {
            document.getElementById("LeadsReIdDash").value = LeadsReId || '';
            document.getElementById("ReminderListid").value = SiteVisitId || '';
            document.getElementById("PersonName").innerHTML = PersonName || '';
            document.getElementById("PersonPhoneNumber").innerHTML = PersonPhoneNumber || '';
            document.getElementById("AddFeedBackForm").style.display = "block";

            var InstantCallPhoneNumber = document.getElementById("InstantCallPhoneNumber");
            var InstantWhatsappChat = document.getElementById("InstantWhatsappChat");

            // ✅ Inject Phone Number in HREFs
            InstantCallPhoneNumber.href = "tel:91" + PersonPhoneNumber;

            const userName = "<?php echo urlencode(AuthAppUser('UserFullName')); ?>";
            const appName = "<?php echo urlencode(APP_NAME); ?>";
            const encodedMessage = `Hello, this side *${userName}* from *${appName}*`;

            InstantWhatsappChat.href = `whatsapp://send?phone=${PersonPhoneNumber}&text=${encodedMessage}`;
        }

        function showSubStages(id) {
            // Hide all sub-stage divs first
            document.querySelectorAll('.sub-stage-box').forEach(function(div) {
                div.style.display = 'none';
            });

            // Show the selected one
            document.getElementById(id).style.display = 'block';
        }
    </script>

</section>