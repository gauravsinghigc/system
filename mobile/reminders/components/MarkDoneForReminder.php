<section class="Instant-Feedback-Form" id="AddFeedBackForm" style="display: none;">
    <form class="feedback-container" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/ReminderController.php">
        <?php echo function_exists('FormPrimaryInputs') ? FormPrimaryInputs(true) : ''; ?>
        <input type="hidden" name="ReminderId" id="SiteVisitIdDB" value="">
        <input type="hidden" name="leads_main_id" id="LeadsReId" value="">
        <h1 class="app-heading app-fs-4"><i class="fa fa-plus text-success"></i> Add Feedback</h1>
        <a class="btn btn-lg btn-warning pull-right" onclick="ControlForms('AddFeedBackForm')"><i class="fa fa-times"></i> Cancel</a>
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
                            <label class="btn btn-xs m-1 app-fs-3 text-black bold" onclick="showSubStages('SubStagesFor_<?php echo $Stages->config_leads_stages_id; ?>')" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                <input type="radio" required style='margin-top:3px;' name="leads_acitivity_call_status" value="<?php echo $Stages->config_leads_stages_id; ?>">
                                <span class="bold app-fs-3 text-black" style="font-weight: bolder !important;"><?php echo $Stages->config_leads_stage_name; ?></span>
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
                                        <label class="btn btn-xs m-1 app-fs-4 text-black bold" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>;">
                                            <input type="radio" required style='margin-top:3px;' name="leads_acitivity_call_sub_status" value="<?php echo $SubStages->config_call_sub_status_id; ?>">
                                            <span class="bold app-fs-3 text-black" style="font-weight: bolder !important;"><?php echo $SubStages->config_call_sub_status_name; ?></span>
                                        </label>
                                    <?php } ?>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group mt-1">
                <label class="app-fs-3">Enter Feedback/Remarks</label>
                <div class="input-group">
                    <textarea name="leads_activity_feedbacks" required id="feedbackTextarea" rows="2" class="form-control" style="font-size:4vw !important;" placeholder="Speak or type your feedback..."></textarea>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <div class="w-50 mx-auto text-center">
                    <div class="f-activity">
                        <a href="tel:" class="mr-5" id="InstantCallPhoneNumber">
                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/call.png" loading="lazy" style="width:5rem;height:5rem;">
                        </a>
                        <span>OR</span>
                        <a id="InstantWhatsappChat" class="ml-5" href="whatsapp://send?phone=&text=Hello, this side *<?php echo AuthAppUser("UserFullName"); ?>* from *<?php echo APP_NAME; ?>*, ">
                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/whatsapp.png" loading="lazy" style="width:5rem;height:5rem;">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-4 mb-3">
            <hr>
            <button type="submit" name="AddFeedBackViaReminders" class="btn btn-success btn-lg circle app-fs-5 pl-5 pr-5">&nbsp;Save FeedBack <i class="fa fa-check text-warning app-fs-5"></i> &nbsp;</button>
        </div>
    </form>

    <script>
        function toggleFields(id, checkbox) {
            const section = document.getElementById(id);
            section.style.display = checkbox.checked ? 'block' : 'none';
        }

        function AddFeedbackForReminders(LeadsReId, SiteVisitId, PersonName, PersonPhoneNumber) {
            document.getElementById("LeadsReId").value = LeadsReId || '';
            document.getElementById("SiteVisitIdDB").value = SiteVisitId || '';
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