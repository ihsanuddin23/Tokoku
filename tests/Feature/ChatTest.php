<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    private User $buyer;
    private User $seller;
    private SellerProfile $sellerProfile;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        \App\Models\Category::factory()->create(['is_active' => true]);
        $this->buyer = User::factory()->buyer()->create();
        $this->seller = User::factory()->seller()->create();
        $this->sellerProfile = SellerProfile::factory()->create(['user_id' => $this->seller->id]);
        $this->product = Product::factory()->create([
            'seller_profile_id' => $this->sellerProfile->id,
            'status' => 'active',
            'stock' => 10,
        ]);
    }

    public function test_guest_cannot_access_messages(): void
    {
        $this->get(route('messages.index'))->assertRedirect(route('login'));
    }

    public function test_buyer_can_view_messages_index(): void
    {
        $this->actingAs($this->buyer)
            ->get(route('messages.index'))
            ->assertOk()
            ->assertViewIs('messages.index');
    }

    public function test_buyer_can_start_conversation(): void
    {
        $response = $this->actingAs($this->buyer)
            ->post(route('messages.start'), [
                'seller_profile_id' => $this->sellerProfile->id,
                'product_id' => $this->product->id,
                'body' => 'Halo, saya tertarik dengan produk ini',
            ]);

        $response->assertRedirect(route('messages.show', Conversation::first()));

        $this->assertDatabaseHas('conversations', [
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
        ]);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->buyer->id,
            'body' => 'Halo, saya tertarik dengan produk ini',
        ]);
    }

    public function test_seller_cannot_chat_with_own_store(): void
    {
        $this->actingAs($this->seller)
            ->post(route('messages.start'), [
                'seller_profile_id' => $this->sellerProfile->id,
                'body' => 'Halo',
            ])
            ->assertSessionHas('info');
    }

    public function test_start_conversation_validates_required_fields(): void
    {
        $this->actingAs($this->buyer)
            ->post(route('messages.start'), [])
            ->assertSessionHasErrors(['seller_profile_id', 'body']);
    }

    public function test_start_conversation_creates_only_one_per_buyer_seller_product(): void
    {
        $this->actingAs($this->buyer)
            ->post(route('messages.start'), [
                'seller_profile_id' => $this->sellerProfile->id,
                'product_id' => $this->product->id,
                'body' => 'Pesan 1',
            ]);

        $this->actingAs($this->buyer)
            ->post(route('messages.start'), [
                'seller_profile_id' => $this->sellerProfile->id,
                'product_id' => $this->product->id,
                'body' => 'Pesan 2',
            ]);

        $this->assertEquals(1, Conversation::count());
        $this->assertEquals(2, Message::count());
    }

    public function test_buyer_can_view_conversation(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->seller->id,
            'body' => 'Halo buyer',
            'is_read' => false,
        ]);

        $this->actingAs($this->buyer)
            ->get(route('messages.show', $conversation))
            ->assertOk()
            ->assertViewIs('messages.show')
            ->assertSee('Halo buyer');
    }

    public function test_seller_can_view_conversation(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($this->seller)
            ->get(route('messages.show', $conversation))
            ->assertOk();
    }

    public function test_unauthorized_user_cannot_view_conversation(): void
    {
        $otherUser = User::factory()->buyer()->create();

        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($otherUser)
            ->get(route('messages.show', $conversation))
            ->assertForbidden();
    }

    public function test_buyer_can_send_message_in_conversation(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($this->buyer)
            ->post(route('messages.store', $conversation), [
                'body' => 'Halo seller, produk ini ready?',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $this->buyer->id,
            'body' => 'Halo seller, produk ini ready?',
        ]);
    }

    public function test_seller_can_reply_to_conversation(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($this->seller)
            ->post(route('messages.store', $conversation), [
                'body' => 'Ready kak',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $this->seller->id,
            'body' => 'Ready kak',
        ]);
    }

    public function test_message_validates_body_required(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($this->buyer)
            ->post(route('messages.store', $conversation), [])
            ->assertSessionHasErrors(['body']);
    }

    public function test_message_body_max_1000_chars(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($this->buyer)
            ->post(route('messages.store', $conversation), [
                'body' => str_repeat('a', 1001),
            ])
            ->assertSessionHasErrors(['body']);
    }

    public function test_viewing_conversation_marks_messages_as_read(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->seller->id,
            'body' => 'Unread message',
            'is_read' => false,
        ]);

        $this->actingAs($this->buyer)
            ->get(route('messages.show', $conversation));

        $this->assertTrue($message->fresh()->is_read);
    }

    public function test_conversation_unread_count(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->seller->id,
            'body' => 'Msg 1',
            'is_read' => false,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->seller->id,
            'body' => 'Msg 2',
            'is_read' => false,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->seller->id,
            'body' => 'Msg 3',
            'is_read' => true,
        ]);

        $this->assertEquals(2, $conversation->unreadCount());
    }

    public function test_messages_index_shows_conversations(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->buyer->id,
            'body' => 'Test message',
        ]);

        $this->actingAs($this->buyer)
            ->get(route('messages.index'))
            ->assertOk()
            ->assertViewHas('conversations');
    }

    public function test_seller_sees_conversations_in_index(): void
    {
        $conversation = Conversation::create([
            'buyer_id' => $this->buyer->id,
            'seller_profile_id' => $this->sellerProfile->id,
            'product_id' => $this->product->id,
            'last_message_at' => now(),
        ]);

        $this->actingAs($this->seller)
            ->get(route('messages.index'))
            ->assertOk()
            ->assertViewHas('conversations');
    }
}
