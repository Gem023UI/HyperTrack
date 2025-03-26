@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">🛒 Your Cart</h1>

    @if ($cartProducts->isEmpty())
        <div class="alert alert-info">Your cart is empty.</div>
    @else
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
                        <td>{{ $product->cart_qty }}</td>
                        <td>${{ number_format($product->price * $product->cart_qty, 2) }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection