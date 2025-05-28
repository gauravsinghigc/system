  <div class="row mb-2 pl-4 pr-4">
      <?php
        $AllStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name, config_leads_stage_color_code FROM config_leads_stages ORDER BY config_leads_stage_sort_by_order ASC", true);
        if ($AllStages != null) {
            $LoginLevelConditions = "leads_managed_by='$SelectedUserId'";

            // Optimize: Fetch all counts in one query using GROUP BY
            $StageCountsQuery = "SELECT leads_stages, SUM(leads_type = 'LEAD') AS total_leads, SUM(leads_type = 'DATA') AS total_data, COUNT(*) AS total_records FROM leads WHERE $LoginLevelConditions GROUP BY leads_stages";
            $StageCountsResult = SET_SQL($StageCountsQuery, true);

            // Convert results into an associative array for faster lookups
            $StageCounts = [];
            if ($StageCountsResult) {
                foreach ($StageCountsResult as $Row) {
                    $StageCounts[$Row->leads_stages] = [
                        'total_leads' => $Row->total_leads,
                        'total_data' => $Row->total_data,
                        'total_records' => $Row->total_records,
                    ];
                }
            }

            foreach ($AllStages as $Stages) {
                $stage_id = $Stages->config_leads_stages_id;
                $TotalLeads = isset($StageCounts[$stage_id]) ? $StageCounts[$stage_id]['total_leads'] : 0;
                $TotalData = isset($StageCounts[$stage_id]) ? $StageCounts[$stage_id]['total_data'] : 0;
                $TotalRecords = isset($StageCounts[$stage_id]) ? $StageCounts[$stage_id]['total_records'] : 0;
        ?>
              <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-2">
                  <div class="app-widget-counter p-2 pb-1" style="background-color:<?php echo $Stages->config_leads_stage_color_code; ?>">
                      <a href="?LeadsView=true&leads_stages_dash=<?php echo $stage_id; ?>">
                          <div class="bg-white d-block rounded-3 p-2 pt-1 pb-1 mb-2">
                              <div class="days-counts pull-right mt-1 text-secondary small" style="line-height: 0.85rem !important;font-size:0.8rem !important;">
                                  <span class="small">DATA : <b><?php echo $TotalData; ?></b></span><br>
                                  <span class="small">LEAD : <b><?php echo $TotalLeads; ?></b></span>
                              </div>
                              <h1 class="text-primary bold mb-0 pb-0"><?php echo $TotalRecords; ?></h1>
                              <p class="text-secondary mt-0 pt-0"><?php echo $Stages->config_leads_stage_name; ?> RECORDS</p>
                          </div>
                      </a>
                  </div>
              </div>
      <?php
            }
        }
        ?>
  </div>
  <div class="records-selection-list" style="display:none;" id="SelectionActivityOptions">
      <div class="action-buttons">
          <div style="display:none;" id='AssignButtonOption' class="m-1">
              <button class="btn btn-sm btn-primary" onclick="showAssignModal()"><i class="bi bi-person-check text-success"></i> Assign Leads</button>
          </div>
          <div style="display:none;" id='RemoveButtonOption' class="m-1">
              <button class="btn btn-sm btn-danger" onclick="showRemoveModal()"><i class="bi bi-trash text-white"></i> Remove Records</button>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12">
          <div class="pull-right m-1">
              <button class="btn btn-sm btn-light" onclick="ControlForms('AdvanceFilters')"><i class="bi bi-filter text-success"></i> Advance Filters</button>
          </div>
      </div>
  </div>

  <?php $FilterForm = isset($_GET["ApplyAdvancefilters"]) ? "block" : "none"; ?>
  <div id="AdvanceFilters" style='display:<?php echo $FilterForm; ?>;'>
      <div class="card">
          <div class="card-body pt-2">
              <form class="row">
                  <input type="hidden" name="leads_managed_by" value="<?php echo $SelectedUserId; ?>">
                  <div class="col-md-12 form-group app-advance-filter text-right">
                      <a href="index.php" class="btn btn-sm btn-danger" onclick="ControlForms('AdvanceFilters')"><i class="bi bi-x"></i> Close Filters</a>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Type</label>
                      <select class="form-select form-control" name="leads_type">
                          <?php echo InputOptionsWithKey([
                                "" => "All Records",
                                "LEAD" => "All LEAD",
                                "DATA" => "All DATA",
                            ], IfRequested("GET", "leads_type", "", null)); ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label class="form-label">Leads Stage</label>
                      <select class="form-select form-control" name="leads_stages" id="callStatus">
                          <option value="">All Calls</option>
                          <?php
                            $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                            if ($AllLeadsStages != null) {
                                foreach ($AllLeadsStages as $Stages) {
                                    $Selected = CheckEquality(IfRequested("GET", "leads_stages"), $Stages->config_leads_stages_id, "selected");
                                    echo "<option value='" . $Stages->config_leads_stages_id . "' $Selected>" . $Stages->config_leads_stage_name . "</option>";
                                }
                            }
                            ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label class="form-label">Lead Sub-Stages</label>
                      <select class="form-select form-control" name="leads_sub_stages" id="callSubStatus">
                          <option value="">All Leads</option>
                          <?php if (isset($_GET["leads_sub_stages"])) {
                                if ($_GET["leads_sub_stages"] != null || $_GET["leads_sub_stages"] != "" || $_GET["leads_sub_stages"] != " ") {
                                    $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_main_id='" . $_GET["leads_stages"] . "'", true);
                                    if ($AllCallSubStatus != null) {
                                        foreach ($AllCallSubStatus as $SubCallStatus) {
                                            $Selected = CheckEquality(IfRequested("GET", "leads_sub_stages"), $SubCallStatus->config_call_sub_status_id, "selected");
                                            echo "<option value='" . $SubCallStatus->config_call_sub_status_id . "' $Selected>" . $SubCallStatus->config_call_sub_status_name . "</option>";
                                        }
                                    }
                                }
                            } ?>
                      </select>
                  </div>
                  <div class="col-md-3 app-advance-filter form-group">
                      <label class="form-label">Select Project</label>
                      <select class="form-select form-control" name="leads_projects_id">
                          <option value="">All Projects</option>
                          <?php
                            $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                            if ($AllProjects != null) {
                                foreach ($AllProjects as $AllProject) {
                                    $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                                    $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                                    $projects_id = $AllProject->projects_id;
                                    $projects_name = $AllProject->projects_name;
                                    $Selected = CheckEquality(IfRequested("GET", "leads_project_id"), $projects_id, "selected");
                                    echo "<option value='$projects_id' $Selected>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                                }
                            } ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Sources</label>
                      <select class="form-select form-control" name="leads_source">
                          <option value="">All Sources</option>
                          <?php
                            $AllLeadsSources = SET_SQL("SELECT config_leads_source_name, config_leads_source_id FROM config_leads_sources where config_leads_source_status='1' ORDER by config_leads_source_name ASC", true);
                            if ($AllLeadsSources != null) {
                                foreach ($AllLeadsSources as $Sources) {
                                    $Selected = CheckEquality(IfRequested("GET", "leads_source"), $Sources->config_leads_source_id, "selected");
                                    echo "<option value='" . $Sources->config_leads_source_id . "' $Selected>" . $Sources->config_leads_source_name . "</option>";
                                }
                            } ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label class="form-label">Resources/Vendor</label>
                      <select class="form-select form-control" name="leads_re_source">
                          <option value="">All Re-Source/Vendors</option>
                          <?php
                            $AllLeadsReSources = SET_SQL("SELECT config_leads_resources_name, config_leads_resources_id FROM config_leads_resources where config_leads_resources_status='1' ORDER by config_leads_resources_name ASC", true);
                            if ($AllLeadsReSources != null) {
                                foreach ($AllLeadsReSources as $ReSources) {
                                    $selected = CheckEquality(IfRequested("GET", "leads_re_source"), $ReSources->config_leads_resources_id, "selected");
                                    echo "<option value='" . $ReSources->config_leads_resources_id . "' $selected>" . $ReSources->config_leads_resources_name . "</option>";
                                }
                            } ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label class="form-label">Leads Created By</label>
                      <select class="form-select form-control" name="leads_assigned_by">
                          <option value="">All Users</option>
                          <?php
                            $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users", true);
                            if ($AllUsers != null) {
                                foreach ($AllUsers as $Users) {
                                    $selected = CheckEquality(IfRequested("GET", "leads_assigned_by"), $Users->UserId, "selected");
                                    // Check if the user is a lead manager or admin
                                    echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                                }
                            } ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Added On (From)</label>
                      <input accept="date" type="date" class="form-control" name="leads_added_on_from_date" value="<?php echo IfRequested("GET", "leads_added_on_from_date", "", null); ?>">
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Added On (To)</label>
                      <input accept="date" type="date" class="form-control" name="leads_added_on_to_date" value="<?php echo IfRequested("GET", "leads_added_on_to_date", "", null); ?>">
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Assigned On (From)</label>
                      <input accept="date" type="date" class="form-control" name="leads_assigned_on_from_date" value="<?php echo IfRequested("GET", "leads_assigned_on_from_date", "", null); ?>">
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Assigned On (To)</label>
                      <input accept="date" type="date" class="form-control" name="leads_assigned_on_to_date" value="<?php echo IfRequested("GET", "leads_assigned_on_to_date", "", null); ?>">
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Updated On (From)</label>
                      <input accept="date" type="date" class="form-control" name="leads_updated_at_from" value="<?php echo IfRequested("GET", "leads_updated_at_from", "", null); ?>">
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label>Leads Updated On (To)</label>
                      <input accept="date" type="date" class="form-control" name="leads_updated_at_to" value="<?php echo IfRequested("GET", "leads_updated_at_to", "", null); ?>">
                  </div>
                  <div class="col-md-3 form-group app-advance-filter">
                      <label class="form-label">Leads Uploaded By</label>
                      <select class="form-select form-control" name="leads_uploaded_by">
                          <option value="">All Users</option>
                          <?php
                            $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users", true);
                            if ($AllUsers != null) {
                                foreach ($AllUsers as $Users) {
                                    $selected = CheckEquality(IfRequested("GET", "leads_uploaded_by"), $Users->UserId, "selected");
                                    // Check if the user is a lead manager or admin
                                    echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
                                }
                            } ?>
                      </select>
                  </div>
                  <div class="col-md-3 form-group app-advance-filter pt-4">
                      <button type="submit" value="true" name="ApplyAdvancefilters" class="btn btn-sm btn-dark"><i class="bi bi-filter"></i> Apply Filters</button>
                  </div>
                  <?php if (isset($_GET["ApplyAdvancefilters"])) { ?>
                      <div class="col-md-12 text-right form-group app-advance-filter pt-4">
                          <?php
                            if (isset($_GET["ApplyAdvancefilters"])) {
                                $ExportFilters = "";
                                foreach ($_GET as $Key => $Values) {
                                    $ExportFilters .= "&$Key=$Values";
                                }
                            }
                            ?>
                          <a href="javascript:void(0);" id="export-btn" data-url="exports.php?ExportRecords=true<?php echo $ExportFilters; ?>" class="btn btn-sm btn-warning">
                              <i class="bi bi-download"></i> Export Records
                          </a>
                      </div>
                  <?php } ?>
              </form>
          </div>
      </div>
      <script>
          document.getElementById("export-btn").addEventListener("click", function() {
              const btn = this;
              const originalText = btn.innerHTML;
              const exportUrl = btn.getAttribute("data-url");

              const steps = [{
                      text: 'Preparing Record...',
                      icon: 'fas fa-refresh fa-spin',
                      class: 'btn-success'
                  },
                  {
                      text: 'Preparing CSV...',
                      icon: 'fas fa-refresh fa-spin',
                      class: 'btn-warning'
                  },
                  {
                      text: 'Generating Report...',
                      icon: 'fas fa-refresh fa-spin',
                      class: 'btn-danger'
                  }
              ];

              let step = 0;

              const animate = setInterval(() => {
                  if (step < steps.length) {
                      btn.innerHTML = `<i class="${steps[step].icon}"></i> ${steps[step].text}`;
                      btn.className = `btn btn-sm ${steps[step].class}`;
                      step++;
                  } else {
                      clearInterval(animate);
                      window.location.href = exportUrl;
                      btn.innerHTML = originalText;
                      btn.className = "btn btn-sm btn-warning";
                  }
              }, 500); // each step takes 1s
          });
      </script>

      <!-- Call Status and Sub-Status Handling Script -->
      <script>
          // Call Status and Sub-Status Data
          const subStatusData = {
              <?php
                $AllCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages WHERE config_leads_stage_status='1' ORDER BY config_leads_stages_id ASC", true);
                if ($AllCallStatus != null) {
                    $output = [];
                    foreach ($AllCallStatus as $MainCallStatus) {
                        $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_main_id='" . $MainCallStatus->config_leads_stages_id . "'", true);
                        if ($AllCallSubStatus != null) {
                            $subStatusArray = [];
                            foreach ($AllCallSubStatus as $SubCallStatus) {
                                $subStatusArray[] = "{id: '" . $SubCallStatus->config_call_sub_status_id  . "', name: '" . $SubCallStatus->config_call_sub_status_name . "'}";
                            }
                            $output[] = "'" . $MainCallStatus->config_leads_stages_id . "': [" . implode(',', $subStatusArray) . "]";
                        }
                    }
                    echo implode(',', $output);
                }
                ?>
          };

          // DOM Elements for Call Status
          const callStatusSelect = document.getElementById('callStatus');
          const callSubStatusSelect = document.getElementById('callSubStatus');

          // Populate Sub-Status based on Call Status
          callStatusSelect.addEventListener('change', function() {
              const selectedStatus = this.value;
              console.log('Selected Status:', selectedStatus, 'Data:', subStatusData[selectedStatus]);
              callSubStatusSelect.innerHTML = '<option value="">All Leads</option>';
              if (subStatusData[selectedStatus] && Array.isArray(subStatusData[selectedStatus])) {
                  subStatusData[selectedStatus].forEach(subStatus => {
                      const option = new Option(subStatus.name, subStatus.id);
                      callSubStatusSelect.appendChild(option);
                  });

              }
          });
      </script>
  </div>
  <?php
    if (isset($_GET["ApplyAdvancefilters"])) {
        $GenerateSQL = "SELECT leads_gender, leads_sub_stages, leads_assign_status, leads_entry_type, leads_created_at, leads_priority_level, leads_type, leads_assigned_date, leads_managed_by, leads_id, leads_re_source, leads_source, leads_full_name, leads_phone_number, leads_alternate_phone, leads_projects_id, leads_stages FROM leads WHERE leads_is_removed!='1' and leads_managed_by='$SelectedUserId'";
        $filters = [
            "leads_type",
            "leads_stages",
            "leads_sub_stages",
            "leads_source",
            "leads_managed_by",
            "leads_assigned_by",
            "leads_uploaded_by",
            "leads_projects_id",
            "leads_re_source"
        ];

        foreach ($filters as $field) {
            if (!empty(trim($_GET[$field]))) {
                $GenerateSQL .= " AND {$field} = '" . trim($_GET[$field]) . "'";
            }
        }

        // Date Filters
        if (!empty(trim($_GET["leads_added_on_from_date"]))) {
            $GenerateSQL .= " AND DATE(leads_created_at) >= '" . trim($_GET["leads_added_on_from_date"]) . "'";
        }

        if (!empty(trim($_GET["leads_added_on_to_date"]))) {
            $GenerateSQL .= " AND DATE(leads_created_at) <= '" . trim($_GET["leads_added_on_to_date"]) . "'";
        }

        if (!empty(trim($_GET["leads_assigned_on_from_date"]))) {
            $GenerateSQL .= " AND DATE(leads_assigned_date) >= '" . trim($_GET["leads_assigned_on_from_date"]) . "'";
        }

        if (!empty(trim($_GET["leads_assigned_on_to_date"]))) {
            $GenerateSQL .= " AND DATE(leads_assigned_date) <= '" . trim($_GET["leads_assigned_on_to_date"]) . "'";
        }

        if (!empty(trim($_GET["leads_updated_at_from"]))) {
            $GenerateSQL .= " AND DATE(leads_updated_at) >= '" . trim($_GET["leads_updated_at_from"]) . "'";
        }

        if (!empty(trim($_GET["leads_updated_at_to"]))) {
            $GenerateSQL .= " AND DATE(leads_updated_at) <= '" . trim($_GET["leads_updated_at_to"]) . "'";
        }

        $PaginationTotalSQL = $GenerateSQL;
        $AllLeadsSQL = $GenerateSQL;
    } else if (isset($_GET["leads_stages_dash"])) {
        $leads_stages = $_GET["leads_stages_dash"];
        $AllLeadsSQL = "SELECT leads_gender, leads_sub_stages, leads_assign_status, leads_entry_type, leads_created_at, leads_priority_level, leads_type, leads_assigned_date, leads_managed_by, leads_id, leads_re_source, leads_source, leads_full_name, leads_phone_number, leads_alternate_phone, leads_projects_id, leads_stages FROM leads where leads_managed_by='$SelectedUserId' and leads_stages='$leads_stages'  and leads_is_removed!='1'  ";
        //default 
    } else {
        $AllLeadsSQL = "SELECT leads_gender, leads_sub_stages, leads_assign_status, leads_entry_type, leads_created_at, leads_priority_level, leads_type, leads_assigned_date, leads_managed_by, leads_id, leads_re_source, leads_source, leads_full_name, leads_phone_number, leads_alternate_phone, leads_projects_id, leads_stages FROM leads where leads_managed_by='$SelectedUserId' and leads_is_removed!='1'  ";
    } ?>
  <div class="table-container mt-4">
      <table>
          <thead>
              <tr>
                  <th><input type="checkbox" id="selectAll" class="d-selection"></th>
                  <th>SNo.</th>
                  <th>Contact Name</th>
                  <th>Phone Number</th>
                  <th>Alt Phone</th>
                  <th>Project</th>
                  <th>Stage</th>
                  <th>SubStage</th>
                  <th>Source</th>
                  <th>ReSource</th>
                  <th>Assigned To</th>
                  <th>Assigned On</th>
                  <th>Type</th>
                  <th>Priority</th>
                  <th>Budget</th>
                  <th>Manager</th>
                  <th>Created</th>
                  <th>InsertMode</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              <?php
                $StartFrom = START_FROM;
                $DisplayRecords = DEFAULT_RECORD_LISTING;
                $PaginationTotalSQL = $AllLeadsSQL;
                $ProcessSQL = SET_SQL($AllLeadsSQL . " ORDER BY leads_id DESC LIMIT $DisplayRecords OFFSET $StartFrom", true);
                if ($ProcessSQL) {
                    $SerialNo = SERIAL_NO;
                    foreach ($ProcessSQL as $Records) {
                        $SerialNo++;
                        if ($Records->leads_gender == "Male") {
                            $ColorClass = "text-primary";
                        } elseif ($Records->leads_gender == "Female") {
                            $ColorClass = "text-info";
                        } else {
                            $ColorClass = "text-secondary";
                        }
                ?>
                      <tr>
                          <td><input type="checkbox" class="d-selection" name="SELECTED_LEADS[]" value="<?php echo $Records->leads_id; ?>"></td>
                          <td><?php echo $SerialNo; ?></td>
                          <td>
                              <a href="<?php echo APP_URL; ?>/leads/details?leadsid=<?php echo $Records->leads_id; ?>" class="text-primary bold">
                                  <i class="bi bi-person-fill <?php echo $ColorClass; ?>"></i> <?php echo LimitText(UpperCase($Records->leads_full_name), 0, 30); ?>
                              </a>
                          </td>
                          <td class="bold"><?php echo $Records->leads_phone_number; ?></td>
                          <td class="bold"><?php echo $Records->leads_alternate_phone; ?></td>
                          <td><?php echo LimitText(FETCH("SELECT projects_name FROM projects where projects_id='" . $Records->leads_projects_id . "'", "projects_name"), 0, 20) ?: '<span class="text-muted">N/A</span>'; ?></td>
                          <td>
                              <span class="color-tags" style="background-color:<?php echo FETCH("SELECT config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages  . "'", "config_leads_stage_color_code"); ?>;color:black !important;">
                                  <?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages . "'", "config_leads_stage_name"); ?>
                              </span>
                          </td>
                          <td><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Records->leads_sub_stages . "'", "config_call_sub_status_name"); ?></td>
                          <td><?php echo FETCH("SELECT config_leads_source_name FROM config_leads_sources where config_leads_source_id='" . $Records->leads_source . "'", "config_leads_source_name"); ?></td>
                          <td><?php echo FETCH("SELECT config_leads_resources_name FROM config_leads_resources where config_leads_resources_id ='" . $Records->leads_re_source . "'", "config_leads_resources_name"); ?></td>
                          <td><?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Records->leads_managed_by . "'", "UserFullName"); ?></td>
                          <td><?php echo DATE_FORMATES("d M, Y", $Records->leads_assigned_date); ?></td>
                          <td><?php echo $Records->leads_type; ?></td>
                          <td><?php echo FETCH("SELECT config_priority_level_name FROM config_priority_levels where config_priority_level_id='" . $Records->leads_priority_level . "'", "config_priority_level_name") ?: '<span class="text-muted">N/A</span>'; ?></td>
                          <td><?php echo Price(FETCH("SELECT leads_requirement_budgets FROM leads_requirements where leads_main_id='" . $Records->leads_id . "'", "leads_requirement_budgets"), "text-success", "Rs."); ?></td>
                          <td><?php echo FETCH("SELECT UserFullName from users where UserId='" . FETCH("SELECT UserReportingManager FROM users where UserId='" . $Records->leads_managed_by . "'", "UserReportingManager") . "'", "UserFullName"); ?></td>
                          <td><?php echo DATE_FORMATES("d M, Y", $Records->leads_created_at); ?></td>
                          <td><?php echo $Records->leads_entry_type; ?></td>
                          <td><?php echo $Records->leads_assign_status; ?></td>
                          <td>
                              <a class="btn btn-xs btn-dark" href="<?php echo APP_URL; ?>/leads/details?leadsid=<?php echo $Records->leads_id; ?>">
                                  <i class="fa fa-eye text-success"></i> View
                              </a>
                          </td>
                      </tr>
              <?php
                    }
                } else {
                    echo "<tr><td colspan='25' class='text-center alert alert-warning'>No Leads Found!</td></tr>";
                }
                ?>
          </tbody>
      </table>
  </div>
  <div class="row">
      <div class="col-md-12">
          <?php echo PaginationFooter(TOTAL($PaginationTotalSQL), APP_URL . "/leads"); ?>
      </div>
  </div>