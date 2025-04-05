<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Landing page with login and register
Route::get('/', function () {
    return view('auth.login');
});

// ✅ Authentication routes
Auth::routes();

// ✅ Normal user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/add-to-cart/{product}', [CartController::class, 'addToCart'])->name('cart.add');

    // Purchase routes
    Route::get('/checkout/{product}', [PurchaseController::class, 'checkoutForm'])->name('purchases.checkout');
    Route::post('/checkout/{product}', [PurchaseController::class, 'checkout'])->name('purchases.process');

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::put('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');

    Route::get('/checkout-review', [PurchaseController::class, 'review'])->name('purchases.review');
    Route::post('/checkout/place', [PurchaseController::class, 'placeOrder'])->name('purchases.place');
    Route::post('/checkout/cancel', [PurchaseController::class, 'cancelCheckout'])->name('purchases.cancelCheckout');

});

// ✅ Admin routes (Protected by 'auth' and 'admin' middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('products', ProductController::class)->names([
        'index'   => 'admin.products.index',
        'create'  => 'admin.products.create',
        'store'   => 'admin.products.store',
        'show'    => 'admin.products.show',
        'edit'    => 'admin.products.edit',
        'update'  => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
});
