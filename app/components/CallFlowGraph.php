<div class="card-body">
    <h5 class="card-title app-heading"><i class="bi bi-clock-history text-warning"></i> Monthly Call Flow Chart</h5>
    <canvas id="callFlowChart"></canvas>

    <?php
    if (AuthAppUser("UserType") == "ADMIN") {
        $AllCalls = SET_SQL("SELECT leads_activity_date_time FROM leads_activities WHERE leads_activity_date_time IS NOT NULL ORDER BY leads_acitivity_id ASC", true);
    } else {
        $AllCalls = SET_SQL("SELECT leads_activity_date_time FROM leads_activities WHERE leads_activity_added_by='" . LOGIN_USER_ID . "' AND leads_activity_date_time IS NOT NULL ORDER BY leads_acitivity_id ASC", true);
    }

    $currentMonth = date('m');
    $currentYear = date('Y');
    $lastMonth = date('m', strtotime('-1 month'));
    $lastMonthYear = date('Y', strtotime('-1 month'));
    $currentDay = date('j'); // Current day of the month

    // Initialize arrays for monthly data
    $currentMonthData = array_fill(1, date('t'), 0);
    $lastMonthData = array_fill(1, date('t', strtotime('-1 month')), 0);

    if ($AllCalls != null) {
        $today = new DateTime();
        foreach ($AllCalls as $FlowCalls) {
            $date = new DateTime($FlowCalls->leads_activity_date_time);
            if ($date > $today) continue; // Skip future dates
            $month = $date->format('m');
            $year = $date->format('Y');
            $day = $date->format('j');

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

            // Get current month and year for tooltip date formatting
            const currentMonth = <?php echo date('m'); ?>;
            const currentYear = <?php echo date('Y'); ?>;
            const lastMonth = <?php echo date('m', strtotime('-1 month')); ?>;
            const lastMonthYear = <?php echo date('Y', strtotime('-1 month')); ?>;

            callFlowChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '<?php echo DATE("M, Y"); ?> Calls ',
                        data: currentMonthCalls,
                        borderColor: '#6D28D9', // Purple
                        backgroundColor: '#6D28D9',
                        borderWidth: 3, // Thicker line
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        pointStyle: 'circle', // Circular points (can be customized further)
                        fill: false
                    }, {
                        label: ' <?php echo DATE("M, Y", strtotime("-1 month")); ?> Calls',
                        data: lastMonthCalls,
                        borderColor: '#38BDF8', // Sky blue
                        backgroundColor: '#38BDF8',
                        borderWidth: 3, // Thicker line
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        pointStyle: 'circle',
                        fill: false,
                        borderDash: [3, 3] // Dashed line for last month
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgb(206, 1, 1)',
                            color: '#FFFFFF',
                            cornerRadius: 10, // Rounded corners
                            padding: 15,
                            titleFont: {
                                size: 15,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 14
                            },
                            callbacks: {
                                title: function(tooltipItems) {
                                    const day = tooltipItems[0].label;
                                    const datasetIndex = tooltipItems[0].datasetIndex;
                                    const month = datasetIndex === 0 ? currentMonth : lastMonth;
                                    const year = datasetIndex === 0 ? currentYear : lastMonthYear;
                                    const date = new Date(year, month - 1, day);
                                    return date.toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    });
                                },
                                label: function(tooltipItem) {
                                    return ` Calls : ${tooltipItem.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Calls',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.3)' // Subtle grid lines
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Day of Month',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: true // Hide vertical grid lines for cleaner look
                            }
                        }
                    },
                    elements: {
                        point: {
                            pointStyle: 'circle' // Default to circle, can be replaced with custom icon
                        }
                    }
                }
            });

            // Totals
            const totals = [
                currentMonthCalls.reduce((a, b) => a + b, 0),
                lastMonthCalls.reduce((a, b) => a + b, 0)
            ];
        }

        // Initial render
        updateCallFlowChart();
    </script>
</div>