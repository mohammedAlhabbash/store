<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index() {}
    public function view(Product $product)
    {
        if ($product->status != 'active') {
            abort(404);
        }
        return view('fornt-pages.show', compact('product'));
    }
}
