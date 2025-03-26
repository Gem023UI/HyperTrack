@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Product List</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">➕ Add Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="align-middle">{{ $product->name }}</td>
                <td class="align-middle">{{ $product->description ?? 'No description' }}</td>
                <td class="align-middle">${{ number_format($product->price, 2) }}</td>
                <td class="align-middle">{{ $product->stock }}</td>
                <td class="align-middle">
                    @if ($product->images->isNotEmpty())
                        <div class="d-flex">
                            @foreach ($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                                     class="img-fluid rounded me-2" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td class="align-middle text-center">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                        ✏️ Edit
                    </a>
                    
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                          class="d-inline" 
                         onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">🗑️ Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
