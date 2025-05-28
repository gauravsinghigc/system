<div class="tab-pane fade pt-2" id="mail-configurations">
    <div class="row">
        <div class="col-md-7">
            <h5 class="app-sub-heading">Update Mail Server</h5>
            <?php
            $GetSMTP = SET_SQL("SELECT * from config_mail_sender ORDER BY config_mail_sender_id ASC", true);
            if ($GetSMTP != null) {
                foreach ($GetSMTP as $SMTP) { ?>
                    <form class="shadow-sm p-2 rounded" action="<?php echo CONTROLLER . "/SystemController/SMTPController.php"; ?>" method="POST">
                        <?php echo FormPrimaryInputs(true, [
                            "config_mail_sender_id" => $SMTP->config_mail_sender_id
                        ]); ?>
                        <div class="form-group mb-3">
                            <label class="bold">SMTP Hostname *</label>
                            <input type="text" name="config_mail_sender_host" value='<?php echo $SMTP->config_mail_sender_host; ?>' class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="bold">Username *</label>
                            <input type="text" name="config_mail_sender_username" value='<?php echo $SMTP->config_mail_sender_username; ?>' class="form-control" required>
                        </div>
                        <div class="flex-s-b mb-3">
                            <div class="form-group w-75 m-1">
                                <label class="bold">Password *</label>
                                <input type="text" name="config_mail_sender_password" value="<?php echo $SMTP->config_mail_sender_password; ?>" class="form-control" required>
                            </div>
                            <div class="form-group w-50 m-1">
                                <label class="bold">SMTP PORT No *</label>
                                <select name="config_mail_sender_port" class="form-control" required="">
                                    <?php echo InputOptionsWithKey([
                                        "0" => "Select Port",
                                        "25" => "25",
                                        "465" => "465",
                                        "587" => "587",
                                    ], $SMTP->config_mail_sender_port); ?>
                                </select>
                            </div>
                        </div>

                        <div class="w-100 mt-4 mb-5 pb-5">
                            <hr>
                            <button class="btn btn-md btn-dark" type="submit" name="UpdateMailConfigurations">Update Mail Server <i class="fa fa-check text-success"></i></button>
                        </div>
                    </form>
            <?php }
            } ?>
        </div>
        <div class="col-md-5">
            <h5 class="app-sub-heading">Test Mail Server</h5>
            <form class="shadow-sm p-2 rounded" action="<?php echo CONTROLLER . "/SystemController/SMTPController.php"; ?>" method="POST">
                <?php echo FormPrimaryInputs(true); ?>
                <div class="form-group mb-3">
                    <label for="GreetingPersonName">Person Name</label>
                    <input type="text" id="GreetingPersonName" name="GreetingPersonName" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="EmailId">Email-Id</label>
                    <input type="email" id="EmailId" name="EmailId" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="MailSubject">Mail Subject</label>
                    <input type="text" id="MailSubject" name="MailSubject" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="MailBody">Mail Body</label>
                    <textarea id="MailBody" name="MailBody" class="form-control" rows="2" required></textarea>
                </div>
                <div class="form-group mb-3 mt-4">
                    <hr>
                    <button class="btn btn-md btn-dark" type="submit" name="TestMailServer">Send Test Mail <i class="fa fa-paper-plane text-success"></i></button>
                </div>
            </form>
        </div>
    </div>

</div>