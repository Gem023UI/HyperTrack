<?php

use App\Models\Cart;
use App\Models\Product;

public function checkoutCart()
{
    $user = auth()->user();

    $cartItems = Cart::where('user_id', $user->id)
        ->whereNull('deleted_at')
        ->with('product') // assumes relation is set
        ->get();

    return view('checkout-cart', compact('cartItems', 'user'));
}

?>

