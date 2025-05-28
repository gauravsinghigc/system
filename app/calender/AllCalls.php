<div class="row">
    <div class="col-md-12">
        <!-- Team Activities Panel -->
        <div class="team-activities">
            <br>
            <form>
                <input type="search" id="TriggeredCallRecord" oninput="SearchData('TriggeredCallRecord', 'AvailableCallRecords')" name="SearchCallHistory" class="form-control" placeholder="Search Call History..." value="">
            </form>
            <?php
            $SelectedUserId = LOGIN_USER_ID;
            $DateTime = DATE("Y-m-d");
            $AllCalFeedBacksSQL = "SELECT * FROM leads_activities where DATE(leads_activity_date_time)='$ActiveDate' AND leads_activity_added_by='$SelectedUserId'"; ?>
            <div class="flex-s-b mb-2">
                <div class="shadow-sm p-3 text-center rounded-2 m-1 bg-white w-50">
                    <h4 class="mb-0 text-primary"><?php echo TOTAL($AllCalFeedBacksSQL . " and leads_activity_call_source='CRM'"); ?></h4>
                    <p class="mb-1 text-secondary small">Total CRM Calls</p>
                </div>
                <div class="shadow-sm p-3 text-center rounded-2 m-1 bg-white w-50">
                    <h4 class="mb-0 text-info"><?php echo TOTAL($AllCalFeedBacksSQL . " and leads_activity_call_source='APP'"); ?></h5>
                        <p class="mb-1 text-secondary small">Total APP Calls</p>
                </div>
            </div>
            <ul class="timeline list-unstyled position-relative" style="max-height: 100%; overflow-y: auto;">
                <?php
                $AllCalFeedBacks = SET_SQL($AllCalFeedBacksSQL . " ORDER BY leads_acitivity_id DESC LIMIT 30", true);
                if ($AllCalFeedBacks != null) {
                    foreach ($AllCalFeedBacks as $Calls) { ?>
                        <li class="timeline-item mb-4 position-relative AvailableCallRecords">
                            <div class="d-flex flex-column">
                                <!-- Milestone Point (Date and Time) -->
                                <div class="flex-shrink-0 me-3 text-left mb-2">
                                    <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $Calls->leads_activity_date_time); ?></span>
                                    <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?></small>
                                    <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 11px; left: -19px;"></div>
                                </div>
                                <!-- Timeline Content -->
                                <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <?php if (UpperCase($Calls->leads_activity_type) == "OUTGOING") { ?>
                                            <strong class="text-info m-1"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                                        <?php } else { ?>
                                            <strong class="text-primary m-1"><?php echo UpperCase($Calls->leads_activity_type); ?></strong>
                                        <?php } ?>
                                        <span class="badge bg-primary m-1"><?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Calls->leads_acitivity_call_status . "'", "config_leads_stage_name"); ?></span>
                                        <span class="badge bg-success m-1"><?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Calls->leads_acitivity_call_sub_status . "'", "config_call_sub_status_name"); ?></span>
                                    </div>
                                    <div class="mt-2">
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
                                        <!-- Voice Note Playback -->
                                        <?php if ($Calls->leads_activity_have_voice_notes == 1) {
                                            $VoiceNoteFile = $Calls->leads_activity_voice_notes_file;
                                            $StoragePath =  "../storage/leads/audios/" . $Calls->leads_activity_main_leads_id;
                                            $VoiceNoteFullPath = "$StoragePath/$VoiceNoteFile";
                                        ?>
                                            <div class="mt-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <audio controls class="w-100">
                                                        <source src="<?php echo $VoiceNoteFullPath; ?>" type="audio/mp3">
                                                        <source src="<?php echo $VoiceNoteFullPath; ?>" type="audio/mp3">
                                                    </audio>
                                                </div>
                                                <small class="text-muted d-block mt-1">Attached Voice Note (<?php echo $VoiceNoteFile; ?>)</small>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php }
                } else { ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation"></i>
                        No Activity Found!
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>