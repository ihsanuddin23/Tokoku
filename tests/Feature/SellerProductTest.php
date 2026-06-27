<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerProductTest extends TestCase
{
    use RefreshDatabase;

    private function createVerifiedSeller(): array
    {
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_verified' => true,
            'is_active' => true,
        ]);
        $category = Category::create(['name' => 'Elektronik', 'icon' => '💻']);

        return [$seller, $sellerProfile, $category];
    }

    public function test_verified_seller_can_view_products_index(): void
    {
        [$seller] = $this->createVerifiedSeller();

        $response = $this->actingAs($seller)->get('/seller/products');

        $response->assertStatus(200);
    }

    public function test_verified_seller_can_view_create_product(): void
    {
        [$seller] = $this->createVerifiedSeller();

        $response = $this->actingAs($seller)->get('/seller/products/create');

        $response->assertStatus(200);
    }

    public function test_verified_seller_can_create_product(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();

        $response = $this->actingAs($seller)->post('/seller/products', [
            'name' => 'Test Product New',
            'category_id' => $category->id,
            'description' => 'Test description',
            'price' => 100000,
            'stock' => 10,
            'condition' => 'new',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $this->assertDatabaseHas('products', [
            'seller_profile_id' => $sellerProfile->id,
            'name' => 'Test Product New',
            'price' => 100000,
        ]);
    }

    public function test_seller_can_edit_own_product(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($seller)->get("/seller/products/{$product->id}/edit");

        $response->assertStatus(200);
    }

    public function test_seller_cannot_edit_other_seller_product(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();
        $otherSeller = User::factory()->seller()->create();
        SellerProfile::factory()->create(['user_id' => $otherSeller->id]);

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($otherSeller)->get("/seller/products/{$product->id}/edit");

        $response->assertStatus(403);
    }

    public function test_seller_can_update_own_product(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($seller)->patch("/seller/products/{$product->id}", [
            'name' => 'Updated Product Name',
            'category_id' => $category->id,
            'description' => 'Updated description',
            'price' => 200000,
            'stock' => 15,
            'condition' => 'new',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $this->assertEquals('Updated Product Name', $product->fresh()->name);
        $this->assertEquals(200000, $product->fresh()->price);
    }

    public function test_seller_cannot_update_other_seller_product(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();
        $otherSeller = User::factory()->seller()->create();
        SellerProfile::factory()->create(['user_id' => $otherSeller->id]);

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($otherSeller)->patch("/seller/products/{$product->id}", [
            'name' => 'Hacked Product',
            'category_id' => $category->id,
            'price' => 1,
            'stock' => 1,
            'condition' => 'new',
            'status' => 'active',
        ]);

        $response->assertStatus(403);
    }

    public function test_seller_can_delete_own_product_without_orders(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($seller)->delete("/seller/products/{$product->id}");

        $response->assertRedirect(route('seller.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_unverified_seller_cannot_access_products(): void
    {
        $seller = User::factory()->seller()->create();
        SellerProfile::factory()->unverified()->create(['user_id' => $seller->id]);

        $response = $this->actingAs($seller)->get('/seller/products');

        $response->assertRedirect('/');
    }

    public function test_buyer_cannot_access_seller_products(): void
    {
        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)->get('/seller/products');

        $response->assertStatus(403);
    }
}
