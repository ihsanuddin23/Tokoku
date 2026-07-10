<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductVariantTest extends TestCase
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
        $category = Category::create(['name' => 'Fashion', 'icon' => '👕']);

        return [$seller, $sellerProfile, $category];
    }

    private function createBuyerWithProductAndVariant(): array
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();

        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'status' => 'active',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Ukuran L',
            'price_adjustment' => 5000,
            'stock' => 10,
            'sku' => 'PROD-L',
            'is_active' => true,
        ]);

        $buyer = User::factory()->buyer()->create();

        return [$buyer, $seller, $sellerProfile, $product, $variant];
    }

    // ─── Seller: Create product with variants ───

    public function test_seller_can_create_product_with_variants(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();

        $response = $this->actingAs($seller)->post('/seller/products', [
            'name' => 'Kaos Test',
            'category_id' => $category->id,
            'description' => 'Kaos berkualitas',
            'price' => 50000,
            'stock' => 100,
            'condition' => 'new',
            'status' => 'active',
            'variants' => [
                [
                    'name' => 'Ukuran S',
                    'price_adjustment' => 0,
                    'stock' => 20,
                    'sku' => 'K-S',
                ],
                [
                    'name' => 'Ukuran M',
                    'price_adjustment' => 5000,
                    'stock' => 15,
                    'sku' => 'K-M',
                ],
            ],
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $product = Product::where('name', 'Kaos Test')->first();
        $this->assertNotNull($product);
        $this->assertCount(2, $product->variants);
        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => 'Ukuran S',
            'price_adjustment' => 0,
            'stock' => 20,
        ]);
        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => 'Ukuran M',
            'price_adjustment' => 5000,
            'stock' => 15,
        ]);
    }

    // ─── Seller: Edit product — update existing variant ───

    public function test_seller_can_update_existing_variant(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'status' => 'active',
        ]);
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Ukuran L',
            'price_adjustment' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->actingAs($seller)->patch("/seller/products/{$product->id}", [
            'name' => $product->name,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'condition' => 'new',
            'status' => 'active',
            'variants' => [
                [
                    'id' => $variant->id,
                    'name' => 'Ukuran XL',
                    'price_adjustment' => 10000,
                    'stock' => 25,
                    'sku' => 'PROD-XL',
                    'is_active' => 1,
                ],
            ],
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $variant->refresh();
        $this->assertEquals('Ukuran XL', $variant->name);
        $this->assertEquals(10000, $variant->price_adjustment);
        $this->assertEquals(25, $variant->stock);
    }

    // ─── Seller: Edit product — add new variant ───

    public function test_seller_can_add_new_variant_on_edit(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'status' => 'active',
        ]);

        $response = $this->actingAs($seller)->patch("/seller/products/{$product->id}", [
            'name' => $product->name,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'condition' => 'new',
            'status' => 'active',
            'variants' => [
                [
                    'name' => 'Warna Merah',
                    'price_adjustment' => 0,
                    'stock' => 5,
                    'is_active' => 1,
                ],
            ],
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => 'Warna Merah',
            'stock' => 5,
        ]);
    }

    // ─── Seller: Edit product — delete variant ───

    public function test_seller_can_delete_variant_on_edit(): void
    {
        [$seller, $sellerProfile, $category] = $this->createVerifiedSeller();
        $product = Product::factory()->create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'status' => 'active',
        ]);
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Ukuran L',
            'price_adjustment' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->actingAs($seller)->patch("/seller/products/{$product->id}", [
            'name' => $product->name,
            'category_id' => $category->id,
            'price' => 100000,
            'stock' => 50,
            'condition' => 'new',
            'status' => 'active',
            'removed_variant_ids' => [$variant->id],
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $this->assertDatabaseMissing('product_variants', ['id' => $variant->id]);
    }

    // ─── Product detail: shows active variants ───

    public function test_product_detail_shows_active_variants(): void
    {
        [$buyer, $seller, $sellerProfile, $product, $variant] = $this->createBuyerWithProductAndVariant();

        $response = $this->actingAs($buyer)->get("/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('Ukuran L');
    }

    public function test_product_detail_hides_inactive_variants(): void
    {
        [$buyer, $seller, $sellerProfile, $product, $variant] = $this->createBuyerWithProductAndVariant();
        $variant->update(['is_active' => false]);

        $response = $this->actingAs($buyer)->get("/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertDontSee('Ukuran L');
    }

    // ─── Cart: add product with variant ───

    public function test_buyer_can_add_product_with_variant_to_cart(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        $response = $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('cart'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);
    }

    public function test_buyer_can_add_same_product_different_variants_as_separate_items(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();
        $variant2 = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Ukuran XL',
            'price_adjustment' => 10000,
            'stock' => 8,
            'is_active' => true,
        ]);

        $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 1,
        ]);

        $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'product_variant_id' => $variant2->id,
            'quantity' => 1,
        ]);

        $this->assertEquals(2, Cart::where('user_id', $buyer->id)->count());
    }

    public function test_buyer_cannot_add_more_than_variant_stock(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        $response = $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 20,
        ]);

        $response->assertSessionHas('info');
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
            'product_variant_id' => $variant->id,
        ]);
    }

    public function test_buyer_cannot_add_inactive_variant_to_cart(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();
        $variant->update(['is_active' => false]);

        $response = $this->actingAs($buyer)->post('/cart', [
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 1,
        ]);

        $response->assertSessionHas('info');
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
            'product_variant_id' => $variant->id,
        ]);
    }

    // ─── Cart: unit price uses variant effective price ───

    public function test_cart_unit_price_uses_variant_effective_price(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        $cart = $buyer->cartItems()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        $cart = Cart::find($cart->id);
        $cart->load('variant.product');
        // effective_price = product price (100000) + adjustment (5000) = 105000
        $this->assertEquals(105000, $cart->unit_price);
        $this->assertEquals(210000, $cart->subtotal);
    }

    // ─── Order: variant info saved to order_items ───

    public function test_order_saves_variant_info_to_order_items(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        Address::create([
            'user_id' => $buyer->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer->name,
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test No. 1',
            'is_default' => true,
        ]);

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 3,
        ]);

        $response = $this->actingAs($buyer)->post('/orders', [
            'address_id' => Address::first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();
        $this->assertNotNull($order);

        $orderItem = $order->items()->first();
        $this->assertEquals($variant->id, $orderItem->product_variant_id);
        $this->assertEquals('Ukuran L', $orderItem->variant_name);
        // product_price should be the variant effective price
        $this->assertEquals(105000, $orderItem->product_price);
    }

    // ─── Order: variant stock decremented ───

    public function test_order_decrements_variant_stock(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        Address::create([
            'user_id' => $buyer->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer->name,
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test No. 1',
            'is_default' => true,
        ]);

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 3,
        ]);

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => Address::first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        // Variant stock: 10 - 3 = 7
        $this->assertEquals(7, $variant->fresh()->stock);
        // Product stock should NOT be decremented when variant is used
        $this->assertEquals(50, $product->fresh()->stock);
    }

    // ─── Order: cancel restores variant stock ───

    public function test_cancel_order_restores_variant_stock(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        Address::create([
            'user_id' => $buyer->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer->name,
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test No. 1',
            'is_default' => true,
        ]);

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 3,
        ]);

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => Address::first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();
        $this->actingAs($buyer)->patch("/orders/{$order->id}/cancel");

        // Variant stock restored: 7 + 3 = 10
        $this->assertEquals(10, $variant->fresh()->stock);
    }

    // ─── Order: reorder includes variant ───

    public function test_reorder_includes_variant(): void
    {
        [$buyer, , , $product, $variant] = $this->createBuyerWithProductAndVariant();

        Address::create([
            'user_id' => $buyer->id,
            'label' => 'Rumah',
            'recipient_name' => $buyer->name,
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test No. 1',
            'is_default' => true,
        ]);

        $buyer->cartItems()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        $this->actingAs($buyer)->post('/orders', [
            'address_id' => Address::first()->id,
            'shipping_courier' => 'jne',
            'payment_method' => 'cod',
        ]);

        $order = Order::where('user_id', $buyer->id)->first();
        $order->forceFill(['status' => 'completed'])->save();
        $order->items()->update(['status' => 'completed']);

        $response = $this->actingAs($buyer)->post("/orders/{$order->id}/reorder");

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
        ]);
    }
}
