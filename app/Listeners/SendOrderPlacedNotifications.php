<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\LowStockAlert;
use App\Mail\OrderPlacedBuyer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderPlacedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        $order->load('items.product.sellerProfile.user', 'user');

        if ($order->user) {
            Mail::to($order->user->email)->queue(new OrderPlacedBuyer($order));
        }

        foreach ($order->items as $item) {
            if ($item->product && $item->product->stock <= 5 && $item->product->stock > 0) {
                $sellerProfile = $item->product->sellerProfile;
                if ($sellerProfile && $sellerProfile->user) {
                    Mail::to($sellerProfile->user->email)->queue(new LowStockAlert($item->product));
                }
            }
        }
    }
}
