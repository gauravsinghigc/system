<section class="site-visit-container" id="ReScheduleForm" style="display: none;">
    <form class="data-container" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/SiteVisitController.php">
        <?php echo function_exists('FormPrimaryInputs') ? FormPrimaryInputs(true) : ''; ?>
        <input type="hidden" name="SiteVisitIdForBackend" id="SiteVisitIdDB1" value="">
        <input type="hidden" name="leads_main_id" id="LeadsReId" value="">
        <h1 class="app-heading"><i class="fa fa-map-marker text-success"></i> Re-Schedule Site Visit Details</h1>
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0"><?php echo isset(ART_ICON['guest']) ? ART_ICON['guest'] : 'Guest'; ?> <span id="PersonName1"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0"><?php echo isset(ART_ICON['call']) ? ART_ICON['call'] : 'Call'; ?> <span id="PersonPhoneNumber1"></span></h6>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label>Managed By</label>
                <select name="leads_site_visit_handled_by" class="form-control">
                    <option value="<?php echo LOGIN_USER_ID; ?>" selected><?php echo AuthAppUser("UserFullName"); ?> (Assigned For Self)</option>
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
                <label for="visitDate" class="form-label">Site Visit Date</label>
                <input type="datetime-local" name="leads_site_visit_schedule_date" class="form-control" id="visitDate" required>
            </div>
            <div class="mb-3 col-md-12">
                <div class="form-check">
                    <input class="form-check-input" value="true" name="CheckReminderOption" type="checkbox" id="addReminderCheckbox" onchange="toggleReminderFields()">
                    <label class="form-check-label" for="addReminderCheckbox">
                        <?php echo ART_ICON['clock']; ?> Add Reminder for Next Call <?php echo ART_ICON['call']; ?>
                    </label>
                </div>

                <div id="reminderFields" style="display: none; margin-top: 10px;">
                    <div class="flex-s-b">
                        <div class="mb-3 w-50 m-1">
                            <label for="reminderDate" class="form-label">Reminder Date</label>
                            <input type="date" class="form-control" id="reminderDate" name="reminder_date">
                        </div>

                        <div class="mb-3 w-50 m-1">
                            <label for="reminderTime" class="form-label">Reminder Time</label>
                            <input type="time" class="form-control" id="reminderTime" name="reminder_time">
                        </div>
                    </div>

                    <div class="mb-3 w-100 m-1">
                        <label for="reminderMsg" class="form-label">Reminder Message</label>
                        <textarea class="form-control" id="reminderMsg" name="Reminder_Message" rows="1"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-3">
            <hr>
            <button type="submit" name="ReScheduleSiteVisit" class="btn btn-dark btn-md">Re-Schedule Site Visit <i class="fa fa-check text-success"></i></button>
            <a class="btn btn-md btn-default" onclick="ControlForms('ReScheduleForm')"><i class="fa fa-times"></i> Cancel</a>
        </div>
    </form>

    <script>
        function ReScheduleSiteVisit(LeadsReId, SiteVisitId, PersonName, PersonPhoneNumber) {
            document.getElementById("LeadsReId").value = LeadsReId || '';
            document.getElementById("SiteVisitIdDB1").value = SiteVisitId || '';
            document.getElementById("PersonName1").innerHTML = PersonName || '';
            document.getElementById("PersonPhoneNumber2").innerHTML = PersonPhoneNumber || '';
            document.getElementById("ReScheduleForm").style.display = "block";
        }
    </script>
</section>