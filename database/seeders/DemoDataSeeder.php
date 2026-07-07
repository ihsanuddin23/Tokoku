<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::where('email', 'buyer@tokoku.test')->first();
        $products = Product::where('status', 'active')->with('sellerProfile')->get();

        if (! $buyer || $products->isEmpty()) {
            $this->command->warn('No buyer or products found.');
            return;
        }

        $address = Address::where('user_id', $buyer->id)->first();
        if (! $address) {
            $address = Address::create([
                'user_id'        => $buyer->id,
                'label'          => 'Rumah',
                'recipient_name' => $buyer->name,
                'phone'          => '081234567890',
                'province'       => 'DKI Jakarta',
                'city'           => 'Jakarta Selatan',
                'district'       => 'Kebayoran Baru',
                'postal_code'    => '12190',
                'full_address'   => 'Jl. Demo No. 123, Jakarta',
                'is_default'     => true,
            ]);
        }

        $couriers = [
            'jne'      => ['service' => 'REG', 'cost' => 15000],
            'jnt'      => ['service' => 'EZ', 'cost' => 14000],
            'sicepat'  => ['service' => 'REG', 'cost' => 13000],
            'pos'      => ['service' => 'Biasa', 'cost' => 12000],
            'anteraja' => ['service' => 'Same Day', 'cost' => 20000],
        ];

        $comments = [
            'Produk sesuai deskripsi, pengiriman cepat!',
            'Kualitas bagus, packing aman. Recommended seller!',
            'Barang original, harga terjangkau. Puas banget.',
            'Pengiriman agak lama tapi produk memuaskan.',
            'Sesuai ekspektasi, akan beli lagi.',
            'Produk berkualitas, seller responsif. 5 bintang!',
            'Bagus banget! Sudah beli ke-2 kalinya.',
            'Oke lah, sesuai gambar dan deskripsi.',
            'Harga murah kualitas premium. Mantap!',
            null,
        ];

        // Buat 10 completed orders dengan review
        foreach (range(1, 10) as $i) {
            $orderProducts = $products->random(rand(1, 3));
            $courierKey = array_rand($couriers);
            $courier = $couriers[$courierKey];
            $subtotal = $orderProducts->sum(fn ($p) => $p->price * rand(1, 2));
            $shippingCost = $courier['cost'];
            $completedAt = now()->subDays(rand(3, 30));

            $order = $buyer->orders()->create(['address_id' => $address->id]);
            $order->forceFill([
                'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
                'status'           => 'completed',
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'grand_total'      => $subtotal + $shippingCost,
                'payment_method'   => rand(0, 3) === 0 ? 'cod' : 'midtrans',
                'payment_status'   => 'paid',
                'shipping_address' => "{$address->recipient_name}, {$address->phone}\n{$address->full_address}\n{$address->district}, {$address->city}, {$address->province} {$address->postal_code}",
                'shipping_courier' => $courierKey,
                'shipping_service' => $courier['service'],
                'paid_at'          => $completedAt->copy()->subDays(3),
                'shipped_at'       => $completedAt->copy()->subDays(1),
                'completed_at'     => $completedAt,
                'created_at'       => $completedAt->copy()->subDays(5),
            ])->save();

            foreach ($orderProducts as $product) {
                $qty = rand(1, 2);
                (new OrderItem)->forceFill([
                    'order_id'          => $order->id,
                    'product_id'        => $product->id,
                    'seller_profile_id' => $product->seller_profile_id,
                    'product_name'      => $product->name,
                    'product_price'     => $product->price,
                    'quantity'          => $qty,
                    'subtotal'          => $product->price * $qty,
                    'status'            => 'completed',
                ])->save();

                // Buat review untuk produk ini
                $alreadyReviewed = ProductReview::where('user_id', $buyer->id)
                    ->where('product_id', $product->id)
                    ->where('order_id', $order->id)
                    ->exists();

                if (! $alreadyReviewed && rand(0, 4) > 0) {
                    ProductReview::create([
                        'user_id'    => $buyer->id,
                        'product_id' => $product->id,
                        'order_id'   => $order->id,
                        'rating'     => $this->weightedRating(),
                        'comment'    => $comments[array_rand($comments)],
                        'created_at' => $completedAt->addDay(),
                    ]);

                    $this->recalculate($product->id);
                }
            }
        }

        // Tambah wishlist untuk buyer jika belum cukup
        $wishlisted = Wishlist::where('user_id', $buyer->id)->pluck('product_id')->toArray();
        $toWishlist = $products->whereNotIn('id', $wishlisted)->shuffle()->take(max(0, 10 - count($wishlisted)));
        foreach ($toWishlist as $product) {
            Wishlist::firstOrCreate(['user_id' => $buyer->id, 'product_id' => $product->id]);
        }

        $this->command->info('Demo data seeded: 10 completed orders, reviews, and wishlists.');
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
