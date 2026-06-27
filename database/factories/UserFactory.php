<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'role'              => 'buyer',
            'phone'             => '08' . fake()->numerify('#########'),
            'avatar'            => null,
            'is_active'         => 1,
            'remember_token'    => Str::random(10),
        ];
    }

    // State: buyer
    public function buyer(): static
    {
        return $this->state(fn() => ['role' => 'buyer']);
    }

    // State: seller
    public function seller(): static
    {
        return $this->state(fn() => ['role' => 'seller']);
    }

    // State: admin
    public function admin(): static
    {
        return $this->state(fn() => ['role' => 'admin']);
    }

    // State: banned
    public function banned(): static
    {
        return $this->state(fn() => ['is_active' => 0]);
    }

    public function unverified(): static
    {
        return $this->state(fn() => ['email_verified_at' => null]);
    }
}
