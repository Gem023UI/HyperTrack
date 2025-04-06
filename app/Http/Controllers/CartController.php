<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Inventory;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;  // Add this line
use Session;
use Exception;
use Carbon\Carbon;



class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your cart.');
        }

        $userId = $user->id;

        // Use Eloquent for querying products in the cart
        $cartProducts = Product::join('carts', 'products.id', '=', 'carts.product_id')
            ->select('products.id', 'products.name', 'products.price', 'carts.cart_qty')
            ->where('carts.user_id', $userId)
            ->get();

        // Calculate cart total using Eloquent
        $cartTotal = Product::join('carts', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', $userId)
            ->sum(DB::raw('products.price * carts.cart_qty'));

        return view('cart.index', compact('cartProducts', 'cartTotal'));
    }

    public function addToCart($product_id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to add items to your cart.');
        }
        
        $userId = $user->id;
        
        // Check if the product already exists in the user's cart
        $existingCartItem = DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_id', $product_id)
            ->first();
        
        if ($existingCartItem) {
            // Update the quantity if the product already exists
            DB::table('carts')
                ->where('user_id', $userId)
                ->where('product_id', $product_id)  // Use correct condition
                ->update(['cart_qty' => $existingCartItem->cart_qty + 1]);
        } else {
            // Insert a new cart item if it doesn't exist
            DB::table('carts')->insert([
                'user_id' => $userId,
                'product_id' => $product_id,
                'cart_qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }
    
    public function update(Request $request, $product_id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to update your cart.');
        }
        
        $userId = $user->id;
        
        // Get the current cart item
        $cartItem = DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_id', $product_id)
            ->first();
        
        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }
        
        $newQty = $cartItem->cart_qty;
        
        if ($request->action == 'increase') {
            $newQty++;
        } elseif ($request->action == 'decrease') {
            $newQty = max(1, $cartItem->cart_qty - 1); // Prevent quantity from going below 1
        }
        
        // Update the quantity
        DB::table('carts')
            ->where('user_id', $userId)
            ->where('product_id', $product_id)
            ->update(['cart_qty' => $newQty]);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to proceed to checkout.');
        }

        $userId = $user->id;

        // Get cart products
        $cartProducts = Product::join('carts', 'products.id', '=', 'carts.product_id')
            ->select('products.id', 'products.name', 'products.price', 'carts.cart_qty')
            ->where('carts.user_id', $userId)
            ->get();

        // Calculate cart total
        $cartTotal = Product::join('carts', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', $userId)
            ->sum(DB::raw('products.price * carts.cart_qty'));

        return view('cart.checkout', compact('cartProducts', 'cartTotal', 'user'));
    }

    public function remove($product_id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to modify your cart.');
        }
        
        DB::table('carts')
            ->where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->delete();
        
        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to complete your purchase.');
        }

        // Check if cart is empty before proceeding
        $cartProducts = Product::join('carts', 'products.id', '=', 'carts.product_id')
            ->select('products.id', 'products.name', 'products.price', 'carts.cart_qty')
            ->where('carts.user_id', $user->id)
            ->get();

        if ($cartProducts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            Log::info('Processing payment for user: ' . $user->id);

            // Calculate total
            $cartTotal = 0;
            foreach ($cartProducts as $product) {
                $cartTotal += $product->price * $product->cart_qty;
            }

            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $cartTotal,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address
            ]);
            
            Log::info('Order created with ID: ' . $order->id);

            // Create order items
            foreach ($cartProducts as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $product->cart_qty,
                    'price' => $product->price
                ]);
                
                Log::info('OrderItem created for product: ' . $product->id);
            }

            // Clear the cart
            DB::table('carts')->where('user_id', $user->id)->delete();
            Log::info('Cart cleared for user: ' . $user->id);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing payment: ' . $e->getMessage());
            return redirect()->route('cart.checkout')
                ->with('error', 'An error occurred while processing your order: ' . $e->getMessage());
        }
    }

    private function clearUserCart($userId)
    {
        $deleted = DB::table('carts')
            ->where('user_id', $userId)
            ->delete();
        
        Log::info('Cart cleared for user: ' . $userId . ', rows deleted: ' . $deleted);
        
        return $deleted;
    }

}
