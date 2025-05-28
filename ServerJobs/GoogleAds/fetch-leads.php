<?php
$config = require 'google-config.php';
require_once 'refresh-token.php';

$tokens = json_decode(file_get_contents('tokens.json'), true);

if (empty($tokens['access_token']) || time() > ($tokens['created_at'] + $tokens['expires_in'])) {
    $newToken = refreshAccessToken($tokens['refresh_token'], $config);
    $tokens = array_merge($tokens, $newToken);
    file_put_contents('tokens.json', json_encode($tokens));
}

$accessToken = $tokens['access_token'];
$developerToken = $config['developer_token'];
$customerId = $config['customer_id'];

$query = "SELECT lead_form_submission_data.lead_form_id, lead_form_submission_data.resource_name, lead_form_submission_data.submitted_at_date_time, lead_form_submission_data.lead_data FROM lead_form_submission_data ORDER BY lead_form_submission_data.submitted_at_date_time DESC";

$ch = curl_init("https://googleads.googleapis.com/v14/customers/$customerId/googleAds:searchStream");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode(['query' => $query]),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken",
        "developer-token: $developerToken",
        "Content-Type: application/json",
    ],
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// Dump leads or save to DB
echo "<pre>";
print_r($data);
echo "</pre>";
