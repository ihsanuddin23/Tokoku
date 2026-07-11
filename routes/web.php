<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminActivityLogController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminPayoutController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminReturnController;
use App\Http\Controllers\AdminSellerVerificationController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminVoucherController;
use App\Http\Controllers\BecomeSellerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerPayoutController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerReviewController;
use App\Http\Controllers\SellerStoreController;
use App\Http\Controllers\SellerVoucherController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:global')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
    Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots.txt');

    Route::get('/terms', fn () => view('legal.terms'))->name('legal.terms');
    Route::get('/privacy', fn () => view('legal.privacy'))->name('legal.privacy');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/about', [ContactController::class, 'about'])->name('about');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:10,1');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search')->middleware('throttle:30,1');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

    // Track Order (public, no login required)
    Route::get('/track-order', [OrderController::class, 'trackForm'])->name('orders.track');
    Route::post('/track-order', [OrderController::class, 'trackOrder'])->name('orders.track.search')->middleware('throttle:10,1');
});

Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Guest routes (auth)
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth', 'active', 'throttle:authenticated'])->group(function () {
    // Buyer Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        return app(DashboardController::class)->buyer(request());
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
    Route::middleware('verified')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/cancel-checkout', [OrderController::class, 'cancelCheckout'])->name('orders.cancel-checkout');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('throttle:write-heavy');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('throttle:write-heavy');
        Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete')->middleware('throttle:write-heavy');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder')->middleware('throttle:write-heavy');

        // Payment
        Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show')->middleware('throttle:payment');
        Route::get('/payment/{order}/finish', [PaymentController::class, 'finish'])->name('payment.finish')->middleware('throttle:payment');
        Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success')->middleware('throttle:payment');

        // Wishlist
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('throttle:30,1');

        // Stock Notification
        Route::post('/products/{product}/notify-stock', [ProductController::class, 'subscribeStock'])->name('products.notify-stock')->middleware('throttle:30,1');

        // Follow Store
        Route::post('/stores/{sellerProfile}/follow', [StoreController::class, 'follow'])->name('stores.follow')->middleware('throttle:30,1');
        Route::delete('/stores/{sellerProfile}/follow', [StoreController::class, 'unfollow'])->name('stores.unfollow');
        Route::get('/followed-stores', [StoreController::class, 'followed'])->name('stores.followed');

        // Reviews
        Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('throttle:10,1');
        Route::patch('/reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond')->middleware('throttle:10,1');

        // Voucher
        Route::post('/voucher/apply', [OrderController::class, 'applyVoucher'])->name('voucher.apply')->middleware('throttle:10,1');
        Route::delete('/voucher/remove', [OrderController::class, 'removeVoucher'])->name('voucher.remove');

        // Returns
        Route::get('/returns', [ReturnRequestController::class, 'index'])->name('returns.index');
        Route::get('/orders/{order}/returns/create', [ReturnRequestController::class, 'create'])->name('returns.create');
        Route::post('/orders/{order}/returns', [ReturnRequestController::class, 'store'])->name('returns.store')->middleware('throttle:write-heavy');

        // Messages / Chat
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('/messages/start', [MessageController::class, 'start'])->name('messages.start')->middleware('throttle:30,1');
        Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store')->middleware('throttle:30,1');

        // Become Seller (buyer only)
        Route::middleware('role:buyer')->group(function () {
            Route::get('/become-seller', [BecomeSellerController::class, 'index'])->name('become-seller');
            Route::post('/become-seller', [BecomeSellerController::class, 'store'])->name('become-seller.store')->middleware('throttle:write-heavy');
        });
    });

    // Notifications
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});

