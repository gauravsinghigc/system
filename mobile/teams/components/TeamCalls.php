<div class="card-body p-0">
    <h5 class="card-title app-sub-heading"><i class="bi bi-clock-history"></i> Call Flow</h5>
    <?php $ActivitySQL = "SELECT leads_acitivity_id FROM leads_activities where leads_activity_added_by='$SelectedUserId'"; ?>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-4 mb-2">
            <div class="app-widget-counter p-1 rounded-3">
                <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                    <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) = CURDATE()"); ?></h5>
                    <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-primary"></i> Today Calls</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-4 mb-2">
            <div class="app-widget-counter p-1 rounded-3">
                <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                    <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) = CURDATE() - INTERVAL 1 DAY"); ?></h5>
                    <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-info"></i> Yesterday</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-4 mb-2">
            <div class="app-widget-counter p-1 rounded-3">
                <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                    <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) >= CURDATE() - INTERVAL 7 DAY"); ?></h5>
                    <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-secondary"></i> Weekly Calls</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-4 mb-2">
            <div class="app-widget-counter p-1 rounded-3">
                <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                    <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and YEAR(leads_activity_date_time) = YEAR(CURDATE()) AND MONTH(leads_activity_date_time) = MONTH(CURDATE())"); ?></h5>
                    <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-success"></i> Current Month</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-4 mb-2">
            <div class="app-widget-counter p-1 rounded-3">
                <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                    <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and YEAR(leads_activity_date_time) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(leads_activity_date_time) = MONTH(CURDATE() - INTERVAL 1 MONTH)"); ?></h5>
                    <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-warning"></i> Last Month</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-4 mb-2">
            <div class="app-widget-counter p-1 rounded-3">
                <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                    <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL); ?></h5>
                    <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-black"></i> Overall Calls</p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <canvas id="callFlowChart"></canvas>

    <?php
    $AllCalls = SET_SQL("SELECT * FROM leads_activities where leads_activity_added_by='$SelectedUserId' ORDER BY leads_acitivity_id ASC", true);

    $currentMonth = date('m');
    $currentYear = date('Y');
    $lastMonth = date('m', strtotime('-1 month'));
    $lastMonthYear = date('Y', strtotime('-1 month'));

    // Monthly data - only total calls
    $currentMonthData = array_fill(1, date('t'), 0);
    $lastMonthData = array_fill(1, date('t', strtotime('-1 month')), 0);

    if ($AllCalls != null) {
        foreach ($AllCalls as $FlowCalls) {
            $date = new DateTime($FlowCalls->leads_activity_date_time);
            $month = $date->format('m');
            $year = $date->format('Y');
            $day = $date->format('j');

            // Monthly data
            if ($year == $currentYear && $month == $currentMonth) {
                $currentMonthData[$day]++;
            } elseif ($year == $lastMonthYear && $month == $lastMonth) {
                $lastMonthData[$day]++;
            }
        }
    }
    ?>
    <script>
        let callFlowChart;

        function updateCallFlowChart() {
            const ctx = document.getElementById('callFlowChart').getContext('2d');

            if (callFlowChart) {
                callFlowChart.destroy();
            }

            const currentMonthCalls = <?php echo json_encode(array_values($currentMonthData)); ?>;
            const lastMonthCalls = <?php echo json_encode(array_values($lastMonthData)); ?>;
            const daysInMonth = <?php echo date('t'); ?>;
            const labels = Array.from({
                length: daysInMonth
            }, (_, i) => i + 1);

            callFlowChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Current Month Calls',
                        data: currentMonthCalls,
                        borderColor: 'blue',
                        fill: false
                    }, {
                        label: 'Last Month Calls',
                        data: lastMonthCalls,
                        borderColor: 'lightblue',
                        fill: false,
                        borderDash: [5, 5]
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Monthly Call Flow Comparison'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Calls'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Day of Month'
                            }
                        }
                    }
                }
            });

            // Totals
            const totals = [
                currentMonthCalls.reduce((a, b) => a + b, 0),
                lastMonthCalls.reduce((a, b) => a + b, 0)
            ];
            console.log('Monthly Totals:', totals);
        }

        // Initial render
        updateCallFlowChart();
    </script>
</div>

<!-- Team Activities Panel -->
<div class="team-activities">
    <h5 class="app-sub-heading"><i class="bi bi-people-fill text-primary"></i> Call & Feedback Activities</h5>
    <form class="mb-2">
        <input type="search" id="TriggeredCallRecord" oninput="SearchData('TriggeredCallRecord', 'AvailableCallRecords')" name="SearchCallHistory" class="form-control" placeholder="Search Call History..." value="">
    </form>
    <?php
    $DateTime = DATE("Y-m-d");
    $AllCalFeedBacksSQL = "SELECT * FROM leads_activities where leads_activity_added_by='$SelectedUserId'"; ?>
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