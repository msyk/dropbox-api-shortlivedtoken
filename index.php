<?php

namespace msyk\DropboxAPIShortLivedToken;

require_once __DIR__ . '/vendor/autoload.php';

use msyk\DropboxAPIShortLivedToken\AutoRefreshingDropBoxTokenService;

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
    $tokenProvider = new AutoRefreshingDropBoxTokenService($refreshToken, $appKey, $appSecret);
    // List the items on the root of your dropbox with spatie/dropbox-api
    $client = new Client($tokenProvider);
    $list = $client->listFolder("/");
} catch (\Exception $ex) {
    var_export($ex->getMessage()); // Very simple output.
}
var_export($list); // Very simple output.