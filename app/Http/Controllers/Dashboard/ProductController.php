<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::
            // with(['category', 'store'])
            join('stores', 'stores.id', '=', 'products.store_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select([
                'products.*',
                'stores.name as store_name',
                'categories.name as category_name'
            ])
            ->paginate(5);
        // dd($products);
        return view('Dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $product = Product::where('slug', '=', $slug)->first();
        $categories = Category::all();
        $stores = Store::all();
        $tags = $product->tags()->pluck('name')->toArray();
        $tags_name = implode(',', $tags);
        return view('Dashboard.products.edit', compact('product', 'categories', 'stores', 'tags_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('tag'));
        $tags = Tag::all()->pluck('id', 'name')->toArray();
        $r_tags = explode(',', $request->tag);
        $t_ids = [];
        foreach ($r_tags as $r_tag) {
            if (!in_array($r_tag, array_keys($tags))) {
                $slug = Str::slug($r_tag);
                $tag = Tag::create([
                    'name' => $r_tag,
                    'slug' => $slug
                ]);
                $t_ids[] = $tag->id;
            } else {
                $t_ids[] = $tags[$r_tag];
            }
        }
        $product->tags()->sync($t_ids);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
