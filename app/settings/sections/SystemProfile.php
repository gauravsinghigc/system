<div class="tab-pane fade active show profile-edit pt-2" id="profile-edit">
    <!-- Profile Edit Form -->
    <div class="row mb-3">
        <div class="col-md-8">
            <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/ConfigController.php" method="POST">
                <div class="col-md-12">
                    <h5 class="app-sub-heading">Update Primary Details</h5>
                    <?php echo FormPrimaryInputs(true); ?>
                </div>
                <div class="form-group mb-4 col-md-12">
                    <label class="bold">Organisation/Individual Name</label>
                    <input type="text" class="form-control" name="APP_NAME" value="<?php echo APP_NAME; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-12">
                    <label class="bold">Tagline</label>
                    <input type="text" class="form-control" name="TAGLINE" value="<?php echo TAGLINE; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Admin/Owner Name</label>
                    <input type="text" class="form-control" name="OWNER_NAME" value="<?php echo OWNER_NAME; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Deals In </label>
                    <select name="LISTING_TYPES" class="form-control" requried="">
                        <?php echo InputOptionsWithKey([
                            "" => "Select Deals In Types",
                            "Projects" => "Projects",
                            "Services" => "Services",
                            "Products And Services" => "Products And Services",
                            "Contracts" => "Contracts"
                        ], LISTING_TYPES); ?>
                    </select>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Type Of Records </label>
                    <select name="TYPE_OF_RECORDS" class="form-control" requried="">
                        <?php echo InputOptionsWithKey([
                            "" => "Type Of Records",
                            "Leads" => "Leads",
                            "Contacts" => "Contacts",
                            "Data" => "Data",
                            "Opportunities" => "Opportunities"
                        ], TYPE_OF_RECORDS); ?>
                    </select>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Type Of Closing </label>
                    <select name="TYPE_OF_CLOSING" class="form-control" requried="">
                        <?php echo InputOptionsWithKey([
                            "" => "Type Of Closings",
                            "Sales" => "Sales",
                            "Bookings" => "Bookings",
                            "Registrations" => "Registrations",
                            "Orders" => "Orders",
                            "Contracts" => "Contracts"
                        ], TYPE_OF_CLOSING); ?>
                    </select>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Primary Phone Number </label>
                    <input type="tel" minlength="10" placeholder="with county code +91 " maxlength="13" class="form-control" name="PRIMARY_PHONE" value="<?php echo PRIMARY_PHONE; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Primary Email-ID</label>
                    <input type="email" class="form-control" name="PRIMARY_EMAIL" value="<?php echo PRIMARY_EMAIL; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Support Mail-Id</label>
                    <input type="email" class="form-control" name="SUPPORT_MAIL" value="<?php echo SUPPORT_MAIL; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Enquiry Mail-Id</label>
                    <input type="email" class="form-control" name="ENQUIRY_MAIL" value="<?php echo ENQUIRY_MAIL; ?>" required>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Short Description</label>
                    <textarea name="SHORT_DESCRIPTION" class="form-control" row="3" value="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>"><?php echo SECURE(SHORT_DESCRIPTION, "d"); ?></textarea>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label class="bold">Registered Address</label>
                    <textarea name="PRIMARY_ADDRESS" class="form-control" row="3" value="<?php echo SECURE(PRIMARY_ADDRESS, "d"); ?>"><?php echo SECURE(PRIMARY_ADDRESS, "d"); ?></textarea>
                </div>
                <div class="form-group mt-3 text-center">
                    <button name="UpdatePrimaryConfigurations" class="btn btn-md btn-dark"><i class="fa fa-check text-success"></i> Update Details</button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12 col-lg-12 text-right justify-content-end">
                    <h5 class="app-sub-heading">Update Logo</h5>
                    <img src="<?php echo APP_LOGO; ?>" alt="<?php echo APP_NAME; ?>" title="<?php echo APP_NAME; ?>" class="shadow-md">
                    <div class="pt-2">
                        <form class="form m-t-3" action="<?php echo CONTROLLER . "/SystemController/ConfigController.php"; ?>" method="POST" enctype="multipart/form-data">
                            <input type="text" name="UploadSystemLogo" value="<?php echo APP_LOGO; ?>" hidden="">
                            <?php FormPrimaryInputs(true); ?>
                            <label for="UploadProfileimg">
                                Update Logo <span class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></span>
                            </label>
                            <input type="file" class="hidden" onchange="form.submit()" hidden="" name="APP_LOGO" id="UploadProfileimg" value="<?php echo APP_LOGO; ?>" accept="images/*">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>