<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminSellerVerificationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BecomeSellerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerStoreController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $banners = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();
    $categories = App\Models\Category::where('is_active', true)->orderBy('name')->take(6)->get();
    $products = App\Models\Product::active()
        ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
        ->with(['sellerProfile', 'category'])
        ->orderBy('total_sold', 'desc')
        ->take(10)
        ->get();
    $newProducts = App\Models\Product::active()
        ->whereHas('sellerProfile', fn ($q) => $q->where('is_active', true))
        ->with(['sellerProfile', 'category'])
        ->latest()
        ->take(10)
        ->get();
    $popularStores = \App\Models\SellerProfile::where('is_active', true)
        ->where('is_verified', true)
        ->whereHas('products', fn ($q) => $q->where('status', 'active'))
        ->withCount(['products as active_products' => fn ($q) => $q->where('status', 'active')])
        ->orderByDesc('active_products')
        ->take(6)
        ->get();

    return view('welcome', compact('banners', 'categories', 'products', 'newProducts', 'popularStores'));
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('throttle:60,1');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('throttle:60,1');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Guest routes (auth)
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth', 'active'])->group(function () {
    // Buyer Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        $recentOrders = Auth::user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get();
        $totalOrders = Auth::user()->orders()->where('status', '!=', 'cancelled')->count();
        $totalSpent = Auth::user()->orders()->where('status', 'completed')->sum('grand_total');
        $completedOrders = Auth::user()->orders()->where('status', 'completed')->count();

        return view('dashboard', compact('recentOrders', 'totalOrders', 'totalSpent', 'completedOrders'));
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Change Password
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Addresses
    Route::get('/profile/addresses', [AddressController::class, 'index'])->name('profile.addresses');
    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('profile.addresses.store');
    Route::patch('/profile/addresses/{address}', [AddressController::class, 'update'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [AddressController::class, 'destroy'])->name('profile.addresses.destroy');
    Route::post('/profile/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('profile.addresses.set-default');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/payment/{order}/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');

    // Become Seller (buyer only)
    Route::middleware('role:buyer')->group(function () {
        Route::get('/become-seller', [BecomeSellerController::class, 'index'])->name('become-seller');
        Route::post('/become-seller', [BecomeSellerController::class, 'store'])->name('become-seller.store');
    });
});

// Seller routes
Route::middleware(['auth', 'active', 'role:seller', 'verified.seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        $sellerProfile = Auth::user()->sellerProfile;

        $totalProducts = $sellerProfile->products()->count();
        $activeProducts = $sellerProfile->products()->where('status', 'active')->count();
        $totalOrders = \App\Models\OrderItem::where('seller_profile_id', $sellerProfile->id)->count();
        $todayRevenue = \App\Models\OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->where('status', 'completed')
            ->whereDate('updated_at', today())
            ->sum('subtotal');
        $monthRevenue = \App\Models\OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->where('status', 'completed')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('subtotal');
        $totalRevenue = \App\Models\OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->where('status', 'completed')
            ->sum('subtotal');
        $recentOrders = \App\Models\OrderItem::where('seller_profile_id', $sellerProfile->id)
            ->with(['order.user', 'product'])
            ->latest()
            ->take(5)
            ->get();
        $topProducts = $sellerProfile->products()
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalProducts', 'activeProducts', 'totalOrders', 'totalRevenue',
            'todayRevenue', 'monthRevenue', 'recentOrders', 'topProducts'
        ));
    })->name('dashboard');

    // Products
    Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/bulk-stock', [SellerProductController::class, 'bulkUpdateStock'])->name('products.bulk-stock');

    // Store Settings
    Route::get('/store', [SellerStoreController::class, 'edit'])->name('store.edit');
    Route::patch('/store', [SellerStoreController::class, 'update'])->name('store.update');

    // Orders
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{orderItem}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Admin routes
Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalUsers = \App\Models\User::count();
        $totalSellers = \App\Models\SellerProfile::where('is_active', true)->count();
        $totalProducts = \App\Models\Product::count();
        $totalOrders = \App\Models\Order::where('status', '!=', 'cancelled')->count();
        $totalRevenue = \App\Models\OrderItem::where('status', 'completed')->sum('subtotal');
        $pendingVerifications = \App\Models\SellerVerification::where('status', 'pending')->count();
        $recentUsers = \App\Models\User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalProducts', 'totalOrders',
            'totalRevenue', 'pendingVerifications', 'recentUsers'
        ));
    })->name('dashboard');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');

    // Seller Verifications
    Route::get('/verifications', [AdminSellerVerificationController::class, 'index'])->name('verifications.index');
    Route::patch('/verifications/{verification}/approve', [AdminSellerVerificationController::class, 'approve'])->name('verifications.approve');
    Route::patch('/verifications/{verification}/reject', [AdminSellerVerificationController::class, 'reject'])->name('verifications.reject');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Banners
    Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::patch('/banners/{banner}', [AdminBannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');
});
