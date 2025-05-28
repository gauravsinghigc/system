 <div class="pagetitle animate-fade-up mb-0">
     <div class="flex-s-b">
         <div>
             <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
             <nav>
                 <ol class="breadcrumb mb-0">
                     <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                     <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                 </ol>
             </nav>
         </div>
         <div class="flex-s-b">
             <div>
                 <a class="btn btn-sm btn-danger m-1" href="<?php echo APP_URL; ?>/leads/add">
                     <i class="bi bi-plus text-success"></i> Add New Contact
                 </a>
                 <?php if (AuthAppUser("UserType") == "ADMIN") { ?>
                     <div class="pull-right m-1">
                         <button class="btn btn-sm btn-light" onclick="ControlForms('AdvanceFilters')"><i class="bi bi-filter text-success"></i> Filters</button>
                     </div>
                     <div class="pull-right m-1">
                         <button class="btn btn-sm btn-dark" onclick="showUploadModal()"><i class="bi bi-upload text-success"></i> Upload Leads</button>
                     </div>
                     <?php } else {
                        $CheckAnyUserUnderLoginPerson = CHECK("SELECT UserId FROM users where UserReportingManager='" . LOGIN_USER_ID . "'");
                        if ($CheckAnyUserUnderLoginPerson != null) { ?>
                         <div class="pull-right m-1">
                             <button class="btn btn-sm btn-light" onclick="ControlForms('AdvanceFilters')"><i class="bi bi-filter text-success"></i> Filters</button>
                         </div>
                         <div class="pull-right m-1">
                             <button class="btn btn-sm btn-dark" onclick="showUploadModal()"><i class="bi bi-upload text-success"></i> Upload Leads</button>
                         </div>
                 <?php }
                    } ?>
             </div>
         </div>
     </div>
 </div>

 <?php
    if (AuthAppUser("UserType") == "ADMIN" || AuthAppUser("UserType") == "TEAM_HEAD") { ?>
     <div class="records-selection-list" style="display:none;" id="SelectionActivityOptions">
         <div class="action-buttons">
             <div style="display:none;" id='AssignButtonOption' class="m-1">
                 <button class="btn btn-sm btn-primary" onclick="showAssignModal()"><i class="bi bi-person-check text-success"></i> Assign Leads</button>
             </div>
             <div style="display:none;" id='RemoveButtonOption' class="m-1">
                 <button class="btn btn-sm btn-danger" onclick="showRemoveModal()"><i class="bi bi-trash text-white"></i> Remove Records</button>
             </div>
         </div>
     </div>
 <?php } ?>