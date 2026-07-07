<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewProductFromFollowedStore extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $product,
        public $store
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_product',
            'title' => 'Produk Baru dari Toko Diikuti',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'store_name' => $this->store->store_name,
            'store_slug' => $this->store->store_slug,
            'message' => $this->store->store_name . ' merilis produk baru: ' . $this->product->name,
        ];
    }
}
