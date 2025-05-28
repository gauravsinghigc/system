<?php
require_once '../../acm/SysFileAutoLoader.php';

if (isset($_SESSION['LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo APP_NAME; ?> | Forget Password</title>
    <meta content="width=device-width, initial-scale=0.95, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderStyleSheets.php"; ?>
</head>

<?php if (DEVICE_TYPE == "MOBILE") { ?>

    <body style="background-image:url('https://images.unsplash.com/photo-1524230572899-a752b3835840?q=80&w=1936&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') !important;background-size:fill;height:100%;background-position:center;">
        <section class="container">
            <div class="row">
                <div class="col-md-12 text-center pt-5">
                    <img src="<?php echo APP_LOGO; ?>" class="w-25 img-fluid rounded-circle">
                    <h2 class="bold text-danger mt-4"><?php echo APP_NAME; ?></h2>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="p-2">
                        <form action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php" method="POST" class="fs-13px">
                            <?php FormPrimaryInputs(true); ?>
                            <h4>Recover Password</h4>
                            <p class="small">Enter your registered email id, we will sent a password reset link on it. You can change password by using that link.</p>

                            <div class="form-group mb-15px mt-2">
                                <label for="emailAddress" class="fs-13px text-gray-600">Email Address</label>
                                <input type="text" class="form-control form-control-lg app-form-control" name="UserEmailId" placeholder="" id="emailAddress" />
                            </div>
                            <button type="submit" name="SearchAccountForPasswordReset" class="btn btn-dark d-block btn-lg w-100 fixed-bottom circle mb-3 fs-4 p-3"><i class="fa fa-search text-success"></i> Search Account</button>
                            <div class="w-100 text-center mt-3">
                                <p class="small mb-0"> Know Password, <a href="<?php echo DOMAIN; ?>/auth/login/">Login Now?</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>

<?php } else { ?>

    <body class="app-login-bg">
        <main>
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">
                                <div class="card mb-3 border-radius-1 box-shadow-1">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-left py-4">
                                            <a href="<?php echo DOMAIN; ?>" class="logo d-flex align-items-center w-auto">
                                                <img src="<?php echo APP_LOGO; ?>" alt="<?php echo APP_NAME; ?>" title="<?php echo APP_NAME; ?>">
                                                <span><?php echo APP_NAME; ?></span>
                                            </a>
                                        </div>
                                        <div class="pt-0 mt-1 pb-2">
                                            <h5 class="card-title text-left pb-0 pt-0 fs-5">Forget Password</h5>
                                            <p class="text-left small text-secondary">Search and verify account for password reset</p>
                                        </div>

                                        <form action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php" method="POST" class="fs-13px">
                                            <?php FormPrimaryInputs(true); ?>
                                            <p class="small">Enter your registered email id, we will sent a password reset link on it. You can change password by using that link.</p>

                                            <div class="form-group mb-15px mt-2">
                                                <label for="emailAddress" class="fs-13px text-gray-600">Email Address</label>
                                                <input type="text" class="form-control form-control-sm h-40px fs-13px" name="UserEmailId" placeholder="" id="emailAddress" />
                                            </div>
                                            <div class="mb-15px mt-3">
                                                <button type="submit" name="SearchAccountForPasswordReset" class="btn btn-dark d-block btn-lg w-100"><i class="fa fa-search text-success"></i> Search Account</button>
                                            </div>
                                            <div class="w-100 text-center mt-3">
                                                <p class="small mb-0"> Know Password, <a href="<?php echo DOMAIN; ?>/auth/login/">Login Now?</a></p>
                                            </div>
                                        </form>
                                        <?php include "../../include/Login-Footer.php"; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </section>

            </div>
        </main><!-- End #main -->
    </body>
<?php } ?>
<?php include_once "../../assets/FooterScripts.php"; ?>

</html>