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
                        <th>ProjectName</th>
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
                    $SiteVisitSQL = "SELECT * FROM leads_site_visits, leads WHERE DATE(leads_site_visit_schedule_date)='$ActiveDate' AND leads_site_visits.leads_main_leads_id=leads.leads_id AND leads_site_visit_handled_by='" . LOGIN_USER_ID . "'";

                    $ReminderGETSQL = SET_SQL($SiteVisitSQL . " LIMIT $LISTING_LIMIT OFFSET $START_FROM", true);
                    if ($ReminderGETSQL != null) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ReminderGETSQL as $Reminder) {
                            $SerialNo++;
                            $LeadsSQL = "SELECT leads_full_name, leads_phone_number FROM leads where leads_id='" . $Reminder->leads_main_leads_id . "'";
                            $ProjectSQL = "SELECT projects_name from projects where projects_id='" . $Reminder->leads_site_visits_projects_id . "'";
                            $ManagedBy = "SELECT UserFullName FROM users where UserId='" . $Reminder->leads_site_visit_handled_by . "'";
                    ?>
                            <tr>
                                <td><?php echo $SerialNo; ?></td>
                                <td>
                                    <a href="<?php echo APP_URL . "/leads/details/?leadsid=$Reminder->leads_main_leads_id"; ?>" class="text-primary bold">
                                        <i class="bi bi-person-fill text-info"></i> <?php echo FETCH($LeadsSQL, "leads_full_name"); ?>
                                    </a>
                                </td>
                                <td><?php echo PHONE(FETCH($LeadsSQL, "leads_phone_number"), "link", "text-success bold", "fa fa-phone text-primary"); ?></td>
                                <td><?php echo FETCH($ProjectSQL, "projects_name") ?? "NOT AVAILABLE"; ?></td>
                                <td><i class="fa fa-clock text-danger"></i> <?php echo date("d M, Y h:i A", strtotime($Reminder->leads_site_visit_schedule_date)); ?></td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/reports/?SelectedUserId=<?php echo SECURE($Reminder->leads_site_visit_handled_by, "e"); ?>" class="text-primary bold text-decoration-underline">
                                        (UID:<?php echo $Reminder->leads_site_visit_handled_by; ?>)- <?php echo FETCH($ManagedBy, "UserFullName"); ?>
                                    </a>
                                </td>
                                <td><?php echo SECURE($Reminder->leads_site_visit_notes, "d"); ?></td>
                                <td><?php echo SiteVisitStatus($Reminder->leads_site_visit_status); ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8'>
                                    <span class='alert alert-warning d-block mt-1 text-center'>No Site Visit Found!.</span>
                                    </td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo PaginationFooter(TOTAL($SiteVisitSQL), "AllSiteVisits.php"); ?>
</div>