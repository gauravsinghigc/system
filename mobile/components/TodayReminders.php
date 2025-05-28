<div class="">
   <h5 class="card-title app-heading app-fs-3"><i class="bi bi-clock text-warning mr-1"></i> Today Reminders</h5>
   <?php
   $ReminderSQL = "SELECT leads_reminder_main_leads_id, leads_reminder_id, leads_reminder_time, leads_reminder_date, leads_reminder_name, leads_reminder_notes FROM leads_reminders WHERE leads_reminder_status='0' and leads_reminder_user_id='" . LOGIN_USER_ID . "' AND DATE(leads_reminder_date)='" . DATE('Y-m-d') . "' ORDER BY DATE(leads_reminder_date) DESC";
   $ReminderGETSQL = SET_SQL($ReminderSQL, true);
   if ($ReminderGETSQL != null) {
      foreach ($ReminderGETSQL as $Reminder) {
         $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads WHERE leads_id='" . $Reminder->leads_reminder_main_leads_id . "'";
         $ProjectSQL = "SELECT projects_name FROM projects WHERE projects_id='" . $Reminder->leads_reminder_main_leads_id . "'";
         $LeadName = FETCH($LeadsSQL, "leads_full_name");
         $LeadPhone = FETCH($LeadsSQL, "leads_phone_number");
         $ProjectName = FETCH($ProjectSQL, "projects_name");
   ?>
         <div class="app-list-shadow">
            <a href="<?php echo DOMAIN . "/mobile/leads/details/?leadsid=$Reminder->leads_reminder_main_leads_id"; ?>" class="d-block">
               <div class="flex-s-b">
                  <div class="w-pr-75">
                     <h6 class="bold app-fs-3 text-primary mb-0"><i class="bi bi-person-fill text-primary bold"></i> <?php echo UpperCase($LeadName); ?></h6>
                     <p class="mb-0 bold app-fs-3">
                        <span class="text-success"><strong>📞 </strong> <?php echo $LeadPhone; ?></span><br>
                        <span class="text-secondary small"><strong>🏗 </strong> <?php echo $ProjectName ?? "Not Available"; ?></span>
                     </p>
                  </div>
                  <div class="w-pr-25 text-center">
                     <p class="mb-0 mt-1 bg-white br-5 shadow-sm text-center" style="line-height: 2.5vw !important;padding:0.55rem 0.75rem !important;position:absolute;margin-left:7vw !important;">
                        <i class="bi bi-bell-fill app-fs-4 text-danger blink-data"></i><br>
                        <span class="text-dark bold app-fs-2 bolder">
                           <?php echo date("d M, Y", strtotime($Reminder->leads_reminder_date)); ?><br>
                           <?php echo date("h:i A", strtotime($Reminder->leads_reminder_time)); ?>
                        </span>
                     </p>
                  </div>
               </div>
               <p class="mb-0 text-secondary app-fs-2 text-left"><i class="bi bi-chat-dots text-black"></i> <?php echo LimitText(SECURE($Reminder->leads_reminder_notes, "d"), 0, 30); ?></p>
            </a>
            <div class="flex-end w-100">
               <a class="btn btn-success m-1 app-fs-2" onclick="AddFeedbackForReminders(`<?php echo $Reminder->leads_reminder_main_leads_id; ?>`,`<?php echo $Reminder->leads_reminder_id; ?>`, `<?php echo $LeadName; ?>`, `<?php echo $LeadPhone; ?>`)">✅ Add FeedBack</a>
               <form action="<?php echo CONTROLLER; ?>/ModuleController/ReminderController.php" method="POST">
                  <?php echo FormPrimaryInputs(true, [
                     "leads_reminder_id" => $Reminder->leads_reminder_id
                  ]); ?>
                  <button type="Submit" name="DropReminder" class="btn app-fs-2 btn-danger m-1"><i class="fa fa-trash app-fs-2"></i> DROP REMINDER</button>
               </form>
            </div>

         </div>
   <?php
      }
   } else {
      echo "<p class='alert alert-warning text-center app-fs-3 br-5'>No Reminders Today.</p>";
   }
   ?>
</div>