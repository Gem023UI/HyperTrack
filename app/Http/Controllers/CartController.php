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
    
        $userId = $user->id; // Use user_id instead of customer_id
    
        // Query using DB::table for better performance
        $cartProducts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('products.id as product_id', 'products.name', 'products.price', 'carts.cart_qty')
            ->where('carts.user_id', $userId) // Use user_id
            ->get();
    
        // Calculate cart total using query instead of collection sum
        $cartTotal = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId) // Use user_id
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
                ->where('product_id', $existingCartItem->id)
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
    // public function reduceByOne($productId)
    // {
    //     $cartItem = Cart::where('product_id', $productId)->firstOrFail();

    //     if ($cartItem->cart_qty > 1) {
    //         $cartItem->cart_qty--;
    //         $cartItem->save();
    //     } else {
    //         $cartItem->delete();
    //     }

    //     return redirect()->back()->with('success', 'Item quantity decreased.');
    // }

    // public function addByOne($productId)
    // {
    //     $cartItem = Cart::where('product_id', $productId)->firstOrFail();

    //     $cartItem->cart_qty++;
    //     $cartItem->save();

    //     return redirect()->back()->with('success', 'Item quantity increased.');
    // }

    // public function delete($productId)
    // {
    //     DB::table('carts')->where('product_id', $productId)->delete();
    //     return redirect()->back()->with('success', 'Item removed from cart.');
    // }

    // public function addToCart($product_id)
    // {
    //     $user = auth()->user();

    //     $customer = $user->customer;

    //     if (!$customer) {
    //         return redirect()->route('customer.create');
    //     }

    //     $customer_id = $customer->id;

    //     $existingCartItem = Cart::where('customer_id', $customer_id)
    //         ->where('product_id', $product_id)
    //         ->first();

    //     if ($existingCartItem) {
    //         $existingCartItem->update(['cart_qty' => $existingCartItem->cart_qty + 1]);
    //     } else {
    //         $cartItem = Cart::create([
    //             'customer_id' => $customer->id,
    //             'product_id' => $product_id,
    //             'cart_qty' => 1,
    //         ]);
    //     }
    //     return redirect()->route('customer.index');
    // }

    // public function checkout(Request $request)
    // {
    //     $user = Auth::user();
    //     $customerId = $user->customer->id;

    //     if (Cart::where('customer_id', $customerId)->count() === 0) {
    //         return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before checkout.');
    //     }

    //     $shippingFee = 60;

    //     try {
    //         DB::beginTransaction();

    //         $cartItems = Cart::where('customer_id', $customerId)->get();

    //         $order = Order::create([
    //             'customer_id' => $customerId,
    //             'shipping_fee' => $shippingFee,
    //             'status' => 'Processing',
    //             'date_placed' => now(),
    //         ]);

    //         $orderLinesValues = '';

    //         foreach ($cartItems as $cartItem) {
    //             $productId = $cartItem->product_id;
    //             $quantity = $cartItem->cart_qty;

    //             $orderLinesValues .= "($order->id, $productId, $quantity),";

    //             $inventory = Inventory::where('product_id', $productId)->firstOrFail();
    //             $inventory->stock -= $quantity;
    //             $inventory->save();
    //         }

    //         $orderLinesValues = rtrim($orderLinesValues, ',');

    //         if (!empty($orderLinesValues)) {
    //             $sql = "INSERT INTO orderlines (order_id, product_id, qty) VALUES $orderLinesValues";
    //             DB::statement($sql);
    //         }

    //         Payment::create([
    //             'order_id' => $order->id,
    //             'mode_of_payment' => $request->input('payment_method'),
    //             'date_of_payment' => now(),
    //         ]);
    //         Cart::where('customer_id', $customerId)->delete();

    //         DB::commit();
    //         return redirect()->route('cart.index')->with('success', 'Placed order successfully');
    //     } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->route('checkout')->with('error', 'Failed to complete the checkout.');
    //     }
    // }
}