// Seller routes
Route::middleware(['auth', 'active', 'role:seller', 'verified.seller', 'throttle:seller-actions'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'seller'])->name('dashboard');

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
    Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{orderItem}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Reports
    Route::get('/reports', [ReportController::class, 'sellerIndex'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'sellerExportPdf'])->name('reports.export-pdf');
    Route::get('/reports/export-csv', [ReportController::class, 'sellerExportCsv'])->name('reports.export-csv');

    // Payouts
    Route::get('/payouts', [SellerPayoutController::class, 'index'])->name('payouts.index');
    Route::post('/payouts/request', [SellerPayoutController::class, 'request'])->name('payouts.request');

    // Reviews
    Route::get('/reviews', [SellerReviewController::class, 'index'])->name('reviews.index');

    // Vouchers
    Route::get('/vouchers', [SellerVoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/vouchers/create', [SellerVoucherController::class, 'create'])->name('vouchers.create');
    Route::post('/vouchers', [SellerVoucherController::class, 'store'])->name('vouchers.store');
    Route::get('/vouchers/{voucher}/edit', [SellerVoucherController::class, 'edit'])->name('vouchers.edit');
    Route::patch('/vouchers/{voucher}', [SellerVoucherController::class, 'update'])->name('vouchers.update');
    Route::delete('/vouchers/{voucher}', [SellerVoucherController::class, 'destroy'])->name('vouchers.destroy');
});

// Admin routes
Route::middleware(['auth', 'active', 'role:admin', 'throttle:admin-actions'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active')->middleware('password.confirm');

    // Seller Verifications
    Route::get('/verifications', [AdminSellerVerificationController::class, 'index'])->name('verifications.index');
    Route::patch('/verifications/{verification}/approve', [AdminSellerVerificationController::class, 'approve'])->name('verifications.approve');
    Route::patch('/verifications/{verification}/reject', [AdminSellerVerificationController::class, 'reject'])->name('verifications.reject');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy')->middleware('password.confirm');

    // Banners
    Route::get('/banners', [AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::patch('/banners/{banner}', [AdminBannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [AdminBannerController::class, 'destroy'])->name('banners.destroy')->middleware('password.confirm');

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/export-csv', [AdminProductController::class, 'exportCsv'])->name('products.export-csv');
    Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy')->middleware('password.confirm');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export-csv', [AdminOrderController::class, 'exportCsv'])->name('orders.export-csv');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Returns
    Route::get('/returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{return}', [AdminReturnController::class, 'show'])->name('returns.show');
    Route::patch('/returns/{return}/approve', [AdminReturnController::class, 'approve'])->name('returns.approve');
    Route::patch('/returns/{return}/reject', [AdminReturnController::class, 'reject'])->name('returns.reject');
    Route::patch('/returns/{return}/refund', [AdminReturnController::class, 'refund'])->name('returns.refund');

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{order}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{order}/mark-paid', [AdminPaymentController::class, 'markPaid'])->name('payments.mark-paid');
    Route::patch('/payments/{order}/mark-refunded', [AdminPaymentController::class, 'markRefunded'])->name('payments.mark-refunded');

    // Payouts
    Route::get('/payouts', [AdminPayoutController::class, 'index'])->name('payouts.index');
    Route::get('/payouts/{payout}', [AdminPayoutController::class, 'show'])->name('payouts.show');
    Route::patch('/payouts/{payout}/process', [AdminPayoutController::class, 'process'])->name('payouts.process');
    Route::patch('/payouts/{payout}/complete', [AdminPayoutController::class, 'complete'])->name('payouts.complete');
    Route::patch('/payouts/{payout}/reject', [AdminPayoutController::class, 'reject'])->name('payouts.reject');

    // Reports
    Route::get('/reports', [ReportController::class, 'adminIndex'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'adminExportPdf'])->name('reports.export-pdf');
    Route::get('/reports/export-csv', [ReportController::class, 'adminExportCsv'])->name('reports.export-csv');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Activity Logs
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');

    // Vouchers
    Route::get('/vouchers', [AdminVoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/vouchers/create', [AdminVoucherController::class, 'create'])->name('vouchers.create');
    Route::post('/vouchers', [AdminVoucherController::class, 'store'])->name('vouchers.store');
    Route::get('/vouchers/{voucher}/edit', [AdminVoucherController::class, 'edit'])->name('vouchers.edit');
    Route::patch('/vouchers/{voucher}', [AdminVoucherController::class, 'update'])->name('vouchers.update');
    Route::delete('/vouchers/{voucher}', [AdminVoucherController::class, 'destroy'])->name('vouchers.destroy');
});
