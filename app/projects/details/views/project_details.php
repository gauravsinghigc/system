<form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST">
    <?php echo FormPrimaryInputs(true, [
        "projects_id" => $ProjectsId,
    ]); ?>
    <div class="col-md-4 form-group">
        <label>Project name</label>
        <input type="text" class="form-control" name="projects_name" value='<?php echo FETCH($ProjectSQL, "projects_name"); ?>' required>
    </div>
    <div class="col-md-4 form-group">
        <label>Project Area</label>
        <input type="text" class="form-control" name="projects_area" value="<?php echo FETCH($ProjectSQL, "projects_area"); ?>" required>
    </div>
    <div class="col-md-4 form-group">
        <label>Area In </label>
        <select class="form-control" name="projects_area_measurement_unit" required>
            <?php echo InputOptions(MEASUREMENT_UNITS, FETCH($ProjectSQL, "projects_area_measurement_unit")); ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Project Locations</label>
        <select class="form-control" onchange="LocationOptions()" id='AvalableLocations' name="projects_locations_id" required>
            <option value="">Select Location</option>
            <option value="NEW">Add New Location</option>
            <?php
            $GetLocations = SET_SQL("SELECT config_projects_locations_name, config_projects_locations_id FROM config_projects_locations where config_projects_locations_status='1' ORDER BY config_projects_locations_name ASC", true);
            if ($GetLocations != null) {
                foreach ($GetLocations as $Projects) {
                    $Selected = CheckEquality($Projects->config_projects_locations_id, FETCH($ProjectSQL, "projects_locations_id"), "selected");
                    echo '<option value="' . $Projects->config_projects_locations_id . '" ' . $Selected . '>' . $Projects->config_projects_locations_name . '</option>';
                }
            } ?>
        </select>
    </div>
    <div class="col-md-4 form-group" id="NewLocation" style="display: none;">
        <label>New Project Location</label>
        <input type="text" class="form-control" id='NewLocationInput' name="new_project_location">
    </div>

    <div class="col-md-4 form-group">
        <label>Project Stages</label>
        <select class="form-control" onchange="StagesOptions()" id='AvailableStages' name="projects_stages_id" required>
            <option value="">Select Project Stage</option>
            <option value="NEW">Add New Stage</option>
            <?php
            $GetProjectStages = SET_SQL("SELECT config_projects_stages_name, config_projects_stages_id FROM config_projects_stages where config_projects_stages_status='1' ORDER BY config_projects_stages_name ASC", true);
            if ($GetProjectStages != null) {
                foreach ($GetProjectStages as $Stages) {
                    $Selected = CheckEquality($Stages->config_projects_stages_id, FETCH($ProjectSQL, "projects_stages_id"), "selected");
                    echo '<option value="' . $Stages->config_projects_stages_id . '"' . $Selected . '>' . $Stages->config_projects_stages_name . '</option>';
                }
            } ?>
        </select>
    </div>
    <div class="col-md-4 form-group" id="NewStage" style="display: none;">
        <label>New Project Stage</label>
        <input type="text" class="form-control" id='NewStageInput' name="new_project_stage">
    </div>

    <div class="col-md-4 form-group">
        <label>Project Status</label>
        <select class="form-control" onchange="StatusOptions()" id='AvailableStatus' name="projects_status_id" required>
            <option value="">Select Project Status</option>
            <option value="NEW">Add New Status</option>
            <?php
            $GetProjectStatus = SET_SQL("SELECT config_projects_status_name, config_projects_status_id FROM config_projects_status where config_projects_status_status='1' ORDER BY config_projects_status_name ASC", true);
            if ($GetProjectStatus != null) {
                foreach ($GetProjectStatus as $Status) {
                    $Selected = CheckEquality($Status->config_projects_status_id, FETCH($ProjectSQL, "projects_status_id"), "selected");
                    echo '<option value="' . $Status->config_projects_status_id . '"' . $Selected . '>' . $Status->config_projects_status_name . '</option>';
                }
            } ?>
        </select>
    </div>
    <div class="col-md-4 form-group" id="NewStatus" style="display: none;">
        <label>New Project Status</label>
        <input type="text" class="form-control" id='NewStatusInput' name="new_project_status">
    </div>

    <div class="col-md-4 form-group">
        <label>Project Types</label>
        <select class="form-control" onchange="ProjectTypeOptions()" id='AvailableProjecTypes' name="projects_type_id" required>
            <option value="">Select Project Type</option>
            <option value="NEW">Add New Project Type</option>
            <?php
            $GetProjectTypes = SET_SQL("SELECT config_project_types_name, config_project_types_id FROM config_project_types where config_project_types_status='1' ORDER BY config_project_types_name ASC", true);
            if ($GetProjectTypes != null) {
                foreach ($GetProjectTypes as $Types) {
                    $Selected = CheckEquality($Types->config_project_types_id, FETCH($ProjectSQL, "projects_type_id"), "selected");
                    echo '<option value="' . $Types->config_project_types_id . '"' . $Selected . '>' . $Types->config_project_types_name . '</option>';
                }
            } ?>
        </select>
    </div>
    <div class="col-md-4 form-group" id="NewProjectTypes" style="display: none;">
        <label>New Project Type</label>
        <input type="text" class="form-control" id='NewProjectTypesInput' name="new_project_types">
    </div>

    <div class="form-group col-md-4">
        <label>Project Status</label>
        <select class="form-control" name="projects_listing_status" required>
            <?php echo InputOptionsWithKey([
                "" => "Select Status",
                "1" => "Active",
                "2" => "Inactive",
                "3" => "Hold",
                "4" => "Paused",
                "6" => "Terminated",
                "7" => "Sold",
            ], FETCH($ProjectSQL, "projects_listing_status")); ?>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Project Launh Date/Possession Date</label>
        <input type="date" class="form-control" placeholder="" name="projects_age" value="<?php echo FETCH($ProjectSQL, "projects_age"); ?>" required>
    </div>
    <div class="col-md-12 form-group mb-5">
        <label>Project Introduction </label>
        <textarea class="form-control" name="projects_introductions" rows="3"><?php echo SECURE(FETCH($ProjectSQL, "projects_introductions"), "d"); ?></textarea>
    </div>

    <div class="col-md-12 form-group text-right mt-5 pt-4">
        <hr>
        <button type="submit" name="UpdatePrimaryProjectDetails" class="btn btn-dark btn-md">Update Details <i class="bi bi-check-circle text-success"></i></button>
    </div>
</form>