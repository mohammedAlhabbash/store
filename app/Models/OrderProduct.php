<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'product_name' => $this->product_name
        ]);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
