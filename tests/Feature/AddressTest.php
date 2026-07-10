<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->buyer()->create();
    }

    public function test_guest_cannot_access_addresses(): void
    {
        $this->get(route('profile.addresses'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_view_addresses_index(): void
    {
        $this->actingAs($this->user)
            ->get(route('profile.addresses'))
            ->assertOk()
            ->assertViewIs('profile.addresses');
    }

    public function test_user_can_create_address(): void
    {
        $this->actingAs($this->user)
            ->post(route('profile.addresses.store'), [
                'label' => 'Rumah',
                'recipient_name' => 'Test User',
                'phone' => '081234567890',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'district' => 'Kebayoran',
                'postal_code' => '12190',
                'full_address' => 'Jl. Test No. 123',
            ])
            ->assertRedirect(route('profile.addresses'));

        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'city' => 'Jakarta',
        ]);
    }

    public function test_create_address_validates_required_fields(): void
    {
        $this->actingAs($this->user)
            ->post(route('profile.addresses.store'), [])
            ->assertSessionHasErrors(['label', 'recipient_name', 'phone', 'province', 'city', 'district', 'postal_code', 'full_address']);
    }

    public function test_user_can_create_default_address(): void
    {
        $this->actingAs($this->user)
            ->post(route('profile.addresses.store'), [
                'label' => 'Rumah',
                'recipient_name' => 'Test User',
                'phone' => '081234567890',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'district' => 'Kebayoran',
                'postal_code' => '12190',
                'full_address' => 'Jl. Test No. 123',
                'is_default' => true,
            ]);

        $address = Address::where('user_id', $this->user->id)->first();
        $this->assertTrue($address->is_default);
    }

    public function test_setting_new_default_unsets_previous_default(): void
    {
        $first = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
            'is_default' => true,
        ]);

        $this->actingAs($this->user)
            ->post(route('profile.addresses.store'), [
                'label' => 'Kantor',
                'recipient_name' => 'Test User',
                'phone' => '081234567890',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'district' => 'Sudirman',
                'postal_code' => '12190',
                'full_address' => 'Jl. Sudirman No. 1',
                'is_default' => true,
            ]);

        $this->assertFalse($first->fresh()->is_default);
    }

    public function test_user_can_update_address(): void
    {
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Old Name',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
        ]);

        $this->actingAs($this->user)
            ->patch(route('profile.addresses.update', $address), [
                'label' => 'Kantor',
                'recipient_name' => 'New Name',
                'phone' => '089876543210',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'district' => 'Dago',
                'postal_code' => '40115',
                'full_address' => 'Jl. Dago No. 5',
            ])
            ->assertRedirect(route('profile.addresses'));

        $this->assertEquals('Kantor', $address->fresh()->label);
        $this->assertEquals('Bandung', $address->fresh()->city);
    }

    public function test_other_user_cannot_update_address(): void
    {
        $otherUser = User::factory()->buyer()->create();
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
        ]);

        $this->actingAs($otherUser)
            ->patch(route('profile.addresses.update', $address), [
                'label' => 'Hacked',
                'recipient_name' => 'Hacker',
                'phone' => '081234567890',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'district' => 'Test',
                'postal_code' => '12345',
                'full_address' => 'Jl. Hack',
            ])
            ->assertForbidden();
    }

    public function test_user_can_delete_address(): void
    {
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
        ]);

        $this->actingAs($this->user)
            ->delete(route('profile.addresses.destroy', $address))
            ->assertRedirect(route('profile.addresses'));

        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function test_other_user_cannot_delete_address(): void
    {
        $otherUser = User::factory()->buyer()->create();
        $address = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
        ]);

        $this->actingAs($otherUser)
            ->delete(route('profile.addresses.destroy', $address))
            ->assertForbidden();
    }

    public function test_user_can_set_default_address(): void
    {
        $first = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Rumah',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Test',
            'postal_code' => '12345',
            'full_address' => 'Jl. Test',
            'is_default' => true,
        ]);

        $second = Address::create([
            'user_id' => $this->user->id,
            'label' => 'Kantor',
            'recipient_name' => 'Test',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Sudirman',
            'postal_code' => '12190',
            'full_address' => 'Jl. Sudirman',
        ]);

        $this->actingAs($this->user)
            ->post(route('profile.addresses.set-default', $second))
            ->assertRedirect(route('profile.addresses'));

        $this->assertFalse($first->fresh()->is_default);
        $this->assertTrue($second->fresh()->is_default);
    }
}
