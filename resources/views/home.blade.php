@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">🛍️ Our Products</h1>
    
    <!-- Search Form -->
    <div class="row justify-content-center mb-5">
    <div class="col-md-8">
        <form action="{{ url('/home') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" 
                       name="query" 
                       class="form-control" 
                       placeholder="Search products..." 
                       value="{{ request('query') }}"
                       aria-label="Search products">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

    @if(request()->has('query'))
        <div class="alert alert-info mb-4">
            Showing results for: "<strong>{{ request('query') }}</strong>"
            <a href="{{ url()->current() }}" class="float-end text-decoration-none">
                <i class="fas fa-times"></i> Clear search
            </a>
        </div>
    @endif

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <!-- Your existing product card code here -->
                <div class="card shadow-sm">
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
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-orange mt-3 mr-2 add-to-cart-btn" style="font-family: 'Roboto', sans-serif;">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    @if(request()->has('query'))
                        No products found matching your search.
                    @else
                        No products available at the moment.
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Updated Pagination Check -->
    @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection