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
        $this->app->bind('Payment', function ($app) {
            return new Payment;
        });
    }
}
