<div class="row">
    <div class="col-md-12">
        <div class="flex-s-b mb-3">
            <h5 class="mb-0 pb-0 app-sub-heading w-pr-75"><i class="<?php echo MASTER_DATA_MENUS[$ActiveMasterMenu]['icon']; ?>"></i> <?php echo MASTER_DATA_MENUS[$ActiveMasterMenu]['name']; ?></h5>
            <a class="btn btn-md btn-danger mb-0 w-pr-25 ml-1" onclick="ControlForms('AddProjectLocations')"><i class="bi bi-plus"></i> Add Project Locations</a>
        </div>
    </div>

    <div class="col-md-12">
        <?php
        $SourcesSQL = "SELECT * FROM config_projects_locations ORDER BY config_projects_locations_id ASC";
        $GetAllSources = SET_SQL($SourcesSQL, true);
        $SerialNo = 0;
        if ($GetAllSources != null) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th><span class="d-heading active text-left">S No</span></th>
                            <th> <span class="d-heading active text-left">Project Location Name </span></th>
                            <th> <span class="d-heading active text-left">Colour Code</span></th>
                            <th><span class="d-heading active text-left">Status</span></th>
                            <th><span class="d-heading active text-left">CreatedAt</span></th>
                            <th><span class="d-heading active text-right">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GetAllSources as $Records) {
                            $SerialNo++; ?>
                            <tr>
                                <td>
                                    <span class="text-left data"><?php echo $SerialNo; ?></span>
                                </td>
                                <td>
                                    <span class="bold"><?php echo $Records->config_projects_locations_name; ?></span>
                                </td>
                                <td>
                                    <span class="color-tags" style="background-color:<?php echo $Records->config_projects_locations_color_code; ?>;">
                                        <?php echo $Records->config_projects_locations_color_code; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo StatusViewWithText($Records->config_projects_locations_status); ?>
                                </td>
                                <td>
                                    <span class="text-left data"><?php echo DATE_FORMATES("d M, Y h:m A", $Records->config_projects_locations_created_at); ?></span>
                                </td>
                                <td>
                                    <button type="button" onclick="ControlForms('Update_<?php echo $Records->config_projects_locations_id; ?>')" class="btn btn-outline-dark btn-xs"><i class="bi bi-pencil-fill"></i> Edit</button>
                                    <?php echo CONFIRM_DELETE_POPUP(
                                        'ProjectStages',
                                        [
                                            "RemoveProjectLocations" => "true",
                                            "RecordsId" => $Records->config_projects_locations_id
                                        ],
                                        CONTROLLER . "/SystemController/MasterDataController.php",
                                        "<i class='fa fa-trash'></i>",
                                        "btn btn-xs btn-outline-danger"
                                    ); ?>
                                    <?php include __DIR__ . "/../../../include/forms/UpdateProjectLocationForm.php"; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "<div class='alert alert-warning'><i class='bi bi-exclamation-triangle'></i> No Project Locations Found!</div>";
        } ?>
    </div>
</div>

<?php include __DIR__ . "/../../../include/forms/AddProjectLocationsForm.php"; ?>