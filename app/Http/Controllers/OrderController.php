<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders for the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load order relationships
        $order->load('items.product', 'user');
        
        return view('orders.show', compact('order'));
    }

    /**
     * Cancel the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only pending orders can be canceled
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be canceled.');
        }
        
        $order->status = 'cancelled';
        $order->save();
        
        return redirect()->route('orders.show', $order)->with('success', 'Order has been canceled.');
    }
}