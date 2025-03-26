@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">🛍️ Our Products</h1>
    
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <!-- Product Image Carousel -->
                    @if ($product->images->isNotEmpty())
                        <div id="carousel-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($product->images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="d-block w-100 rounded-top" 
                                             style="height: 250px; object-fit: cover;" 
                                             alt="Product Image">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Carousel Controls -->
                            @if ($product->images->count() > 1)
                                <button class="carousel-control-prev" type="button" 
                                        data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" 
                                        data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="card-img-top" 
                             style="height: 250px; object-fit: cover;" alt="No Image Available">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description ?? 'No description available' }}</p>
                        <h6 class="text-primary">${{ number_format($product->price, 2) }}</h6>
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-orange mt-3 mr-2 add-to-cart-btn" style="font-family: 'Roboto', sans-serif;">Add to Cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
