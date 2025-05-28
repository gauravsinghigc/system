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
    <title><?php echo APP_NAME; ?> | Verify Account</title>
    <meta content="width=device-width, initial-scale=0.95, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <?php include_once "../../assets/HeaderStyleSheets.php"; ?>
</head>

<?php if (DEVICE_TYPE == "MOBILE") { ?>

    <body style="background-image:url('https://images.unsplash.com/photo-1524230572899-a752b3835840?q=80&w=1936&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') !important;background-size:fill;height:100%;background-position:center;">
        <section class="container">
            <div class="row">
                <div class="col-md-12 text-center pt-5">
                    <img src="<?php echo APP_LOGO; ?>" class="w-25 img-fluid rounded-circle">
                    <h2 class="bold text-danger mt-4"><?php echo APP_NAME; ?></h2>
                </div>
                <div class="col-md-12 mt-4 text-center">
                    <div class="p-2">
                        <div class="pt-0 mt-1 pb-2 text-center">
                            <h3 class="card-title pb-0 pt-0 fs-5 text-center"><i class="fa fa-check-circle text-success"></i> Password Reset Link Sent!</h3>
                            <p class="text-secondary text-center">Verify account and generate new password</p>
                        </div>
                        <div class="w-100">
                            <p class="small">
                                Password Reset Link is sent successfully on submitted email id.
                                <br>Follow the link to change your password securely.
                            </p>
                            <br>
                            <a href="<?php echo APP_URL; ?>" class="btn btn-block btn-dark fixed-bottom p-3 fs-4 circle mb-3 btn-lg w-100"><i class='fa fa-arrow-circle-left text-success'></i> Back to Login</a>
                        </div>
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
                                            <h5 class="card-title text-left pb-0 pt-0 fs-5"><i class="fa fa-check-circle text-success"></i> Password Reset Link Sent!</h5>
                                            <p class="text-left small text-secondary">Verify account and generate new password</p>
                                        </div>
                                        <div class="w-100">
                                            <p class="small">
                                                Password Reset Link is sent successfully on submitted email id.
                                                <br>Follow the link to change your password securely.
                                            </p>
                                            <br>
                                            <a href="<?php echo APP_URL; ?>" class="btn btn-block btn-dark btn-lg w-100"><i class='fa fa-arrow-circle-left text-success'></i> Back to Login</a>
                                        </div>
                                        <?php include_once "../../include/Login-Footer.php"; ?>
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