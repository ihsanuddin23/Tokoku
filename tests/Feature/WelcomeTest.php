<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_welcome_page_shows_active_banners(): void
    {
        Banner::create([
            'title' => 'Active Banner',
            'image_path' => null,
            'link' => '/products',
            'order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Inactive Banner',
            'image_path' => null,
            'link' => '/products',
            'order' => 2,
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Active Banner');
        $response->assertDontSee('Inactive Banner');
    }

    public function test_welcome_page_shows_categories(): void
    {
        Category::create(['name' => 'Elektronik Test', 'icon' => '💻']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Elektronik Test');
    }

    public function test_welcome_page_shows_products(): void
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $category = Category::create(['name' => 'Test Cat', 'icon' => '📦']);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'name' => 'Welcome Test Product',
            'status' => 'active',
            'total_sold' => 100,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Welcome Test Product');
    }

    public function test_welcome_page_does_not_show_inactive_products(): void
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $category = Category::create(['name' => 'Test Cat', 'icon' => '📦']);
        Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'name' => 'Inactive Product Show',
            'status' => 'inactive',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Inactive Product Show');
    }
}
