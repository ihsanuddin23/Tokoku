<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SellerProfileFactory extends Factory
{
    public function definition(): array
    {
        $storeName = fake()->company() . ' Store';

        return [
            'user_id'     => User::factory()->seller(),
            'store_name'  => $storeName,
            'store_slug'  => Str::slug($storeName) . '-' . fake()->unique()->numerify('###'),
            'description' => fake()->paragraph(3),
            'logo'        => null,
            'banner'      => null,
            'city'        => fake()->randomElement([
                'Jakarta Selatan', 'Jakarta Barat', 'Bandung', 'Surabaya',
                'Medan', 'Semarang', 'Yogyakarta', 'Makassar', 'Palembang', 'Depok'
            ]),
            'is_verified' => 1,
            'is_active'   => 1,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn() => ['is_verified' => 0]);
    }
}
