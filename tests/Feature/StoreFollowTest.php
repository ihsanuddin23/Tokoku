<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\StoreFollower;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreFollowTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_follow_store(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
        ]);

        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->post(route('stores.follow', $store));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'followed']);
        $this->assertDatabaseHas('store_followers', [
            'user_id' => $buyer->id,
            'seller_profile_id' => $store->id,
        ]);
    }

    public function test_buyer_can_unfollow_store(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
        ]);

        $buyer = User::factory()->buyer()->create();
        StoreFollower::create([
            'user_id' => $buyer->id,
            'seller_profile_id' => $store->id,
        ]);

        $response = $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->delete(route('stores.unfollow', $store));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'unfollowed']);
        $this->assertDatabaseMissing('store_followers', [
            'user_id' => $buyer->id,
            'seller_profile_id' => $store->id,
        ]);
    }

    public function test_seller_cannot_follow_own_store(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
        ]);

        $response = $this->actingAs($seller)
            ->withHeader('Accept', 'application/json')
            ->post(route('stores.follow', $store));

        $response->assertStatus(400);
        $this->assertDatabaseMissing('store_followers', [
            'user_id' => $seller->id,
            'seller_profile_id' => $store->id,
        ]);
    }

    public function test_followed_stores_page_shows_followed_stores(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
            'store_name' => 'Toko Test Follow',
        ]);

        $buyer = User::factory()->buyer()->create();
        StoreFollower::create([
            'user_id' => $buyer->id,
            'seller_profile_id' => $store->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('stores.followed'));

        $response->assertStatus(200);
        $response->assertSee('Toko Test Follow');
    }

    public function test_followed_stores_page_empty_for_new_user(): void
    {
        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)->get(route('stores.followed'));

        $response->assertStatus(200);
        $response->assertSee('belum mengikuti');
    }

    public function test_store_page_shows_follower_count(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
            'store_slug' => 'test-store-slug',
        ]);
        $category = \App\Models\Category::factory()->create();
        Product::factory()->create([
            'seller_profile_id' => $store->id,
            'category_id' => $category->id,
            'status' => 'active',
        ]);

        $buyer = User::factory()->buyer()->create();
        StoreFollower::create([
            'user_id' => $buyer->id,
            'seller_profile_id' => $store->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('stores.show', 'test-store-slug'));

        $response->assertStatus(200);
        $response->assertSee('pengikut');
    }

    public function test_guest_cannot_follow_store(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
        ]);

        $response = $this->post(route('stores.follow', $store));

        $response->assertRedirect(route('login'));
    }

    public function test_following_twice_does_not_create_duplicate(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
        ]);

        $buyer = User::factory()->buyer()->create();

        $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->post(route('stores.follow', $store));

        $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->post(route('stores.follow', $store));

        $this->assertEquals(1, StoreFollower::where('user_id', $buyer->id)->count());
    }

    public function test_buyer_cannot_follow_inactive_store(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => false,
            'is_verified' => true,
        ]);

        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->post(route('stores.follow', $store));

        $response->assertStatus(404);
        $this->assertDatabaseMissing('store_followers', [
            'user_id' => $buyer->id,
            'seller_profile_id' => $store->id,
        ]);
    }

    public function test_unfollow_non_followed_store_does_not_error(): void
    {
        $seller = User::factory()->seller()->create();
        $store = SellerProfile::factory()->create([
            'user_id' => $seller->id,
            'is_active' => true,
            'is_verified' => true,
        ]);

        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)
            ->withHeader('Accept', 'application/json')
            ->delete(route('stores.unfollow', $store));

        $response->assertStatus(200);
        $response->assertJson(['status' => 'unfollowed']);
    }
}
