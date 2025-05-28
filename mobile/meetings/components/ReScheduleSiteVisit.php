<section class="Instant-Feedback-Form" id="ReScheduleForm" style="display: none;">
    <form class="feedback-container" style="padding:2rem !important;" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/SiteVisitController.php">
        <?php echo function_exists('FormPrimaryInputs') ? FormPrimaryInputs(true) : ''; ?>
        <input type="hidden" name="SiteVisitIdForBackend" id="SiteVisitIdDB" value="">
        <input type="hidden" name="leads_main_id" id="LeadsReId" value="">
        <h1 class="app-heading app-fs-5"><i class="fa fa-map-marker text-success"></i> Re-Schedule Site Visit Details</h1>
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0 app-fs-4"><?php echo isset(ART_ICON['guest']) ? ART_ICON['guest'] : 'Guest'; ?> <span id="PersonName"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0 app-fs-4"><?php echo isset(ART_ICON['call']) ? ART_ICON['call'] : 'Call'; ?> <span id="PersonPhoneNumber"></span></h6>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="app-fs-3">Managed By</label>
                <select name="leads_site_visit_handled_by" class="form-control form-control-lg">
                    <option value="<?php echo LOGIN_USER_ID; ?>" selected><?php echo AuthAppUser("UserFullName"); ?> (For Self)</option>
                    <?php
                    if (AuthAppUser("UserType") == "ADMIN") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId!='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    } else if (AuthAppUser("UserType") == "TEAM_HEAD") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId!='" . LOGIN_USER_ID . "' and UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    } else {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    }
                    if ($AllUsers != null) {
                        foreach ($AllUsers as $AllUser) {
                            $UserId = $AllUser->UserId;
                            $UserFullName = $AllUser->UserFullName;
                            $SelectedUser = CheckEquality($UserId, LOGIN_USER_ID, "selected");
                            echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                        }
                    } ?>
                </select>
            </div>
            <div class="mb-3 col-md-12">
                <label for="visitDate" class="form-label app-fs-3">Site Visit Date</label>
                <input type="datetime-local" name="leads_site_visit_schedule_date" class="form-control form-control-lg" id="visitDate" required>
            </div>
            <div class="mb-3 col-md-12">
                <div class="form-check text-center">
                    <label class="btn btn-sm btn-info text-white" for="addReminderCheckbox" onclick="ControlForms('reminderFields')">
                        <input class="form-check-input" hidden value="true" name="CheckReminderOption" type="checkbox" id="addReminderCheckbox" onchange="ControlForms('reminderFields')">
                        <?php echo ART_ICON['clock']; ?> Add Reminder for Next Call <?php echo ART_ICON['call']; ?>
                    </label>
                </div>

                <div id="reminderFields" style="display: none; margin-top: 10px;">
                    <div class="flex-s-b pl-3">
                        <div class="mb-3 w-50 m-1">
                            <label for="reminderDate" class="form-label app-fs-3">Reminder Date</label>
                            <input type="date" class="form-control form-control-lg" id="reminderDate" name="reminder_date">
                        </div>

                        <div class="mb-3 w-50 m-1">
                            <label for="reminderTime" class="form-label app-fs-3">Reminder Time</label>
                            <input type="time" class="form-control form-control-lg" id="reminderTime" name="reminder_time">
                        </div>
                    </div>

                    <div class="mb-3 w-100 m-1">
                        <label for="reminderMsg" class="form-label app-fs-3">Reminder Message</label>
                        <textarea class="form-control form-control-lg" id="reminderMsg" name="Reminder_Message" rows="1"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-4 mb-5">
            <hr>
            <button type="submit" name="ReScheduleSiteVisit" class="btn btn-success btn-lg circle app-fs-5">&nbsp; Re-Schedule Site Visit <i class="fa fa-check text-warning app-fs-4"></i> &nbsp;</button>
            <a class="btn btn-lg circle btn-warning" onclick="ControlForms('ReScheduleForm')"><i class="fa fa-times"></i> Cancel</a>
        </div>
    </form>

    <script>
        function ReScheduleSiteVisit(LeadsReId, SiteVisitId, PersonName, PersonPhoneNumber) {
            document.getElementById("LeadsReId").value = LeadsReId || '';
            document.getElementById("SiteVisitIdDB").value = SiteVisitId || '';
            document.getElementById("PersonName").innerHTML = PersonName || '';
            document.getElementById("PersonPhoneNumber").innerHTML = PersonPhoneNumber || '';
            document.getElementById("ReScheduleForm").style.display = "block";
        }
    </script>
</section>