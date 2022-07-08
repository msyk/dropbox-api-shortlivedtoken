<?php

// You can copy this file and rename to 'credentials.php'.
// After that, you can edit the credentials.php file, and fill keys and token as below.

$appKey = 'Your App Key';
$appSecret = 'Your App Secret';
$refreshToken = 'Your Refrech Token';

// The short-lived access token is going to store this file.
// This file must be writable for the web server process, also care for security.
$tokenFilePath = "/tmp/access_token.txt";