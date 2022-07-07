<?php

namespace msyk\DropboxAPIShortLivedToken;

use Spatie\Dropbox\TokenProvider;

class AutoRefreshingDropBoxTokenService implements TokenProvider
{
    private $refreshToken;
    private $appKey;
    private $appSecret;

    public function __construct($refreshToken, $appKey, $appSecret)
    {
        $this->refreshToken = $refreshToken;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    public function getToken(): string
    {
        $dropboxClient = new DropboxClientModified([$this->appKey, $this->appSecret]);
        $response = $dropboxClient->authRequest('token',
            ['grant_type' => 'refresh_token', 'refresh_token' => $this->refreshToken,]);
        return $response['access_token'];
    }
}