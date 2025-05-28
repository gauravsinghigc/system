<!-- Notification -->
<div class="notification-container" onclick="Databar('Notification-container')">
    <i class="fa fa-bell-o"></i>
    <?php
    $UserID = AuthAppUser('UserId');
    $TotalUploaded = TOTAL("SELECT leadsUploadId FROM lead_uploads WHERE CompanyID='" . CompanyId . "' AND LeadStatus='UPLOADED' AND Notify='1' AND LeadsUploadedfor='$UserID'");
    $TotalLeads = TOTAL("SELECT LeadsId FROM leads WHERE CompanyID='" . CompanyId . "' AND Notify='1' AND LeadPersonManagedBy='$UserID'");
    if ($TotalLeads > 0) {
        $leadcount = 1;
    } else {
        $leadcount = 0;
    }
    $TotalTasks = TOTAL("SELECT * FROM tasks WHERE Notify='1' AND CompanyID='" . CompanyId . "' AND ManagedBy='" . AuthAppUser('UserId') . "'");
    if ($TotalUploaded > 0) {
        $uploadedCount = 1;
    } else {
        $uploadedCount = 0;
    }
    $Total = $uploadedCount + $TotalTasks + $leadcount;
    if ($Total == 0) {
        $hidden = "hidden";
    } else {
        $hidden = "";
        echo '
         <audio controls autoplay hidden id="notification-audio">
            <source src="' . STORAGE_URL_D . '/sys-tone/task-notification.mp3" type="audio/ogg">
         </audio>';
    }
    ?>
    <span class="notification-count blink-data <?php echo $hidden; ?>">
        <?php echo $Total; ?>
    </span>
</div>
<div id="Notification-container" class="Notification-box">
    <div class="notification-header">
        <span class="notification-title">Notifications</span>
        <button class="btn btn-xs btn-light fs-15" onclick='Databar("Notification-container")'><i class="fa fa-times-circle-o text-danger"></i></button>
    </div>
    <div class="notification-list">
        <?php
        if ($Total != 0) {
            // Fetch uploaded leads notifications
            if ($TotalUploaded != 0) {
        ?>
                <a href="<?php echo APP_URL; ?>/leads/uploaded/" class="shadow-sm p-2 m-2 flex-s-b bg-light">
                    <div class="w-pr-20 flex-s-b align-items-center">
                        <span style="border-radius: 50%; padding: 10px 15px;background-color: green;color: white;"><i class="fa fa-upload blink-data text-light"></i></span>
                    </div>
                    <div class="w-pr-80">
                        <span class="fs-15"> <b> <?php echo $TotalUploaded; ?></b> New Lead/Data Uploaded!
                            <span class="text-warning fs-10">
                                <?php
                                echo FETCH("SELECT Upload_Source FROM lead_uploads WHERE CompanyId='" . CompanyId . "' AND Notify='1' AND LeadsUploadedfor='$UserID' ORDER BY leadsUploadId DESC LIMIT 1", "Upload_Source");
                                $time =  FETCH("SELECT UploadedOn FROM lead_uploads WHERE CompanyId='" . CompanyId . "' AND Notify='1' AND LeadsUploadedfor='$UserID' ORDER BY leadsUploadId DESC LIMIT 1", "UploadedOn");
                                ?></span><br>

                            <span class="flex-s-b text-grey fs-10"><?php echo timeAgo($time); ?>
                            </span>
                            <span class="text-success mt-0 fs-11 bold">UPLOADED</span>

                        </span>
                    </div>
                </a>
            <?php  }
            // Fetch leads notifications
            if ($TotalLeads != 0) {
            ?>
                <a href="<?php echo APP_URL; ?>/leads/" class="shadow-sm p-2 m-2 flex-s-b bg-light">
                    <div class="w-pr-20 flex-s-b align-items-center">
                        <span style="border-radius: 50%; padding: 10px 15px;background-color:#14213d;color: white;"><i class="fa fa-user blink-data text-light"></i></span>
                    </div>
                    <div class="w-pr-80">
                        <span class="fs-15"> <b> <?php echo $TotalLeads; ?></b> New Lead/Data Assigned!
                            <span class="text-warning fs-10">
                                <?php if (AuthAppUser("UserType") == 'Admin') {
                                    echo FETCH("SELECT Distribute_Type FROM leads WHERE CompanyID='" . CompanyId . "' AND Notify='1' AND LeadPersonManagedBy='$UserID' ORDER BY LeadsId DESC LIMIT 1", "Distribute_Type");
                                    $time =  FETCH("SELECT LeadPersonCreatedAt FROM leads WHERE CompanyId='" . CompanyId . "' AND Notify='1' AND LeadPersonManagedBy='$UserID' ORDER BY LeadsId DESC LIMIT 1", "LeadPersonCreatedAt");
                                } else {
                                    echo FETCH("SELECT Distribute_Type FROM leads WHERE CompanyID='" . CompanyId . "' AND Notify='1' AND LeadPersonManagedBy='$UserID' ORDER BY LeadsId DESC LIMIT 1", "Distribute_Type");
                                    $time =  FETCH("SELECT LeadPersonCreatedAt FROM leads WHERE CompanyId='" . CompanyId . "' AND Notify='1' AND LeadPersonManagedBy='$UserID' ORDER BY LeadsId DESC LIMIT 1", "LeadPersonCreatedAt");
                                } ?></span><br>

                            <span class="flex-s-b text-grey fs-10"><?php echo timeAgo($time); ?>
                            </span>
                            <span class="mt-0 fs-11 bold" style='color:#14213d;'>Lead/Data</span>

                        </span>
                    </div>
                </a>
                <?php  }
            // Fetch task notifications
            if ($TotalTasks != 0) {
                $GetTask = _DB_COMMAND_("SELECT * FROM tasks WHERE Notify='1' AND CompanyID='" . CompanyId . "' AND ManagedBy='" . AuthAppUser('UserId') . "' ORDER BY Task_ID DESC", true);
                if (AuthAppUser('UserType') == "Admin" || AuthAppUser('UserType') == "TeamMember") {
                    $path = "tasks";
                } else {
                    $path = "dashboard-task";
                }
                if ($GetTask != null) {
                    foreach ($GetTask as $task) {
                ?>
                        <a href="<?php echo APP_URL . '/' . $path; ?>/details/?taskid=<?php echo SECURE($task->Task_ID, "e"); ?>" class="shadow-sm p-2 m-2 flex-s-b bg-light">
                            <div class="w-pr-20 flex-s-b align-items-center">
                                <span style="border-radius: 50%; padding: 10px 15px;background-color:skyblue;"><i class="fa fa-bell blink-data text-light"></i></span>
                            </div>
                            <div class="w-pr-80">
                                <span class="fs-15"> <b> <?php echo $task->TaskName; ?> </b><span class="fs-10 text-warning"> <?php echo $task->TaskStatus; ?></span><br>
                                    <span class="flex-s-b text-grey fs-10"> <?php echo timeAgo($task->CreatedAt); ?></span>
                                    <span class="text-primary mt-0 bold fs-11">TASK</span>
                                </span>

                            </div>

                        </a>
        <?php
                    }
                }
            }
        } else {
            NoData("No Notifications Found!!");
        }
        ?>
    </div>
</div>
<!-- notification end -->