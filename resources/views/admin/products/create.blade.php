@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Add Product</h1>
    <div class="card p-4 shadow-sm">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Product Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter product description (optional)"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price ($):</label>
                <input type="number" name="price" class="form-control" step="0.01" placeholder="Enter price" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock:</label>
                <input type="number" name="stock" class="form-control" placeholder="Enter stock quantity" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Images:</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">You can upload multiple images at once.</small>
            </div>

            <button type="submit" class="btn btn-primary">➕ Add Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Back to Products</a>
        </form>
    </div>
</div>
@endsection
