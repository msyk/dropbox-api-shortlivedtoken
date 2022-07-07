# dropbox-api-shortlivedtoken
Sample implementation of generating access token from refresh token with spatie/dropbox-api.

by Masayuki Nii (nii@msyk.net)

## How to use
- Create Dropbox App on the Dropbox App Console. (https://dropbox.com/developers/)
- Generate refresh token. (ex. https://towardsdev.com/dropbox-api-short-lived-tokens-and-refresh-tokens-spring-java-application-fc7264dcdcbd)
- ```composer update```
- Copy the credential_must_exists.php to credentials.php and filli it.
- Do the index.php. (ex. ```php -S localhost:9000``` and open that url with any browser)