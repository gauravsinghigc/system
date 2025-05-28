<section class="site-visit-container" id="ReScheduleForm" style="display: none;padding:0rem !important;">
    <form class="data-container" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/SiteVisitController.php" style="width: 100% !important;bottom:0px !important;position:absolute !important;">
        <?php echo FormPrimaryInputs(true); ?>
        <input type="hidden" name="SiteVisitIdForBackend" id="SiteVisitIdDB2" value="">
        <input type="hidden" name="leads_main_id" id="LeadsReId" value="">
        <h1 class="app-heading app-fs-5"><i class="fa fa-map-marker text-warning"></i> Re-Schedule Site Visit Details</h1>
        <a class="btn btn-md btn-warning pull-right" onclick="ControlForms('ReScheduleForm')"><i class="fa fa-times"></i> Cancel</a>
        <div class="shadow-sm p-3 mb-3 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0 app-fs-4"><?php echo isset(ART_ICON['guest']) ? ART_ICON['guest'] : 'Guest'; ?> <span id="PersonName3"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0 app-fs-4"><?php echo isset(ART_ICON['call']) ? ART_ICON['call'] : 'Call'; ?> <span id="PersonPhoneNumber3"></span></h6>
        </div>
        <div class="row">
            <div class="col-md-12 mb-0">
                <div class="form-group p-3 pt-0 mb-1 pb-0">
                    <label class="app-fs-4">Managed By</label>
                    <select name="leads_site_visit_handled_by" class="form-control mb-1">
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
            </div>
            <div class="mb-1 col-md-12">
                <div class="p-3 form-group pt-0 mb-0">
                    <label for="visitDate" class="form-label app-fs-4">New Site Visit Date</label>
                    <input type="datetime-local" name="leads_site_visit_schedule_date" class="form-control" id="visitDate" required>
                </div>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-2">
            <button type="submit" name="ReScheduleSiteVisit" class="btn btn-success btn-lg br-5">Re-Schedule Site Visit <i class="fa fa-check text-warning"></i></button>
        </div>
    </form>

    <script>
        function ReScheduleSiteVisit(LeadsReId, SiteVisitId, PersonName, PersonPhoneNumber) {
            document.getElementById("LeadsReId").value = LeadsReId || '';
            document.getElementById("SiteVisitIdDB2").value = SiteVisitId || '';
            document.getElementById("PersonName3").innerHTML = PersonName || '';
            document.getElementById("PersonPhoneNumber3").innerHTML = PersonPhoneNumber || '';
            document.getElementById("ReScheduleForm").style.display = "block";
        }
    </script>
</section>