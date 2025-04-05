<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkoutForm(Product $product)
    {
        return view('purchases.checkout-form', compact('product'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['items.product', 'user']);
        return view('purchases.show', compact('order'));
    }

    public function review()
    {
        $productId = session('checkout.product_id');
        $quantity = session('checkout.quantity');

        if (!$productId || !$quantity) {
            return redirect()->route('home')->with('error', 'Missing checkout data.');
        }

        $product = Product::with('images')->findOrFail($productId);
        $user = Auth::user();

        return view('purchases.checkout-review', compact('product', 'quantity', 'user'));
    }

    public function checkout(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Store checkout data in session for review page
        session([
            'checkout.product_id' => $product->id,
            'checkout.quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('purchases.review');
    }

    public function cancelCheckout()
    {
        session()->forget(['checkout.product_id', 'checkout.quantity']);
        return redirect()->route('home')->with('info', 'Checkout cancelled.');
    }

    // PurchaseController.php

    public function placeOrder(Request $request)
    {
        // Validate the shipping address
        $request->validate([
            'shipping_address' => 'required|string|max:255',
        ]);

        // Retrieve the product ID and quantity from the session
        $productId = session('checkout.product_id');
        $quantity = session('checkout.quantity');

        // Check if checkout session data exists
        if (!$productId || !$quantity) {
            return redirect()->route('home')->with('error', 'Missing checkout session data.');
        }

        // Retrieve the product and user
        $product = Product::findOrFail($productId);
        $user = Auth::user();

        // Start a database transaction to ensure data consistency
        \DB::beginTransaction();

        try {
            // Insert into the 'orders' table
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $product->price * $quantity,
                'status' => 'pending',
            ]);

            // Insert into the 'order_items' table
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            // OPTIONAL: Save shipping address if needed (you can create a shipping_address table)
            // For now, we'll just store it in the session or elsewhere
            // For example: $order->shipping_address = $request->input('shipping_address');
            
            // Commit the transaction
            \DB::commit();

            // Clear the session data after the order is placed
            session()->forget(['checkout.product_id', 'checkout.quantity']);

            // Redirect to the orders list with a success message
            return redirect()->route('purchases.index')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            \DB::rollBack();

            // Log the error (optional)
            \Log::error('Order placement failed: ' . $e->getMessage());

            // Redirect with an error message
            return redirect()->route('purchases.review')->with('error', 'There was an issue placing your order. Please try again.');
        }
    }

}
