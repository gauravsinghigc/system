 <?php
    if (isset($_SESSION['APP_LOGIN_USER_ID']) != null) {

        $UserId = $_SESSION['APP_LOGIN_USER_ID'];
        $APP_KEY = $_SESSION['APP_KEY'];

        //Validation Array
        $Validation = [];

        //validate UserId
        if (trim(SECURE($UserId, "d")) != null || trim(SECURE($UserId, "d")) != "") {
            //push true in validation array
            array_push($Validation, true);
        } else {
            //push false in validation array
            array_push($Validation, false);
        }

        //check APP_KEY and validate it
        if (trim(SECURE($UserId, "d")) != null) {

            //get users email-id
            $UserId = trim(SECURE($UserId, "d"));
            $UserEmailId = FETCH("SELECT UserEmailId FROM users where UserId='$UserId'", "UserEmailId");

            if (filter_var(trim(SECURE($APP_KEY, "d")), FILTER_VALIDATE_EMAIL)) {
                //validate APP_KEY
                if ($UserEmailId == trim(SECURE($APP_KEY, "d"))) {
                    //push true in validation array
                    array_push($Validation, true);
                } else {
                    //push false in validation array
                    array_push($Validation, false);
                }
            } else {
                //push false in validation array
                array_push($Validation, false);
            }
        }

        //check if all true is exits in $Validation then redirect to main app
        if (!in_array(false, $Validation)) {

            //check login token and validate it
            LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app");
        }
    }
    if (isset($_SERVER['HTTP_REFERER'])) {
        $LAST_OPEN_URL = $_SERVER['HTTP_REFERER'];
    } else {
        $LAST_OPEN_URL = true;
    }

    ?>

 <div class="card border-0">
     <div class="card-header text-center">
         <?php include __DIR__ . "/../components/AuthFormLogo.php"; ?>
         <br>
         <span class="h5">
             <i class="fa fa-lock text-success"></i> Login to Account
         </span>
     </div>
     <div class="card-body mt-2">
         <form action="<?php echo CONTROLLER("AuthController/AuthController.php"); ?>" method="POST" class="fs-13px">
             <?php echo FormPrimaryInputs($LAST_OPEN_URL); ?>
             <div class="form-group mb-20px">
                 <input type="email" oninput="HidePassword()" onclick="HidePassword()" id='emailid' class="form-control form-control-lg h-40px fs-20" name="UserEmailId" placeholder="Email Address" />
             </div>
             <div class="form-group mb-15px m-t-15">
                 <input type="password" oninput="HideEmail()" onclick="HideEmail()" id='passwords' name="UserPassword" class="form-control form-control-lg h-40px fs-20" placeholder="*******" />
             </div>
             <div class="mb-10px text-secondary text-right">
                 Forget Password? <a href="<?php echo DOMAIN; ?>/auth/?Authview=ForgetForm" class="text-secondary bold"><b>Recover Password</b></a>
                 <br><br>
             </div>
             <div class="mb-15px">
                 <button type="submit" name="LoginRequest" class="btn btn-success d-block h-45px w-100 btn-lg fs-14px">
                     <i class="fa fa-lock text-white"></i> Secured Login
                 </button>
             </div>
             <?php include "../include/common/login-footer.php"; ?>
         </form>
     </div>
 </div>
 <script>
     function HidePassword() {
         document.getElementById("emailid").type = "email";
         document.getElementById("passwords").type = "password";
     }

     function HideEmail() {
         document.getElementById("emailid").type = "password";
         document.getElementById("passwords").type = "text";
     }
 </script>