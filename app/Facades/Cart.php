<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositaries\Cart\CartRepositary;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartRepositary::class;
    }
}
