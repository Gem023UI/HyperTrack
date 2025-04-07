<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.order.index', compact('orders'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        $validStatuses = ['pending', 'to_ship', 'to_deliver', 'completed'];
        
        $request->validate([
            'status' => ['required', 'in:' . implode(',', $validStatuses)]
        ]);
        
        try {
            $order->update(['status' => $request->status]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}