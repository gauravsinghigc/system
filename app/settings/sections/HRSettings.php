 <div class="tab-pane fade pt-2" id="hr-settings">
     <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/ConfigController.php" method="POST">
         <?php echo FormPrimaryInputs(true); ?>
         <div class="col-md-12">
             <h5 class="app-sub-heading"><i class="fa fa-clock text-primary"></i> HR Settings</h5>
         </div>
         <div class="form-group col-md-4 mb-3">
             <label>Office Start Time</label>
             <input type="time" name="OFFICE_START_TIME" class="form-control" value="<?php echo OFFICE_START_TIME; ?>">
         </div>
         <div class="form-group col-md-4 mb-3">
             <label>Office Closing Time</label>
             <input type="time" name="OFFICE_END_TIME" class="form-control" value="<?php echo OFFICE_END_TIME; ?>">
         </div>
         <div class="form-group col-md-4 mb-3">
             <label>Lunch Start Time</label>
             <input type="time" name="OFFICE_LUNCH_TIME" class="form-control" value="<?php echo OFFICE_LUNCH_TIME; ?>">
         </div>
         <div class="form-group col-md-4 mb-3">
             <label>Lunch End Time</label>
             <input type="time" name="OFFICE_LUNCH_END_TIME" class="form-control" value="<?php echo OFFICE_LUNCH_END_TIME; ?>">
         </div>
         <div class="form-group col-md-4 mb-3">
             <label>Weekly Off (Every)</label>
             <select name="WEEKLY_OFF_DAY" class="form-control">
                 <?php echo InputOptionsWithKey([
                        "Sunday" => "Sunday",
                        "Monday" => "Monday",
                        "Tuesday" => "Tuesday",
                        "Wednesday" => "Wednesday",
                        "Thursday" => "Thursday",
                        "Friday" => "Friday",
                        "Saturday" => "Saturday",
                        "" => "Open All Days"
                    ], WEEKLY_OFF_DAY); ?>
             </select>
         </div>
         <div class="col-md-12 text-center mt-3">
             <button name="UpdateHRSettings" class="btn btn-md btn-dark"><i class="fa fa-check text-success"></i> Update Details</button>
         </div>
     </form>
 </div>