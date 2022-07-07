<?php

namespace msyk\DropboxAPIShortLivedToken;

require_once __DIR__ . '/vendor/autoload.php';

// Check the existence of the credentials.php file, and include it.
$credFile = __DIR__ . '/credentials.php';
if (!file_exists($credFile)) {
    echo "You have to set up the 'credentials.php' file. The template of it is 'credentials_must_exists.php',";
    echo "and you can fill keys and refresh token in it.";
    exit;
}
require_once $credFile;

use Spatie\Dropbox\Client;

try {
    // Get the access token from refresh token. Referred from https://www.softel.co.jp/blogs/tech/archives/7067
    $data = http_build_query(['grant_type' => 'refresh_token', 'refresh_token' => $refreshToken,], '', '&');
    $options = [
        'http' => [
            'ignore_errors' => true, 'method' => 'POST',
            'header' => [
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode($appKey . ':' . $appSecret),
            ],
            'content' => $data,
        ],
    ];
    $context = stream_context_create($options);
    $response = json_decode(file_get_contents('https://api.dropbox.com/oauth2/token', false, $context));
    $accessKey = $response->access_token;
    ////////////////////////////////////////////////

    // List the items on the root of your dropbox with spatie/dropbox-api
    $client = new Client($accessKey);
    $list = $client->listFolder("/");
} catch (\Exception $ex) {
    var_export($ex->getMessage()); // Very simple output.
}
var_export($list); // Very simple output.