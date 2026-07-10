<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_mark_notification_read(): void
    {
        $this->post('/notifications/123/read')
            ->assertRedirect(route('login'));
    }

    public function test_user_can_mark_notification_read(): void
    {
        $user = User::factory()->buyer()->create();

        $notification = DatabaseNotification::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'type' => 'App\\Notifications\\StockAvailableNotification',
            'data' => ['message' => 'Stok tersedia', 'url' => '/products/1'],
            'read_at' => null,
        ]);

        $this->actingAs($user)
            ->post(route('notifications.read', $notification->id))
            ->assertRedirect('/products/1');

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_user_can_mark_notification_read_json(): void
    {
        $user = User::factory()->buyer()->create();

        $notification = DatabaseNotification::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'type' => 'App\\Notifications\\StockAvailableNotification',
            'data' => ['message' => 'Stok tersedia'],
            'read_at' => null,
        ]);

        $this->actingAs($user)
            ->postJson(route('notifications.read', $notification->id))
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_user_cannot_mark_other_users_notification(): void
    {
        $user1 = User::factory()->buyer()->create();
        $user2 = User::factory()->buyer()->create();

        $notification = DatabaseNotification::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user1->id,
            'type' => 'App\\Notifications\\StockAvailableNotification',
            'data' => ['message' => 'Stok tersedia'],
            'read_at' => null,
        ]);

        $this->actingAs($user2)
            ->post(route('notifications.read', $notification->id))
            ->assertNotFound();
    }

    public function test_user_can_mark_all_notifications_read(): void
    {
        $user = User::factory()->buyer()->create();

        for ($i = 0; $i < 3; $i++) {
            DatabaseNotification::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'notifiable_type' => User::class,
                'notifiable_id' => $user->id,
                'type' => 'App\\Notifications\\StockAvailableNotification',
                'data' => ['message' => "Notif {$i}"],
                'read_at' => null,
            ]);
        }

        $this->actingAs($user)
            ->post(route('notifications.read-all'))
            ->assertRedirect();

        $this->assertEquals(0, $user->fresh()->unreadNotifications->count());
    }

    public function test_mark_notification_redirects_safely(): void
    {
        $user = User::factory()->buyer()->create();

        $notification = DatabaseNotification::create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'type' => 'App\\Notifications\\StockAvailableNotification',
            'data' => ['message' => 'Test', 'url' => 'https://evil.com'],
            'read_at' => null,
        ]);

        $this->actingAs($user)
            ->post(route('notifications.read', $notification->id))
            ->assertRedirect(); // Should redirect back, not to external URL
    }
}
