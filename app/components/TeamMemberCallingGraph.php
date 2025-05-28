<?php if (AuthAppUser("UserType") == "ADMIN" || AuthAppUser("UserType") == "TEAM_HEAD") { ?>
 <div class="col-md-12">
  <div class="card pt-4 mb-3">
   <div class="card-body">
    <h5 class="card-title app-heading">
     <i class="bi bi-person-fill text-warning"></i> Team Wise Call Flow
    </h5>
    <div class="team-wise-calling-container" style="width: 100%; height: 450px;">
     <canvas id="teamWiseCallingChart" style="width: 100% !important; height: 100% !important;"></canvas>
    </div>

    <?php
    $teamWiseCallingData = [];
    $today = DATE("Y-m-d");
    $yesterday = DATE("Y-m-d", strtotime("-1 day"));

    if (AuthAppUser("UserType") == "ADMIN") {
     $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
    } else if (AuthAppUser("UserType") == "TEAM_HEAD") {
     $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
    } else {
     $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserId='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
    }

    if ($AllUsers != null) {
     foreach ($AllUsers as $AllUser) {
      $UserId = $AllUser->UserId;
      $UserFullName = $AllUser->UserFullName;
      $UserPhoneNumber = $AllUser->UserPhoneNumber;
      $UserProfileImage = GetUserImage($UserId, APP_LOGO);

      $todayCalls = TOTAL("SELECT leads_activity_date_time FROM leads_activities where DATE(leads_activity_date_time)='$today' and leads_activity_added_by='$UserId'") ?? 0;
      $yesterdayCalls = TOTAL("SELECT leads_activity_date_time FROM leads_activities where DATE(leads_activity_date_time)='$yesterday' and leads_activity_added_by='$UserId'") ?? 0;

      $teamWiseCallingData[] = [
       'userId' => $UserId,
       'userName' => $UserFullName,
       'profileImage' => $UserProfileImage,
       'todayCalls' => (int)$todayCalls,
       'yesterdayCalls' => (int)$yesterdayCalls
      ];
     }
    }
    ?>

    <script>
     const teamWiseCallingData = <?php echo json_encode($teamWiseCallingData); ?>;
     const ctx = document.getElementById('teamWiseCallingChart').getContext('2d');

     const maxCallCount = Math.max(
      ...teamWiseCallingData.map(user => user.todayCalls),
      ...teamWiseCallingData.map(user => user.yesterdayCalls)
     );

     const targetSteps = 12; // Target number of steps for Y-axis
     let stepSize = Math.ceil(maxCallCount / targetSteps) || 1;

     const yAxisConfig = {
      title: {
       display: true,
       text: 'Call Count & Activities'
      },
      beginAtZero: true,
      ticks: {
       stepSize: stepSize
      },
      suggestedMax: stepSize * targetSteps
     };

     new Chart(ctx, {
      type: 'line',
      data: {
       labels: teamWiseCallingData.map(user => `${user.userName} (${user.userId})`),
       datasets: [{
         label: "Today's Calls",
         data: teamWiseCallingData.map(user => user.todayCalls),
         borderColor: '#800080', // Purple
         backgroundColor: 'rgb(255, 0, 157)',
         fill: false,
         tension: 0.5,
         pointRadius: 7,
         pointHoverRadius: 10,
         borderDash: [5, 5],
         pointStyle: 'circle'
        },
        {
         label: "Yesterday's Calls",
         data: teamWiseCallingData.map(user => user.yesterdayCalls),
         borderColor: '#87CEEB', // Sky Blue
         backgroundColor: 'rgb(0, 208, 255)',
         fill: false,
         tension: 0.5,
         pointRadius: 7,
         pointHoverRadius: 10,
         borderDash: [5, 5],
         pointStyle: 'circle'
        }
       ]
      },
      options: {
       responsive: true,
       maintainAspectRatio: false,
       scales: {
        x: {
         title: {
          display: true,
          text: 'All Team Members'
         },
         ticks: {
          autoSkip: false,
          maxRotation: 70,
          minRotation: 70,
          callback: function(value, index) {
           const label = this.getLabelForValue(value);
           return label.length > 20 ? label.substring(0, 17) + '...' : label;
          }
         }
        },
        y: yAxisConfig
       },
       plugins: {
        tooltip: {
         callbacks: {
          title: function(tooltipItems) {
           return '';
          },
          label: function(context) {
           const user = teamWiseCallingData[context.dataIndex];
           const callCount = context.raw;
           const type = context.dataset.label;
           const icon = '📞';
           return [
            `👤 ${user.userName}`,
            `${icon} ${type.replace("Calls", "").trim()}: ${callCount} calls`
           ];
          },
          labelTextColor: function() {
           return '#FFF';
          }
         },
         displayColors: false,
         bodyAlign: 'center',
         titleAlign: 'center'
        },
        legend: {
         position: 'top'
        }
       },
       layout: {
        padding: {
         top: 10,
         bottom: 10,
         left: 10,
         right: 10
        }
       }
      }
     });
    </script>

   </div>
  </div>
 </div>
<?php } ?>