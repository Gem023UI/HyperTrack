@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Order #{{ $order->id }}</h2>
            <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                    {{ ucfirst($order->status) }}
                </span>
                <small class="text-white">Placed on {{ $order->created_at->format('F j, Y \a\t g:i a') }}</small>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Shipping Information</h4>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p class="mb-0"><strong>Address:</strong> {{ $order->shipping_address }}</p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4>Order Summary</h4>
                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span>${{ number_format($order->total_price, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Shipping:</span>
                            <span>$0.00</span> <!-- Adjust if you have shipping fees -->
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>${{ number_format($order->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <h4>Order Items</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-active">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                            <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
                @if($order->status == 'pending')
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Cancel Order
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection