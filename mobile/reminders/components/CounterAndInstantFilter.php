 <section class="section animate-fade-up">
     <div class="row mt-2">
         <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
             <div class="app-widget-counter p-3 pb-2">
                 <a href="?InstantReminderStatusView=0">
                     <div class="bg-white d-block rounded-3 p-2 pt-1 pb-1 mb-2">
                         <h1 class="app-fs-6 pull-right mr-1 mt-2 text-warning"><i class="fa fa-clock"></i></h1>
                         <h1 class="text-primary app-fs-5 bold mb-0 pb-0"><?php echo TOTAL($AllLeadsReminders . " and leads_reminder_status='0'"); ?></h1>
                         <h6 class="text-secondary mt-0 pt-0">Active Reminders</h6>
                     </div>
                 </a>
             </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
             <div class="app-widget-counter p-3 pb-2">
                 <a href="?InstantReminderStatusView=1">
                     <div class="bg-white d-block rounded-3 p-2 pt-1 pb-1 mb-2">
                         <h1 class="app-fs-6 pull-right mr-1 mt-2 text-success"><i class="fa fa-check-circle"></i></h1>
                         <h1 class="text-primary app-fs-5 bold mb-0 pb-0"><?php echo TOTAL($AllLeadsReminders . " and leads_reminder_status='1'"); ?></h1>
                         <h6 class="text-secondary mt-0 pt-0">Completed</h6>
                     </div>
                 </a>
             </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
             <div class="app-widget-counter p-3 pb-2">
                 <a href="?InstantReminderStatusView=2">
                     <div class="bg-white d-block rounded-3 p-2 pt-1 pb-1 mb-2">
                         <h1 class="app-fs-6 pull-right mr-1 mt-2 text-danger"><i class="fa fa-times"></i></h1>
                         <h1 class="text-primary app-fs-5 bold mb-0 pb-0"><?php echo TOTAL($AllLeadsReminders . " and leads_reminder_status='2'"); ?></h1>
                         <h6 class="text-secondary mt-0 pt-0">Reminder Dropped</h6>
                     </div>
                 </a>
             </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-3">
             <div class="app-widget-counter p-3 pb-2">
                 <a href="?InstantReminderStatusView=3">
                     <div class="bg-white d-block rounded-3 p-2 pt-1 pb-1 mb-2">
                         <h1 class="app-fs-6 pull-right mr-1 mt-2 text-secondary"><i class="fa fa-warning"></i></h1>
                         <h1 class="text-primary app-fs-5 bold mb-0 pb-0"><?php echo TOTAL($AllLeadsReminders . " and leads_reminder_status='3'"); ?></h1>
                         <h6 class="text-secondary mt-0 pt-0">Missed Reminders</h6>
                     </div>
                 </a>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12 text-center mb-1">
             <a href="<?php echo DOMAIN; ?>/mobile/reminders" class="btn btn-sm btn-primary text-white">📅 All Reminders <b><?php echo TOTAL($AllLeadsReminders); ?></b></a>
             <a href="?getReminderFor=<?php echo DATE("Y-m-d", strtotime("-1 days")); ?>" class="btn btn-sm btn-warning text-white">🕰️ Yesterday : <b><?php echo TOTAL($AllLeadsReminders . " and DATE(leads_reminder_date)='" . DATE("Y-m-d", strtotime("-1 days")) . "'"); ?></b></a>
             <a href="?getReminderFor=<?php echo DATE("Y-m-d"); ?>" class="btn btn-sm btn-success text-white">📅 Today : <b><?php echo TOTAL($AllLeadsReminders . " and DATE(leads_reminder_date)='" . DATE("Y-m-d") . "'"); ?></b></a>
             <a href="?getReminderFor=<?php echo DATE("Y-m-d", strtotime("+1 days")); ?>" class="btn btn-sm btn-danger text-white">🔮 Tomorrow : <b><?php echo TOTAL($AllLeadsReminders . " and DATE(leads_reminder_date)='" . DATE("Y-m-d", strtotime("+1 days")) . "'"); ?></b></a>
         </div>
     </div>

 </section>