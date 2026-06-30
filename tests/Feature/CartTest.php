<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private function createBuyerWithProduct(): array
    {
        $buyer = User::factory()->buyer()->create();
        $seller = User::factory()->seller()->create();
        $sellerProfile = SellerProfile::factory()->create(['user_id' => $seller->id]);
        $category = Category::create(['name' => 'Test Category', 'icon' => '📦']);
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'stock' => 50,
            'status' => 'active',
        ]);

        return [$buyer, $product];
    }

    public function test_buyer_can_view_cart(): void
    {
        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)->get('/cart');

        $response->assertStatus(200);
    }

    public function test_buyer_can_add_product_to_cart(): void
    {
        [$buyer, $product] = $this->createBuyerWithProduct();

        $response = $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('cart'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_buyer_cannot_add_inactive_product_to_cart(): void
    {
        [$buyer, $product] = $this->createBuyerWithProduct();
        $product->update(['status' => 'inactive']);

        $response = $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertSessionHas('info');
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_buyer_cannot_add_more_than_stock(): void
    {
        [$buyer, $product] = $this->createBuyerWithProduct();
        $product->update(['stock' => 5]);

        $response = $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'quantity' => 10,
        ]);

        $response->assertSessionHas('info');
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_buyer_can_update_cart_quantity(): void
    {
        [$buyer, $product] = $this->createBuyerWithProduct();

        $cart = $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->patch("/cart/{$cart->id}", [
            'quantity' => 3,
        ]);

        $response->assertRedirect();
        $this->assertEquals(3, $cart->fresh()->quantity);
    }

    public function test_buyer_can_remove_cart_item(): void
    {
        [$buyer, $product] = $this->createBuyerWithProduct();

        $cart = $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->delete("/cart/{$cart->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    public function test_buyer_cannot_update_other_user_cart(): void
    {
        [$buyer, $product] = $this->createBuyerWithProduct();
        $otherBuyer = User::factory()->buyer()->create();

        $cart = $buyer->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($otherBuyer)->patch("/cart/{$cart->id}", [
            'quantity' => 5,
        ]);

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_cart(): void
    {
        $response = $this->get('/cart');

        $response->assertRedirect(route('login'));
    }
}
