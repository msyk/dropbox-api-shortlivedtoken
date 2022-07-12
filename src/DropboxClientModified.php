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

    /*
     * download and downloadZip methods weren't work fine because StreamWrapper::getResource() returns null
     * in spite of the $response->getBody() respond something. So the return process of both method changed
     * as like. These returns the contents of file itself. 2022-7-12 msyk (nii@msyk.net)
     */
    /**
     * Download a file from a user's Dropbox.
     *
     * @param string $path
     *
     * @return string
     *
     * @link https://www.dropbox.com/developers/documentation/http/documentation#files-download
     */
    public function download(string $path)
    {
        $arguments = [
            'path' => $this->normalizePath($path),
        ];

        $response = $this->contentEndpointRequest('files/download', $arguments);

        return $response->getBody()->getContents();
    }

    /**
     * Download a folder from the user's Dropbox, as a zip file.
     * The folder must be less than 20 GB in size and have fewer than 10,000 total files.
     * The input cannot be a single file. Any single file must be less than 4GB in size.
     *
     * @param string $path
     *
     * @return string
     *
     * @link https://www.dropbox.com/developers/documentation/http/documentation#files-download_zip
     */
    public function downloadZip(string $path)
    {
        $arguments = [
            'path' => $this->normalizePath($path),
        ];

        $response = $this->contentEndpointRequest('files/download_zip', $arguments);

        return $response->getBody()->getContents();
    }

}