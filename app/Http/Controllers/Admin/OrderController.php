<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Your existing methods

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Make sure users can only see their own orders unless they're an admin
        if (!auth()->user()->is_admin && auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load the order items with their products
        $order->load('items.product', 'user');
        
        return view('orders.show', compact('order'));
    }
    
    // Rest of your controller methods
}