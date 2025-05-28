  <div class="row mt-2">
      <div class="col-md-12">
          <!-- Existing table modified for meetings -->
          <div class="table-container">
              <table>
                  <thead>
                      <tr>
                          <th>S.No</th>
                          <th>CustomerName</th>
                          <th>PhoneNumber</th>
                          <th>ReminderName</th>
                          <th>DateTime</th>
                          <th>ManagedBy</th>
                          <th>Remarks</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                        $START_FROM = START_FROM;
                        $LISTING_LIMIT = DEFAULT_RECORD_LISTING;
                        $AllLeadsReminders = "SELECT * FROM leads_reminders, leads WHERE DATE(leads_reminder_date)='$ActiveDate' AND leads_reminders.leads_reminder_main_leads_id=leads.leads_id AND leads_reminder_user_id='" . LOGIN_USER_ID . "'";

                        $ReminderGETSQL = SET_SQL($AllLeadsReminders . " LIMIT $LISTING_LIMIT OFFSET $START_FROM", true);
                        if ($ReminderGETSQL != null) {
                            $SerialNo = SERIAL_NO;
                            foreach ($ReminderGETSQL as $Reminder) {
                                $SerialNo++;

                                $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_reminder_main_leads_id . "'";
                                $ManagedBy = "SELECT UserFullName FROM users where UserId='" . $Reminder->leads_reminder_user_id . "'";
                        ?>
                              <tr>
                                  <td><?php echo $SerialNo; ?></td>
                                  <td>
                                      <a href="<?php echo APP_URL . "/leads/details/?leadsid=$Reminder->leads_reminder_main_leads_id"; ?>" class="text-primary bold">
                                          <i class="bi bi-person-fill text-info"></i> <?php echo FETCH($LeadsSQL, "leads_full_name"); ?>
                                      </a>
                                  </td>
                                  <td><?php echo PHONE(FETCH($LeadsSQL, "leads_phone_number"), "link", "text-success bold", "fa fa-phone text-primary"); ?></td>
                                  <td><?php echo $Reminder->leads_reminder_name; ?></td>
                                  <td><i class="fa fa-clock text-danger"></i> <?php echo date("d M, Y h:i A", strtotime($Reminder->leads_reminder_date)); ?></td>
                                  <td>
                                      <a href="<?php echo APP_URL; ?>/reports/?SelectedUserId=<?php echo SECURE($Reminder->leads_reminder_user_id, "e"); ?>" class="text-primary bold text-decoration-underline">
                                          (UID:<?php echo $Reminder->leads_reminder_user_id; ?>)- <?php echo FETCH($ManagedBy, "UserFullName"); ?>
                                      </a>
                                  </td>
                                  <td><?php echo SECURE($Reminder->leads_reminder_notes, "d"); ?></td>
                                  <td><?php echo ReminderStatus($Reminder->leads_reminder_status); ?></td>
                              </tr>
                      <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>
                                    <span class='alert alert-warning d-block mt-1 text-center'>No Reminder Found!.</span>
                                    </td></tr>";
                        } ?>
                  </tbody>
              </table>
          </div>
      </div>
      <?php echo PaginationFooter(TOTAL($AllLeadsReminders), "index.php"); ?>
  </div>