<?php
$config = require 'google-config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $postData = [
        'code' => $code,
        'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret'],
        'redirect_uri' => $config['redirect_uri'],
        'grant_type' => 'authorization_code',
    ];

    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    $response = curl_exec($ch);
    curl_close($ch);

    $tokenInfo = json_decode($response, true);

    if (!empty($tokenInfo['access_token'])) {
        file_put_contents('tokens.json', json_encode($tokenInfo));
        echo "Access token saved successfully.";
    } else {
        echo "Error: " . $response;
    }
}
