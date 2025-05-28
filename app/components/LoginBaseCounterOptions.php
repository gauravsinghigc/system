<?php
$ActiveDashboardView = ReturnSessionalValues("activeDashboard", "ACTIVE_DASHBOARD_VIEW", "MY-DASHBOARD");
if (AuthAppUser("UserType") == "TEAM_HEAD") { ?>
 <div class="row mt-2">
  <div class="col-md-12 text-center bg-white">
   <div class="p-1">
    <?php
    if ($ActiveDashboardView == "MY-DASHBOARD") {
     $_SESSION["ACTIVE_LEAD_FOR_TEAM_HEADS"] = "MY-LEADS";
    } else {
     $_SESSION["ACTIVE_LEAD_FOR_TEAM_HEADS"] = "TEAM-LEADS";
    }
    foreach (DASHBOARD_VIEW_FOR_TEAM_HEADS as $Dashboardkey => $DashboardKeyValues) {
     $CompareDashboards = CheckEquality($ActiveDashboardView, $Dashboardkey, "btn-primary"); ?>
     <a href="?activeDashboard=<?php echo $Dashboardkey; ?>" class="btn btn-md <?php echo $CompareDashboards; ?> btn-default">
      <?php echo $Dashboardkey; ?>
     </a>
    <?php } ?>
   </div>
  </div>
 </div>
<?php } ?>