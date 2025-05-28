 <?php if (DEVICE_TYPE == "MOBILE") {
      $CheckActiveLinksALways = ReturnSessionalValues("app_view", "ACTIVE_MOBILE_NAV_LINKS", "app_dashboard");
   ?>
    <style>
       html {
          zoom: 0.85 !important;
       }

       .text-primary-2 {
          color: rgb(3, 112, 215) !important;
       }

       .bg-primary-2 {
          background-color: rgb(3, 112, 215) !important;
       }

       .main {
          margin-top: 4.25rem !important;
       }

       .site-visit-container .data-container {
          max-width: 100% !important;
          min-width: 100% !important;
       }

       .notification-box {
          width: 98% !important;
          margin: 1vw auto !important;
          max-width: 98% !important;
          box-shadow: 0px 0px 1px white !important;
       }

       .notification-box p {
          font-size: 3vw !important;
       }
    </style>
    <header id="header" class="header fixed-top d-flex align-items-center" style="height: 4.75rem !important;">
       <div class="d-flex align-items-center justify-content-between">
          <a href="<?php echo DOMAIN; ?>" class="logo d-flex align-items-center text-primary bold">
             <span class="app-fs-5 ml-3 bold">
                <i class="<?php echo APP_BOTTOM_NAVBAR[$CheckActiveLinksALways]['icon']; ?> text-primary-2 app-fs-4"></i>
                <b class="app-fs-5"><?php echo APP_BOTTOM_NAVBAR[$CheckActiveLinksALways]['name']; ?></b>
             </span>
          </a>
       </div><!-- End Logo -->

       <nav class="header-nav ms-auto mt-2">
          <ul class="d-flex align-items-center">
             <li class="nav-item">
                <a href="<?php echo DOMAIN; ?>/mobile/leads/add" class="nav-link nav-icon bold app-fs-5"><i class="bi bi-plus-circle"></i></a>
             </li>
             <li class="nav-item">
                <a class="nav-link nav-icon bold app-fs-5" href="#">
                   <i class="bi bi-bell"></i>
                   <!--<span class="badge bg-primary badge-number">0</span> -->
                </a><!-- End Notification Icon -->
             </li>
             <li class="nav-item dropdown pe-3">
                <a class="nav-link d-flex align-items-center" href="<?php echo APP_URL; ?>/profile?menu=profile">
                   <img src="<?php echo AuthAppUser("UserProfileImage"); ?>" alt="<?php echo AuthAppUser("UserFullName"); ?>" style="width:2.75rem !important; height:2.75rem !important;margin-top:-0.5rem !important;" title="<?php echo AuthAppUser("UserFullName"); ?>" class="rounded-circle">
                </a><!-- End Profile Iamge Icon -->
             </li>
          </ul>
       </nav><!-- End Icons Navigation -->
    </header>

    <section class="bottom-nav-bar">
       <ul>
          <?php
            foreach (APP_BOTTOM_NAVBAR as $NavKeys => $NavData) {
               $CompareStatus = CheckEquality($CheckActiveLinksALways, $NavKeys, 'active'); ?>
             <li>
                <a style="line-height: 3.25vw !important;" href="<?php echo $NavData['dir']; ?>" class="<?php echo $CompareStatus; ?>">
                   <i style="font-size: 4vw !important;" class="<?php echo $NavData['icon']; ?>"></i>
                   <span style="font-size: 1.75vw !important;"><?php echo $NavData['name']; ?></span>
                </a>
             </li>
          <?php } ?>
       </ul>
    </section>
 <?php } else { ?>
    <header id="header" class="header fixed-top d-flex align-items-center">

       <div class="d-flex align-items-center justify-content-between">
          <a href="<?php echo DOMAIN; ?>" class="logo d-flex align-items-center">
             <img src="<?php echo APP_LOGO; ?>" alt="<?php echo APP_NAME; ?>" title="<?php echo APP_NAME; ?>">
             <span class="d-none d-lg-block"><?php echo LimitText(APP_NAME, 0, 7, ""); ?></span>
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
       </div><!-- End Logo -->

       <div class="d-flex ml-1 mt-1 app-timer">
          <h5 class="mt-1 ml-1 font-weight-bold bold text-primary">
             <i class="bi bi-clock text-danger bold"></i>
             <span id="liveTime"><?php echo CURRENT_TIME; ?></span>
          </h5>
       </div>
       <div class="search-bar">
          <form class="search-form d-flex align-items-center" method="GET" action="<?php echo APP_URL; ?>/search">
             <input type="text" name="s" onchange="form.submit()" placeholder="Search leads, users, projects..." title="Enter search keyword">
             <button type="submit" title="Search"><i class="bi bi-search"></i></button>
          </form>
       </div>

       <?php
         $AllFacebookAds = SET_SQL("SELECT config_facebook_accounts_id, config_facebook_accounts_name, config_facebook_accounts_last_fetched_at, config_facebook_accounts_vendor_name FROM config_facebook_accounts WHERE config_facebook_accounts__status='1' ORDER BY config_facebook_accounts_last_fetched_at DESC", true);
         if ($AllFacebookAds != null) {
            if (AuthAppUser("UserType") == "ADMIN") { ?>
             <div class="fb-leads-refresh">
                <form class="flex-s-b" method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/FacebookLeadsController.php">
                   <?php echo FormPrimaryInputs(true); ?>
                   <span><i class="fa fa-facebook text-primary"></i> Ads</span>
                   <select name="AdsId" class="form-control form-control-sm">
                      <?php
                        // Set timezone to India
                        date_default_timezone_set('Asia/Kolkata');

                        $LastFetchTime = date('Y-m-d H:i'); // Default current time
                        $CanSubmit = false; // Flag to check if submission is allowed

                        if ($AllFacebookAds != null) { ?>
                         <option value="ALL">Refresh All Ads</option>
                         <?php
                           foreach ($AllFacebookAds as $FbAds) {
                              $VendorName = FETCH("SELECT config_leads_resources_name FROM config_leads_resources where config_leads_resources_id='" . $FbAds->config_facebook_accounts_vendor_name . "'", "config_leads_resources_name");
                           ?>
                            <option value="<?php echo $FbAds->config_facebook_accounts_id; ?>">
                               (<?php echo $VendorName; ?>) - <?php echo $FbAds->config_facebook_accounts_name; ?>
                            </option>
                      <?php
                              $LastFetchTime = $FbAds->config_facebook_accounts_last_fetched_at; // Update with latest fetch time
                           }

                           // Compare current time with last fetch time
                           $CurrentDateTime = date('Y-m-d H:i');
                           $currentTimestamp = strtotime($CurrentDateTime);
                           $lastFetchTimestamp = strtotime($LastFetchTime);

                           // If current time is greater than last fetch time + 40 minutes (1800 seconds)
                           if ($currentTimestamp >= ($lastFetchTimestamp)) {
                              $CanSubmit = true; // Allow submission
                           } else {
                              $remainingSeconds = ($lastFetchTimestamp) - $currentTimestamp; // Time left in seconds
                           }
                        }
                        ?>
                   </select>
                   <button name="RefreshLeads" class="btn btn-sm small <?php echo $CanSubmit ? 'btn-success text-white' : 'btn-secondary'; ?>" <?php echo !$CanSubmit ? 'disabled' : ''; ?> id="refreshButton">
                      <?php if ($CanSubmit) { ?>
                         <strong>
                            <i class="fa fa-refresh"></i> Refresh Leads
                         </strong>
                      <?php } else { ?>
                         <strong>
                            <i class="fa fa-history"></i>
                            <b id="timeLeft"><?php echo floor($remainingSeconds / 60) . ' Min'; ?></b>
                         </strong>
                      <?php } ?>
                   </button>
                </form>
             </div>

             <script>
                <?php if (!$CanSubmit) { ?>
                   // JavaScript countdown timer
                   let remainingSeconds = <?php echo $remainingSeconds; ?>;
                   const timeLeftElement = document.getElementById('timeLeft');
                   const refreshButton = document.getElementById('refreshButton');

                   function updateTimer() {
                      if (remainingSeconds > 0) {
                         let minutes = Math.floor(remainingSeconds / 60);
                         let seconds = remainingSeconds % 60;
                         timeLeftElement.textContent = `${minutes} Min ${seconds} Sec`;
                         remainingSeconds--;
                      } else {
                         // When time is up, enable the button and update style
                         refreshButton.removeAttribute('disabled');
                         refreshButton.classList.remove('btn-secondary');
                         refreshButton.classList.add('btn-success', 'text-white');
                         refreshButton.innerHTML = '<strong><i class="fa fa-refresh"></i> Refresh Leads</strong>';
                         clearInterval(timerInterval);
                      }
                   }

                   // Update timer every second
                   updateTimer(); // Initial call
                   const timerInterval = setInterval(updateTimer, 1000);
                <?php } ?>
             </script>
       <?php }
         } ?>
       <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">

             <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#">
                   <i class="bi bi-search"></i>
                </a>
             </li>

             <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                   <i class="bi bi-bell"></i>
                   <span class="badge bg-primary badge-number">4</span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                   <li class="dropdown-header">
                      You have 4 new notifications
                      <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                   </li>
                   <li>
                      <hr class="dropdown-divider">
                   </li>

                   <li class="notification-item">
                      <i class="bi bi-exclamation-circle text-warning"></i>
                      <div>
                         <h4>Lorem Ipsum</h4>
                         <p>Quae dolorem earum veritatis oditseno</p>
                         <p>30 min. ago</p>
                      </div>
                   </li>

                   <li>
                      <hr class="dropdown-divider">
                   </li>

                   <li class="notification-item">
                      <i class="bi bi-x-circle text-danger"></i>
                      <div>
                         <h4>Atque rerum nesciunt</h4>
                         <p>Quae dolorem earum veritatis oditseno</p>
                         <p>1 hr. ago</p>
                      </div>
                   </li>

                   <li>
                      <hr class="dropdown-divider">
                   </li>

                   <li class="notification-item">
                      <i class="bi bi-check-circle text-success"></i>
                      <div>
                         <h4>Sit rerum fuga</h4>
                         <p>Quae dolorem earum veritatis oditseno</p>
                         <p>2 hrs. ago</p>
                      </div>
                   </li>

                   <li>
                      <hr class="dropdown-divider">
                   </li>

                   <li class="notification-item">
                      <i class="bi bi-info-circle text-primary"></i>
                      <div>
                         <h4>Dicta reprehenderit</h4>
                         <p>Quae dolorem earum veritatis oditseno</p>
                         <p>4 hrs. ago</p>
                      </div>
                   </li>

                   <li>
                      <hr class="dropdown-divider">
                   </li>
                   <li class="dropdown-footer">
                      <a href="#">Show all notifications</a>
                   </li>

                </ul><!-- End Notification Dropdown Items -->

             </li>

             <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="<?php echo APP_URL; ?>/profile?menu=profile">
                   <img src="<?php echo AuthAppUser("UserProfileImage"); ?>" alt="<?php echo AuthAppUser("UserFullName"); ?>" title="<?php echo AuthAppUser("UserFullName"); ?>" class="rounded-circle">
                   <span class="d-none d-md-block fs-6 bold ps-2"><?php echo AuthAppUser("UserFullName"); ?></span>
                </a><!-- End Profile Iamge Icon -->
             </li>

          </ul>
       </nav><!-- End Icons Navigation -->

    </header>
 <?php } ?>