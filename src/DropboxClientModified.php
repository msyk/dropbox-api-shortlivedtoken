<?php

namespace msyk\DropboxAPIShortLivedToken;

use Spatie\Dropbox\Client;
use GuzzleHttp\Exception\ClientException;

class DropboxClientModified extends Client
{
    public function authRequest(string $uri, array $parameters = null): array
    {
        try {
            $options = [
                'headers' => $this->getHeaders(),
                'Content-type' => 'application/x-www-form-urlencoded',
            ];

            if ($parameters) {
                $options['form_params'] = $parameters;
            }

            $response = $this->client->post("https://api.dropbox.com/oauth2/{$uri}", $options);
        } catch (ClientException $exception) {
            throw $this->determineException($exception);
        }
        return json_decode($response->getBody(), true) ?? [];
    }
}