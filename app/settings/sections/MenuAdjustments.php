<div class="tab-pane fade pt-2" id="menu-adjustments">
    <form class="row" action="<?php echo CONTROLLER; ?>/SystemController/ConfigController.php" method="POST">
        <?php echo FormPrimaryInputs(true); ?>
        <div class="col-md-12">
            <h5 class="app-sub-heading"><i class="fa fa-bars text-primary"></i> Menu Display Adjustments</h5>
        </div>
        <div class="form-group mb-4 col-md-4">
            <label>Listing Type </label>
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
        <div class="form-group mb-4 col-md-4">
            <label>Type Of Records </label>
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
        <div class="form-group mb-4 col-md-4">
            <label>Type Of Closing </label>
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
        <div class="form-group mb-4 col-md-4">
            <label>Type Of Users </label>
            <select name="TYPES_OF_USERS" class="form-control" requried="">
                <?php echo InputOptionsWithKey([
                    "" => "Type Of Users",
                    "Users" => "Users",
                    "Team Members" => "Team Members",
                    "Agents" => "Agents",
                    "Associates" => "Associates",
                    "Partners" => "Partners",
                    "Employees" => "Employees",
                    "Sales Executive" => "Sales Executives",
                    "Sales Team" => "Sales Team"
                ], TYPES_OF_USERS); ?>
            </select>
        </div>
        <div class="form-group mt-3 text-center">
            <hr>
            <button name="UpdateMenuDisplayOptions" class="btn btn-md btn-dark"><i class="fa fa-check text-success"></i> Update Details</button>
        </div>
    </form>
</div>