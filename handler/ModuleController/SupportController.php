<?php
require_once __DIR__ . "/../../acm/SysFileAutoLoader.php";
require_once __DIR__ . "/../../acm/SystemReqHandler.php";
require_once __DIR__ . "/../../handler/AuthController/AuthAccessController.php";

if (isset($_POST["SendSupportRequest"])) {
  $FullName = $_POST["FullName"];
  $EmailId = $_POST["EmailId"];
  $PhoneNumber = $_POST["PhoneNumber"];
  $company = $_POST["company"];
  $Support_Topic = $_POST["Support_Topic"];
  $Message = $_POST["Message"];
  $SendTo = "gauravsinghigc@gmail.com";

  $Response = array("status" => false, "message" => "");

  // Email to Support Person (Gaurav Singh)
  $subject_support = "Support Query: $Support_Topic - " . "($company)";
  $headers_support = "MIME-Version: 1.0" . "\r\n";
  $headers_support .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers_support .= "From: no-reply@" . HOST . "\r\n";
  $headers_support .= "Reply-To: $EmailId" . "\r\n";

  $message_support = "
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; color: #333; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
    .header { background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
    .content { padding: 20px; }
    .footer { text-align: center; font-size: 12px; color: #777; padding: 10px; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <div class='container'>
    <div class='header'>
      <h2>New Support Query Received</h2>
    </div>
    <div class='content'>
      <p><span class='label'>Dear <b>Gaurav Singh</b>,</span></p>
      <p>A new support query has been submitted with the following details:</p>
      <p><span class='label'>Full Name:</span> $FullName</p>
      <p><span class='label'>Email:</span> $EmailId</p>
      <p><span class='label'>Phone Number:</span> $PhoneNumber</p>
      <p><span class='label'>Company:</span> $company</p>
      <p><span class='label'>Support Topic:</span> $Support_Topic</p>
      <p><span class='label'>Message:</span><br>$Message</p>
      <p>Please review and take appropriate action.</p>
    </div>
    <div class='footer'>
      <p>&copy; " . date("Y") . " - " . DEVELOPED_BY . " | All rights reserved.</p>
    </div>
  </div>
</body>
</html>
";

  // Email to User (Acknowledgment)
  $subject_user = "Thank You for Your Support Query" . "(" . DEVELOPED_BY . ")";
  $headers_user = "MIME-Version: 1.0" . "\r\n";
  $headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers_user .= "From: noreply@" . HOST . "\r\n";
  $headers_user .= "Reply-To: $SendTo" . "\r\n";

  $message_user = "
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; color: #333; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
    .header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
    .content { padding: 20px; }
    .footer { text-align: center; font-size: 12px; color: #777; padding: 10px; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <div class='container'>
    <div class='header'>
      <h2>Thank You for Reaching Out!</h2>
    </div>
    <div class='content'>
      <p><span class='label'>Dear $FullName,</span></p>
      <p>Thank you for sharing your valuable feedback and query with us. We have received your request regarding <strong>$Support_Topic</strong>.</p>
      <p>Our team is reviewing your message and will get back to you as soon as possible. If needed, we may contact you at <strong>$PhoneNumber</strong> or <strong>$EmailId</strong> for further details.</p>
      <p>We appreciate your patience and understanding.</p>
      <p>Best regards,<br>Support Team<br>" . DEVELOPED_BY . "</p>
    </div>
    <div class='footer'>
      <p>Coprighted &copy; " . date("Y") . "- " . DEVELOPED_BY . " | All rights reserved.</p>
    </div>
  </div>
</body>
</html>
";

  // Send emails and check status
  $mail_support_sent = mail($SendTo, $subject_support, $message_support, $headers_support);
  $mail_user_sent = mail($EmailId, $subject_user, $message_user, $headers_user);

  if ($mail_support_sent && $mail_user_sent) {
    $Response = true;
  } else {
    $Response = false;
  }

  RequestHandler($Response, [
    "true" => "Support Query and Details are send successfully!",
    "false" => "Failed to send support query details at the moment!"
  ]);
}
