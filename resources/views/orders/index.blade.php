@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">My Orders</h2>

    @forelse ($orders as $order)
        <div class="card mb-4">
            <div class="row g-0">
                <!-- Product Image -->
                <div class="col-md-4">
                    @php
                        $firstItem = $order->orderItems->first();
                        $product = $firstItem ? $firstItem->product : null;
                    @endphp

                    @if ($product && $product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="img-fluid rounded-start" style="height: 250px; object-fit: cover;" alt="Product Image">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="img-fluid rounded-start" style="height: 250px; object-fit: cover;" alt="No Image">
                    @endif
                </div>

                <!-- Order Details -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Order #{{ $order->id }}</h5>
                        <p class="card-text"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p class="card-text"><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>

                        @foreach ($order->orderItems as $item)
                            <div class="mb-2">
                                <p class="mb-0"><strong>Product:</strong> {{ $item->product->name }}</p>
                                <p class="mb-0"><strong>Quantity:</strong> {{ $item->quantity }}</p>
                                <p class="mb-0"><strong>Unit Price:</strong> ${{ number_format($item->product->price, 2) }}</p>
                            </div>
                        @endforeach

                        <h6 class="mt-3"><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</h6>
                        <p class="text-muted mt-1"><small>Ordered on {{ $order->created_at->format('F j, Y, g:i a') }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>You have no orders yet.</p>
    @endforelse
</div>
@endsection
