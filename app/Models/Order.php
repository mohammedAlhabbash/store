<?php

namespace App\Models;

use App\Models\User;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'guest'
        ]);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(OrderProduct::class)
            ->as('detalis')
            ->withPivot(['product_name', 'price', 'quantity','options']);
    }

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextNumber($order);
        });
    }
    public static function getNextNumber(Order $order)
    {
        $number = $order->whereYear('created_at', Carbon::now()->year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return Carbon::now()->year . '0001';
    }
    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->whereType('billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->whereType('shipping');
    }
}
