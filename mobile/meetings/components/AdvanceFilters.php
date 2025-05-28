 <?php if (isset($_GET["AdvanceSiteVisitFilters"])) {
        $AdvanceFilters = "block";
    } else {
        $AdvanceFilters = "none";
    } ?>
 <div id="AdvanceFilters" style="display: <?php echo $AdvanceFilters; ?>;">
     <form class="row" method="GET">
         <div class="col-md-2 form-group app-advance-filter">
             <label>Person Name</label>
             <input type="text" class="form-control" name="leads_full_name" placeholder="Search Person Name..." value="<?php echo IfRequested("GET", "leads_full_name", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Phone Number</label>
             <input type="text" class="form-control" name="leads_phone_number" placeholder="Search Phone Number..." value="<?php echo IfRequested("GET", "leads_phone_number", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Project Name</label>
             <select name="leads_site_visits_projects_id" class="form-control">
                 <option value="">All Project</option>
                 <?php
                    $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                    if ($AllProjects != null) {
                        foreach ($AllProjects as $AllProject) {
                            $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                            $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                            $projects_id = $AllProject->projects_id;
                            $projects_name = $AllProject->projects_name;
                            $SelectedProject = CheckEquality($projects_id, $_GET["leads_site_visits_projects_id"], "selected");
                            echo "<option value='$projects_id' $SelectedProject>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                        }
                    } ?>
             </select>
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Site Visit Status</label>
             <select name="leads_site_visit_status" class="form-control">
                 <option value="">All Status</option>
                 <?php echo InputOptionsWithKey([
                        "1" => "Scheduled",
                        "2" => "Completed",
                        "3" => "Cancelled",
                        "4" => "Missed"
                    ], IfRequested("GET", "leads_site_visit_status", "", false)); ?>
             </select>
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Site Visit Date (From)</label>
             <input type="date" class="form-control" name="leads_site_visit_schedule_date_from" value="<?php echo IfRequested("GET", "leads_site_visit_schedule_date_from", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Site Visit Date (To)</label>
             <input type="date" class="form-control" name="leads_site_visit_schedule_date_to" value="<?php echo IfRequested("GET", "leads_site_visit_schedule_date_to", "", false); ?>">
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Managed By</label>
             <select name="leads_site_visit_handled_by" class="form-control">
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
                            $SelectedUser = CheckEquality($UserId, $_GET["leads_site_visit_handled_by"], "selected");
                            echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                        }
                    } ?>
             </select>
         </div>
         <div class="col-md-2 form-group app-advance-filter">
             <label>Created By</label>
             <select name="leads_site_visit_created_by" class="form-control">
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
                            $SelectedUser = CheckEquality($UserId, $_GET["leads_site_visit_created_by"], "selected");
                            echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                        }
                    } ?>
             </select>
         </div>

         <div class="col-md-8 text-left">
             <label class="d-block">&nbsp;</label>
             <button type="submit" name="AdvanceSiteVisitFilters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Apply Filters</button>
             <a href="<?php echo APP_URL . "/meetings"; ?>" onclick="ControlForms('AdvanceFilters')" class="btn btn-sm btn-danger text-white"><i class="fa fa-times"></i> Clear Filter</a>
             <?php if (isset($_GET["leads_site_visit_schedule_date_from"])) { ?>
                 <a href="exports.php?ExportSql=<?php echo SECURE($GeneratedSQL, "e"); ?>" class="btn btn-sm btn-warning text-black"><i class="fa fa-download"></i> Export Records</a>
             <?php } ?>
         </div>
     </form>
 </div>