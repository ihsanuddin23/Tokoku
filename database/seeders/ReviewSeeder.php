<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::where('email', 'buyer@tokoku.test')->first();
        if (! $buyer) {
            return;
        }

        $completedOrders = Order::where('user_id', $buyer->id)
            ->where('status', 'completed')
            ->with('items.product')
            ->get();

        $comments = [
            'Produk sesuai deskripsi, pengiriman cepat!',
            'Kualitas bagus, packing aman. Recommended seller!',
            'Barang original, harga terjangkau. Puas banget.',
            'Pengiriman agak lama tapi produk memuaskan.',
            'Sesuai ekspektasi, akan beli lagi.',
            'Produk berkualitas, seller responsif. 5 bintang!',
            'Oke lah, sesuai gambar.',
            'Bagus banget! Sudah beli ke-2 kalinya.',
            null,
            null,
        ];

        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                if (! $item->product) {
                    continue;
                }

                $alreadyReviewed = ProductReview::where('user_id', $buyer->id)
                    ->where('product_id', $item->product_id)
                    ->where('order_id', $order->id)
                    ->exists();

                if ($alreadyReviewed) {
                    continue;
                }

                $rating = $this->weightedRating();

                ProductReview::create([
                    'user_id'    => $buyer->id,
                    'product_id' => $item->product_id,
                    'order_id'   => $order->id,
                    'rating'     => $rating,
                    'comment'    => $comments[array_rand($comments)],
                    'created_at' => $order->completed_at ?? now()->subDays(rand(1, 10)),
                ]);

                $this->recalculate($item->product_id);
            }
        }

        $extraBuyers = User::where('role', 'buyer')
            ->where('email', '!=', 'buyer@tokoku.test')
            ->take(3)
            ->get();

        $completedOrdersExtra = Order::whereIn('user_id', $extraBuyers->pluck('id'))
            ->where('status', 'completed')
            ->with('items.product')
            ->get();

        foreach ($completedOrdersExtra as $order) {
            foreach ($order->items as $item) {
                if (! $item->product) {
                    continue;
                }

                $alreadyReviewed = ProductReview::where('user_id', $order->user_id)
                    ->where('product_id', $item->product_id)
                    ->where('order_id', $order->id)
                    ->exists();

                if ($alreadyReviewed) {
                    continue;
                }

                ProductReview::create([
                    'user_id'    => $order->user_id,
                    'product_id' => $item->product_id,
                    'order_id'   => $order->id,
                    'rating'     => $this->weightedRating(),
                    'comment'    => $comments[array_rand($comments)],
                    'created_at' => $order->completed_at ?? now()->subDays(rand(1, 10)),
                ]);

                $this->recalculate($item->product_id);
            }
        }
    }

    private function weightedRating(): int
    {
        $weights = [5 => 50, 4 => 30, 3 => 12, 2 => 5, 1 => 3];
        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $rating => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $rating;
            }
        }

        return 5;
    }

    private function recalculate(int $productId): void
    {
        $avg = ProductReview::where('product_id', $productId)->avg('rating');
        $count = ProductReview::where('product_id', $productId)->count();

        \App\Models\Product::where('id', $productId)->update([
            'rating'       => round($avg, 1),
            'review_count' => $count,
        ]);
    }
}
