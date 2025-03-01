<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositaries\Cart\CartRepositary;
use App\Repositaries\Cart\CartModelRepositary;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepositary::class, function () {
            return new CartModelRepositary();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
