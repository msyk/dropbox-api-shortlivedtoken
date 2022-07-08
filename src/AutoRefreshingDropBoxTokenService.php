<?php

namespace msyk\DropboxAPIShortLivedToken;

use GuzzleHttp\Exception\ClientException;
use Spatie\Dropbox\RefreshableTokenProvider;

class AutoRefreshingDropBoxTokenService implements RefreshableTokenProvider
{
    private $refreshToken;
    private $appKey;
    private $appSecret;
    private $filePath;

    public function __construct($refreshToken = '', $appKey = '', $appSecret = '', $path = '')
    {
        $this->refreshToken = $refreshToken;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->filePath = $path;
    }

    public function setRefreshToken($refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    public function setAppKey($appKey): void
    {
        $this->appKey = $appKey;
    }

    public function setAppSecret($appSecret): void
    {
        $this->appSecret = $appSecret;
    }

    public function setFilePath($path): void
    {
        $this->filePath = $path;
    }

    public function getToken(): string
    {
        $token = '';
        if (file_exists($this->filePath)) {
            $token = trim(file_get_contents($this->filePath));
        }
        return $token;
    }

    public function refresh(ClientException $exception): bool
    {
        $dropboxClient = new DropboxClientModified([$this->appKey, $this->appSecret]);
        $response = $dropboxClient->authRequest('token',
            ['grant_type' => 'refresh_token', 'refresh_token' => $this->refreshToken,]);
        if (!file_exists($this->filePath)) {
            if (!is_writable(dirname($this->filePath))) {
                return false;
            }
        } else if (!is_writable($this->filePath)) {
            return false;
        }
        if (!isset($response['access_token'])) {
            return false;
        }
        file_put_contents($this->filePath, $response['access_token']);
        return true;
    }
}