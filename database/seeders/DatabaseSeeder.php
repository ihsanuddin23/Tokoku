<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            SellerProfileSeeder::class,
            ProductSeeder::class,
            BannerSeeder::class,
            OrderSeeder::class,
            WishlistSeeder::class,
            ReviewSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
