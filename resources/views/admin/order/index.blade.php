@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Orders Management</h1>
    
    @if($orders->isEmpty())
        <div class="alert alert-info">
            No orders found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('M j, Y') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>${{ number_format($order->total_price, 2) }}</td>
                        <td>
                            <select class="form-select form-select-sm status-select" 
                                    data-order-id="{{ $order->id }}" 
                                    style="width: auto; display: inline-block;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="to_ship" {{ $order->status == 'to_ship' ? 'selected' : '' }}>To Ship</option>
                                <option value="to_deliver" {{ $order->status == 'to_deliver' ? 'selected' : '' }}>To Deliver</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <span class="badge bg-{{ 
                                $order->status == 'completed' ? 'success' : 
                                ($order->status == 'cancelled' ? 'danger' : 
                                ($order->status == 'pending' ? 'secondary' : 'warning')) 
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.status-select').change(function() {
        var select = $(this);
        var orderId = select.data('order-id');
        var newStatus = select.val();
        var badge = select.siblings('.badge');
        
        // Store original value in case we need to revert
        var originalStatus = select.data('original-status') || select.val();
        select.data('original-status', originalStatus);
        
        $.ajax({
            url: '/admin/orders/' + orderId + '/update-status',
            method: 'PATCH',
            data: {
                status: newStatus
            },
            success: function(response) {
                if(response.success) {
                    // Update badge appearance
                    var badgeClass = '';
                    switch(newStatus) {
                        case 'completed': badgeClass = 'success'; break;
                        case 'cancelled': badgeClass = 'danger'; break;
                        case 'pending': badgeClass = 'secondary'; break;
                        default: badgeClass = 'warning';
                    }
                    
                    badge.removeClass('bg-secondary bg-warning bg-success bg-danger')
                         .addClass('bg-' + badgeClass)
                         .text(newStatus.replace('_', ' ').charAt(0).toUpperCase() + 
                               newStatus.replace('_', ' ').slice(1));
                    
                    // Update original status to new value
                    select.data('original-status', newStatus);
                    
                    // Show success message
                    alert('Status updated successfully!');
                }
            },
            error: function(xhr) {
                // Revert to original value
                select.val(originalStatus);
                alert('Error updating status. Please try again.');
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
@endsection