<div class="container-fluid">
    <!-- User Icon and Name in Same Div -->
    <div class="text-center mb-3 bg-white shadow-sm p-3 rounded-3">
        <div class="d-inline-block">
            <span class="badge bg-primary rounded-circle p-3 fw-bold text-white shadow-sm" style="width: 60px; height: 60px; line-height: 1; font-size: 1.5rem;">
                <?php echo FirstWord(FETCH($LeadsSQL, "leads_full_name")); ?>
            </span>
        </div>
        <h5 class="fw-bold text-primary mt-2 mb-0"><?php echo FETCH($LeadsSQL, "leads_full_name"); ?></h5>
        <h6 class="fw-bold text-dark mt-1 mb-0"><?php echo FETCH($LeadsSQL, "leads_phone_number"); ?></h6>
        <small><?php echo FETCH($LeadsAddressSQL, "leads_address_line1") . ', ' . FETCH($LeadsAddressSQL, "leads_address_city"); ?></small>
    </div>

    <!-- Primary Details in Two-Column Layout -->
    <div class="mb-3">
        <div class="shadow-sm p-3 rounded-3 bg-light">
            <div class="row g-2 small">
                <div class="col-6" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">Project</span>
                    <span class="text-dark bold fw-bold">
                        <?php
                        echo FETCH("SELECT projects_name FROM projects where projects_id='" . FETCH($LeadsSQL, "leads_projects_id") . "'", "projects_name"); ?>
                    </span>
                </div>
                <div class="col-6 text-right" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">Call Stage</span>
                    <span class="badge fw-normal px-2 py-1 text-dark" style="background-color:<?php echo FETCH("SELECT config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id='" . FETCH($LeadsSQL, "leads_stages") . "'", "config_leads_stage_color_code"); ?>;">
                        <?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . FETCH($LeadsSQL, "leads_stages") . "'", "config_leads_stage_name"); ?>
                    </span>
                </div>
                <div class="col-6" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">Sub Stage</span>
                    <span class="text-dark bold fw-bold"><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_id='" . FETCH($LeadsSQL, "leads_sub_stages") . "'", "config_call_sub_status_name"); ?></span>
                </div>
                <div class="col-6 text-right" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">DOB</span>
                    <span class="text-dark bold fw-bold"><?php echo DATE_FORMATES("d M, Y", FETCH($LeadsSQL, "leads_date_of_birth")); ?></span>
                </div>
                <div class="col-6" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">Gender</span>
                    <span class="text-dark bold fw-bold"><?php echo FETCH($LeadsSQL, "leads_gender"); ?></span>
                </div>
                <div class="col-6 text-right" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">Marital</span>
                    <span class="text-dark bold fw-bold"><?php echo FETCH($LeadsSQL, "leads_marital_status"); ?></span>
                </div>
                <div class="col-12 text-left" style="line-height:0.97rem !important;">
                    <span class="text-muted d-block small">Remarks</span>
                    <span class="text-dark bold fw-bold"><?php echo SECURE(FETCH($LeadsSQL, "leads_remarks"), "d"); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons Full Width, Fully Rounded -->
    <div class="d-flex justify-content-between gap-2 mb-3">
        <a href="tel:<?php echo FETCH($LeadsSQL, "leads_phone_number"); ?>" class="btn btn-primary flex-fill rounded-circle p-3">
            <i class="fa fa-phone"></i>
        </a>
        <a href="mailto:<?php echo FETCH($LeadsSQL, "leads_email_id"); ?>" class="btn btn-warning flex-fill rounded-circle p-3">
            <i class="bi bi-envelope"></i>
        </a>
        <a href="whatsapp://send?phone=91<?php echo FETCH($LeadsSQL, "leads_phone_number"); ?>&text=Hello *<?php echo FETCH($LeadsSQL, "leads_full_name"); ?>*" class="btn btn-success flex-fill rounded-circle p-3">
            <i class="bi bi-whatsapp"></i>
        </a>
    </div>
</div>