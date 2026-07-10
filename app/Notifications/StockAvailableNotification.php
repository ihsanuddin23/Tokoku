<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockAvailableNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product,
        public string $variantName = ''
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $name = $this->variantName ? "{$this->product->name} ({$this->variantName})" : $this->product->name;

        return (new MailMessage)
            ->subject('Stok Produk Tersedia Kembali!')
            ->line("Produk \"{$name}\" yang Anda pantau kini tersedia kembali.")
            ->action('Lihat Produk', route('products.show', $this->product))
            ->line('Terima kasih telah menggunakan ' . config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'variant_name' => $this->variantName,
            'message' => 'Stok produk tersedia kembali',
            'url' => route('products.show', $this->product),
        ];
    }
}
