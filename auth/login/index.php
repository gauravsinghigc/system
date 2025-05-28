<?php
require_once '../../acm/SysFileAutoLoader.php';
if (isset($_SESSION['APP_LOGIN_USER_ID']) || isset($_COOKIE['LOGIN_USER_ID'])) {
    if (!isset($_SESSION['APP_LOGIN_USER_ID']) && isset($_COOKIE['LOGIN_USER_ID'])) {
        $_SESSION['APP_LOGIN_USER_ID'] = $_COOKIE['LOGIN_USER_ID'];
    }
    LOCATION("info", "Welcome <b>" . AuthAppUser("UserFullName") . "</b>, You are logged in successfully!", APP_URL);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo APP_NAME; ?> | Login </title>
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
                <div class="col-md-12 mt-4">
                    <div class="p-2">
                        <form class="row g-3 needs-validation" method="POST" action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php">
                            <?php FormPrimaryInputs(true); ?>
                            <div class="col-12">
                                <label for="AppUsername" class="form-label">Username</label>
                                <input type="email" minlength="10" name="UserEmailId" class="form-control form-control-lg app-form-control" id="AppUsername" required>
                            </div>
                            <div class="col-12 pb-3">
                                <label for="AppPassword" class="form-label">Password</label>
                                <input type="password" minlength="4" name="UserPassword" class="form-control form-control-lg app-form-control" id="AppPassword" required>
                                <span id='PasswordVisibility' style="margin-top:-11.5vw !important;"><i class="fa fa-eye-slash"></i></span>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="small2"><i class="bi bi-check text-success"></i> By Continue This, I agree Terms & Conditions and Privacy Policy!</p>
                            </div>

                            <div class="col-md-11 mx-auto">
                                <button class="btn btn-dark btn-lg fixed-bottom mb-2 p-2 fs-4 rounded-circle circle" name="LoginRequest" type="submit"><i class="fa fa-lock text-success"></i> Secured Login</button>
                            </div>
                            <div class="col-12 text-center">
                                <p class="small mb-0">Forget Password? <a href="<?php echo DOMAIN; ?>/auth/forget/">Create New Password</a></p>
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
                                            <h5 class="card-title text-left pb-0 pt-0 fs-5">Login to Your Account</h5>
                                            <p class="text-left small text-secondary">Enter your username & password to login</p>
                                        </div>

                                        <form class="row g-3 needs-validation" method="POST" action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php">
                                            <?php FormPrimaryInputs(true); ?>
                                            <div class="col-12">
                                                <label for="AppUsername" class="form-label">Username</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text bold" id="inputGroupPrepend">@</span>
                                                    <input type="email" minlength="10" name="UserEmailId" class="form-control" id="AppUsername" required>
                                                    <div class="invalid-feedback">Please enter your username.</div>
                                                </div>
                                            </div>

                                            <div class="col-12 pb-3">
                                                <label for="AppPassword" class="form-label">Password</label>
                                                <input type="password" minlength="4" name="UserPassword" class="form-control" id="AppPassword" required>
                                                <span id='PasswordVisibility'><i class="fa fa-eye-slash"></i></span>
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-dark btn-lg w-100" name="LoginRequest" type="submit"><i class="fa fa-lock text-success"></i> Secured Login</button>
                                            </div>
                                            <div class="col-12 text-center">
                                                <p class="small mb-0">Forget Password? <a href="<?php echo DOMAIN; ?>/auth/forget/">Create New Password</a></p>
                                            </div>
                                        </form>
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
<script>
    document
        .getElementById("PasswordVisibility")
        .addEventListener("click", function() {
            let passwordField = document.getElementById("AppPassword");
            let icon = this.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });
</script>
<?php include_once "../../assets/FooterScripts.php"; ?>

</html>