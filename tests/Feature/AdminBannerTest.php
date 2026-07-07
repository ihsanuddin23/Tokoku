<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBannerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_banners_index(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/banners');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_banner_without_image(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/banners', [
            'title' => 'Test Banner Promo',
            'link' => '/products',
            'order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.banners.index'));
        $this->assertDatabaseHas('banners', [
            'title' => 'Test Banner Promo',
            'image_path' => null,
        ]);
    }

    public function test_admin_can_update_banner(): void
    {
        $admin = User::factory()->admin()->create();
        $banner = Banner::create([
            'title' => 'Old Title',
            'image_path' => null,
            'link' => '/products',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch("/admin/banners/{$banner->id}", [
            'title' => 'Updated Banner Title',
            'link' => '/products?sort=newest',
            'order' => 2,
            'is_active' => false,
        ]);

        $response->assertRedirect(route('admin.banners.index'));
        $this->assertEquals('Updated Banner Title', $banner->fresh()->title);
        $this->assertFalse($banner->fresh()->is_active);
    }

    public function test_admin_can_delete_banner(): void
    {
        $admin = User::factory()->admin()->create();
        $banner = Banner::create([
            'title' => 'Delete Me',
            'image_path' => null,
            'link' => '/products',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->withSession(['auth.password_confirmed_at' => time()])->delete("/admin/banners/{$banner->id}");

        $response->assertRedirect(route('admin.banners.index'));
        $this->assertSoftDeleted('banners', ['id' => $banner->id]);
    }

    public function test_admin_delete_banner_requires_password_confirmation(): void
    {
        $admin = User::factory()->admin()->create();
        $banner = Banner::create([
            'title' => 'Confirm Me',
            'image_path' => null,
            'link' => '/products',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/banners/{$banner->id}");

        $response->assertRedirect(route('password.confirm'));
        $this->assertDatabaseHas('banners', ['id' => $banner->id]);
    }

    public function test_non_admin_cannot_access_banners(): void
    {
        $buyer = User::factory()->buyer()->create();

        $response = $this->actingAs($buyer)->get('/admin/banners');

        $response->assertStatus(403);
    }

    public function test_seller_cannot_access_banners(): void
    {
        $seller = User::factory()->seller()->create();

        $response = $this->actingAs($seller)->get('/admin/banners');

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_banners(): void
    {
        $response = $this->get('/admin/banners');

        $response->assertRedirect(route('login'));
    }
}
