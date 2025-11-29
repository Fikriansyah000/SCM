<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
<<<<<<< HEAD
use App\Http\Controllers\ShippingController;
=======
>>>>>>> 81f0d06 (First Up|)

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

<<<<<<< HEAD
// Public API Routes
Route::get('/api/products', function () {
    $products = \App\Models\Product::with('shop')
        ->where('status', 'available')
        ->orderBy('created_at', 'desc')
        ->limit(12)
        ->get();
    return response()->json($products);
});

// Shipping API (Public - for checkout)
Route::get('/api/shipping/modes', [\App\Http\Controllers\ShippingController::class, 'getAvailableModes']);
Route::post('/api/shipping/calculate', [\App\Http\Controllers\ShippingController::class, 'calculateShipping']);
Route::get('/api/shipping/check-availability', [\App\Http\Controllers\ShippingController::class, 'checkAvailability']);

=======
>>>>>>> 81f0d06 (First Up|)
// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register/buyer', [AuthController::class, 'showRegisterBuyer'])->name('register.buyer');
    Route::post('/register/buyer', [AuthController::class, 'registerBuyer']);
    
    Route::get('/register/seller', [AuthController::class, 'showRegisterSeller'])->name('register.seller');
    Route::post('/register/seller', [AuthController::class, 'registerSeller']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Buyer Routes
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/home', [BuyerController::class, 'home'])->name('home');
    Route::get('/search', [BuyerController::class, 'search'])->name('search');
    Route::get('/shop/{id}', [BuyerController::class, 'visitShop'])->name('shop.visit');
    // Product detail (PDP)
    Route::get('/products/{product}', [\App\Http\Controllers\Buyer\ProductPageController::class, 'show'])->name('products.show');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
     // Checkout & Orders
    Route::get('/checkout', [BuyerOrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [BuyerOrderController::class, 'store'])->name('checkout.store');  // ← Beda nama
    Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm-delivery', [BuyerOrderController::class, 'confirmDelivery'])->name('orders.confirm-delivery');
    Route::post('/orders/{order}/complete', [BuyerOrderController::class, 'complete'])->name('orders.complete');
    Route::post('/orders/{order}/cancel', [BuyerOrderController::class, 'cancel'])->name('orders.cancel');
<<<<<<< HEAD
    // Returns
    Route::post('/orders/{order}/request-return', [BuyerOrderController::class, 'requestReturn'])->name('orders.request-return');
    Route::post('/orders/{order}/ship-return', [BuyerOrderController::class, 'shipReturn'])->name('orders.ship-return');
=======
>>>>>>> 81f0d06 (First Up|)
}); 

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    
    // Shop
    Route::get('/shop/create', [SellerController::class, 'showCreateShop'])->name('shop.create');
    Route::post('/shop/create', [SellerController::class, 'createShop'])->name('shop.store');
    Route::get('/shop', [SellerController::class, 'showShop'])->name('shop');
    Route::get('/shop/edit', [SellerController::class, 'editShop'])->name('shop.edit');
    Route::put('/shop', [SellerController::class, 'updateShop'])->name('shop.update');
    
    // Products
    Route::resource('products', ProductController::class);
     // Seller Orders
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [SellerOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/ship', [SellerOrderController::class, 'ship'])->name('orders.ship');
<<<<<<< HEAD
    // Return management
    Route::post('/orders/{order}/return/approve', [SellerOrderController::class, 'approveReturn'])->name('orders.return.approve');
    Route::post('/orders/{order}/return/reject', [SellerOrderController::class, 'rejectReturn'])->name('orders.return.reject');
    Route::post('/orders/{order}/return/confirm-received', [SellerOrderController::class, 'confirmReturnReceived'])->name('orders.return.confirm-received');
=======
>>>>>>> 81f0d06 (First Up|)
});

// Shared Routes (Both Buyer and Seller)
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
    
<<<<<<< HEAD
    // Product reviews
    Route::post('/reviews', [App\Http\Controllers\ProductReviewController::class, 'store'])->name('reviews.store');
    
=======
>>>>>>> 81f0d06 (First Up|)
    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'send'])->name('messages.send');
});

<<<<<<< HEAD


=======
>>>>>>> 81f0d06 (First Up|)
