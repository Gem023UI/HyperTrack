@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4 text-gray-800">Product List</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">➕ Add Product</a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body bg-light">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="brand_id" class="form-label text-gray-700">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-select">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brand }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type_id" class="form-label text-gray-700">Type</label>
                    <select name="type_id" id="type_id" class="form-select">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="min_price" class="form-label text-gray-700">Min Price</label>
                    <input type="number" name="min_price" id="min_price" class="form-control" 
                           value="{{ request('min_price') }}" placeholder="Min">
                </div>
                <div class="col-md-2">
                    <label for="max_price" class="form-label text-gray-700">Max Price</label>
                    <input type="number" name="max_price" id="max_price" class="form-control" 
                           value="{{ request('max_price') }}" placeholder="Max">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover border">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3">Product Name</th>
                    <th class="py-3">Brand</th>
                    <th class="py-3">Type</th>
                    <th class="py-3">Description</th>
                    <th class="py-3">Price</th>
                    <th class="py-3">Stock</th>
                    <th class="py-3">Images</th>
                    <th class="py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="align-middle">
                    <td class="text-gray-800 fw-medium">{{ $product->name }}</td>
                    <td>
                        @if($product->brand)
                            <span class="badge bg-primary text-white">{{ $product->brand->brand }}</span>
                        @else
                            <span class="text-gray-600">No Brand</span>
                        @endif
                    </td>
                    <td>
                        @if($product->type)
                            <span class="badge bg-info text-white">{{ $product->type->type }}</span>
                        @else
                            <span class="text-gray-600">No Type</span>
                        @endif
                    </td>
                    <td class="text-gray-700">{{ Str::limit($product->description ?? 'No description', 50) }}</td>
                    <td class="text-success fw-bold">${{ number_format($product->price, 2) }}</td>
                    <td class="{{ $product->stock > 0 ? 'text-gray-800' : 'text-danger' }} fw-medium">
                        {{ $product->stock }}
                    </td>
                    <td>
                        @if ($product->images->isNotEmpty())
                            <div class="d-flex flex-wrap">
                                @foreach ($product->images as $image)
                                    @if (Storage::disk('public')->exists($image->image_path))
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                                             class="img-thumbnail me-2 mb-2"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/placeholder.png') }}" alt="No Image Found"
                                             class="img-thumbnail me-2 mb-2"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-600">No Image</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="btn btn-sm btn-warning text-white">
                                ✏️ Edit
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">🗑️ Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .text-gray-800 {
        color: #2d3748;
    }
    .text-gray-700 {
        color: #4a5568;
    }
    .text-gray-600 {
        color: #718096;
    }
    body {
        background-color: #f8f9fa;
    }
    .table {
        background-color: white;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endsection