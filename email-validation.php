<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

function getApiResponse($email, $api_key) {
    $client = new Client();
    $url = 'https://api.emailvalidation.io/v1?email=' . urlencode($email);

    try {
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Accept'        => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), false);
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
        return false;
    }

    return false;
}

echo "Enter an email address: ";
$email = trim(fgets(STDIN));

$api_key = 'ema_live_nll3fY15uIgeaBEJz0n9uGDENbNsgk83U96Wxo8Q';

$email_data = getApiResponse($email, $api_key);

if ($email_data && isset($email_data->deliverable) && $email_data->deliverable) {
    echo "The email address '$email' is valid." . PHP_EOL;
} else {
    echo "The email address '$email' is not valid." . PHP_EOL;
}