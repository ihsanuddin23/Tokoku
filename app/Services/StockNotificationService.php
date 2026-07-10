<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockSubscription;
use App\Notifications\StockAvailableNotification;

class StockNotificationService
{
    public function notifyProductRestocked(Product $product): void
    {
        if ($product->stock <= 0) {
            return;
        }

        $subscriptions = StockSubscription::where('product_id', $product->id)
            ->where('notified', false)
            ->whereNull('product_variant_id')
            ->with('user')
            ->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription->user) {
                $subscription->user->notify(new StockAvailableNotification($product));
            }
            $subscription->update(['notified' => true]);
        }
    }

    public function notifyVariantRestocked(int $variantId, int $stock): void
    {
        if ($stock <= 0) {
            return;
        }

        $subscriptions = StockSubscription::where('product_variant_id', $variantId)
            ->where('notified', false)
            ->with(['user', 'product', 'variant'])
            ->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription->user && $subscription->product) {
                $variantName = $subscription->variant?->name ?? '';
                $subscription->user->notify(new StockAvailableNotification($subscription->product, $variantName));
            }
            $subscription->update(['notified' => true]);
        }
    }
}
