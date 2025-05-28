<div class="card-body">
 <h5 class="card-title app-heading"><i class="bi bi-person text-warning"></i> Today Site Visits</h5>
 <div class="table-container">
  <table>
   <thead>
    <tr>
     <th>Name</th>
     <th>PhoneNumber</th>
     <th>ProjectName</th>
     <th>SiteVisitDateTime</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (AuthAppUser("UserType") == "ADMIN") {
     $ReminderSQL = "SELECT leads_main_leads_id ,leads_site_visits_projects_id, leads_site_visit_schedule_date FROM leads_site_visits where DATE(leads_site_visit_schedule_date)='" . DATE('Y-m-d') . "' ORDER BY DATE(leads_site_visit_schedule_date) DESC";
    } else {
     $ReminderSQL = "SELECT leads_main_leads_id ,leads_site_visits_projects_id, leads_site_visit_schedule_date FROM leads_site_visits where leads_site_visit_handled_by='" . LOGIN_USER_ID . "' and DATE(leads_site_visit_schedule_date)='" . DATE('Y-m-d') . "' ORDER BY DATE(leads_site_visit_schedule_date) DESC";
    }
    $ReminderGETSQL = SET_SQL($ReminderSQL, true);
    if ($ReminderGETSQL != null) {
     foreach ($ReminderGETSQL as $Reminder) {
      $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_main_leads_id . "'";
      $ProjectSQL = "SELECT projects_name from projects where projects_id='" . $Reminder->leads_site_visits_projects_id . "'";
    ?>
      <tr>
       <td>
        <a href="<?php echo APP_URL . "/contacts/details/?leadsid=$Reminder->leads_main_leads_id"; ?>">
         <?php echo FETCH($LeadsSQL, "leads_full_name"); ?>
        </a>
       </td>
       <td><?php echo FETCH($LeadsSQL, "leads_phone_number"); ?></td>
       <td><?php echo FETCH($ProjectSQL, "projects_name") ?? "Not Available"; ?></td>
       <td><?php echo date("d M, Y h:i A", strtotime($Reminder->leads_site_visit_schedule_date)); ?></td>
      </tr>
    <?php
     }
    } else {
     echo "<tr><td colspan='4'>No Reminders Today.</td></tr>";
    } ?>
   </tbody>
  </table>
 </div>
</div>