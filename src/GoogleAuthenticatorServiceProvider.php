<?php

namespace tanchengjin\LaravelAdmin\Google\GoogleAuthenticator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use tanchengjin\LaravelAdmin\Google\GoogleAuthenticator\Http\Controllers\GoogleAuthenticatorController;

class GoogleAuthenticatorServiceProvider extends ServiceProvider
{
    protected $commandName = 'google:secret';

    /**
     * {@inheritdoc}
     */
    public function boot(GoogleAuthenticator $extension)
    {
        if (!config('admin.extensions.t-laravel-admin-google-authenticator.enable', true)) {
            return;
        }

        if (!GoogleAuthenticator::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-google-authenticator');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes([
                __DIR__ . '/../resources/lang/zh-CN/google-auth.php' => resource_path('lang/zh-CN/google-auth.php'),
                __DIR__ . '/../resources/lang/en/google-auth.php' => resource_path('lang/en/google-auth.php')
            ], 'lang');
        }

        #引入路由
        $this->app->booted(function () {
            GoogleAuthenticator::routes(__DIR__ . '/../routes/web.php');
        });

        //绑定google 令牌路由
        $this->app['router']->get('googleAuthenticator', GoogleAuthenticatorController::class . '@test');

        #生成google令牌 secret
        $this->generateSecret(GoogleAuthenticatorController::getGoogleAuthenticatorSecret());

    }

    private function generateSecret($value, $key = 'google_authenticator_secret')
    {
        Artisan::command($this->commandName, function () use ($value, $key) {
            $envPath = base_path('.env');

            if (file_exists($envPath)) {
                if (!$envValue = env($key)) {
                    file_put_contents($envPath, $envValue . '=' . $value, FILE_APPEND);
                } else {
                    file_put_contents($envPath,str_replace(
                        $envValue,
                        $value,
                        file_get_contents($envPath)
                    ));
                }
            }
        });
    }
}
