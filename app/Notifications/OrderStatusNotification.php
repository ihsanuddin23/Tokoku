<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus,
        public ?string $url = null,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $labels = [
            'pending'   => 'Menunggu Pembayaran',
            'paid'      => 'Pembayaran Diterima',
            'shipped'   => 'Sedang Dikirim',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Pesanan Dibatalkan',
        ];

        $icons = [
            'pending'   => '🕐',
            'paid'      => '✅',
            'shipped'   => '🚚',
            'completed' => '🎉',
            'cancelled' => '❌',
        ];

        $icon = $icons[$this->newStatus] ?? '📦';
        $label = $labels[$this->newStatus] ?? ucfirst($this->newStatus);

        return [
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'title'        => $icon . ' ' . $label,
            'message'      => "Pesanan {$this->order->order_number}: {$label}",
            'url'          => $this->url ?? route('orders.show', $this->order->id),
            'new_status'   => $this->newStatus,
        ];
    }
}
