 <?php
    $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users where UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserId DESC", true);
    if ($AllUsersSQL != null) {
        foreach ($AllUsersSQL as $Users) {
            if ($Users->UserProfileImage == null || $Users->UserProfileImage == "" || $Users->UserProfileImage == " ") {
                $UserProfileImage = APP_LOGO;
            } else {
                $UserProfileImage = STORAGE_URL . "/users/" . $Users->UserId . "/img/" . $Users->UserProfileImage;
            }
            $UserId = $Users->UserId;
            $ActivitySQL = "SELECT leads_acitivity_id FROM leads_activities where leads_activity_added_by='$UserId'"; ?>
         <li class='SearchRecords'>
             <a class='text-secondary bg-light' href="reports.php?SelectedUserId=<?php echo SECURE($Users->UserId, "e"); ?>">
                 <div class="user_lists">
                     <div class="user-img text-center w-pr-15">
                         <img src="<?php echo $UserProfileImage; ?>" alt="<?php echo $Users->UserFullName; ?>" class="img-fluid rounded-circle" style="width:14vw !important;height:14vw !important;">
                     </div>
                     <div class="user-details">
                         <span style="position:absolute;right:2rem;"><?php echo StatusViewWithText($Users->UserStatus); ?></span>
                         <h5 class="app-fs-3">
                             <?php echo $Users->UserSalutation; ?>
                             <?php echo $Users->UserFullName; ?>
                         </h5>
                         <h6 class="app-fs-2"><?php echo $Users->UserDesignation; ?></h6>
                         <p>
                             <span><i class="bi bi-phone-fill text-primary"></i> <?php echo $Users->UserPhoneNumber; ?></span>
                             <span><i class="bi bi-envelope text-warning"></i> <?php echo $Users->UserEmailId; ?></span>
                         </p>
                     </div>
                 </div>
                 <div class="w-100 p-1">
                     <hr class="">
                     <div class="row">
                         <div class="col-md-4 col-4 col-xs-4 col-sm-4 mb-2">
                             <div class="app-widget-counter p-1 rounded-3">
                                 <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                                     <h5 class="text-primary bold mb-0 pb-0 mt-0"><i class="bi bi-telephone-outbound-fill app-fs-2 text-primary"></i> <?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) = CURDATE()"); ?></h5>
                                     <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.575rem !important;">Today Calls</p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4 col-4 col-xs-4 col-sm-4 mb-2">
                             <div class="app-widget-counter p-1 rounded-3">
                                 <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                                     <h5 class="text-primary bold mb-0 pb-0 mt-0"><i class="bi bi-telephone-outbound-fill app-fs-2 text-info"></i> <?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) = CURDATE() - INTERVAL 1 DAY"); ?></h5>
                                     <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.575rem !important;"> Yesterday</p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4 col-4 col-xs-4 col-sm-4 mb-2">
                             <div class="app-widget-counter p-1 rounded-3">
                                 <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                                     <h5 class="text-primary bold mb-0 pb-0 mt-0"><i class="bi bi-telephone-outbound-fill app-fs-2 text-secondary"></i> <?php echo TOTAL($ActivitySQL . " and DATE(leads_activity_date_time) >= CURDATE() - INTERVAL 7 DAY"); ?></h5>
                                     <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.575rem !important;"> Weekly Calls</p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4 col-4 col-xs-4 col-sm-4 mb-2">
                             <div class="app-widget-counter p-1 rounded-3">
                                 <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                                     <h5 class="text-primary bold mb-0 pb-0 mt-0"><i class="bi bi-telephone-outbound-fill app-fs-2 text-success"></i> <?php echo TOTAL($ActivitySQL . " and YEAR(leads_activity_date_time) = YEAR(CURDATE()) AND MONTH(leads_activity_date_time) = MONTH(CURDATE())"); ?></h5>
                                     <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.575rem !important;"> Current Month</p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4 col-4 col-xs-4 col-sm-4 mb-2">
                             <div class="app-widget-counter p-1 rounded-3">
                                 <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                                     <h5 class="text-primary bold mb-0 pb-0 mt-0"><i class="bi bi-telephone-outbound-fill app-fs-2 text-warning"></i> <?php echo TOTAL($ActivitySQL . " and YEAR(leads_activity_date_time) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(leads_activity_date_time) = MONTH(CURDATE() - INTERVAL 1 MONTH)"); ?></h5>
                                     <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.575rem !important;"> Last Month</p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4 col-4 col-xs-4 col-sm-4 mb-2">
                             <div class="app-widget-counter p-1 rounded-3">
                                 <div class="bg-white d-block rounded-2 p-2 pt-1 pb-1">
                                     <h5 class="text-primary bold mb-0 pb-0 mt-0"><i class="bi bi-telephone-outbound-fill app-fs-2 text-black"></i> <?php echo TOTAL($ActivitySQL); ?></h5>
                                     <p class="text-secondary mt-0 pt-1 mb-0" style="font-size:0.575rem !important;"> Overall Calls</p>
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