@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Buy Now - {{ $product->name }}</h2>

    <div class="card shadow-sm">
        <!-- Product Image or Carousel -->
        @if ($product->images->isNotEmpty())
            <div id="carousel-checkout-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($product->images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 class="d-block w-100 rounded-top" 
                                 style="height: 300px; object-fit: cover;" 
                                 alt="Product Image">
                        </div>
                    @endforeach
                </div>
                @if ($product->images->count() > 1)
                    <button class="carousel-control-prev" type="button" 
                            data-bs-target="#carousel-checkout-{{ $product->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" 
                            data-bs-target="#carousel-checkout-{{ $product->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        @else
            <img src="{{ asset('images/no-image.png') }}" 
                 class="card-img-top" 
                 style="height: 300px; object-fit: cover;" 
                 alt="No Image Available">
        @endif
        
        <div class="row justify-content-center">
            <div class="card-body">
                <h4 class="card-title">{{ $product->name }}</h4>
                <p class="card-text text-muted">{{ $product->description ?? 'No description available' }}</p>
                <h5 class="text-primary mb-4">Price: ${{ number_format($product->price, 2) }}</h5>
    
                <form method="POST" action="{{ route('purchases.process', $product->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" 
                               class="form-control" min="1" value="1" required>
                        @error('quantity')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
