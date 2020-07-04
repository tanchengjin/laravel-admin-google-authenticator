Laravel-admin Captcha Extension
======
### Intro
可在laravel-admin中使用谷歌身份认证，安全快捷的使用令牌进行登录

### install
````
composer require tanchengjin/laravel-admin-google-authenticator
````

### Generate Secret 
##### 此操作将在.env中生成secret用于绑定令牌
google_authenticator_secret=
````
php artisan google:secret
````

### configuration
````
'extensions' => [
't-laravel-admin-google-authenticator' => [
    'enable' => true,
    #谷歌令牌secret
    'secret' => env('google_authenticator_secret', ''),
],
],
````

### publish language
````
php artisan vendor:publish --provider=tanchengjin\LaravelAdmin\Google\Authenticator\GoogleAuthenticatorServiceProvider
````
