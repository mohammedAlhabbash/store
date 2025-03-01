@if ($errors->any())
    <div class="alert alert-danger">
        <h2>Error Occured!</h2>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form.input label="Product Name" type="text" name="name" :value="$product->name" />
</div>
{{-- <div class="form-group">
    <x-form.select name="category_id" :value="$product->category_id" :parents="$categories" label="Category"
        defualtName="Primary Category" />
</div> --}}
<div class="form-group">
    <x-form.select name="store_id" :value="$product->store_id" :parents="$stores" label="Store" defualtName="Store" />
</div>
<div class="form-group">
    <x-form.input label="Tag Name" type="text" name="tag" :value="$tags_name" />{{-- :value="$product->tags->name" --}}
</div>
<div class="form-group">
    <x-form.textarea name='describtion' :value="$product->describtion" label="Description" />
</div>
<div class="form-group">
    <x-form.input label="Price" type="text" name="price" :value="$product->price" />
</div>
<div class="form-group">
    <x-form.input label="Rating" type="text" name="rating" :value="$product->rating" />
</div>

{{-- <div class="form-group">
    <label for="">Image</label>
    <x-form.input type="file" name="image" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" style="object-fit: cover;" width="100px"
            height="100px">
    @endif
</div> --}}
<div class="form-group">
    <x-form.radio label="Status" name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $button_label ?? 'Save' }}</button>
</div>
