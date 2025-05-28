 <!-- Modals -->
 <div id="assignModal" class="modal">
     <div class="modal-content">
         <div class="modal-header app-heading">
             <h5 class="modal-title" id="my-modal-title">Re-Assign Leads to Users</h5>
         </div>
         <form class="row" id="AssignFormForLeads" method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php">
             <?php echo FormPrimaryInputs(true); ?>
             <div class="col-md-7">
                 <h5 class="app-sub-heading">Selected Leads For Assign/Re-Assign</h5>
                 <div id="assignSelectedLeads" class="mb-3"></div>
             </div>
             <div class="col-md-5">
                 <div class="form-group">
                     <label>Assign To</label>
                     <select class="form-control" name="leads_managed_by" id="assignUser" required>
                         <option value="">Select User</option>
                         <?php
                            $users = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users WHERE UserStatus='1' ORDER BY UserFullName", true);
                            foreach ($users as $user) {
                                echo "<option value='{$user->UserId}'>(UID{$user->UserId}) -{$user->UserFullName} - {$user->UserPhoneNumber}</option>";
                            }
                            ?>
                     </select>
                 </div>
                 <div class="form-group">
                     <label>Stage</label>
                     <select class="form-control" name="leads_stages" id="assignStage" required>
                         <option value="">Select Stage</option>
                         <?php
                            $AllLeadsStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages ORDER BY config_leads_stage_name", true);
                            foreach ($AllLeadsStages as $stage) {
                                echo "<option value='{$stage->config_leads_stages_id}'>{$stage->config_leads_stage_name}</option>";
                            }
                            ?>
                     </select>
                 </div>
                 <div class="col-md-12 mb-3">
                     <label>Change Record Type</label>
                     <select name="leads_type" class="form-control" required>
                         <?php echo InputOptionsWithKey([
                                "" => "Update Record Type",
                                "LEAD" => "LEAD",
                                "DATA" => "DATA"
                            ], $Records->leads_type) ?>
                     </select>
                 </div>
             </div>

             <div class="col-md-12 text-right">
                 <hr>
                 <button class="btn btn-primary btn-md" name="ReAssignSelectedLeads" onclick="submitAssign()"><i class="bi bi-check-circle text-success"></i> Assign</button>
                 <button class="btn btn-default btn-md ml-2" onclick="closeModal('assignModal')"><i class="bi bi-x-circle text-success"></i> Close</button>
             </div>
         </form>

     </div>
 </div>