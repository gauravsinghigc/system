<?php
if (AuthAppUser("UserType") == "ADMIN") {
     $AllFacebookAds = SET_SQL("SELECT config_facebook_accounts_id, config_facebook_accounts_name, config_facebook_accounts_last_fetched_at, config_facebook_accounts_vendor_name FROM config_facebook_accounts WHERE config_facebook_accounts__status='1' ORDER BY config_facebook_accounts_last_fetched_at DESC", true);
     if ($AllFacebookAds != null) { ?>
          <div class="row mb-3">
               <div class="col-md-12">
                    <div class="flex-start">
                         <div class="shadow-sm p-3 rounded-2">
                              <h6 class="mb-0 bold">
                                   <i class="bi bi-facebook text-primary"></i> Facebook Leads |
                                   <span class="text-primary counter-btn mr-1">
                                        <small>Overall Total </small> :
                                        <b><?php echo TOTAL("SELECT leads_id FROM leads WHERE leads_other_sources_name='FB_ADS_API'"); ?></b>
                                   </span> |
                                   <span class="text-info counter-btn mr-1">
                                        <small>Yesterday</small> :
                                        <b><?php echo TOTAL("SELECT leads_id FROM leads WHERE leads_other_sources_name='FB_ADS_API' and DATE(leads_created_at)='" . DATE('Y-m-d', strtotime("-1 days")) . "'"); ?></b>
                                   </span> |
                                   <span class="text-success counter-btn mr-1">
                                        <small>Today</small> :
                                        <b><?php echo TOTAL("SELECT leads_id FROM leads WHERE leads_other_sources_name='FB_ADS_API' and DATE(leads_created_at)='" . DATE('Y-m-d') . "'"); ?></b>
                                   </span>
                              </h6>
                         </div>
                    </div>
               </div>
          </div>
<?php }
} ?>