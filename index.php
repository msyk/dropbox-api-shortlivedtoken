<?php

require_once __DIR__ . '/vendor/autoload.php';

// Check the existence of the credentials.php file, and include it.
$credFile = __DIR__ . '/credentials.php';
$refreshToken = '';
$appKey = '';
$appSecret = '';
$tokenFilePath = '';
if (!file_exists($credFile)) {
    echo "You have to set up the 'credentials.php' file. The template is 'credentials_must_exists.php',";
    echo "and you can fill keys and refresh token in it.";
    exit;
}
require_once $credFile;

use Spatie\Dropbox\Client;
use msyk\DropboxAPIShortLivedToken\AutoRefreshingDropBoxTokenService;

// List the items on the root of your dropbox with spatie/dropbox-api
try {
    $tokenProvider = new AutoRefreshingDropBoxTokenService($refreshToken, $appKey, $appSecret, $tokenFilePath);
    $client = new Client($tokenProvider);
    $list = $client->listFolder("/");
} catch (\Exception $ex) {
    var_export($ex->getMessage()); // Very simple output.
}
var_export($list); // Very simple output.