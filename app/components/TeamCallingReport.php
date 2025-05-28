<div class="card-body">
  <h4 class="app-heading"><i class="fa fa-users text-warning"></i> Team Member Wise Calling Reports</h4>
  <ul class="team-reports-user-lists mt-0 mb-2 w-100 pb-0" style="margin-top: 0px !important;">
    <?php
    if (AuthAppUser("UserType") == "ADMIN") {
      $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users ORDER BY UserId DESC", true);
    } else {
      $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users where UserReportingManager='" . LOGIN_USER_ID . "' and UserId!='$SelectedUserId' ORDER BY UserId DESC", true);
    }
    if ($AllUsersSQL != null) {
      foreach ($AllUsersSQL as $Users) {
        if ($Users->UserProfileImage == null || $Users->UserProfileImage == "" || $Users->UserProfileImage == " ") {
          $UserProfileImage = APP_LOGO;
        } else {
          $UserProfileImage = STORAGE_URL . "/users/" . $Users->UserId . "/img/" . $Users->UserProfileImage;
        }
        $UserId = $Users->UserId;
        $ActivitySQL = "SELECT leads_acitivity_id FROM leads_activities where leads_activity_added_by='$UserId'"; ?>
        <li class='SearchRecords mb-2'>
          <a class='text-secondary mb-0'>
            <div class="user_lists">
              <div class="user-img" style="width:7% !important;">
                <span class="pull-left position-absolute"><?php echo StatusView($Users->UserStatus); ?></span>
                <img src="<?php echo $UserProfileImage; ?>" alt="<?php echo $Users->UserFullName; ?>" class="img-fluid rounded-circle shadow-md" style="width:3.5rem !important;height:3.5rem !important;">
              </div>
              <div class="user-details" style="width:25% !important;">
                <h5>
                  <?php echo $Users->UserSalutation; ?>
                  <?php echo $Users->UserFullName; ?>
                </h5>
                <h6><?php echo $Users->UserDesignation; ?></h6>
                <p>
                  <span><i class="bi bi-phone-fill text-success"></i> <?php echo $Users->UserPhoneNumber; ?></span>
                  <span><i class="bi bi-envelope text-danger"></i> <?php echo $Users->UserEmailId; ?></span>
                </p>
              </div>
              <div class="w-100">
                <div class="row">
                  <div class="col">
                    <div class="app-widget-counter p-1 rounded-3">
                      <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                        <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) = CURDATE()"); ?></h5>
                        <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-primary"></i> Today Calls</p>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="app-widget-counter p-1 rounded-3">
                      <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                        <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) = CURDATE() - INTERVAL 1 DAY"); ?></h5>
                        <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-info"></i> Yesterday</p>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="app-widget-counter p-1 rounded-3">
                      <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                        <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) >= CURDATE() - INTERVAL 7 DAY"); ?></h5>
                        <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-secondary"></i> Weekly Calls</p>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="app-widget-counter p-1 rounded-3">
                      <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                        <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and YEAR(leads_activity_date_time) = YEAR(CURDATE()) AND MONTH(leads_activity_date_time) = MONTH(CURDATE())"); ?></h5>
                        <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-success"></i> Current Month</p>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="app-widget-counter p-1 rounded-3">
                      <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                        <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL . " and YEAR(leads_activity_date_time) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(leads_activity_date_time) = MONTH(CURDATE() - INTERVAL 1 MONTH)"); ?></h5>
                        <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-warning"></i> Last Month</p>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="app-widget-counter p-1 rounded-3">
                      <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                        <h5 class="text-primary bold mb-0 pb-0 mt-0"><?php echo TOTAL($ActivitySQL); ?></h5>
                        <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.75rem !important;"><i class="bi bi-telephone-outbound-fill text-black"></i> Overall Calls</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </li>

    <?php
      }
    } else {
      echo "<li class='text-danger p-2 shadow-sm br-1 mt-3'>No Team Member Found</li>";
    } ?>
  </ul>
</div>