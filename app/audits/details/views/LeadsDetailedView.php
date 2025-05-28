<div class="card shadow-lg border-0 br-2">
    <div class="card-body p-4">
        <div class="bg-info p-2 w-100 mx-auto text-center br-2 mb-3">
            <!-- User Icon -->
            <div class="user-icon mx-auto  text-center">
                <span class="badge bg-gradient-primary rounded-circle p-4 fw-bold text-white shadow-sm" style="width: 80px; height: 80px; line-height: 1;font-size:3rem;">
                    <?php echo FirstWord(FETCH($LeadsSQL, "leads_full_name")); ?>
                </span>
            </div>
        </div>

        <!-- Primary Information Section -->
        <h5 class="fw-bold text-primary mb-3">Primary Information</h5>
        <hr class="my-3 border-primary opacity-50">
        <div class="row g-3 small">
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Name:</strong>
                    <span class="bold"><?php echo FETCH($LeadsSQL, "leads_full_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Phone:</strong>
                    <?php echo PHONE(FETCH($LeadsSQL, "leads_phone_number"), "link", "text-primary", "fa fa-phone"); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Alt Phone:</strong>
                    <?php echo PHONE(FETCH($LeadsSQL, "leads_alternate_phone"), "link", "text-primary", "fa fa-phone"); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Email-Id:</strong>
                    <?php echo EMAIL(FETCH($LeadsSQL, "leads_email_id"), "text-warning", "bi bi-envelope"); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Gender:</strong>
                    <span class="bold"><?php echo FETCH($LeadsSQL, "leads_gender"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Date Of Birth:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y", FETCH($LeadsSQL, "leads_date_of_birth")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Marital Status:</strong>
                    <span class="bold"><?php echo FETCH($LeadsSQL, "leads_marital_status"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Anniversary Date:</strong>
                    <span class="bold"><?php echo FETCH($LeadsSQL, "leads_anniversary_date"); ?></span>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Address:</strong>
                    <span>
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_type"); ?> -
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_line1"); ?>
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_area"); ?>
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_city"); ?>,
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_state"); ?>,
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_country"); ?>
                        <?php echo FETCH($LeadsAddressSQL, "leads_address_pincode"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Remarks</strong>
                    <span><?php echo SECURE(FETCH($LeadsSQL, "leads_remarks"), "d"); ?></span>
                </div>
            </div>
        </div>

        <!-- Lead Details Section -->
        <h5 class="fw-bold text-primary mt-5 mb-3">Lead Details</h5>
        <hr class="my-3 border-primary opacity-50">
        <div class="row g-3 small">
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Source:</strong>
                    <span class="bold"><?php echo UpperCase(FETCH("SELECT config_leads_source_name FROM config_leads_sources where config_leads_source_id='" . FETCH($LeadsSQL, "leads_source") . "'", "config_leads_source_name")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Type:</strong>
                    <span class="bold"><?php echo UpperCase(FETCH($LeadsSQL, "leads_type")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Entry Type:</strong>
                    <span class="bold"><?php echo FETCH($LeadsSQL, "leads_entry_type"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Stage:</strong>
                    <span class="badge fw-normal px-2 py-1" style="background-color:<?php echo FETCH("SELECT config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id='" . FETCH($LeadsSQL, "leads_stages") . "'", "config_leads_stage_color_code"); ?>;text-shadow:0px 0px 5px white;">
                        <?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . FETCH($LeadsSQL, "leads_stages") . "'", "config_leads_stage_name"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Status:</strong>
                    <span class="bold"><?php echo StatusViewWithText(FETCH($LeadsSQL, "leads_status")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Created On:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y h:i A", FETCH($LeadsSQL, "leads_created_at")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Created By:</strong>
                    <span class="text-primary">
                        (UID<?php echo FETCH($LeadsSQL, "leads_created_by"); ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($LeadsSQL, "leads_created_by") . "'", "UserFullName"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Updated On:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y h:i A", FETCH($LeadsSQL, "leads_updated_at")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Updated By:</strong>
                    <span class="text-info">
                        (UID<?php echo FETCH($LeadsSQL, "leads_updated_by"); ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($LeadsSQL, "leads_updated_by") . "'", "UserFullName"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Uploaded By:</strong>
                    <span class="text-warning">
                        (UID<?php echo FETCH($LeadsSQL, "leads_uploaded_by"); ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($LeadsSQL, "leads_uploaded_by") . "'", "UserFullName"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Is it Created By Admin?:</strong>
                    <span class="text-success">
                        <?php echo (FETCH($LeadsSQL, "leads_is_created_by_admin") == 0) ? "No" : "Yes"; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Projects Details Section -->
        <h5 class="fw-bold text-primary mt-5 mb-3">Projects Details</h5>
        <hr class="my-3 border-primary opacity-50">
        <div class="row g-3 small">
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Name:</strong>
                    <span class="bold"><?php echo FETCH($ProjectSQL, "projects_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Area:</strong>
                    <span class="bold"><?php echo FETCH($ProjectSQL, "projects_area"); ?> <?php echo FETCH($ProjectSQL, "projects_area_measurement_unit"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Age:</strong>
                    <span class="bold"><?php echo FETCH($ProjectSQL, "projects_age"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Type:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_project_types_name FROM config_project_types where config_project_types_id='" . FETCH($ProjectSQL, "projects_type_id") . "'", "config_project_types_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Stage:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_projects_stages_name FROM config_projects_stages where config_projects_stages_id='" . FETCH($ProjectSQL, "projects_stages_id") . "'", "config_projects_stages_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Location:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . FETCH($ProjectSQL, "projects_locations_id") . "'", "config_projects_locations_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Status:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_projects_status_name FROM config_projects_status where config_projects_status_id='" . FETCH($ProjectSQL, "projects_status_id") . "'", "config_projects_status_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Developer Name:</strong>
                    <span class="bold"><?php echo FETCH($DeveloperSQL, "projects_developers_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Project Added On:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y h:i A", FETCH($ProjectSQL, "projects_created_at")); ?></span>
                </div>
            </div>
        </div>

        <!-- Requirement Details Section -->
        <h5 class="fw-bold text-primary mt-5 mb-3">Requirement Details</h5>
        <hr class="my-3 border-primary opacity-50">
        <div class="row g-3 small">
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Max Budget:</strong>
                    <?php echo Price(FETCH($LeadsRequirementSQL, "leads_requirement_budgets"), "text-success", "Rs."); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Locations:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . FETCH($LeadsRequirementSQL, "leads_requirement_preffered_location") . "'", "config_projects_locations_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Requirement Type:</strong>
                    <span class="bold"><?php echo FETCH($LeadsRequirementSQL, "leads_requirement_tags"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Unit Details:</strong>
                    <span class="bold"><?php echo FETCH($LeadsRequirementSQL, "leads_requirement_unit_type"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Unit No:</strong>
                    <span class="bold"><?php echo FETCH($LeadsRequirementSQL, "leads_requirement_unit_no"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Required:</strong>
                    <span class="bold"><?php echo FETCH($LeadsRequirementSQL, "leads_requirement_duration"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Requirement Added On:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y h:i A", FETCH($LeadsRequirementSQL, "leads_requirement_added_at")); ?></span>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Remarks:</strong>
                    <span class="bold">
                        <?php
                        $Remarks = FETCH($LeadsRequirementSQL, "leads_requirement_remarks");
                        if ($Remarks == null) {
                            $Remarks = "NA";
                        }
                        echo SECURE($Remarks, "d"); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Assign Details Section -->
        <h5 class="fw-bold text-primary mt-5 mb-3">Assign Details</h5>
        <hr class="my-3 border-primary opacity-50">
        <div class="row g-3 small">
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Assigned To:</strong>
                    <span>
                        UID<?php echo FETCH($LeadsSQL, "leads_managed_by"); ?> -
                        <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($LeadsSQL, "leads_managed_by") . "'", "UserFullName"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Assignee Phone Number:</strong>
                    <span class="bold"><?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='" . FETCH($LeadsSQL, "leads_managed_by") . "'", "UserPhoneNumber"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Assignee Email-Id:</strong>
                    <span class="bold"><?php echo FETCH("SELECT UserEmailId FROM users where UserId='" . FETCH($LeadsSQL, "leads_managed_by") . "'", "UserEmailId"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Assigned On:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y h:i A", FETCH($LeadsSQL, "leads_assigned_date")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Assigned By:</strong>
                    <span>
                        UID<?php echo FETCH($LeadsSQL, "leads_assigned_by"); ?> -
                        <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($LeadsSQL, "leads_assigned_by") . "'", "UserFullName"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Previously Assigned To:</strong>
                    <span>
                        UID<?php echo FETCH($LeadsAssignedSQL . " ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_to"); ?> -
                        <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($LeadsAssignedSQL . " ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_to") . "'", "UserFullName"); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Previously Assigned On:</strong>
                    <span class="bold"><?php echo DATE_FORMATES("d M, Y h:i A", FETCH($LeadsAssignedSQL . " ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_on")); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Current Stage:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . FETCH($LeadsSQL, "leads_stages") . "'", "config_leads_stage_name"); ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-secondary fw-normal d-block">Leads Previous Stage:</strong>
                    <span class="bold"><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . FETCH($LeadsAssignedSQL . " ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previous_stages") . "'", "config_leads_stage_name"); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateProfileModalLabel"><i class="bi bi-person-lines-fill me-2"></i>Update Lead Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST">
                    <?php echo FormPrimaryInputs(true, [
                        "leads_id" => FETCH($LeadsSQL, "leads_id"),
                    ]); ?>
                    <!-- Personal Details -->
                    <h6 class="app-sub-heading mb-3"><i class="bi bi-person me-2"></i>Personal Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="leads_full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="leads_full_name" name="leads_full_name" value="<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>" placeholder="Enter full name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="leads_phone_number" name="leads_phone_number" value="<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_alternate_phone" class="form-label">Alternate Phone</label>
                            <input type="text" class="form-control" id="leads_alternate_phone" name="leads_alternate_phone" value="<?php echo FETCH($LeadsSQL, 'leads_alternate_phone'); ?>" placeholder="Enter alternate phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_email_id" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="leads_email_id" name="leads_email_id" value="<?php echo FETCH($LeadsSQL, 'leads_email_id'); ?>" placeholder="Enter email ID">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="leads_date_of_birth" name="leads_date_of_birth" value="<?php echo FETCH($LeadsSQL, 'leads_date_of_birth'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_anniversary_date" class="form-label">Anniversary Date</label>
                            <input type="date" class="form-control" id="leads_anniversary_date" name="leads_anniversary_date" value="<?php echo FETCH($LeadsSQL, 'leads_anniversary_date'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_gender" class="form-label">Gender</label>
                            <select class="form-select" id="leads_gender" name="leads_gender">
                                <option value="" <?php echo FETCH($LeadsSQL, 'leads_gender') == '' ? 'selected' : ''; ?>>Select Gender</option>
                                <option value="Male" <?php echo FETCH($LeadsSQL, 'leads_gender') == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo FETCH($LeadsSQL, 'leads_gender') == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo FETCH($LeadsSQL, 'leads_gender') == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_marital_status" class="form-label">Marital Status</label>
                            <select class="form-select" id="leads_marital_status" name="leads_marital_status">
                                <option value="" <?php echo FETCH($LeadsSQL, 'leads_marital_status') == '' ? 'selected' : ''; ?>>Select Marital Status</option>
                                <option value="Single" <?php echo FETCH($LeadsSQL, 'leads_marital_status') == 'Single' ? 'selected' : ''; ?>>Single</option>
                                <option value="Married" <?php echo FETCH($LeadsSQL, 'leads_marital_status') == 'Married' ? 'selected' : ''; ?>>Married</option>
                                <option value="Divorced" <?php echo FETCH($LeadsSQL, 'leads_marital_status') == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                <option value="Widowed" <?php echo FETCH($LeadsSQL, 'leads_marital_status') == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <h6 class="app-sub-heading mb-3"><i class="bi bi-geo-alt me-2"></i>Address Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="leads_address_line1" name="leads_address_line1" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_line1'); ?>" placeholder="Enter address line 1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_area" class="form-label">Area</label>
                            <input type="text" class="form-control" id="leads_address_area" name="leads_address_area" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_area'); ?>" placeholder="Enter area">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_city" class="form-label">City</label>
                            <input type="text" class="form-control" id="leads_address_city" name="leads_address_city" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_city'); ?>" placeholder="Enter city">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_state" class="form-label">State</label>
                            <input type="text" class="form-control" id="leads_address_state" name="leads_address_state" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_state'); ?>" placeholder="Enter state">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="leads_address_country" name="leads_address_country" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_country'); ?>" placeholder="Enter country">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_pincode" class="form-label">Pincode</label>
                            <input type="number" class="form-control" id="leads_address_pincode" name="leads_address_pincode" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_pincode'); ?>" placeholder="Enter pincode">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_address_type" class="form-label">Address Type</label>
                            <input type="text" class="form-control" id="leads_address_type" name="leads_address_type" value="<?php echo FETCH($LeadsAddressSQL, 'leads_address_type'); ?>" placeholder="Enter address type">
                        </div>
                    </div>

                    <!-- Lead Details -->
                    <h6 class="app-sub-heading mb-3"><i class="bi bi-info-circle me-2"></i>Lead Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lead Type</label>
                            <select class="form-select" name="leads_type" required>
                                <?php echo InputOptionsWithKey([
                                    "" => "Select Status",
                                    "DATA" => "DATA",
                                    "LEAD" => "LEAD",
                                ], FETCH($LeadsSQL, 'leads_type')); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_source" class="form-label">Lead Source</label>
                            <select class="form-select" name="leads_source" required>
                                <option value="NEW">Select Source</option>
                                <?php
                                $AllLeadsSources = SET_SQL("SELECT config_leads_source_name, config_leads_source_id FROM config_leads_sources where config_leads_source_status='1' ORDER by config_leads_source_name ASC", true);
                                if ($AllLeadsSources != null) {
                                    foreach ($AllLeadsSources as $Sources) {
                                        $Selected = CheckEquality(FETCH($LeadsSQL, 'leads_source'), $Sources->config_leads_source_id, "selected");
                                        echo "<option value='" . $Sources->config_leads_source_id . "' $Selected>" . $Sources->config_leads_source_name . "</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_entry_type" class="form-label">Entry Type</label>
                            <input type="text" readonly class="form-control" id="leads_entry_type" name="leads_entry_type" value="<?php echo FETCH($LeadsSQL, 'leads_entry_type'); ?>" placeholder="Enter entry type">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Priority Level</label>
                            <select name="leads_assigned_priority_level" class="form-control">
                                <option value="">Select Priority Level</option>
                                <?php
                                $AllPriorityLevels = SET_SQL("SELECT config_priority_level_id, config_priority_level_name FROM config_priority_levels where config_priority_level_status='1'", true);
                                if ($AllPriorityLevels != null) {
                                    foreach ($AllPriorityLevels as $Priority) {
                                        $Selected = CheckEquality(FETCH($LeadsSQL, "leads_priority_level"), $Priority->config_priority_level_id, "selected"); ?>
                                        <option value="<?php echo $Priority->config_priority_level_id; ?>" <?php echo $Selected; ?>><?php echo $Priority->config_priority_level_name; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="leads_stages" class="form-label">Stages</label>
                            <select class="form-select" name="leads_stages" required>
                                <option value="">Select Stage</option>
                                <?php
                                $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                                if ($AllLeadsStages != null) {
                                    foreach ($AllLeadsStages as $Stages) {
                                        $Selected = CheckEquality(FETCH($LeadsSQL, "leads_stages"), $Stages->config_leads_stages_id, "selected");
                                        echo "<option value='" . $Stages->config_leads_stages_id . "' $Selected>" . $Stages->config_leads_stage_name . "</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <h5 class="app-sub-heading">Update Requirement Details</h5>
                    <div class="row g-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Property Type</label>
                            <select class="form-select" name="leads_requirement_type">
                                <option value="">Select Type</option>
                                <?php
                                $ProjectTypes = SET_SQL("SELECT config_project_types_id, config_project_types_name FROM config_project_types where config_project_types_status='1'", true);
                                if ($ProjectTypes != null) {
                                    foreach ($ProjectTypes as $ProjectType) {
                                        $Selected = CheckEquality(FETCH($LeadsRequirementSQL, "leads_requirement_type"), $ProjectType->config_project_types_id, "selected");
                                        echo '<option value="' . $ProjectType->config_project_types_id . '" ' . $Selected . '>' . $ProjectType->config_project_types_name . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Property Unit Category</label>
                            <input type="text" class="form-control" name="leads_requirement_tags" value="<?php echo FETCH($LeadsRequirementSQL, "leads_requirement_tags"); ?>" placeholder="plots, flats, villa, offices">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Units Type</label>
                            <input type="text" class="form-control" placeholder="2bhk, 3bhk, 50 yards, 5 Sittings " name="leads_requirement_unit_type" value="<?php echo FETCH($LeadsRequirementSQL, "leads_requirement_unit_type"); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Recommended Units</label>
                            <input type="text" class="form-control" name="leads_requirement_unit_no" value="<?php echo FETCH($LeadsRequirementSQL, "leads_requirement_unit_no"); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Select Project</label>
                            <select class="form-select" name="leads_project_id">
                                <option value="">Select Project</option>
                                <?php
                                $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                                if ($AllProjects != null) {
                                    foreach ($AllProjects as $AllProject) {
                                        $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                                        $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                                        $projects_id = $AllProject->projects_id;
                                        $projects_name = $AllProject->projects_name;
                                        $Selected = CheckEquality(FETCH($LeadsSQL, "leads_projects_id"), $projects_id, "selected");
                                        echo "<option value='$projects_id' $Selected>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Budget Range</label>
                            <input type="text" class="form-control" value="<?php echo FETCH($LeadsRequirementSQL, "leads_requirement_budgets"); ?>" name="leads_requirement_budgets" placeholder="e.g., 50L - 1Cr">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Preferred Location</label>
                            <select class="form-select" name="leads_requirement_preffered_location">
                                <option value="">Select Location</option>
                                <?php
                                $AllLocations = SET_SQL("SELECT config_projects_locations_id, config_projects_locations_name FROM config_projects_locations where config_projects_locations_status='1'", true);
                                if ($AllLocations != null) {
                                    foreach ($AllLocations as $AllLocation) {
                                        $Selected = CheckEquality(FETCH($LeadsRequirementSQL, "leads_requirement_preffered_location"), $AllLocation->config_projects_locations_id, "selected");  // check if selected or not 
                                        echo '<option value="' . $AllLocation->config_projects_locations_id . '" ' . $Selected . ' >' . $AllLocation->config_projects_locations_name . '</option>';
                                    }
                                } ?>
                                <option value="0">Others</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Purchase Duration</label>
                            <select class="form-select" name="leads_requirement_duration">
                                <?php echo InputOptionsWithKey(
                                    [
                                        "" => "Select Duration",
                                        "Within 1 Month" => "Within 1 Month",
                                        "2-3 Months" => "2-3 Months",
                                        "3-6 Months" => "3-6 Months",
                                        "6+ Months" => "6+ Months"
                                    ],
                                    FETCH($LeadsRequirementSQL, "leads_requirement_duration")
                                ); ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>More Requirement Remarks</label>
                            <textarea class="form-control" rows="3" name="leads_requirement_remarks"><?php echo SECURE(FETCH($LeadsRequirementSQL, "leads_requirement_remarks"), "d"); ?></textarea>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="UpdateLeadsDetails" class="btn btn-primary">Update Changes <i class="bi bi-check text-success"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>