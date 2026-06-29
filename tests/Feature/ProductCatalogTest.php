<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    private function createActiveProduct(array $overrides = []): Product
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
        ]);
        $category = Category::create(['name' => 'Elektronik', 'icon' => '💻']);

        return Product::factory()->create(array_merge([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'status' => 'active',
        ], $overrides));
    }

    public function test_catalog_page_loads(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function test_catalog_filters_by_category(): void
    {
        $product = $this->createActiveProduct(['name' => 'Filtered Product']);

        $response = $this->get('/products?category=' . $product->category_id);

        $response->assertStatus(200);
        $response->assertSee('Filtered Product');
    }

    public function test_catalog_filters_by_price_range(): void
    {
        $this->createActiveProduct(['name' => 'Cheap Product', 'price' => 50000]);
        $this->createActiveProduct(['name' => 'Expensive Product', 'price' => 500000]);

        $response = $this->get('/products?min_price=10000&max_price=100000');

        $response->assertStatus(200);
        $response->assertSee('Cheap Product');
        $response->assertDontSee('Expensive Product');
    }

    public function test_catalog_filters_by_condition(): void
    {
        $this->createActiveProduct(['name' => 'New Product', 'condition' => 'new']);
        $this->createActiveProduct(['name' => 'Used Product', 'condition' => 'used']);

        $response = $this->get('/products?condition=new');

        $response->assertStatus(200);
        $response->assertSee('New Product');
        $response->assertDontSee('Used Product');
    }

    public function test_catalog_filters_by_minimum_rating(): void
    {
        $this->createActiveProduct(['name' => 'High Rated Product', 'rating' => 4.5]);
        $this->createActiveProduct(['name' => 'Low Rated Product', 'rating' => 2.5]);

        $response = $this->get('/products?min_rating=4');

        $response->assertStatus(200);
        $response->assertSee('High Rated Product');
        $response->assertDontSee('Low Rated Product');
    }

    public function test_catalog_sorts_by_price(): void
    {
        $this->createActiveProduct(['name' => 'Mid Product', 'price' => 100000]);
        $this->createActiveProduct(['name' => 'Low Product', 'price' => 50000]);
        $this->createActiveProduct(['name' => 'High Product', 'price' => 200000]);

        $response = $this->get('/products?sort=price_asc');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Low Product', 'Mid Product', 'High Product']);
    }
}
