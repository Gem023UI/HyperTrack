    @extends('layouts.app')

    @section('content')
    <div class="container py-5">
        <h2 class="mb-4">Review Your Order</h2>

        <div class="row">
            <!-- Product Info -->
            <div class="col-md-6">
                <div class="card mb-4">
                    @if ($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Product Image">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="No Image">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <h6 class="text-primary">Unit Price: ${{ number_format($product->price, 2) }}</h6>
                        <h6 class="text-dark">Quantity: {{ $quantity }}</h6>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>User Info</h5>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>

                        <form method="POST" action="{{ route('purchases.place') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address</label>
                                <input type="text" name="shipping_address" id="shipping_address" class="form-control" required>
                                @error('shipping_address')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <h5>Total: ${{ number_format($product->price * $quantity, 2) }}</h5>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-success">Place Order</button>
                                <a href="{{ route('home') }}" class="btn btn-secondary"
                                    onclick="event.preventDefault(); document.getElementById('cancel-checkout-form').submit();">Cancel Order</a>

                                <form id="cancel-checkout-form" action="{{ route('purchases.cancelCheckout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </form>
                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
