<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
</head>

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <div class="row">
                                <!-- FAQ Section (col-md-7) -->
                                <div class="col-md-7">
                                    <h4 class="mb-3"><i class="bi bi-question-circle-fill text-primary"></i> Lead Automation FAQs</h4>
                                    <div class="accordion" id="faqAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq1">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                                    What is lead automation?
                                                </button>
                                            </h2>
                                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Lead automation is the process of using software to automatically capture, nurture, and manage leads through predefined workflows.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq2">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                                    How do I set up an automation workflow?
                                                </button>
                                            </h2>
                                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Go to the Automation section, click "Create Workflow," and define triggers, actions, and conditions.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq3">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                                    Can I integrate with my CRM?
                                                </button>
                                            </h2>
                                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Yes, we support integration with major CRMs like Salesforce, HubSpot, and Zoho via API or Zapier.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq4">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                                    How do I track lead progress?
                                                </button>
                                            </h2>
                                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Use the Lead Dashboard to monitor lead stages, conversion rates, and pipeline status in real-time.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq5">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                                    What are lead scoring rules?
                                                </button>
                                            </h2>
                                            <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Lead scoring assigns points to leads based on their behavior and demographics to prioritize follow-ups.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq6">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                                    How can I automate email campaigns?
                                                </button>
                                            </h2>
                                            <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Create email templates, set triggers (e.g., form submission), and schedule follow-ups in the Email Automation tool.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq7">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                                                    Can I import leads from a CSV file?
                                                </button>
                                            </h2>
                                            <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Yes, use the "Import Leads" feature under Lead Management and upload your CSV file with mapped fields.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq8">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                                                    How do I segment my leads?
                                                </button>
                                            </h2>
                                            <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Use filters like location, behavior, or source in the Lead Segmentation tool to create targeted groups.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq9">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9">
                                                    What happens if a lead unsubscribes?
                                                </button>
                                            </h2>
                                            <div id="collapse9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    They’re automatically removed from active campaigns and marked as "Unsubscribed" in the system.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq10">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10">
                                                    How do I measure automation ROI?
                                                </button>
                                            </h2>
                                            <div id="collapse10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Check the Analytics tab for metrics like conversion rates, cost per lead, and revenue generated.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq11">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11">
                                                    Can I automate social media leads?
                                                </button>
                                            </h2>
                                            <div id="collapse11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    Yes, connect your social accounts and set up triggers to capture leads from platforms like Facebook or LinkedIn.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Support Form (col-md-5) -->
                                <div class="col-md-5">
                                    <h4 class="mb-3 app-heading"><i class="bi bi-headset text-success"></i> Contact Support</h4>
                                    <form action="<?php echo CONTROLLER; ?>/ModuleController/SupportController.php" method="POST">
                                        <?php echo FormPrimaryInputs(true); ?>
                                        <div class="mb-3">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" required class="form-control" value="<?php echo AuthAppUser("UserFullName"); ?>" name="FullName" placeholder="Enter your full name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Email Address <span class="text-danger">*</span></label>
                                            <input type="email" required class="form-control" value="<?php echo AuthAppUser("UserEmailId"); ?>" name="EmailId" placeholder="Enter your email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Phone Number <span class="text-danger">*</span></label>
                                            <input type="tek" required class="form-control" value="<?php echo AuthAppUser("UserPhoneNumber"); ?>" name="PhoneNumber" placeholder="+91-" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" readonly class="form-control" value="<?php echo APP_NAME; ?>" name="company" placeholder="Enter your company name">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Issue & Support Category <span class="text-danger">*</span></label>
                                            <select class="form-control" name="Support_Topic" required>
                                                <option value="">Select a Topic</option>
                                                <?php echo InputOptionsWithKey([
                                                    "TRAINING-AND-DEMO" => "Training And Demo Request",
                                                    "USER-CREATION-AND-UPDATE" => "User Creation And Update",
                                                    "LEAD-NOT-RECEIVING" => "Leads Not Receiving",
                                                    "LEAD-DUPLICATION" => "Duplicate Leads Issue",
                                                    "LEAD-ASSIGNMENT-ERROR" => "Lead Assignment Not Working",
                                                    "LEAD-SOURCE-TRACKING" => "Lead Source Not Tracking Properly",
                                                    "CRM-LOGIN-ISSUE" => "CRM Login Issue",
                                                    "CRM-SLOW-PERFORMANCE" => "CRM Loading Slowly",
                                                    "NOTIFICATION-NOT-WORKING" => "Notification Not Working",
                                                    "EMAIL-NOT-SENT" => "Email Not Being Sent",
                                                    "SMS-NOT-SENT" => "SMS Not Being Sent",
                                                    "WHATSAPP-INTEGRATION" => "WhatsApp Integration Support",
                                                    "CALL-LOG-NOT-UPDATING" => "Call Logs Not Updating",
                                                    "APP-NOT-OPENING" => "Mobile App Not Opening",
                                                    "APP-CRASHING" => "App Crashing Frequently",
                                                    "APP-LOGIN-ISSUE" => "Mobile App Login Issue",
                                                    "APP-UPDATE-SUPPORT" => "Mobile App Update Required",
                                                    "ROLE-PERMISSION-ISSUE" => "User Role or Permission Issue",
                                                    "CUSTOM-REPORT-REQUEST" => "Custom Report or Export Issue",
                                                    "DATA-NOT-UPDATING" => "Data Not Updating in Real-Time",
                                                    "FILTER-NOT-WORKING" => "Filter/Sorting Not Working",
                                                    "QUOTATION-NOT-GENERATING" => "Quotation Not Generating",
                                                    "PROJECT-UPDATE-ISSUE" => "Project Update Not Saving",
                                                    "CUSTOMER-DETAILS-MISSING" => "Customer Details Not Displayed",
                                                    "BILLING-AND-INVOICING" => "Billing or Invoicing Issue",
                                                    "SUBSCRIPTION-SUPPORT" => "Subscription/Renewal Related",
                                                    "INTEGRATION-SUPPORT" => "Third-party Integration Support",
                                                    "PROFILE-UPDATE-ISSUE" => "Profile Update Not Saving",
                                                    "SECURITY-AND-ACCESS" => "Security or Access Control Issues",
                                                    "OTHER-SUPPORT" => "Other or General Support",
                                                ]); ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Message <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="Message" rows="4" placeholder="Describe your issue in detail" required></textarea>
                                        </div>
                                        <button type="submit" name="SendSupportRequest" class="btn btn-dark w-100">
                                            <i class="bi bi-send text-success"></i> Submit Support Request
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
</body>

</html>