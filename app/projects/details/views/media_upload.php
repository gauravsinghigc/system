<div class="row">
    <div class="col-md-12 text-center mb-3">
        <h6 class="mb-0 pb-0">Adding Details For</h6>
        <h5 class="bold mt-0 pt-0"><?php echo FETCH("SELECT projects_name FROM projects where projects_id='" . $_SESSION["PROJECT_SESSION_ID"] . "'", "projects_name"); ?></h5>
    </div>
    <div class="col-md-4">
        <div class="shadow-sm p-2 br-1">
            <h5 class="app-heading"><i class="bi bi-image"></i> Upload Images</h5>
            <form action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST" enctype="multipart/form-data">
                <?php echo FormPrimaryInputs(true, [
                    "projects_id" => IfSessionExists("PROJECT_SESSION_ID", $_SESSION["PROJECT_SESSION_ID"]),
                ]); ?>
                <div class="form-group">
                    <label for="project_image" class="form-label">Image File</label>
                    <input type="file" class="form-control" accept="image/*" onchange="PreviewImages('project_image', 'MediaFiles')" id="project_image" name="project_image[]" multiple required>
                    <div id="MediaFiles" class="img-preview"></div>
                </div>
                <div class="form-group">
                    <p class="small text-secondary">You can upload multiple images multiple times and all images will be saved under recently added project.</p>
                    <hr>
                    <button type="submit" name="UploadImagesForProjects" class="btn btn-dark btn-md"><i class="bi bi-upload text-success"></i> Upload Images</button>
                </div>
            </form>
        </div>
    </div>
    <div class=" col-md-4">
        <div class="shadow-sm p-2 br-1">
            <h5 class="app-heading"><i class="b- bi-file-pdf"></i> Upload Brochures</h5>
            <form action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST" enctype="multipart/form-data">
                <?php echo FormPrimaryInputs(true, [
                    "projects_id" => IfSessionExists("PROJECT_SESSION_ID", $_SESSION["PROJECT_SESSION_ID"]),
                ]); ?>
                <div class="form-group">
                    <label for="project_brochures" class="form-label">Select Files/Brochures</label>
                    <input type="file" class="form-control" accept="application/pdf" onchange="PreviewFiles('project_brochures', 'BrochureFiles')" id="project_brochures" name="project_brochures[]" multiple required>
                    <div id="BrochureFiles" class="img-preview"></div>
                </div>
                <div class="form-group">
                    <p class="small text-secondary">You can upload multiple pdf files multiple times and all pdf files will be saved under recently added project.</p>
                    <hr>
                    <button type="submit" name="UploadBrochureForProjects" class="btn btn-dark btn-md"><i class="bi bi-upload text-success"></i> Upload Files</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="shadow-sm p-2 br-1">
            <h5 class="app-heading"><i class="bi bi-youtube"></i> Add YouTube Videos</h5>
            <form action="<?php echo CONTROLLER; ?>/ModuleController/ProjectsController.php" method="POST" enctype="multipart/form-data">
                <?php echo FormPrimaryInputs(true, [
                    "projects_id" => IfSessionExists("PROJECT_SESSION_ID", $_SESSION["PROJECT_SESSION_ID"]),
                ]); ?>
                <div class="form-group">
                    <label for="project_brochures" class="form-label">Add Youtube Video ID</label>
                    <textarea rows="4" placeholder="https://www.youtube.com/watch?v=XXXXXXXX. You can add multiple watch-ids seperated by commas, like abcdefghijkl, lkjhgfdsa, poiuytrewwq" class="form-control small" id="youtube_video_id" name="youtube_video_id" required></textarea>
                </div>
                <div class="form-group">
                    <p class="small text-secondary">You can add multiple youtube watch-ids multiple times and that will be saved under recently added project.</p>
                    <p class="small">
                        <b>Notes:</b><br> https://www.youtube.com/watch?v=XXXXXXXX, here <b>XXXXXXXX</b> will be watch id. We have to add/insert this.
                    </p>
                    <hr>
                    <button type="submit" name="UploadYoutubeWatchIds" class="btn btn-dark btn-md"><i class="bi bi-check text-success"></i> Save Youtube Video Link</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12 text-right">
        <hr>
        <span class="text-secondary">Continue From Here after uploading all documents</span>
        <a href="?project_entry_step=amenities" class="btn btn-dark btn-md">Continue for Amenities <i class="bi bi-check text-success"></i></a>
    </div>
</div>