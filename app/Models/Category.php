<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault(
            [
                'name'=>'-'
            ]
        );
    }

    public static function rules($id = 0)
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('categories', 'name')->ignore($id)], //unique:categories,name,$id
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => ['image', 'dimensions:min_width=100,min_height=100'],
            'status' => ['in:active,archived'],
        ];
    }
}
