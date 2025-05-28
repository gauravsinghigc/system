<div class="row mt-4">
    <div class="col-md-6">
        <form action="" method="GET">
            <input type="number" class='form-control form-control-md' value='<?php echo IfRequested("GET", "Search_Phone_Number", "", ""); ?>' name='Search_Phone_Number' placeholder="Search Phone Number...">
        </form>
    </div>
    <?php if (AuthAppUser("UserType") == "TEAM_HEAD") { ?>
        <div class="col-md-6 text-right">
            <?php
            $ActiveLeadViewForTeamHead = IfSessionExists("ACTIVE_LEAD_FOR_TEAM_HEADS", ReturnSessionalValues("LeadViewByTeamHead", "ACTIVE_LEAD_FOR_TEAM_HEADS", "TEAM-LEADS"));
            if ($ActiveLeadViewForTeamHead == "MY-LEADS") {
                $_SESSION["ACTIVE_DASHBOARD_VIEW"] = "MY-DASHBOARD";
            } else {
                $_SESSION["ACTIVE_DASHBOARD_VIEW"] = "TEAM-DASHBOARD";
            }
            foreach (TEAM_HEAD_LEAD_VIEW_OPTIONS as $Key => $Values) {
                $ActiveLeadsView = CheckEquality($Key, $ActiveLeadViewForTeamHead, "btn-primary"); ?>
                <a href="?LeadViewByTeamHead=<?php echo $Key; ?>&activeDashboard=<?php echo $Values; ?>" class="btn btn-md <?php echo $ActiveLeadsView; ?> btn-light"><?php echo $Key; ?></a>
            <?php } ?>
        </div>
    <?php } ?>
</div>