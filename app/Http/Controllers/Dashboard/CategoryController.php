<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        $categories = Category::with('children')
            // leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')->select([
            //     'categories.*',
            //     'parents.name as parent_name'
            // ])
            ->when($request->query('name') != null, function ($q) {
                $q->where('categories.name', 'like', '%' . request()->query('name') . '%');
            })->when($request->query('status') != null, function ($q) {
                $q->where('categories.status', '=', request()->query('status'));
            })->orderBy('categories.name')->paginate(20);
        // $category = Category::where('id', '=', 36)->get();
        // $p=Product::where('category_id','=',36)->get();
        // dd($p);
        // foreach ($category as $c) {
        //     dd($c->products->name);
        // }
        return view('Dashboard.categories.index', compact('categories'));
    }

    public function showProducts($id)
    {
        return view('Dashboard.categories.show');
    }

    public function showTrashed()
    {
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')->select([
            'categories.*',
            'parents.name as parent_name'
        ])->onlyTrashed()->paginate();

        return view('Dashboard.categories.index', compact('categories'));
    }
    public function restore($slug)
    {
        $restoreCategory = Category::onlyTrashed()->where('slug', '=', $slug)->first();
        $restoreCategory->restore();
        return redirect()->route('categories.index')->with(['success' => 'Restore Success', 'status' => 'success']);
    }
    public function forceDelete($slug)
    {
        $forceDelete = Category::onlyTrashed()->where('slug', '=', $slug)->first();
        if (!$forceDelete) {
            abort(404);
        }
        $forceDelete->forceDelete();
        if ($forceDelete->image) {
            Storage::disk('public')->delete($forceDelete->image);
        }
        return redirect()->route('categories.index')->with(['success' => 'Deleted Successfully', 'status' => 'danger']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::where('parent_id', null)->get();
        $category = new Category();
        return view('Dashboard.categories.add', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // $request->validate(Category::rules());
        $path = $this->uploadImage($request);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name),
            'describtion' => $request->describtion,
            'image' => $path
        ]);
        return redirect()->route('categories.index')->with(['success' => 'Created Successfully', 'status' => 'success']);
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

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->route('categories.index')->with(['info' => 'Not find!']);
        }
        $id = $category->id;
        $parents = Category::where('id', '<>', $id)->where(function ($query) use ($id) {
            $query->whereNull('parent_id')->orWhere('parent_id', '<>', $id);
        })->get();
        // dd($category);
        return view('Dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        // $request->validate(Category::rules($category->id));
        $old_image = $category->image;
        $path = $this->uploadImage($request);
        if ($path == null) {
            $path = $old_image;
        }
        // dd($path);
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name),
            'describtion' => $request->describtion,
            'image' => $path
        ]);
        if ($old_image != $path) { //&& $path != null
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('categories.index')->with(['success' => 'Updated Successfully', 'status' => 'warning']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }
        $category->delete();
        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }
        return redirect()->route('categories.index')->with(['success' => 'Deleted Successfully', 'status' => 'danger']);
    }
    protected function uploadImage(Request $request)
    {

        if (!$request->hasFile('image')) {
            return;
        }
        $image = $request->file('image');
        $path = $image->store('uploads/categories', [
            'disk' => 'public'
        ]);
        return $path;
    }
}
