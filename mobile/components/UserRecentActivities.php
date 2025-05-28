<!-- Team Activities Panel -->
<div class="team-activities" style="background-color: white !important;border:none !important;box-shadow:none !important;">
   <h5 class="app-heading app-fs-3"><i class="bi bi-people-fill text-warning"></i> Recent Activities </h5>
   <ul class="timeline list-unstyled position-relative" style="max-height: 100%; overflow-y: auto;padding-left:-0.25rem !important;">
      <?php
      $AllCalFeedBacks = SET_SQL("SELECT leads_activity_date_time, leads_activity_main_leads_id, leads_activity_feedbacks, leads_acitivity_call_status, leads_activity_created_by, leads_activity_call_method, leads_activity_call_source, leads_acitivity_call_sub_status, leads_activity_type FROM leads_activities where DATE(leads_activity_date_time)='$DateTime' and leads_activity_added_by='" . LOGIN_USER_ID . "' ORDER BY leads_acitivity_id DESC LIMIT 7 OFFSET 0", true);
      if ($AllCalFeedBacks != null) {
         foreach ($AllCalFeedBacks as $Calls) {
            $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads WHERE leads_id='" . $Calls->leads_activity_main_leads_id . "'";
            $LeadName = FETCH($LeadsSQL, "leads_full_name");
            $LeadPhone = FETCH($LeadsSQL, "leads_phone_number");
      ?>
            <li class="timeline-item mb-3 position-relative">
               <div class="d-flex flex-column">
                  <!-- Milestone Point (Date and Time) -->
                  <div class="flex-shrink-0 me-3 text-left mb-1" style="font-size: 3.5vw !important;">
                     <span class="badge rounded-pill bg-primary text-white"><i class="fa fa-calendar-day"></i> <?php echo DATE_FORMATES("d M, Y", $Calls->leads_activity_date_time); ?></span>
                     <span class="badge rounded-pill bg-primary-2 text-white"><i class="fa fa-clock"></i> <?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?></span>
                     <div class="timeline-point bg-danger rounded-circle position-absolute" style="width: 2.7vw !important; height: 2.7vw !important; top: 2.5vw !important; left: -0.3vw !important;"></div>
                  </div>
                  <!-- Timeline Content -->
                  <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-primary">
                     <div style="margin-left: -1vw !important;">
                        <h6 class="text-danger app-fs-3 bold">
                           <span class="btn btn-sm btn-dark app-fs-3"><i class="fa fa-phone text-success app-fs-3"></i> <?php echo $LeadPhone; ?></span>
                           <i class="bi bi-person-badge-fill text-success"></i> <?php echo UpperCase($LeadName); ?>
                        </h6>
                        <span class="badge tag-warning app-fs-2"><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Calls->leads_acitivity_call_status . "'", "config_leads_stage_name"); ?></span>
                        <span class="badge tag-success app-fs-2"><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Calls->leads_acitivity_call_sub_status . "'", "config_call_sub_status_name"); ?></span>
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
                     <span class="d-block text-right">
                        <span>
                           <?php if (UpperCase($Calls->leads_activity_type) == "OUTGOING") { ?>
                              <strong class="text-info"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                           <?php } else { ?>
                              <strong class="text-primary"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                           <?php } ?>
                        </span>
                     </span>
                  </div>
               </div>
            </li>
         <?php }
      } else { ?>
         <div class="alert alert-warning">
            <i class="bi bi-exclamation"></i>
            No Today Activity Found!
         </div>
      <?php } ?>
   </ul>
</div>