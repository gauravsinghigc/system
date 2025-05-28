<div class="pagetitle animate-fade-up mb-0">
    <div class="flex-s-b">
        <div>
            <h1 class="pb-0 mb-0"><i class="bi bi-speedometer2 text-danger bold"></i> <?php echo $PageName; ?></h1>
            <div class="mt-0">
                <span><i class="bi <?php echo $greetingIcon; ?> text-primary"></i> <?php echo $greeting; ?></span>
                <span class="ms-2"><strong><?php echo AuthAppUser("UserFullName"); ?></strong></span>
            </div>
        </div>
        <form>
            <input type="month" onchange="form.submit()" class="form-control form-control-lg" name="ActiveMonth" value="<?php echo IfRequested("GET", "ActiveMonth", ReturnSessionalValues("ActiveMonth", "DefaultActiveMonths", DATE('Y-m')), null); ?>">
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <div class="alert alert-warning br-2 app-lines">
            <i class="bi bi-chat-right-quote"></i>
            <?php echo MOTIVATIONAL_QUOTES[array_rand(MOTIVATIONAL_QUOTES)]; ?>
            <i class="bi bi-chat-left-quote"></i>
        </div>
    </div>
</div>