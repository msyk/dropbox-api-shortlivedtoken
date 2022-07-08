# dropbox-api-shortlivedtoken
Sample implementation of generating access token from refresh token with spatie/dropbox-api.

by Masayuki Nii (nii@msyk.net)

The ['spatie/dropbox-api'](https://github.com/spatie/dropbox-api) is one of the PHP library for Dropbox API.
The access token for authentication was just simple, but at mid-2021 it was changed. The access token terns to deactivate in short-lived period, and we have to regenerate it from the refresh token periodically. The refreshing feature is not implemented on 'spatie/dropbox-api' because it's not scope of the library from the descriptions on discussion board. This repository is the sample implementation of refreshing access tokens. In the readme page of 'spatie/dropbox-api' describes about AutoRefreshingDropBoxTokenService class, and here is the example of AutoRefreshingDropBoxTokenService class.

## How to try here
- Create Dropbox App on the Dropbox App Console. (https://dropbox.com/developers/)
- Generate refresh token. (ex. https://towardsdev.com/dropbox-api-short-lived-tokens-and-refresh-tokens-spring-java-application-fc7264dcdcbd)
- ```composer update```
- Copy the credential_must_exists.php to credentials.php and fill it. You require to set the AppKey, AppSecret, Refresh Token, and file path to store the access token.
- Do the index.php. (ex. ```php -S localhost:9000``` and open that url with any browser)

## Integrate your solutions

You can install the package via composer:

```composer require msyk/dropbox-api-shortlivedtoken```

Or you can describe in the 'require' section of the composer.json file

The operations for your Dropbox area is the same way of 'spatie/dropbox-api', as like below.
The Clinet class is coming from 'spatie/dropbox-api'.
The AutoRefreshingDropBoxTokenService class has 4 parameter constructor.
The cached access token is going to store the path in $tokenFilePath,
so it must be a writable directory and file.

```
use Spatie\Dropbox\Client;
use msyk\DropboxAPIShortLivedToken\AutoRefreshingDropBoxTokenService;
try {
    $tokenProvider = new AutoRefreshingDropBoxTokenService($refreshToken, $appKey, $appSecret, $tokenFilePath);
    $client = new Client($tokenProvider);
    $list = $client->listFolder("/");
} catch (\Exception $ex) {
    var_export($ex->getMessage()); // Very simple output.
}
var_export($list); // Very simple output.
```

## Acknowledgements

Thanks for the creators and committers of ['spatie/dropbox-api'](https://github.com/spatie/dropbox-api).
