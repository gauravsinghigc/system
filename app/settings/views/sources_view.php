<div class="row">
    <div class="col-md-12">
        <div class="flex-s-b mb-3">
            <h5 class="mb-0 pb-0 app-sub-heading w-pr-80"><i class="<?php echo MASTER_DATA_MENUS[$ActiveMasterMenu]['icon']; ?>"></i> <?php echo MASTER_DATA_MENUS[$ActiveMasterMenu]['name']; ?></h5>
            <a class="btn btn-md btn-danger mb-0 w-pr-20 ml-1" onclick="ControlForms('LeadSourceForm')"><i class="bi bi-plus"></i> Add Sources</a>
        </div>
    </div>

    <div class="col-md-12">
        <?php
        $SourcesSQL = "SELECT * FROM config_leads_sources ORDER BY config_leads_source_id ASC";
        $GetAllSources = SET_SQL($SourcesSQL, true);
        $SerialNo = 0;
        if ($GetAllSources != null) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th><span class="d-heading active text-left">S No</span></th>
                            <th> <span class="d-heading active text-left">Image</span></th>
                            <th> <span class="d-heading active text-left">Source Name</span></th>
                            <th><span class="d-heading active text-left">Colour Code</span></th>
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
                                    <img src="<?php echo STORAGE_URL; ?>/sources/<?php echo $Records->config_leads_source_image; ?>" class="list-icon">
                                </td>
                                <td>
                                    <span class="bold"><?php echo $Records->config_leads_source_name; ?></span>
                                </td>
                                <td>
                                    <span class="color-tags" style="background-color:<?php echo $Records->config_leads_source_color; ?>;">
                                        <?php echo $Records->config_leads_source_color; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo StatusViewWithText($Records->config_leads_source_status); ?>
                                </td>
                                <td>
                                    <span class="text-left data"><?php echo DATE_FORMATES("d M, Y h:m A", $Records->config_leads_source_created_at); ?></span>
                                </td>
                                <td>
                                    <button type="button" onclick="ControlForms('Update_<?php echo $Records->config_leads_source_id; ?>')" class="btn btn-outline-dark btn-xs"><i class="bi bi-pencil-fill"></i> Edit</button>
                                    <?php echo CONFIRM_DELETE_POPUP(
                                        'LeadsSources',
                                        [
                                            "RemoveLeadsSourcesRecords" => "true",
                                            "RecordsId" => $Records->config_leads_source_id
                                        ],
                                        CONTROLLER . "/SystemController/MasterDataController.php",
                                        "<i class='fa fa-trash'></i>",
                                        "btn btn-xs btn-outline-danger"
                                    ); ?>
                                    <?php include __DIR__ . "/../../../include/forms/UpdateLeadsSourceForm.php"; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "<div class='alert alert-warning'><i class='bi bi-exclamation-triangle'></i> No Source Found</div>";
        } ?>
    </div>
</div>

<?php include __DIR__ . "/../../../include/forms/AddLeadSourcesForm.php"; ?>