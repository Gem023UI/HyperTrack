<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Landing page with login and register
Route::get('/', function () {
    return view('auth.login'); // Show login page directly
});

// ✅ Authentication routes
Auth::routes();

// ✅ Normal user route
Route::get('/add-to-cart/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// ✅ Admin routes (Protected by 'auth' and 'admin' middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Product Routes (Resource Controller for CRUD operations)
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
