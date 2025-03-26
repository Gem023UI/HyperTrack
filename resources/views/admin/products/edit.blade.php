@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Edit Product</h1>
    
    <div class="card p-4 shadow-sm">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Product Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price ($):</label>
                <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock:</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Product Image:</label>
                <div>
                    <img src="{{ asset('uploads/' . $product->image) }}" alt="Product Image" class="img-fluid rounded mb-2" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload New Image (Optional):</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success">💾 Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Back to Products</a>
        </form>
    </div>
</div>
@endsection
