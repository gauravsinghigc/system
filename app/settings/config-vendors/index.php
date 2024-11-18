<?php
$Dir = "../../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Vendor Types";
$PageDescription = "Manage System Profile, address, logo";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("configs_vendor").classList.add("active");
      document.getElementById("settings").classList.add("active");
      document.getElementById("config_vendor_types").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include $Dir . "/include/common/TopHeader.php"; ?>


    <div class="content-wrapper">
      <?php include $Dir . "/include/common/MainNavbar.php"; ?>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-2">
                      <?php include $Dir . "/app/settings/sections/common.php"; ?>
                    </div>

                    <div class="col-md-2">
                      <?php include $Dir . "/app/settings/config-vendors/sections/ConfigMenus.php"; ?>
                    </div>

                    <div class="col-md-8">
                      <div class="flex-s-b">
                        <h4 class="app-heading mb-0 w-100"><?php echo $PageName; ?></h4>
                        <a onclick="Databar('AddNewVendorType')" class="btn ml-1 btn-sm btn-block w-pr-20 btn-danger"><i class='fa fa-plus'></i> Add Record</a>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-12">
                          <form>
                            <div class="form-group">
                              <input type="search" onchange="form.submit()" list='vendor_type_name' value='<?php echo IfRequested("GET", "vendor_type_name", "", null); ?>' name='vendor_type_name' placeholder="Search Vendor Type Name..." class="form-control">
                              <?php echo SUGGEST("config_vendor_types", "vendor_type_name", "ASC"); ?>
                            </div>
                          </form>
                        </div>
                      </div>

                      <?php echo ClearFilters("vendor_type_name"); ?>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="data-list flex-s-b bg-dark">
                            <div class="w-pr-5">S.No.</div>
                            <div class="w-pr-40">Vendor Type</div>
                            <div class="w-pr-15">NoOfRecords</div>
                            <div class="w-pr-10">CreatedAt</div>
                            <div class="w-pr-15">CreatedBy</div>
                            <div class="w-pr-5">Status</div>
                            <div class="w-pr-10 text-right">Records</div>
                          </div>
                          <?php
                          $Start = START_FROM;
                          $EndLimit = DEFAULT_RECORD_LISTING;
                          if (isset($_GET['vendor_type_name'])) {
                            $VendorSQL = "SELECT * FROM config_vendor_types WHERE vendor_type_name LIKE '%" . $_GET['vendor_type_name'] . "%' ORDER BY vendor_type_id DESC";
                          } else {
                            $VendorSQL = "SELECT * FROM config_vendor_types ORDER BY vendor_type_id DESC";
                          }
                          $VendorTypes = SET_SQL($VendorSQL . " limit $Start, $EndLimit", true);
                          if ($VendorTypes != null) {
                            $SerialNo = SERIAL_NO;
                            foreach ($VendorTypes as $Data) {
                              $SerialNo++;
                              $Selection = ReturnSelectionStatus($Data->vendor_type_status); ?>
                              <div class="RecordsList">
                                <div class="data-list flex-s-b">
                                  <div class="w-pr-5"><?php echo $SerialNo; ?></div>
                                  <div class="w-pr-40 bold text-primary text-left">
                                    <a onclick="Databar('UpdateVendorType_<?php echo $Data->vendor_type_id; ?>')">
                                      <?php echo ReplaceSpecialCharacters(UpperCase($Data->vendor_type_name), "_"); ?>
                                      <span class="text-gray" title="<?php echo SECURE($Data->vendor_type_desc, "d"); ?>"><i class="fa fa-info-circle"></i></span>
                                    </a>
                                  </div>
                                  <div class="w-pr-15">
                                    <b><?php echo TOTAL("SELECT vendor_id FROM vendor WHERE vendor_type_id='" . $Data->vendor_type_id . "'"); ?></b> Vendors
                                  </div>
                                  <div class="w-pr-10">
                                    <?php echo DATE_FORMATES("d M, Y", $Data->vendor_type_created_at); ?>
                                  </div>
                                  <div class="w-pr-15">
                                    <?php echo AttachUserEntity($Data->vendor_type_created_by); ?>
                                  </div>
                                  <div class="w-pr-5">
                                    <form action="<?php echo CONTROLLER("SystemController/ConfigController.php"); ?>" method="POST" class="user-status">
                                      <?php echo FormPrimaryInputs(true, [
                                        "vendor_type_id" => $Data->vendor_type_id,
                                        "UpdateVendorTypeStatus" => $Data->vendor_type_status
                                      ]); ?>
                                      <div class="custom-control custom-switch">
                                        <input onchange="form.submit()" <?php echo $Selection; ?> type="checkbox" class="custom-control-input" id="customSwitch<?php echo $Data->vendor_type_id; ?>">
                                        <label class="custom-control-label" for="customSwitch<?php echo $Data->vendor_type_id; ?>"></label>
                                      </div>
                                    </form>
                                  </div>
                                  <div class="w-pr-10 text-right">
                                    <a onclick="Databar('UpdateVendorType_<?php echo $Data->vendor_type_id; ?>')" class="btn btn-dark btn-xs"><i class='fa fa-edit'></i> Update</a>
                                  </div>
                                </div>
                              </div>
                          <?php
                              include $Dir . "/include/forms/app/UpdateVendorTypeForm.php";
                            }
                          }
                          PaginationFooter(TOTAL($VendorSQL), "index.php"); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <?php
  include $Dir . "/include/forms/app/CreateVendorTypes.php";
  include $Dir . "/include/common/Footer.php";
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>