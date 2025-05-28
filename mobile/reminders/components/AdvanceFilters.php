 <?php if (isset($_GET["AdvanceSiteVisitFilters"])) {
        $AdvanceFilters = "block";
    } else {
        $AdvanceFilters = "none";
    } ?>
 <div id="AdvanceFilters" style="display: <?php echo $AdvanceFilters; ?>;">
     <form class="row" method="GET">
         <div class="col-md-2 form-group app-advance-filter">
             <label>Reminder Name</label>
             <input type="text" class="form-control" name="leads_reminder_name" placeholder="Search Reminder Name..." value="<?php echo IfRequested("GET", "leads_reminder_name", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Person Name</label>
             <input type="text" class="form-control" name="leads_full_name" placeholder="Search Person Name..." value="<?php echo IfRequested("GET", "leads_full_name", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Phone Number</label>
             <input type="text" class="form-control" name="leads_phone_number" placeholder="Search Phone Number..." value="<?php echo IfRequested("GET", "leads_phone_number", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Reminder Status</label>
             <select name="leads_reminder_status" class="form-control">
                 <option value="">All Status</option>
                 <?php echo InputOptionsWithKey([
                        "0" => "Active",
                        "1" => "Work Done On Reminders",
                        "2" => "Dropped Reminders",
                        "3" => "Missed Reminders"
                    ], IfRequested("GET", "leads_reminder_status", "", false)); ?>
             </select>
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Reminder (From)</label>
             <input type="date" class="form-control" name="leads_reminder_date_from" value="<?php echo IfRequested("GET", "leads_reminder_date_from", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Reminder (To)</label>
             <input type="date" class="form-control" name="leads_reminder_date_to" value="<?php echo IfRequested("GET", "leads_reminder_date_to", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Reminder Scheduled For</label>
             <select name="leads_reminder_rescheduled_by" class="form-control">
                 <option value="">All Users</option>
                 <?php
                    if (AuthAppUser("UserType") == "ADMIN") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users ORDER BY UserFullName ASC", true);
                    } else if (AuthAppUser("UserType") == "TEAM_HEAD") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    } else {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    }
                    if ($AllUsers != null) {
                        foreach ($AllUsers as $AllUser) {
                            $UserId = $AllUser->UserId;
                            $UserFullName = $AllUser->UserFullName;
                            $SelectedUser = CheckEquality($UserId, $_GET["leads_reminder_rescheduled_by"], "selected");
                            echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                        }
                    } ?>
             </select>
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Created By</label>
             <select name="leads_reminder_created_by" class="form-control">
                 <option value="">All Users</option>
                 <?php
                    if (AuthAppUser("UserType") == "ADMIN") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users ORDER BY UserFullName ASC", true);
                    } else if (AuthAppUser("UserType") == "TEAM_HEAD") {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    } else {
                        $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                    }
                    if ($AllUsers != null) {
                        foreach ($AllUsers as $AllUser) {
                            $UserId = $AllUser->UserId;
                            $UserFullName = $AllUser->UserFullName;
                            $SelectedUser = CheckEquality($UserId, $_GET["leads_reminder_created_by"], "selected");
                            echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                        }
                    } ?>
             </select>
         </div>

         <div class="col-md-8 text-left">
             <label class="d-block">&nbsp;</label>
             <button type="submit" name="AdvanceSiteVisitFilters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Apply Filters</button>
             <a href="<?php echo APP_URL . "/reminders"; ?>" onclick="ControlForms('AdvanceFilters')" class="btn btn-sm btn-danger text-white"><i class="fa fa-times"></i> Clear Filter</a>
             <?php if (isset($_GET["AdvanceSiteVisitFilters"])) { ?>
                 <a href="exports.php?ExportSql=<?php echo SECURE($GeneratedSQL, "e"); ?>" class="btn btn-sm btn-warning text-black"><i class="fa fa-download"></i> Export Records</a>
             <?php } ?>
         </div>
     </form>
 </div>