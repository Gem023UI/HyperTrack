<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

}
