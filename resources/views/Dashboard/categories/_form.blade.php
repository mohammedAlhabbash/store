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
    <x-form.input label="Category Name" type="text" name="name" :value="$category->name" />

</div>
<div class="form-group">
    <x-form.select name="parent_id" :value="$category->parent_id" :parents="$parents" label="Parent" defualtName="Primary Category" />
</div>
<div class="form-group">
    <x-form.textarea name='describtion' :value="$category->describtion" label="Description" />
</div>
<div class="form-group">
    <label for="">Image</label>
    <x-form.input type="file" name="image" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" style="object-fit: cover;" width="100px"
            height="100px">
    @endif
</div>
<div class="form-group">
    <x-form.radio label="Status" name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $button_label ?? 'Save' }}</button>
</div>
