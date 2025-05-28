<div class="">
   <h5 class="card-title app-heading app-fs-3"><i class="bi bi-person text-warning mr-2"></i> Today Site Visits</h5>
   <?php
   $ReminderSQL = "SELECT leads_main_leads_id, leads_site_visits_projects_id, leads_site_visit_notes, leads_site_visit_schedule_date, leads_site_visit_id  FROM leads_site_visits WHERE leads_site_visit_status='1' and leads_site_visit_handled_by='" . LOGIN_USER_ID . "' AND DATE(leads_site_visit_schedule_date)='" . DATE('Y-m-d') . "' ORDER BY DATE(leads_site_visit_schedule_date) DESC";
   $ReminderGETSQL = SET_SQL($ReminderSQL, true);
   if ($ReminderGETSQL != null) {
      foreach ($ReminderGETSQL as $Reminder) {
         $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads WHERE leads_id='" . $Reminder->leads_main_leads_id . "'";
         $LeadName = FETCH($LeadsSQL, "leads_full_name");
         $LeadPhone = FETCH($LeadsSQL, "leads_phone_number");
         $ProjectSQL = "SELECT projects_name FROM projects WHERE projects_id='" . $Reminder->leads_site_visits_projects_id . "'";
         $ProjectName = FETCH($ProjectSQL, "projects_name");
   ?>
         <div class="app-list-shadow">
            <a href="<?php echo DOMAIN . "/mobile/leads/details/?leadsid=$Reminder->leads_main_leads_id"; ?>" class="d-block">
               <div class="flex-s-b">
                  <div class="w-pr-75">
                     <h6 class="bold app-fs-3 text-primary mb-0"><i class="bi bi-person-fill text-primary bold"></i> <?php echo UpperCase($LeadName); ?></h6>
                     <p class="mb-0 bold app-fs-3">
                        <span class="text-success"><strong>📞 </strong> <?php echo $LeadPhone; ?></span><br>
                        <span class="text-secondary"><strong>🏗 </strong> <?php echo $ProjectName ?? "Not Available"; ?></span>
                     </p>
                  </div>
                  <div class="w-pr-25 text-right">
                     <p class="mb-0 mt-1 bg-white br-5 shadow-sm text-center" style="line-height: 2.5vw !important;padding:0.55rem 0.75rem !important;position:absolute;margin-left:7vw !important;">
                        <i class="fa fa-map-marker app-fs-4 text-success blink-data"></i><br>
                        <span class="text-dark bold app-fs-2 bolder">
                           <?php echo date("d M, Y", strtotime($Reminder->leads_site_visit_schedule_date)); ?><br>
                           <?php echo date("h:i A", strtotime($Reminder->leads_site_visit_schedule_date)); ?>
                        </span>
                     </p>
                  </div>
               </div>
               <p class="mb-0 text-secondary app-fs-3 text-left"><i class="bi bi-chat-dots text-black"></i> <?php echo LimitText(SECURE($Reminder->leads_site_visit_notes, "d"), 0, 30); ?></p>
            </a>
            <div class="flex-end w-100">
               <a class="btn btn-success m-1 app-fs-2" onclick="SiteVisitController(`<?php echo $Reminder->leads_main_leads_id; ?>`,`<?php echo $Reminder->leads_site_visit_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`, `<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`, `<?php echo SECURE($Reminder->leads_site_visit_notes, 'd'); ?>`, `<?php echo FETCH($ProjectSQL, 'projects_name') ?? 'NOT AVAILABLE'; ?>`)">✅ Mark Done</a>
               <a class="btn btn-warning m-1 app-fs-2" onclick="ReScheduleSiteVisit(`<?php echo $Reminder->leads_main_leads_id; ?>`,`<?php echo $Reminder->leads_site_visit_id; ?>`, `<?php echo FETCH($LeadsSQL, 'leads_full_name'); ?>`,`<?php echo FETCH($LeadsSQL, 'leads_phone_number'); ?>`)"><?php echo ART_ICON['clock']; ?> Re-Schedule</a>
            </div>
         </div>
   <?php
      }
   } else {
      echo "<p class='alert alert-danger text-center app-fs-3 br-5'>No Site Visits Today.</p>";
   }
   ?>
</div>