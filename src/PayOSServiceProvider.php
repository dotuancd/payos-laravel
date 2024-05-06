<?php

namespace PayOS\Laravel;

use Illuminate\Support\ServiceProvider;
use PayOS\PayOS;

class PayOSServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        $this->loadRoutesFrom(__DIR__ . '/Http/Routes.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/payos.php', 'payos');
        $this->publishes([
            __DIR__ . '/../config/payos.php' => config_path('payos.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/payos'),
        ]);

        $this->app->bind(PayOS::class, function ($app) {
            $config = $app['config']->get('payos');

            $clientId = $config->get('client_id');
            $apiKey = $config->get('api_key');
            $checksumKey = $config->get('checksum_key');

            return new PayOS(
                $clientId,
                $apiKey,
                $checksumKey
            );
        });

        $this->app->alias(PayOS::class, 'payos');
    }
}
