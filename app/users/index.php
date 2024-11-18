<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Users";
$PageDescription = "Manage all customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>
    <?php echo $PageName; ?> |
    <?php echo APP_NAME; ?>
  </title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("users").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body>
  <div class="wrapper">
    <?php include $Dir . "/include/common/TopHeader.php"; ?>

    <div class="content-wrapper">
      <?php include $Dir . "/include/common/MainNavbar.php"; ?>
      <section class="content">
        <div class="">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-10">
                <h4 class="app-heading mt-0">
                  <i class='fa fa-users text-warning'></i>
                  <?php echo $PageName; ?>
                </h4>
              </div>
              <div class="col-md-2">
                <a href="#" class="btn btn-md btn-block btn-danger"><i class="fa fa-plus"></i> New
                  Users</a>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div class="flex-s-b data-list bg-dark">
                    <div>SNo/RefNo</div>
                    <div>FullName</div>
                    <div>PhoneNo</div>
                    <div>EmailId</div>
                    <div>WorkProfile</div>
                    <div>DateOfBirth</div>
                    <div>CreatedAt</div>
                    <div>UserType</div>
                    <div>UserStatus</div>
                  </div>

                  <div class="RecordsList">
                    <div class="flex-s-b data-list">
                      <div>1/1</div>
                      <div>Gaurav Singh</div>
                      <div>8447575665</div>
                      <div>gauravsinghigc@gmail.com</div>
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
  include $Dir . "/include/common/Footer.php";
  include $Dir . "/assets/FooterFiles.php";
  ?>
</body>

</html>