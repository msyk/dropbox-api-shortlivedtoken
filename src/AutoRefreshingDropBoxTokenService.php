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
        // Get the access token from refresh token. Referred from https://www.softel.co.jp/blogs/tech/archives/7067
        $data = http_build_query(['grant_type' => 'refresh_token', 'refresh_token' => $this->refreshToken,], '', '&');
        $options = [
            'http' => [
                'ignore_errors' => true, 'method' => 'POST',
                'header' => [
                    'Content-type: application/x-www-form-urlencoded',
                    'Authorization: Basic ' . base64_encode($this->appKey . ':' . $this->appSecret),
                ],
                'content' => $data,
            ],
        ];
        $context = stream_context_create($options);
        $response = json_decode(file_get_contents('https://api.dropbox.com/oauth2/token', false, $context));
        return $response->access_token;
    }
}