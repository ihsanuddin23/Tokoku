<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Mail\NewOrderSeller;
use App\Mail\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPaymentReceivedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PaymentReceived $event): void
    {
        $order = $event->order;
        $order->load('items.sellerProfile.user', 'user');

        if ($order->user) {
            Mail::to($order->user->email)->queue(new OrderStatusUpdated($order, 'pending', 'paid'));
        }

        foreach ($order->items as $item) {
            if ($item->sellerProfile && $item->sellerProfile->user) {
                Mail::to($item->sellerProfile->user->email)->queue(new NewOrderSeller($item));
            }
        }
    }
}
