<form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST" enctype="multipart/form-data">
    <?php echo FormPrimaryInputs(true, [
        "projects_id" => IfSessionExists("PROJECT_SESSION_ID", $_SESSION["PROJECT_SESSION_ID"]),
    ]); ?>
    <div class="col-md-12 text-center mb-3">
        <h6 class="mb-0 pb-0">Adding Details For</h6>
        <h5 class="bold mt-0 pt-0"><?php echo FETCH("SELECT projects_name FROM projects where projects_id='" . $_SESSION["PROJECT_SESSION_ID"] . "'", "projects_name"); ?></h5>
    </div>
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-12">
                <h5 class="app-sub-heading">Developer Primary Details</h5>
            </div>
            <div class="col-md-6 form-group">
                <label for="projects_developers_name">Developer Name</label>
                <input type="text" class="form-control" id="projects_developers_name" name="projects_developers_name" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="projects_developer_phone_number">Phone Number</label>
                <input type="tel" class="form-control" id="projects_developer_phone_number" name="projects_developer_phone_number" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="projects_developer_primary_email_id">Email-Id (optional)</label>
                <input type="tel" class="form-control" id="projects_developer_primary_email_id" name="projects_developer_primary_email_id">
            </div>
            <div class="form-group col-md-6">
                <label for="project_developer_status">Status</label>
                <select class="form-control" id="project_developer_status" name="project_developer_status" required>
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <label for="projects_developers_address">Address</label>
                <textarea class="form-control" id="projects_developers_address" name="projects_developers_address" rows="2" required></textarea>
            </div>
            <div class="col-md-12 form-group">
                <label for="projects_landing_page_url">Landing Page Url</label>
                <input type="text" class="form-control" id="projects_landing_page_url" name="projects_landing_page_url" required>
            </div>
        </div>
    </div>
    <div class=" col-md-5">
        <div class="row">
            <div class="col-md-12">
                <h5 class="app-sub-heading">Developer Logo</h5>
            </div>
            <div class="col-md-12 form-group">
                <label for="projects_developers_logo">Logo</label>
                <input type="file" class="form-control" id="projects_developers_logo" name="projects_developers_logo" onchange="PreviewImages('projects_developers_logo', 'preview')">
                <div id="preview" class="img-preview"></div>
            </div>

        </div>
    </div>
    <div class="col-md-12 text-right">
        <hr>
        <button type="submit" name="SaveProjectDeveloperDetails" class="btn btn-md btn-dark"><i class="bi bi-check-circle text-success"></i> Save Details & Continue</button>
    </div>
</form>