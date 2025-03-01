<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);
            }
        });
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, //related model
            'product_tag', //pivot table name
            'product_id', //fk in pivot table for the current model
            'tag_id', //fk in pivot table for the related model
            'id', //pk for current model
            'id' //pk for related model
        );
    }
    public function scopeActive(Builder $q)
    {
        $q->where('status', '=', 'active');
    }
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['https://', 'http://'])) {
            return $this->image;
        }
        return asset('storage/', '.', $this->image);
    }
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price));
    }
}
