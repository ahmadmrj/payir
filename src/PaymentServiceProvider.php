<?php

namespace Ahmadmrj\Payir;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Payir', function ($app) {
            return new Payir;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Payment');
    }
}
