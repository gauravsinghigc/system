 <form class="row">
     <div class="col-md-12">
         <h5 class="app-heading"><i class="bi bi-search"></i> Get Report For Leads</h5>
     </div>
     <div class="col-md-3 mb-2">
         <label>Leads Person Name</label>
         <input type="text" name="leads_full_name" class="form-control" placeholder="Enter Leads Person Name">
     </div>
     <div class="col-md-3 mb-2">
         <label>Phone Number</label>
         <input type="text" name="leads_phone_number" class="form-control" placeholder="Phone number">
     </div>
     <div class="col-md-3 mb-2">
         <label>Alt Phone Number</label>
         <input type="text" name="leads_alternate_phone" class="form-control" placeholder="Phone number">
     </div>
     <div class="col-md-3 mb-2">
         <label>Email-Id</label>
         <input type="text" name="leads_email_id" class="form-control" placeholder="Phone number">
     </div>
     <div class="col-md-3 mb-2">
         <label>Gender</label>
         <select class="form-select" name="leads_gender">
             <?php echo InputOptionsWithKey([
                    "" => "All Genders",
                    "Male" => "Male",
                    "Female" => "Female",
                    "Other" => "Other"
                ], IfRequested("GET", "leads_gender", "", null)); ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label>Marital Status</label>
         <select class="form-select" name="leads_marital_status">
             <?php echo InputOptionsWithKey([
                    "" => "All Marital Status",
                    "Single" => "Single",
                    "Married" => "Married",
                    "Divoreced" => "Divoreced",
                    "Widowed" => "Widowed",
                ], IfRequested("GET", "leads_marital_status", "", null)); ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Select Project</label>
         <select class="form-select" name="leads_project_id">
             <option value="">All Projects</option>
             <?php
                $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                if ($AllProjects != null) {
                    foreach ($AllProjects as $AllProject) {
                        $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                        $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                        $projects_id = $AllProject->projects_id;
                        $projects_name = $AllProject->projects_name;
                        $Selected = CheckEquality(IfRequested("GET", "leads_project_id", "", NULL), "selected");
                        echo "<option value='$projects_id' $Selected>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Lead Stage</label>
         <select class="form-select" name="leads_stages">
             <option value="">All Stages</option>
             <?php
                $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                if ($AllLeadsStages != null) {
                    foreach ($AllLeadsStages as $Stages) {
                        $Selected = CheckEquality(IfRequested("GET", "leads_stages", "", NULL), "selected");
                        echo "<option value='" . $Stages->config_leads_stages_id . "' $Selected>" . $Stages->config_leads_stage_name . "</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Lead Type</label>
         <select class="form-select" name="leads_type">
             <?php echo InputOptionsWithKey([
                    "" => "All Records",
                    "DATA" => "DATA",
                    "LEAD" => "LEAD",
                ], IfRequested("GET", "leads_type", "", null)); ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Lead Source</label>
         <select class="form-select" name="leads_source">
             <option value="">All Sources</option>
             <?php
                $AllLeadsSources = SET_SQL("SELECT config_leads_source_name, config_leads_source_id FROM config_leads_sources where config_leads_source_status='1' ORDER by config_leads_source_name ASC", true);
                if ($AllLeadsSources != null) {
                    foreach ($AllLeadsSources as $Sources) {
                        $Selected = CheckEquality(IfRequested("GET", "leads_source", "", NULL), "selected");
                        echo "<option value='" . $Sources->config_leads_source_id . "' $Selected>" . $Sources->config_leads_source_name . "</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Resources/Vendor</label>
         <select class="form-select form-control" name="leads_re_source">
             <option value="">All Resources</option>
             <?php
                $AllLeadsReSources = SET_SQL("SELECT config_leads_resources_name, config_leads_resources_id FROM config_leads_resources where config_leads_resources_status='1' ORDER by config_leads_resources_name ASC", true);
                if ($AllLeadsReSources != null) {
                    foreach ($AllLeadsReSources as $ReSources) {
                        $Selected = CheckEquality(IfRequested("GET", "leads_re_source", "", NULL), "selected");
                        echo "<option value='" . $ReSources->config_leads_resources_id . "' $Selected>" . $ReSources->config_leads_resources_name . "</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Leads Assigned To</label>
         <select class="form-select" name="leads_assigned_to">
             <option value="">By All Users</option>
             <?php
                $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                if ($AllUsers != null) {
                    foreach ($AllUsers as $Users) {
                        if ($Users->UserId == IfRequested("GET", "leads_assigned_to", "", null)) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Leads Created By</label>
         <select class="form-select" name="leads_assigned_by">
             <option value="">By All Users</option>
             <?php
                $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                if ($AllUsers != null) {
                    foreach ($AllUsers as $Users) {
                        if ($Users->UserId == IfRequested("GET", "leads_assigned_by", "", null)) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Uploaded By</label>
         <select class="form-select" name="leads_uploaded_by">
             <option value="">By All Users</option>
             <?php
                $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                if ($AllUsers != null) {
                    foreach ($AllUsers as $Users) {
                        if ($Users->UserId == IfRequested("GET", "leads_uploaded_by", "", null)) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                    }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label class="form-label">Priority Level</label><br>
         <select name="leads_assigned_priority_level" class="form-control">
             <option value="">All Priority Levels</option>
             <?php
                $AllPriorityLevels = SET_SQL("SELECT config_priority_level_id, config_priority_level_name FROM config_priority_levels where config_priority_level_status='1'", true);
                if ($AllPriorityLevels != null) {
                    foreach ($AllPriorityLevels as $Priority) {
                        $Selected = CheckEquality(IfRequested("GET", "leads_assigned_priority_level", "", null), $Priority->config_priority_level_id, "selected"); ?>
                     <option value="<?php echo $Priority->config_priority_level_id; ?>" <?php echo $Selected; ?>><?php echo $Priority->config_priority_level_name; ?></option>
             <?php }
                } ?>
         </select>
     </div>
     <div class="col-md-3 mb-2">
         <label>Order By</label>
         <select class="form-select" name="order_by">
             <?php echo InputOptionsWithKey([
                    "ASC" => "Ascending",
                    "DESC" => "Descending",
                ], IfRequested("GET", "order_by", "", null)); ?>
         </select>
     </div>
     <div class="col-md-12 mb-2">
         <label>&nbsp;<br></label>
         <button type="submit" name="ApplyFilters" class="btn mt-4 btn-md btn-primary"><i class="bi bi-search text-success"></i> Apply Filters & Search</button>
         <?php if (isset($_GET["ApplyFilters"])) { ?>
             <button type="button" onclick="window.location.href='?<?php echo $_SERVER['QUERY_STRING']; ?>&download_csv=1'" class="btn btn-md btn-warning mt-4 pull-right"><i class="bi bi-download"></i> Exports Records</button>
         <?php  } ?>
     </div>
 </form>