<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Integrations & Plugins Setup";
$PageDescription = "Configure and manage integrations for " . APP_NAME . " to enhance your automation capabilities";

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];
$PageName = "3rd Party Integrations API";

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
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printableContent,
            #printableContent * {
                visibility: visible;
            }

            #printableContent {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>

    <main id="main" class="main">
        <div class="pagetitle pt-2">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-plug-fill text-warning bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="pt-2">
                    <button onclick="window.print()" class="btn btn-md btn-primary"><i class="fa fa-print text-warning"></i> Print Document</button>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="container" id="printableCardBody">
            <div class="row">
                <!-- Left Side: Documentation Text -->
                <div class="col-md-6 mb-3">
                    <div class="card pt-3 shadow-sm">
                        <div class="card-body">
                            <h3 class="app-heading"><i class="fa fa-info text-warning"></i> API Documentation</h3>
                            <p>This API enables external applications to securely create new leads in the system through a simple GET request. The API is authenticated, robust, and optimized for seamless integration with your CRM or lead management tools.</p>

                            <hr>
                            <h4>📌 Overview</h4>
                            <p>The <strong>Leads API</strong> is designed to collect, validate, and store lead information directly into your system. It incorporates input sanitization, parameterized SQL queries to prevent injection attacks, and returns structured JSON responses to ensure smooth client-server communication.</p>
                            <p>This API can be consumed by various frontend or third-party tools such as mobile apps, websites, chatbots, or partner systems for real-time lead registration.</p>

                            <hr>
                            <h4>🚀 How to Use</h4>
                            <p>Initiate a GET request with proper query parameters and a valid <code>authentication_key</code>. If the request is valid, it will return a JSON response indicating success or failure.</p>
                            <ul>
                                <li><strong>Endpoint:</strong> <code><?php echo DOMAIN; ?>/api/getRecords.php</code></li>
                                <li><strong>Method:</strong> GET</li>
                                <li><strong>Authentication:</strong> Required via <code>authentication_key</code> parameter</li>
                            </ul>

                            <hr>
                            <h4>🔧 Request Format</h4>
                            <p>Construct a URL as follows (replace values as needed):</p>
                            <code>
                                <?php echo DOMAIN; ?>/api/getRecords.php?authentication_key=<?php echo SECURE(APP_NAME, "e"); ?>&leads_full_name=John+Doe&leads_phone_number=1234567890&leads_type=Customer&leads_source=Website&leads_projects_name=ProjectX
                            </code>
                            <hr>
                            <p><strong>Supported Parameters:</strong></p>
                            <ul>
                                <li><code>leads_full_name</code> - Full name of the lead (Required)</li>
                                <li><code>leads_phone_number</code> - Phone number (Required)</li>
                                <li><code>leads_email</code> - Email address (Optional)</li>
                                <li><code>leads_type</code> - Customer / Vendor / Partner / Others (Required)</li>
                                <li><code>leads_source</code> - Source of lead (e.g., Website, Facebook, Referral)</li>
                                <li><code>leads_projects_name</code> - Name of the project linked to the lead</li>
                                <li><code>leads_message</code> - Any custom message or note (Optional)</li>
                                <li><code>leads_gender</code> - Male / Female / Other (Optional)</li>
                                <li><code>leads_date</code> - Date of lead in `YYYY-MM-DD` format (Optional)</li>
                            </ul>

                            <hr>
                            <h4>📤 Response Format</h4>
                            <p>The API returns structured JSON output:</p>
                            <code>
                                {<br>
                                &nbsp;"status": "success" | "error",<br>
                                &nbsp;"message": "Description of the result",<br>
                                &nbsp;"data": null | { "leads_id": 123 } | ["Error message"]<br>
                                }
                            </code>

                            <hr>
                            <h5>✅ Success Response (HTTP 201)</h5>
                            <code>
                                {<br>
                                &nbsp;"status": "success",<br>
                                &nbsp;"message": "Lead created successfully",<br>
                                &nbsp;"data": { "leads_id": 123 }<br>
                                }
                            </code>

                            <hr>
                            <h5>❌ Error Response (HTTP 400/401/500)</h5>
                            <code>
                                {<br>
                                &nbsp;"status": "error",<br>
                                &nbsp;"message": "Validation errors",<br>
                                &nbsp;"data": ["Field leads_full_name is required", "Invalid phone number"]<br>
                                }
                            </code>

                            <hr>
                            <h4>✅ Validation Rules</h4>
                            <p>The API performs strict validation to ensure data integrity:</p>
                            <ul>
                                <li><strong>Required Fields:</strong> Name, Phone, Type</li>
                                <li><strong>Maximum Length:</strong> 100 characters for names, emails, etc.</li>
                                <li><strong>Email Format:</strong> Must be a valid email address (if provided)</li>
                                <li><strong>Phone Format:</strong> Digits only, max 15 digits</li>
                                <li><strong>Date Format:</strong> Must follow <code>YYYY-MM-DD</code></li>
                                <li><strong>Allowed Values:</strong> For dropdown-type fields like <code>gender</code> or <code>leads_type</code></li>
                            </ul>
                            <p>All inputs are trimmed, sanitized, and escaped using internal secure functions.</p>

                            <hr>
                            <h4>⚠️ Error Handling</h4>
                            <p>Different HTTP status codes are used for different types of failures:</p>
                            <ul>
                                <li><strong>201:</strong> Lead created successfully</li>
                                <li><strong>400:</strong> Bad Request – validation errors or missing parameters</li>
                                <li><strong>401:</strong> Unauthorized – invalid or missing authentication key</li>
                                <li><strong>500:</strong> Internal Server Error – unexpected system issues</li>
                            </ul>

                            <hr>
                            <h4>🔐 Security Considerations</h4>
                            <ul>
                                <li>Always use <strong>HTTPS</strong> for API requests to prevent data interception</li>
                                <li>Keep your <code>authentication_key</code> confidential and rotate it regularly</li>
                                <li>All inputs are sanitized and use prepared SQL statements to avoid SQL injection</li>
                                <li>Rate limiting and IP whitelisting are recommended for high-volume applications</li>
                            </ul>

                            <hr>
                            <h4>📞 Support & Contact</h4>
                            <p>If you face any issues or need customization support for this API, please contact our technical support team:</p>
                            <ul>
                                <li>Email: <a href="mailto:enquiry@gauravsinghigc.in">enquiry@gauravsinghigc.in</a></li>
                                <li>Phone: +91 8447572565</li>
                                <li>Website: <a href="https://gauravsinghigc.in" target="_blank">https://gauravsinghigc.in</a></li>
                            </ul>
                            <br><br>
                        </div>
                    </div>
                </div>

                <!-- Right Side: API Details and Copyable Code -->
                <div class="col-md-6">
                    <div class="card pt-3 shadow-sm">
                        <div class="card-body">
                            <h3 class="app-heading"><i class="fa fa-plug text-primary"></i> API Integration Guide</h3>
                            <p>This section provides detailed documentation on how to integrate with our Leads API using a secure GET request method. This API allows you to submit structured lead data and ensures safe, validated, and efficient data handling.</p>

                            <hr>
                            <h4><i class="fa fa-link text-success"></i> API Endpoint Information</h4>
                            <ul>
                                <li><strong>🔗 Endpoint:</strong> <code><?php echo DOMAIN; ?>/api/getRecords.php</code></li>
                                <li><strong>📤 Method:</strong> GET</li>
                                <li><strong>🔐 Authentication Key:</strong> <code><?php echo SECURE(APP_NAME, "e"); ?></code> (Passed as a parameter)</li>
                                <li><strong>📄 Response Format:</strong> JSON</li>
                            </ul>

                            <hr>
                            <h4><i class="fa fa-database text-info"></i> Parameters & Descriptions</h4>
                            <div class="table-container">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>🧩 Parameter</th>
                                            <th>🔠 Type</th>
                                            <th>📌 Required</th>
                                            <th>📏 Max Length</th>
                                            <th>📝 Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>authentication_key</td>
                                            <td>String</td>
                                            <td>Yes</td>
                                            <td>-</td>
                                            <td>Encrypted API Key for authentication</td>
                                        </tr>
                                        <tr>
                                            <td>leads_full_name</td>
                                            <td>String</td>
                                            <td>Yes</td>
                                            <td>100</td>
                                            <td>Lead's complete name</td>
                                        </tr>
                                        <tr>
                                            <td>leads_phone_number</td>
                                            <td>String</td>
                                            <td>Yes</td>
                                            <td>15</td>
                                            <td>Primary contact number (10–15 digits)</td>
                                        </tr>
                                        <tr>
                                            <td>leads_alternate_phone</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>15</td>
                                            <td>Secondary contact number</td>
                                        </tr>
                                        <tr>
                                            <td>leads_email_id</td>
                                            <td>Email</td>
                                            <td>No</td>
                                            <td>100</td>
                                            <td>Valid email address</td>
                                        </tr>
                                        <tr>
                                            <td>leads_gender</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>10</td>
                                            <td>Gender value: Male, Female, Other</td>
                                        </tr>
                                        <tr>
                                            <td>leads_type</td>
                                            <td>String</td>
                                            <td>Yes</td>
                                            <td>50</td>
                                            <td>Lead category (e.g., LEAD, DATA)</td>
                                        </tr>
                                        <tr>
                                            <td>leads_source</td>
                                            <td>String</td>
                                            <td>Yes</td>
                                            <td>100</td>
                                            <td>Source name (e.g., 99ACRES, Housing)</td>
                                        </tr>
                                        <tr>
                                            <td>leads_re_source</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>100</td>
                                            <td>Referring person/agency name</td>
                                        </tr>
                                        <tr>
                                            <td>leads_entry_type</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>50</td>
                                            <td>Entry classification (e.g., PAID-API, FREE-API)</td>
                                        </tr>
                                        <tr>
                                            <td>leads_projects_name</td>
                                            <td>String</td>
                                            <td>Yes</td>
                                            <td>100</td>
                                            <td>Related project name</td>
                                        </tr>
                                        <tr>
                                            <td>leads_remarks</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>500</td>
                                            <td>Free-text notes or remarks</td>
                                        </tr>
                                        <tr>
                                            <td>leads_date_of_birth</td>
                                            <td>Date</td>
                                            <td>No</td>
                                            <td>-</td>
                                            <td>Format: YYYY-MM-DD</td>
                                        </tr>
                                        <tr>
                                            <td>budgets</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>50</td>
                                            <td>Budget range or estimate</td>
                                        </tr>
                                        <tr>
                                            <td>location</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>100</td>
                                            <td>Preferred property location</td>
                                        </tr>
                                        <tr>
                                            <td>duration</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>50</td>
                                            <td>Duration of interest (e.g., 6 months)</td>
                                        </tr>
                                        <tr>
                                            <td>property_type</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>50</td>
                                            <td>Options: RESIDENTIAL, COMMERCIAL, VILLA</td>
                                        </tr>
                                        <tr>
                                            <td>tags</td>
                                            <td>String</td>
                                            <td>No</td>
                                            <td>200</td>
                                            <td>Descriptive tags (e.g., 3BHK, 500 Sqft)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <h4><i class="fa fa-terminal text-warning"></i> Example API Request</h4>
                            <p>Here is an example of how to structure your GET request:</p>
                            <code><code><?php echo DOMAIN; ?>/api/getRecords.php?authentication_key=<?php echo SECURE(APP_NAME, "e"); ?>&leads_full_name=John+Doe&leads_phone_number=9876543210&leads_type=LEAD&leads_source=Website&leads_projects_name=LuxuryHeights</code></code>

                            <hr>
                            <h4><i class="fa fa-code text-danger"></i> JSON Response Examples</h4>
                            <br>
                            <h5>✅ Success Response (HTTP 201)</h5>
                            <code>
                                {<br>
                                "status": "success",<br>
                                "message": "Lead created successfully",<br>
                                "data": { "leads_id": 123 }<br>
                                }
                            </code>
                            <hr>
                            <h5>❌ Error Response (HTTP 400/401/500)</h5>
                            <code>
                                {<br>
                                "status": "error",<br>
                                "message": "Validation errors",<br>
                                "data": ["Field leads_full_name is required"]<br>
                                }<br>
                            </code>

                            <hr>
                            <h4><i class="fa fa-shield-alt text-secondary"></i> Security Best Practices</h4>
                            <ul>
                                <li>✅ Use HTTPS for all requests.</li>
                                <li>🔐 Keep your <code>authentication_key</code> confidential.</li>
                                <li>🧹 Inputs are validated and sanitized to prevent SQL injection.</li>
                                <li>🛡️ Parameterized queries are enforced for secure DB access.</li>
                            </ul>

                            <hr>
                            <h3 class="app-heading"><i class="fa fa-magic text-success"></i> Generated API URL</h3>
                            <p>Use the following generated template and update the parameter values as required:</p>

                            <div class="input-group">
                                <textarea class="form-control small form-control-sm" id="apiRequest" rows="6" readonly><?php echo DOMAIN; ?>/api/getRecords.php?authentication_key=<?php echo SECURE(APP_NAME, "e"); ?>&leads_full_name=&leads_phone_number=&leads_alternate_phone=&leads_email_id=&leads_gender=&leads_type=LEAD&leads_source=&leads_re_source=&leads_entry_type=&leads_projects_name=&leads_remarks=&leads_date_of_birth=&budgets=&location=&duration=&property_type=&tags=</textarea>
                            </div>
                            <br>
                            <button class="btn btn-success btn-sm" type="button" onclick="copyToClipboard()"><i class="fa fa-copy text-warning"></i> Copy API URL</button>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Hidden div for print content -->
        <div id="printableContent" style="display: none;"></div>

    </main><!-- End #main -->

    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>

    <script>
        // Copy to clipboard function (retained from original)
        function copyToClipboard() {
            var copyText = document.getElementById("apiRequest");
            copyText.select();
            document.execCommand("copy");
            alert("Copied to clipboard!");
        }

        // Print content extraction for specific card-body
        window.addEventListener('beforeprint', function() {
            const cardBody = document.getElementById('printableCardBody');
            const printDiv = document.getElementById('printableContent');
            if (cardBody && printDiv) {
                // Copy the exact HTML content of the specified card-body
                printDiv.innerHTML = cardBody.innerHTML;
                printDiv.style.display = 'block';
                document.body.appendChild(printDiv);
            }
        });

        window.addEventListener('afterprint', function() {
            const printDiv = document.getElementById('printableContent');
            if (printDiv) {
                printDiv.style.display = 'none';
                printDiv.innerHTML = '';
            }
        });
    </script>

</body>

</html>