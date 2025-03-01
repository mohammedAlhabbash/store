<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = [];

    public static function booted()
    {
        // static::addGlobalScope('cookie_id', function (Builder $builder) {
        //   return  $builder->Where('cookie_id', '=', Cart::getCookieId());
        // });
        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid();
            // $cart->cookie_id = Cart::getCookieId();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'user' => 'guest'
        ]);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // protected static function getCookieId()
    // {
    //     $cookie = Cookie::get('cart');
    //     if (!$cookie) {
    //         $cookie = Str::uuid();
    //         Cookie::queue('cart', $cookie, 30 * 24 * 60);
    //     }
    //     return $cookie;
    // }
}
