<?php

namespace Siaoynli\AliCloud\Sms;

use Illuminate\Support\ServiceProvider;

class LaravelAliCloudSmsServerProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sms', function ($app) {
            return new Sms($app['config']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/alicloud-sms.php' => config_path('alicloud-sms.php'),
        ]);
    }

    public function provides()
    {
        return ['sms'];
    }

}
