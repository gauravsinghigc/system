<div class="row">
    <div class="col-md-12">
        <div class="table-container mt-4">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" class="d-selection"></th>
                        <th>SNo.</th>
                        <th>Contact Name</th>
                        <th>Phone Number</th>
                        <th>Alt Phone</th>
                        <th>Project</th>
                        <th>Stage</th>
                        <th>SubStage</th>
                        <th>Source</th>
                        <th>ReSource</th>
                        <th>Assigned To</th>
                        <th>Assigned On</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Budget</th>
                        <th>Manager</th>
                        <th>Created</th>
                        <th>PrevStage</th>
                        <th>PrevAssignedTo</th>
                        <th>AssignedBy</th>
                        <th>Modified</th>
                        <th>ModifiedBy</th>
                        <th>InsertMode</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $StartFrom = START_FROM;
                    $DisplayRecords = DEFAULT_RECORD_LISTING;
                    $GetRecordsColumns = "leads_gender, leads_id, leads_full_name, leads_phone_number, leads_assign_status, leads_entry_type, leads_alternate_phone, leads_projects_id, leads_stages, leads_type, leads_sub_stages, leads_source, leads_re_source, leads_managed_by, leads_assigned_date, leads_priority_level, leads_created_at ";
                    $AllLeadsSQL = "SELECT $GetRecordsColumns FROM leads WHERE DATE(leads_created_at)='$ActiveDate' AND leads_managed_by='" . LOGIN_USER_ID . "' and leads_is_removed!= '1'";

                    $PaginationTotalSQL = $AllLeadsSQL;
                    $ProcessSQL = SET_SQL($AllLeadsSQL . " ORDER BY leads_id DESC LIMIT $DisplayRecords OFFSET $StartFrom", true);
                    if ($ProcessSQL) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ProcessSQL as $Records) {
                            $SerialNo++;
                            if ($Records->leads_gender == "Male") {
                                $ColorClass = "text-primary";
                            } elseif ($Records->leads_gender == "Female") {
                                $ColorClass = "text-info";
                            } else {
                                $ColorClass = "text-secondary";
                            }
                    ?>
                            <tr>
                                <td><input type="checkbox" class="d-selection" name="SELECTED_LEADS[]" value="<?php echo $Records->leads_id; ?>"></td>
                                <td><?php echo $SerialNo; ?></td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/leads/details?leadsid=<?php echo $Records->leads_id; ?>" class="text-primary bold">
                                        <i class="bi bi-person-fill <?php echo $ColorClass; ?>"></i> <?php echo LimitText(UpperCase($Records->leads_full_name), 0, 30); ?>
                                    </a>
                                </td>
                                <td class="bold"><?php echo PHONE($Records->leads_phone_number, "link", "text-success", "bi bi-phone"); ?></td>
                                <td class="bold"><i class="bi bi-telephone-plus-fill text-muted"></i> <?php echo $Records->leads_alternate_phone; ?></td>
                                <td><i class="bi bi-building-fill text-info"></i> <?php echo LimitText(FETCH("SELECT projects_name FROM projects where projects_id='" . $Records->leads_projects_id . "'", "projects_name"), 0, 20) ?: '<span class="text-muted">N/A</span>'; ?></td>
                                <td>
                                    <span class="color-tags" style="background-color:<?php echo FETCH("SELECT config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages  . "'", "config_leads_stage_color_code"); ?>;color:black !important;">
                                        <?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Records->leads_stages . "'", "config_leads_stage_name"); ?>
                                    </span>
                                </td>
                                <td><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Records->leads_sub_stages . "'", "config_call_sub_status_name"); ?></td>
                                <td><i class="bi bi-share-fill text-warning"></i> <?php echo FETCH("SELECT config_leads_source_name FROM config_leads_sources where config_leads_source_id='" . $Records->leads_source . "'", "config_leads_source_name"); ?></td>
                                <td><i class="bi bi-globe text-success"></i> <?php echo FETCH("SELECT config_leads_resources_name FROM config_leads_resources where config_leads_resources_id ='" . $Records->leads_re_source . "'", "config_leads_resources_name"); ?></td>
                                <td><i class="bi bi-person-badge-fill text-dark"></i> <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Records->leads_managed_by . "'", "UserFullName"); ?></td>
                                <td><i class="bi bi-calendar-event text-info"></i> <?php echo DATE_FORMATES("d M, Y", $Records->leads_assigned_date); ?></td>
                                <td><i class="bi bi-briefcase-fill text-secondary"></i> <?php echo $Records->leads_type; ?></td>
                                <td><i class="bi bi-flag-fill text-danger"></i> <?php echo FETCH("SELECT config_priority_level_name FROM config_priority_levels where config_priority_level_id='" . $Records->leads_priority_level . "'", "config_priority_level_name") ?: '<span class="text-muted">N/A</span>'; ?></td>
                                <td><?php echo Price(FETCH("SELECT leads_requirement_budgets FROM leads_requirements where leads_main_id='" . $Records->leads_id . "'", "leads_requirement_budgets"), "text-success", "Rs."); ?></td>
                                <td><i class="bi bi-diagram-3-fill text-muted"></i> <?php echo FETCH("SELECT UserFullName from users where UserId='" . FETCH("SELECT UserReportingManager FROM users where UserId='" . $Records->leads_managed_by . "'", "UserReportingManager") . "'", "UserFullName"); ?></td>
                                <td><i class="bi bi-clock-history text-info"></i> <?php echo DATE_FORMATES("d M, Y", $Records->leads_created_at); ?></td>
                                <td>
                                    <i class="bi bi-arrow-return-left text-primary"></i>
                                    <?php
                                    $leads_assigned_previous_stages = FETCH("SELECT leads_assigned_previous_stages FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previous_stages");
                                    echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='$leads_assigned_previous_stages'", "config_leads_stage_name");
                                    ?>
                                </td>
                                <td>
                                    <i class="bi bi-person-lines-fill text-warning"></i>
                                    <?php
                                    $leads_assigned_previously_to = FETCH("SELECT leads_assigned_previously_to FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_to");
                                    echo FETCH("SELECT UserFullName FROM users where UserId='$leads_assigned_previously_to'", "UserFullName");
                                    ?>
                                </td>
                                <td>
                                    <i class="bi bi-person-circle text-success"></i>
                                    <?php
                                    $leads_assigned_previously_by = FETCH("SELECT leads_assigned_previously_by FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_previously_by");
                                    echo FETCH("SELECT UserFullName FROM users where UserId='$leads_assigned_previously_by'", "UserFullName");
                                    ?>
                                </td>
                                <td>
                                    <i class="bi bi-calendar-check-fill text-primary"></i>
                                    <?php
                                    $leads_assigned_udpated_at = FETCH("SELECT leads_assigned_udpated_at FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_udpated_at");
                                    echo DATE_FORMATES("d M, Y", $leads_assigned_udpated_at);
                                    ?>
                                </td>
                                <td>
                                    <i class="bi bi-person-gear text-muted"></i>
                                    <?php
                                    $leads_assigned_udpated_by = FETCH("SELECT leads_assigned_udpated_by FROM leads_assignees where leads_main_id='" . $Records->leads_id . "' ORDER BY leads_assign_id DESC LIMIT 1", "leads_assigned_udpated_by");
                                    echo FETCH("SELECT UserFullName FROM users where UserId='$leads_assigned_udpated_by'", "UserFullName");
                                    ?>
                                </td>
                                <td><i class="bi bi-journal-code text-secondary"></i> <?php echo $Records->leads_entry_type; ?></td>
                                <td><i class="bi bi-toggle-on text-info"></i> <?php echo $Records->leads_assign_status; ?></td>
                                <td>
                                    <a class="btn btn-xs btn-dark" href="<?php echo APP_URL; ?>/leads/details?leadsid=<?php echo $Records->leads_id; ?>">
                                        <i class="fa fa-eye text-success"></i> View
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='25' class='text-center alert alert-warning'>No Leads Found!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo PaginationFooter(TOTAL($PaginationTotalSQL), APP_URL . "/calendar"); ?>
            </div>
        </div>
    </div>
</div>