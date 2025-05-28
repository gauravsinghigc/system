 <div class="pagetitle animate-fade-up">
     <div class="flex-s-b">
         <div>
             <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                     <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                 </ol>
             </nav>
         </div>
     </div>
 </div>

 <?php
    if (AuthAppUser("UserType") == "ADMIN" || AuthAppUser("UserType") == "COORDINATOR") { ?>
     <div class="records-selection-list" style="display:none;" id="SelectionActivityOptions">
         <div class="action-buttons">
             <div style="display:none;" id='AssignButtonOption' class="m-1">
                 <button class="btn btn-sm btn-primary" onclick="showAssignModal()"><i class="bi bi-person-check text-success"></i> Re-Assign/Re-Active Leads</button>
             </div>
             <div style="display:none;" id='RemoveButtonOption' class="m-1">
                 <button class="btn btn-sm btn-danger" onclick="showRemoveModal()"><i class="bi bi-trash text-white"></i> Remove Permanently All Leads</button>
             </div>
         </div>
     </div>
 <?php } ?>