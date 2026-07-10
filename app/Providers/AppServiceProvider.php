<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || str_contains(config('app.url'), 'ngrok')) {
            URL::forceScheme('https');
        }

        Event::listen(\App\Events\OrderPlaced::class, \App\Listeners\SendOrderPlacedNotifications::class);
        Event::listen(\App\Events\PaymentReceived::class, \App\Listeners\SendPaymentReceivedNotifications::class);
        Event::listen(\App\Events\StockUpdated::class, \App\Listeners\SendStockRestockedNotifications::class);

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('authenticated', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()->id);
        });

        RateLimiter::for('write-heavy', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()->id);
        });

        RateLimiter::for('seller-actions', function (Request $request) {
            $sellerProfileId = $request->user()->sellerProfile?->id ?? $request->user()->id;

            return Limit::perMinute(45)->by('seller:' . $sellerProfileId);
        });

        RateLimiter::for('admin-actions', function (Request $request) {
            return Limit::perMinute(100)->by('admin:' . $request->user()->id);
        });

        RateLimiter::for('payment', function (Request $request) {
            $orderId = $request->route('order')?->id ?? $request->ip();

            return Limit::perMinute(20)->by('payment:' . ($request->user()?->id ?: $request->ip()) . ':' . $orderId);
        });
    }
}
