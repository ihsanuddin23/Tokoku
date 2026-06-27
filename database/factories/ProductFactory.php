<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SellerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(fake()->numberBetween(2, 5), true);
        $name = ucwords($name);
        $price = fake()->randomElement([
            15000, 25000, 35000, 50000, 75000, 99000,
            125000, 150000, 200000, 250000, 300000, 500000,
            750000, 1000000, 1500000, 2000000, 3500000, 5000000
        ]);

        return [
            'seller_profile_id' => SellerProfile::factory(),
            'category_id'    => Category::inRandomOrder()->first()?->id ?? 1,
            'name'           => $name,
            'slug'           => Str::slug($name) . '-' . fake()->unique()->numerify('####'),
            'description'    => fake()->paragraphs(3, true),
            'price'          => $price,
            'stock'          => fake()->numberBetween(0, 200),
            'weight'         => fake()->randomElement([100, 200, 300, 500, 750, 1000, 1500, 2000]),
            'condition'      => fake()->randomElement(['new', 'used']),
            'status'         => 'active',
            'total_sold'     => fake()->numberBetween(0, 500),
            'rating'         => fake()->randomFloat(2, 3.5, 5.0),
        ];
    }

    public function active(): static
    {
        return $this->state(fn() => ['status' => 'active', 'stock' => fake()->numberBetween(10, 200)]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn() => ['stock' => 0]);
    }
}
