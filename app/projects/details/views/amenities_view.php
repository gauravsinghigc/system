<div class="row">
    <div class="col-md-12 text-center mb-3">
        <h6 class="mb-0 pb-0">Adding Details For</h6>
        <h5 class="bold mt-0 pt-0"><?php echo FETCH("SELECT projects_name FROM projects where projects_id='" . $_SESSION["PROJECT_SESSION_ID"] . "'", "projects_name"); ?></h5>
    </div>
    <div class="col-md-4">
        <div class="shadow-sm p-2 br-1">
            <h5 class="app-heading"><i class="bi bi-plus"></i> Add New Amenities</h5>
            <form action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST">
                <?php echo FormPrimaryInputs(true, [
                    "projects_id" => IfSessionExists("PROJECT_SESSION_ID", $_SESSION["PROJECT_SESSION_ID"]),
                ]); ?>
                <div class="form-group">
                    <label for="project_amenities_name" class="form-label">Amenity Name</label>
                    <input type="text" class="form-control" name="project_amenities_name" required>
                </div>
                <div class="form-group">
                    <label for="project_amenities_short_desc" class="form-label">Short Description</label>
                    <textarea class="form-control" name="project_amenities_short_desc" rows="3"></textarea>
                </div>
                <div class="form-group text-right">
                    <hr>
                    <button type="submit" name="AddMenitiesInTheProjects" class="btn btn-dark btn-md"><i class="bi bi-check text-success"></i> Save Details</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="shadow-sm p-2 br-1">
            <h5 class="app-heading"><i class="bi bi-list-columns"></i> Added Amenities</h5>
            <?php
            $AllAmenities = SET_SQL("SELECT * FROM project_amenities where project_amenities_project_main_id='" . $_SESSION['PROJECT_SESSION_ID'] . "'", true);
            if ($AllAmenities != null) {
                foreach ($AllAmenities as $Amenity) { ?>
                    <div class="shadow-sm p-2 br-1 mb-1">
                        <div class="d-block w-100 flex-s-b">
                            <div class="w-pr-60" style='line-height:normal;'>
                                <h6 class="mb-0 bold pb-0"><?php echo $Amenity->project_amenities_name; ?></h6>
                                <p class="small text-muted mb-0 mt-0 pt-0"><?php echo SECURE($Amenity->project_amenities_short_desc, "d"); ?></p>
                            </div>
                            <div class="w-pr-40 text-right">
                                <button type="button" onclick="ControlForms('UpdateAmenities_<?php echo $Amenity->project_amenities_id; ?>')" class="btn btn-sm btn-primary"><i class="bi bi-pen"></i> Edit</button>
                                <?php
                                echo CONFIRM_DELETE_POPUP(
                                    "Amenities",
                                    [
                                        "RemoveAmenitiesRecords" => "true",
                                        "RecordsId" => $Amenity->project_amenities_id
                                    ],
                                    CONTROLLER . "/ModuleController/ProjectsController.php",
                                    "<i class='fa fa-trash'></i>",
                                    "btn btn-sm btn-outline-danger"
                                ); ?>
                            </div>
                        </div>
                        <div class="w-100 shadow-md br-1 mt-2 p-2" style='display:none;' id="UpdateAmenities_<?php echo $Amenity->project_amenities_id; ?>">
                            <form action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST">
                                <?php echo FormPrimaryInputs(true, [
                                    "project_amenities_id" => $Amenity->project_amenities_id,
                                ]); ?>
                                <div class="form-group">
                                    <label for="project_amenities_name" class="form-label">Amenity Name</label>
                                    <input type="text" class="form-control" name="project_amenities_name" value="<?php echo $Amenity->project_amenities_name; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="project_amenities_short_desc" class="form-label">Short Description</label>
                                    <textarea class="form-control" name="project_amenities_short_desc" rows="3"><?php echo SECURE($Amenity->project_amenities_short_desc, "d"); ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <hr>
                                    <button type="submit" name="UpdateAmenitiesRecords" class="btn btn-dark btn-md"><i class="bi bi-check text-success"></i> Update Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php }
            } else {
                echo '<div class="alert alert-warning" role="alert">No Amenities added yet.</div>';
            } ?>
        </div>
    </div>
    <div class="col-md-12 text-right">
        <hr>
        <a href="?project_entry_step=media" class="btn btn-md btn-default"><i class="fa fa-angle-left text-success"></i> Back to Upload Media Options </a>
        <a href="../?reset_previous_project_record=true" class="btn btn-dark btn-md">Go to All Projects <i class="bi bi-check text-success"></i></a>
    </div>
</div>