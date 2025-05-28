<div class="card-body">
  <h5 class="card-title app-heading"><i class="bi bi-clock text-warning"></i> Today Reminders</h5>
  <div class="table-container">
    <table class="">
      <thead>
        <tr>
          <th>Name</th>
          <th>PhoneNumber</th>
          <th>ReminderName</th>
          <th>ReminderDateTime</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (AuthAppUser("UserType") == "ADMIN") {
          $ReminderSQL = "SELECT leads_reminder_main_leads_id, leads_reminder_date, leads_reminder_time, leads_reminder_name  FROM leads_reminders where DATE(leads_reminder_date)='" . DATE('Y-m-d') . "' ORDER BY DATE(leads_reminder_date) DESC";
        } else {
          $ReminderSQL = "SELECT leads_reminder_date, leads_reminder_main_leads_id, leads_reminder_time, leads_reminder_name  FROM leads_reminders where leads_reminder_user_id='" . LOGIN_USER_ID . "' and DATE(leads_reminder_date)='" . DATE('Y-m-d') . "' ORDER BY DATE(leads_reminder_date) DESC";
        }
        $ReminderGETSQL = SET_SQL($ReminderSQL, true);
        if ($ReminderGETSQL != null) {
          foreach ($ReminderGETSQL as $Reminder) {
            $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_reminder_main_leads_id . "'";
        ?>
            <tr>
              <td>
                <a href="<?php echo APP_URL . "/contacts/details/?leadsid=$Reminder->leads_reminder_main_leads_id"; ?>">
                  <?php echo FETCH($LeadsSQL, "leads_full_name"); ?>
                </a>
              </td>
              <td><?php echo FETCH($LeadsSQL, "leads_phone_number"); ?></td>
              <td><?php echo $Reminder->leads_reminder_name; ?></td>
              <td><?php echo date("d M, Y", strtotime($Reminder->leads_reminder_date)); ?> <?php echo date("h:i A", strtotime($Reminder->leads_reminder_time)); ?></td>
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