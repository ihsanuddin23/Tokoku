<?php

namespace App\Console\Commands;

use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\Setting;
use App\Notifications\OrderStatusNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Cancel pending unpaid orders older than the configured expiry period and restore stock.';

    public function handle(): int
    {
        $expiryHours = (int) Setting::get('order_expiry_hours', 24);
        $cutoff = now()->subHours($expiryHours);

        $orders = Order::where('status', 'pending')
            ->where('payment_status', 'unpaid')
            ->where('created_at', '<', $cutoff)
            ->with('items.product', 'items.variant', 'user')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No expired orders found.');
            return self::SUCCESS;
        }

        $cancelled = 0;

        foreach ($orders as $order) {
            DB::transaction(function () use ($order, &$cancelled) {
                $order->forceFill([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ])->save();

                foreach ($order->items as $item) {
                    if ($item->product) {
                        if ($item->variant) {
                            $item->variant->increment('stock', $item->quantity);
                        } else {
                            $item->product->increment('stock', $item->quantity);
                        }
                        $item->product->decrement('total_sold', $item->quantity);
                    }
                    $item->forceFill(['status' => 'cancelled'])->save();
                }

                $cancelled++;
            });

            if ($order->user) {
                Mail::to($order->user->email)->queue(
                    new OrderStatusUpdated($order, 'pending', 'cancelled')
                );
                $order->user->notify(
                    new OrderStatusNotification($order, 'pending', 'cancelled', route('orders.show', $order->id))
                );
            }
        }

        $this->info("Cancelled {$cancelled} expired order(s).");

        return self::SUCCESS;
    }
}
