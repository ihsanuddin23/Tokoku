<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::where('email', 'buyer@tokoku.test')->first();
        $products = Product::where('status', 'active')->take(20)->get();

        if (! $buyer || $products->isEmpty()) {
            return;
        }

        $address = Address::firstOrCreate(
            ['user_id' => $buyer->id],
            [
                'label' => 'Rumah',
                'recipient_name' => $buyer->name,
                'phone' => $buyer->phone,
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'district' => 'Kebayoran Baru',
                'postal_code' => '12190',
                'full_address' => 'Jl. Demo No. 123, Jakarta',
                'is_default' => true,
            ]
        );

        $statuses = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
        $weights = [40, 25, 15, 15, 5];

        foreach (range(1, 15) as $i) {
            $product = $products->random();
            $quantity = rand(1, 3);
            $subtotal = $product->price * $quantity;
            $status = $this->weightedRandom($statuses, $weights);

            $order = $buyer->orders()->create([
                'address_id' => $address->id,
                'notes' => rand(0, 1) ? 'Mohon dikemas rapi.' : null,
            ]);

            $order->forceFill([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'status' => $status,
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'grand_total' => $subtotal,
                'payment_method' => 'manual',
                'payment_status' => in_array($status, ['completed', 'paid', 'shipped']) ? 'paid' : 'unpaid',
                'shipping_address' => "{$address->recipient_name}, {$address->phone}\n{$address->full_address}\n{$address->district}, {$address->city}, {$address->province} {$address->postal_code}",
                'paid_at' => in_array($status, ['paid', 'shipped', 'completed']) ? now()->subDays(rand(1, 5)) : null,
                'shipped_at' => in_array($status, ['shipped', 'completed']) ? now()->subDays(rand(1, 3)) : null,
                'completed_at' => $status === 'completed' ? now()->subDays(rand(0, 2)) : null,
                'cancelled_at' => $status === 'cancelled' ? now()->subDays(rand(0, 1)) : null,
            ])->save();

            (new OrderItem)->forceFill([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'seller_profile_id' => $product->seller_profile_id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'status' => $status === 'completed' ? 'completed' : ($status === 'cancelled' ? 'cancelled' : 'pending'),
            ])->save();
        }
    }

    private function weightedRandom(array $items, array $weights): string
    {
        $total = array_sum($weights);
        $rand = mt_rand(1, $total);

        foreach ($items as $index => $item) {
            $rand -= $weights[$index];
            if ($rand <= 0) {
                return $item;
            }
        }

        return $items[0];
    }
}
