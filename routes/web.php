<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Content pages (text lives in config/pages.php)
foreach (['services', 'industries', 'portfolio', 'how-it-works', 'training', 'about'] as $slug) {
    Route::get('/' . $slug, [PageController::class, 'show'])
        ->defaults('slug', $slug)
        ->name('pages.' . $slug);
}

// Contact and quote requests
Route::get('/contact', [EnquiryController::class, 'contact'])->name('contact.create');
Route::post('/contact', [EnquiryController::class, 'storeContact'])->name('contact.store')->middleware('throttle:5,1');
Route::get('/request-a-quote', [EnquiryController::class, 'quote'])->name('quote.create');
Route::post('/request-a-quote', [EnquiryController::class, 'storeQuote'])->name('quote.store')->middleware('throttle:5,1');
Route::get('/request-a-quote/received', [EnquiryController::class, 'thanks'])->name('quote.thanks');

// Public shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

// Cart (works before logging in)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Only for people who are NOT logged in
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// Only for logged-in people
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/account', [AccountController::class, 'show'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('throttle:10,1');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/download/{product}', [OrderController::class, 'download'])->name('orders.download');

    // SandboxPay (fallback gateway)
    Route::get('/orders/{order}/pay', [OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay')->middleware('throttle:10,1');

    // Paystack (test mode)
    Route::post('/orders/{order}/gateway', [OrderController::class, 'gatewayStart'])->name('orders.gateway.start')->middleware('throttle:10,1');
    Route::get('/orders/{order}/gateway/return', [OrderController::class, 'gatewayReturn'])->name('orders.gateway.return');
});

// Only for logged-in ADMINS
Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::redirect('/', '/admin/products');
        Route::resource('products', AdminProductController::class)->except('show');
    });