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

            <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                         <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" 
                     {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->brand }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="type_id">Type</label>
                    <select name="type_id" id="type_id" class="form-control">
                        <option value="">Select Type</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" 
                                {{ old('type_id', $product->type_id ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
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
                    @foreach ($product->images as $img)
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="img-thumbnail mb-2" width="120">
                    @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label">Upload New Image (Optional):</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
            </div>

            <button type="submit" class="btn btn-success">💾 Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Back to Products</a>
        </form>
    </div>
</div>
@endsection
