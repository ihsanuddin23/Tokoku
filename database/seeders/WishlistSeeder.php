<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::where('email', 'buyer@tokoku.test')->first();
        if (! $buyer) {
            return;
        }

        $products = Product::where('status', 'active')->inRandomOrder()->take(8)->get();

        foreach ($products as $product) {
            Wishlist::firstOrCreate([
                'user_id'    => $buyer->id,
                'product_id' => $product->id,
            ]);
        }

        $extraBuyers = User::where('role', 'buyer')->where('email', '!=', 'buyer@tokoku.test')->take(3)->get();
        $allProducts = Product::where('status', 'active')->get();

        foreach ($extraBuyers as $extraBuyer) {
            $picks = $allProducts->random(min(5, $allProducts->count()));
            foreach ($picks as $product) {
                Wishlist::firstOrCreate([
                    'user_id'    => $extraBuyer->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
