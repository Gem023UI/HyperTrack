<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

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


    public function show(Purchase $purchase)
    {
        $this->authorize('view', $purchase);
        $purchase->load(['items.product.images', 'shippingAddress']);
        return view('purchases.show', compact('purchase'));
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


}
