 <!-- Modals -->
 <div id="removeModal" class="modal">
     <div class="modal-content">
         <div class="modal-header app-heading p-2">
             <h5 class="modal-title" id="my-modal-title">Remove Leads Permanently From the Storage</h5>
         </div>
         <form class="row" method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php">
             <?php echo FormPrimaryInputs(true); ?>
             <div class="col-md-12">
                 <h5 class="app-sub-heading">Selected Leads For Remove</h5>
                 <div id="removeSelectedLeads" class="mb-3"></div>
             </div>

             <div class="col-md-12 text-right">
                 <hr>
                 <button type="submit" class="btn btn-primary btn-md" name="RemoveSelectedLeadsPermanently"><i class="bi bi-check-circle text-success"></i> Remove Selected Records</button>
                 <button type="button" class="btn btn-default btn-md ml-2" onclick="closeModal('removeModal')"><i class="bi bi-x-circle text-success"></i> Close</button>
             </div>
         </form>

     </div>
 </div>