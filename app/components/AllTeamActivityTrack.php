<!-- Team Activities Panel -->
<div class="team-activities">
  <div class="shadow-sm p-2 rounded-2 bg-white mb-3">
    <h5 class="app-heading"><i class="bi bi-people-fill text-warning"></i> Team Activities</h5>
    <?php if (AuthAppUser("UserType") == "ADMIN" || AuthAppUser("TEAM_HEAD")) { ?>
      <div class="flex-s-b">
        <form class="mb-2 w-100">
          <select class="form-select form-control mb-0" onchange="form.submit()" name="GetActivityRecordFor">
            <option value="">All Users</option>
            <?php
            if (AuthAppUser("UserType") == "ADMIN") {
              $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
            } else {
              $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users WHERE UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
            }
            foreach ($AllUsers as $Users) {
              $selected = CheckEquality(IfRequested("GET", "GetActivityRecordFor"), $Users->UserId, "selected");
              echo "<option value='" . $Users->UserId . "' $selected>" . $Users->UserFullName . " - " . $Users->UserPhoneNumber . "</option>";
            } ?>
          </select>
        </form>
        <?php if (isset($_GET["GetActivityRecordFor"])) { ?>
          <div class="w-50 ml-1">
            <a href="<?php echo APP_URL; ?>" class="btn btn-md btn-block w-100 btn-outline-danger"><i class="fa fa-times"></i> View All</a>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
    <?php
    $DateTime = DATE("Y-m-d");
    if (isset($_GET["GetActivityRecordFor"]) != null) {
      $GetActivityRecordFor = trim($_GET["GetActivityRecordFor"]);
      if ($GetActivityRecordFor == null) {
        $AllCalFeedBacksSQL = "SELECT leads_activity_date_time, leads_activity_main_leads_id, leads_activity_feedbacks, leads_acitivity_call_status, leads_activity_created_by, leads_activity_call_method, leads_activity_call_source, leads_acitivity_call_sub_status, leads_activity_type FROM leads_activities where DATE(leads_activity_date_time)='$DateTime'";
      } else {
        $AllCalFeedBacksSQL = "SELECT leads_activity_date_time, leads_activity_main_leads_id, leads_activity_feedbacks, leads_acitivity_call_status, leads_activity_created_by, leads_activity_call_method, leads_activity_call_source, leads_acitivity_call_sub_status, leads_activity_type FROM leads_activities where DATE(leads_activity_date_time)='$DateTime' and leads_activity_added_by='$GetActivityRecordFor'";
      }
    } else {
      if (AuthAppUser("UserType") == "ADMIN") {
        $AllCalFeedBacksSQL = "SELECT leads_activity_date_time, leads_activity_main_leads_id, leads_activity_feedbacks, leads_acitivity_call_status, leads_activity_created_by, leads_activity_call_method, leads_activity_call_source, leads_acitivity_call_sub_status, leads_activity_type FROM leads_activities where DATE(leads_activity_date_time)='$DateTime' ";
      } elseif (AuthAppUser("UserType") == "TEAM_HEAD") {
        $AllCalFeedBacksSQL = "SELECT leads_activity_date_time, leads_activity_main_leads_id, leads_activity_feedbacks, leads_acitivity_call_status, leads_activity_created_by, leads_activity_call_method, leads_activity_call_source, leads_acitivity_call_sub_status, leads_activity_type FROM leads_activities, users where DATE(leads_activity_date_time)='$DateTime' and leads_activities.leads_activity_added_by=users.UserId and users.UserReportingManager='" . LOGIN_USER_ID . "'";
      } else {
        $AllCalFeedBacksSQL = "SELECT leads_activity_date_time, leads_activity_main_leads_id, leads_activity_feedbacks, leads_acitivity_call_status, leads_activity_created_by, leads_activity_call_method, leads_activity_call_source, leads_acitivity_call_sub_status, leads_activity_type FROM leads_activities where DATE(leads_activity_date_time)='$DateTime' and leads_activity_added_by='" . LOGIN_USER_ID . "'";
      }
    } ?>
    <div class="flex-s-b mb-2">
      <div class="shadow-sm p-3 text-center rounded-2 m-1 bg-white w-50">
        <h4 class="mb-0 text-primary"><?php echo TOTAL($AllCalFeedBacksSQL . " and leads_activity_call_source='CRM'"); ?></h4>
        <p class="mb-1 text-secondary small">Today CRM Calls</p>
      </div>
      <div class="shadow-sm p-3 text-center rounded-2 m-1 bg-white w-50">
        <h4 class="mb-0 text-info"><?php echo TOTAL($AllCalFeedBacksSQL . " and leads_activity_call_source='APP'"); ?></h5>
          <p class="mb-1 text-secondary small">Today APP Calls</p>
      </div>
    </div>
    <ul class="timeline list-unstyled position-relative" style="max-height: 100%; overflow-y: auto;">
      <?php
      $AllCalFeedBacks = SET_SQL($AllCalFeedBacksSQL . " ORDER BY leads_acitivity_id DESC LIMIT 10", true);
      if ($AllCalFeedBacks != null) {
        foreach ($AllCalFeedBacks as $Calls) {
          $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads WHERE leads_id='" . $Calls->leads_activity_main_leads_id . "'";
          $LeadName = FETCH($LeadsSQL, "leads_full_name");
          $LeadPhone = FETCH($LeadsSQL, "leads_phone_number"); ?>
          <li class="timeline-item mb-2 position-relative">
            <div class="d-flex flex-column">
              <!-- Milestone Point (Date and Time) -->
              <div class="flex-shrink-0 me-3 text-left mb-2 mt-0">
                <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $Calls->leads_activity_date_time); ?></span>
                <span class="badge rounded-pill bg-warning text-white"><?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?></span>
                <div class="timeline-point bg-danger rounded-circle position-absolute" style="width: 0.5rem !important; height: 0.5rem !important; top: 0.5rem !important; left: 0.1rem !important;"></div>
              </div>
              <!-- Timeline Content -->
              <div class="timeline-content p-3 bg-white rounded shadow-sm mt-0 flex-grow-1 border-primary">
                <div style="margin-left: -0.5rem !important;">
                  <h6 class="text-danger bold">
                    <span class="btn btn-xs btn-dark"><i class="fa fa-phone text-success"></i> <?php echo $LeadPhone; ?></span>
                    <small><i class="bi bi-person-badge-fill text-success small"></i> <?php echo $LeadName; ?></small>
                  </h6>
                  <span class="pull-right">
                    <?php if (UpperCase($Calls->leads_activity_type) == "OUTGOING") { ?>
                      <strong class="text-info"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                    <?php } else { ?>
                      <strong class="text-primary"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                    <?php } ?>
                  </span>
                  <span class="badge tag-warning"><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Calls->leads_acitivity_call_status . "'", "config_leads_stage_name"); ?></span>
                  <span class="badge tag-success"><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Calls->leads_acitivity_call_sub_status . "'", "config_call_sub_status_name"); ?></span>
                </div>
                <div class="mt-1">
                  <span class="detail-title fw-bold">Duration/Time:</span>
                  <?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?>
                  <span class="text-right pull-right shadow-sm br-1 p-1">
                    <span class="text-primary"><?php echo $Calls->leads_activity_call_source; ?></span>
                    <span class="text-info"><?php echo $Calls->leads_activity_call_method; ?></span>
                  </span>
                  <br>
                  <strong>
                    <b>
                      <span class="detail-title fw-bold">By:</span>
                      (UID<?php echo $Calls->leads_activity_created_by; ?>)-
                      <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Calls->leads_activity_created_by . "'", "UserFullName"); ?>
                    </b>
                  </strong>
                  <br>
                  <span class="detail-title fw-bold">Remarks:</span>
                  <?php echo SECURE($Calls->leads_activity_feedbacks, "d"); ?>
                </div>
              </div>
            </div>
          </li>
        <?php }
      } else { ?>
        <div class="alert alert-warning">
          <i class="bi bi-exclamation"></i>
          No Activity Found!
        </div>
      <?php } ?>
    </ul>
  </div>
</div>