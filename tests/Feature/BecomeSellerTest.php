<?php

namespace Tests\Feature;

use App\Models\SellerVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BecomeSellerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_become_seller(): void
    {
        $this->get(route('become-seller'))
            ->assertRedirect(route('login'));
    }

    public function test_buyer_can_view_become_seller_page(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->get(route('become-seller'))
            ->assertOk()
            ->assertViewIs('become-seller');
    }

    public function test_buyer_can_submit_seller_application(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->post(route('become-seller.store'), [
                'store_name' => 'Toko Test',
                'city' => 'Jakarta',
                'description' => 'Toko yang menjual berbagai produk',
            ])
            ->assertRedirect(route('become-seller'));

        $this->assertDatabaseHas('seller_verifications', [
            'user_id' => $buyer->id,
            'store_name' => 'Toko Test',
            'city' => 'Jakarta',
            'status' => 'pending',
        ]);
    }

    public function test_application_validates_required_fields(): void
    {
        $buyer = User::factory()->buyer()->create();
        $this->actingAs($buyer)
            ->post(route('become-seller.store'), [])
            ->assertSessionHasErrors(['store_name', 'city']);
    }

    public function test_buyer_with_pending_application_cannot_resubmit(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new \App\Models\SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Toko Lama',
            'city' => 'Bandung',
            'status' => 'pending',
        ])->save();

        $this->actingAs($buyer)
            ->post(route('become-seller.store'), [
                'store_name' => 'Toko Baru',
                'city' => 'Jakarta',
            ])
            ->assertSessionHas('info');
    }

    public function test_buyer_with_rejected_application_can_resubmit(): void
    {
        $buyer = User::factory()->buyer()->create();
        $verification = new \App\Models\SellerVerification;
        $verification->user_id = $buyer->id;
        $verification->forceFill([
            'store_name' => 'Toko Lama',
            'city' => 'Bandung',
            'status' => 'rejected',
            'admin_note' => 'Data tidak lengkap',
        ])->save();

        $this->actingAs($buyer)
            ->post(route('become-seller.store'), [
                'store_name' => 'Toko Baru',
                'city' => 'Jakarta',
                'description' => 'Toko baru dengan data lengkap',
            ])
            ->assertRedirect(route('become-seller'));

        $this->assertDatabaseHas('seller_verifications', [
            'user_id' => $buyer->id,
            'store_name' => 'Toko Baru',
            'status' => 'pending',
        ]);

        $this->assertDatabaseMissing('seller_verifications', [
            'store_name' => 'Toko Lama',
        ]);
    }

    public function test_seller_cannot_access_become_seller(): void
    {
        $seller = User::factory()->seller()->create();
        $this->actingAs($seller)
            ->get(route('become-seller'))
            ->assertForbidden();
    }
}
