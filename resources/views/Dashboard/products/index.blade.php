@extends('layouts.dashboard')

@section('content')
    <div class="content-header">
        <x-alert type="success" />
        <x-alert type="info" />
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('products.index') }}">
                        <h1 class="m-0">Products</h1>
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="mb-5">
            {{-- @if (Request::url() == route('category.trashed'))
                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-primary"> Categories</a>
            @else
                <a href="{{ route('category.trashed') }}" class="btn btn-sm btn-outline-primary">Trashed Category</a>
            @endif
            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-primary">Create Category</a> --}}
        </div>
        {{-- @if (Request::url() == route('products.index')) --}}
            <form action="{{ route('products.index') }}" method="GET" class="d-flex justify-content-between mb-4">
                <x-form.input name="name" placeholder="Name" :value="request('name')" class="mx-2" />
                <select name="status" class="form-control mx-2">
                    <option value="">Status</option>
                    <option value="active" @selected(request('status') == 'active')>Active</option>
                    <option value="archived" @selected(request('status') == 'archived')>Archived</option>
                </select>
                <button class="btn btn-dark">Filter</button>
            </form>
        {{-- @endif --}}
        <div class="container-fluid">
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            {{-- <th>Image</th> --}}
                            <th>ID</th>
                            <th>name</th>
                            <th>store</th>
                            <th>category</th>
                            <th>status</th>
                            <th>Created At</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                {{-- <td>
                                    @if ($product->image != null)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                            style="object-fit: cover;" width="70px" height="70px">
                                    @endif
                                </td> --}}
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->store_name }}</td>
                                <td>{{ $product->category_name }}</td>
                                <td>{{ $product->status }}</td>
                                <td>{{ $product->created_at }}</td>
                                {{-- @if (Request::url() == route('categories.index')) --}}
                                    <td style="width:0">
                                        <a class="btn btn-sm btn-outline-warning"
                                            href="{{ route('products.edit', $product->slug) }}">edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('products.destroy', $product->slug) }}" method="POST">
                                            @csrf @method('delete')
                                            <button class="btn btn-sm btn-outline-danger">delete</button>
                                        </form>
                                    </td>
                                {{-- @else --}}
                                    {{-- <td style="width:0">
                                        <form action="{{ route('product.restore', $product->slug) }}" method="POST">
                                            @csrf @method('put')
                                            <button style="border: 0 ; background-color:inherit"
                                                class=" fas fa-trash-restore btn-lg"></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('product.forceDelete', $category->slug) }}" method="POST">
                                            @csrf @method('delete')
                                            <button style="border: 0 ; background-color:inherit"
                                                class="fas fa-trash btn-lg"></button>
                                        </form> --}}
                                    {{-- </td> --}}
                                {{-- @endif --}}
                            </tr>
                        @empty
                            <td> No Product</td>
                        @endforelse

                    </tbody>
                </table>
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
