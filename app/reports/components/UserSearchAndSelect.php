 <?php
    $SelectedUserId = SECURE(ReturnSessionalValues("SelectedUserId", "SELECTED_USER_ID", IfRequested("GET", "SelectedUserId", null, null), "GET"), "d");
    if ($SelectedUserId != null) {
        $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users WHERE UserId='$SelectedUserId'", true);
        if ($AllUsersSQL != null) {
            foreach ($AllUsersSQL as $Users) {
                if ($Users->UserProfileImage == null || $Users->UserProfileImage == "" || $Users->UserProfileImage == " ") {
                    $UserProfileImage = APP_LOGO;
                } else {
                    $UserProfileImage = STORAGE_URL . "/users/" . $Users->UserId . "/img/" . $Users->UserProfileImage;
                } ?>
             <li class='SearchRecords'>
                 <a class='text-secondary active' href="?SelectedUserId=<?php echo SECURE($Users->UserId, "e"); ?>">
                     <img src="<?php echo STORAGE_URL_D; ?>/tool-img/right-side-icon.png" class="active-user-icon">
                     <div class="user_lists">
                         <div class="user-img">
                             <img src="<?php echo $UserProfileImage; ?>" alt="<?php echo $Users->UserFullName; ?>" class="img-fluid rounded-circle">
                         </div>
                         <div class="user-details">
                             <span class='pull-right small mr-2 small'><?php echo StatusViewWithText($Users->UserStatus); ?></span>
                             <h5>
                                 <?php echo $Users->UserSalutation; ?>
                                 <?php echo $Users->UserFullName; ?>
                             </h5>
                             <h6><?php echo $Users->UserDesignation; ?></h6>
                             <p>
                                 <span><i class="bi bi-phone-fill text-primary"></i> <?php echo $Users->UserPhoneNumber; ?></span>
                                 <span><i class="bi bi-envelope text-warning"></i> <?php echo $Users->UserEmailId; ?></span>
                             </p>
                         </div>
                     </div>
                 </a>
             </li>
         <?php
            }
        }
    }

    if (AuthAppUser("UserType") == "ADMIN") {
        $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users where UserId!='$SelectedUserId' ORDER BY UserId DESC", true);
    } else {
        $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users where UserReportingManager='" . LOGIN_USER_ID . "' and UserId!='$SelectedUserId' ORDER BY UserId DESC", true);
    }
    if ($AllUsersSQL != null) {
        foreach ($AllUsersSQL as $Users) {
            if ($Users->UserProfileImage == null || $Users->UserProfileImage == "" || $Users->UserProfileImage == " ") {
                $UserProfileImage = APP_LOGO;
            } else {
                $UserProfileImage = STORAGE_URL . "/users/" . $Users->UserId . "/img/" . $Users->UserProfileImage;
            } ?>
         <li class='SearchRecords'>
             <a class='text-secondary' href="?SelectedUserId=<?php echo SECURE($Users->UserId, "e"); ?>">
                 <div class="user_lists">
                     <div class="user-img">
                         <img src="<?php echo $UserProfileImage; ?>" alt="<?php echo $Users->UserFullName; ?>" class="img-fluid rounded-circle">
                     </div>
                     <div class="user-details">
                         <span class='pull-right small mr-2 small'><?php echo StatusViewWithText($Users->UserStatus); ?></span>

                         <h5>
                             <?php echo $Users->UserSalutation; ?>
                             <?php echo $Users->UserFullName; ?>
                         </h5>
                         <h6><?php echo $Users->UserDesignation; ?></h6>
                         <p>
                             <span><i class="bi bi-phone-fill text-primary"></i> <?php echo $Users->UserPhoneNumber; ?></span>
                             <span><i class="bi bi-envelope text-warning"></i> <?php echo $Users->UserEmailId; ?></span>
                         </p>
                     </div>
                 </div>
             </a>
         </li>
 <?php
        }
    } else {
        echo "<li class='text-danger p-2 shadow-sm br-1 mt-3'>No Team Member Found</li>";
    } ?>