<div class="card">
    <div class="card-header text-center">
        <?php include __DIR__ . "/../components/AuthFormLogo.php"; ?>
        <br>
    </div>
    <div class="card-body no-border">
        <h5 class="text-center"><i class="fa fa-check-circle-o text-success"></i> Password Reset Link Sent!</h5>
        <p> Password Reset Link is sent successfully on submitted email id <b><?php echo $_SESSION['REQUESTED_EMAIL']; ?></b>. Change your password by following that link.</p>
        <a href="<?php echo DOMAIN; ?>/auth/?Authview=LoginForm" class="btn btn-block btn-success btn-lg"><i class='fa fa-angle-left'></i> Back to Login</a>
    </div>
    <div class="mb-15px">
        <hr class="bg-gray-600 opacity-2 mt-50px" />
        <?php include "../include/common/login-footer.php"; ?>
        <br>
    </div>
</div>