@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">🛒 Your Cart</h1>

    @if ($cartProducts->isEmpty())
        <div class="alert alert-info">Your cart is empty.</div>
    @else
        <div class="text-end mb-3">
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg">Proceed to Checkout</a>
        </div>
        
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <form action="{{ route('cart.update', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">−</button>
                                </form>
                                                                
                                <span class="mx-2">{{ $product->cart_qty }}</span>
                                                                
                                <form action="{{ route('cart.update', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                                </form>                                
                            </div>
                        </td>
                        <td>${{ number_format($product->price * $product->cart_qty, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection