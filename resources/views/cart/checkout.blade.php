@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Checkout</h1>

    <div class="row">
        <div class="col-md-8">
            <h3>Order Summary</h3>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->cart_qty }}</td>
                            <td>${{ number_format($product->price * $product->cart_qty, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-active">
                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                        <td><strong>${{ number_format($cartTotal, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Shipping Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cart.process-payment') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $user->name }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                            @error('shipping_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" id="submit-btn">Complete Purchase</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection