<div class="tab-pane fade pt-2" id="advance-configurations">
    <form class="form row" action="<?php echo CONTROLLER("SystemController/ConfigController.php"); ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="col-md-12">
            <h5 class='app-sub-heading'>
                <i class="fa fa-gear text-primary"></i> Advanced Configuration Settings
            </h5>
        </div>
        <div class="form-group form-group-2 col-md-4 mb-3">
            <div class="shadow-md br-1 p-2 pr-5 pl-5">
                <label class="bold">Work Environment</label>
                <?php if (CONTROL_WORK_ENV == "PROD") { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_WORK_ENV" Value="PROD" checked=""> <span class="fs-17">Production</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_WORK_ENV" Value="DEV"> <span class="fs-17">Development</span>
                        </span>
                    </div>
                <?php } else { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_WORK_ENV" Value="PROD"> <span class="fs-17">Production</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_WORK_ENV" Value="DEV" checked=""> <span class="fs-17">Development</span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="form-group form-group-2 col-md-4 mb-3">
            <div class="shadow-md br-1 p-2 pr-5 pl-5">
                <label class="bold">Desktop Notifications</label>
                <?php if (CONTROL_NOTIFICATION == "true") { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION" Value="true" checked=""> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION" Value="false"> <span class="fs-17">Disabled</span>
                        </span>
                    </div>
                <?php } else { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION" Value="true"> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION" Value="false" checked=""> <span class="fs-17">Disabled</span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="form-group form-group-2 col-md-4 mb-3">
            <div class="shadow-md br-1 p-2 pr-5 pl-5">
                <label class="bold">Desktop Notifications Sound</label>
                <?php if (CONTROL_NOTIFICATION_SOUND == "true") { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION_SOUND" Value="true" checked=""> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION_SOUND" Value="false"> <span class="fs-17">Disabled</span>
                        </span>
                    </div>
                <?php } else { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION_SOUND" Value="true"> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_NOTIFICATION_SOUND" Value="false" checked=""> <span class="fs-17">Disabled</span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="form-group form-group-2 col-md-4 mb-3">
            <div class="shadow-md br-1 p-2 pr-5 pl-5">
                <label class="bold">Activity Logs</label>
                <?php if (CONTROL_APP_LOGS == "true") { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_APP_LOGS" Value="true" checked=""> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_APP_LOGS" Value="false"> <span class="fs-17">Disabled</span>
                        </span>
                    </div>
                <?php } else { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="CONTROL_APP_LOGS" Value="true"> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="CONTROL_APP_LOGS" Value="false" checked=""> <span class="fs-17">Disabled</span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="form-group form-group-2 col-md-4 mb-3">
            <div class="shadow-md br-1 p-2 pr-5 pl-5">
                <label class="bold">Server Down</label>
                <?php if (SERVER_DOWN_CONTROL == "true") { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="SERVER_DOWN_CONTROL" Value="true" checked=""> <span class="fs-17">Live</span>
                        </span>
                        <span>
                            <input type="radio" name="SERVER_DOWN_CONTROL" Value="false"> <span class="fs-17">Temporary Down</span>
                        </span>
                    </div>
                <?php } else { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="SERVER_DOWN_CONTROL" Value="true"> <span class="fs-17">Live</span>
                        </span>
                        <span>
                            <input type="radio" name="SERVER_DOWN_CONTROL" Value="false" checked=""> <span class="fs-17">Temporary Down</span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="form-group form-group-2 col-md-4 mb-3">
            <div class="shadow-md br-1 p-2 pr-5 pl-5">
                <label class="bold">Internal Chat Feature</label>
                <?php if (INTERNAL_CHAT_APP == "true") { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="INTERNAL_CHAT_APP" Value="true" checked=""> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="INTERNAL_CHAT_APP" Value="false"> <span class="fs-17">Disable</span>
                        </span>
                    </div>
                <?php } else { ?>
                    <div class="flex-s-b">
                        <span>
                            <input type="radio" name="INTERNAL_CHAT_APP" Value="true"> <span class="fs-17">Enable</span>
                        </span>
                        <span>
                            <input type="radio" name="INTERNAL_CHAT_APP" Value="false" checked=""> <span class="fs-17">Disable</span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="form-group form-group-2 col-md-7 mb-3">
            <label class="bold">Alert Display Time (1000x1 = 1sec)</label>
            <input type="number" name="CONTROL_MSG_DISPLAY_TIME" class="form-control " required="" value="<?php echo CONTROL_MSG_DISPLAY_TIME; ?>">
        </div>
        <div class="form-group form-group-2 col-md-5 mb-3">
            <label class="bold">Records Listing Limit</label>
            <input type="number" name="DEFAULT_RECORD_LISTING" class="form-control " required="" value="<?php echo DEFAULT_RECORD_LISTING; ?>">
        </div>

        <div class="col-md-12 m-t-10 text-center">
            <hr>
            <button type="Submit" name="UpdateFeatures" class="btn btn-md btn-dark"><i class="fa fa-check text-success"></i> Update Details</button>
        </div>
    </form>
</div>