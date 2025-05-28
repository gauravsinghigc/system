 <!-- Reminders Tab -->
 <div class="tab-pane fade" id="reminders" role="tabpanel" aria-labelledby="reminders-tab">
     <div class="mb-3">
         <h5 class="app-sub-heading text-primary fw-bold"><i class="bi bi-bell-fill me-2"></i>Reminders</h5>
     </div>
     <div class="row mb-4">
         <div class="col-4">
             <div class="widget text-center p-2 bg-white border rounded shadow-sm">
                 <span class="display-6 text-primary fw-bold">
                     <?php echo TOTAL($LeadsReminderSQL); ?>
                 </span><br>
                 <strong class="text-primary small" style="font-size: 0.55rem !important;">All Reminders</strong>
             </div>
         </div>
         <div class="col-4">
             <div class="widget text-center p-2 bg-white border rounded shadow-sm">
                 <span class="display-6 text-success fw-bold">
                     <?php echo TOTAL($LeadsReminderSQL); ?>
                 </span><br>
                 <strong class="text-success small" style="font-size: 0.55rem !important;">Active Reminders</strong>
             </div>
         </div>
         <div class="col-4">
             <div class="widget text-center p-2 bg-white border rounded shadow-sm">
                 <span class="display-6 text-danger fw-bold">
                     <?php echo TOTAL($LeadsReminderSQL); ?>
                 </span><br>
                 <strong class="text-danger small" style="font-size: 0.55rem !important;">Missed Reminders</strong>
             </div>
         </div>
     </div>
     <ul class="timeline list-unstyled position-relative">
         <?php
            $AllReminderList = SET_SQL($LeadsReminderSQL . " ORDER BY leads_reminder_id DESC", true);
            if ($AllReminderList != null) {
                foreach ($AllReminderList as $Reminders) { ?>
                 <li class="timeline-item mb-4 position-relative">
                     <div class="">
                         <!-- Milestone Point (Date and Time) -->
                         <div class="flex-shrink-0 me-3 text-left" style="padding-left:1.2rem !important;">
                             <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $Reminders->leads_reminder_created_at); ?></span>
                             <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $Reminders->leads_reminder_created_at); ?></small>
                             <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 10px; left: 1px;"></div>
                             <span class="m-1 bx-pull-right pull-right float-end">
                                 <?php echo StatusViewWithText($Reminders->leads_reminder_status); ?>
                             </span>
                         </div>
                         <!-- Timeline Content -->
                         <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                             <div class="d-flex justify-content-start align-items-center">
                                 <strong class="text-primary"><?php echo UpperCase($Reminders->leads_reminder_name); ?></strong>
                             </div>
                             <div class="mt-1">
                                 <span class="detail-title fw-bold">Scheduled For :</span>
                                 <span class="badge bg-primary m-1"><i class="bi bi-calendar-day"></i> <?php echo DATE_FORMATES("d M, Y", $Reminders->leads_reminder_date); ?></span>
                                 <span class="badge bg-success m-1"><i class="bi bi-bell"></i> <?php echo DATE_FORMATES("h:i A", $Reminders->leads_reminder_time); ?></span>
                                 <br>
                                 <span class="detail-title fw-bold">By:</span>
                                 (UID<?php echo $Reminders->leads_reminder_created_by; ?>)-
                                 <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Reminders->leads_reminder_created_by . "'", "UserFullName"); ?>
                                 <br>
                                 <span class="detail-title fw-bold">Reminder Note:</span>
                                 <?php echo SECURE($Reminders->leads_reminder_notes, "d"); ?>
                             </div>
                         </div>
                     </div>
                 </li>
             <?php }
            } else { ?>
             <div class="alert alert-warning">
                 <i class="bi bi-exclamation"></i>
                 No Reminders Found!
             </div>
         <?php } ?>
     </ul>
 </div>

 <!-- Reminders Modal -->
 <div class="modal fade" id="addReminderModal" tabindex="-1" aria-labelledby="addReminderModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header app-heading">
                 <h5 class="modal-title" id="addReminderModalLabel">Add Reminder</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST">
                     <?php echo FormPrimaryInputs(true, [
                            "leads_id" => $LeadsId,
                        ]); ?>
                     <div class="mb-3">
                         <label for="reminderName" class="form-label">Reminder Name</label>
                         <input type="text" name="leads_reminder_name" required class="form-control" id="reminderName" placeholder="e.g., Follow-up Call">
                     </div>
                     <div class="mb-3 col-md-4">
                         <label for="reminderDate" class="form-label">Date</label>
                         <input type="date" min="<?php echo DATE('Y-m-d'); ?>" required min="<?php echo DATE('Y-m-d'); ?>" name="leads_reminder_date" class="form-control" id="reminderDate">
                     </div>
                     <div class="mb-3 col-md-4">
                         <label for="reminderTime" class="form-label">Time</label>
                         <input type="time" name="leads_reminder_time" required min="<?php echo DATE('h:i A'); ?>" minlength="<?php echo DATE('h:i A'); ?>" class="form-control" id="reminderTime">
                     </div>
                     <div class="col-md-4 mb-3">
                         <label>Re-Remind Before/Repeating</label>
                         <select class="form-control" name="leads_reminder_re_remind_time" required>
                             <option value="0">Select Interval</option>
                             <option value="0">No Re-Reminders</option>
                             <option value="15 Minutes">15 Minutes</option>
                             <option value="30 Minutes">30 Minutes</option>
                             <option value="45 Minutes">45 Minutes</option>
                             <option value="60 Minutes">1 Hour</option>
                             <option value="24 Hours">24 Hours</option>
                             <option value="48 Hours">48 Hour</option>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label for="reminderNote" class="form-label">Reminder Note</label>
                         <textarea class="form-control" name="leads_reminder_notes" required id="reminderNote" rows="3" placeholder="Enter reminder details"></textarea>
                     </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" name="AddLeadReminders" class="btn btn-primary">Save Reminder</button>
             </div>
             </form>
         </div>
     </div>
 </div>