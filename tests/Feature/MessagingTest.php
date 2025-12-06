<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagingTest extends TestCase
{
    use RefreshDatabase;

    public function test_messaging_dashboard_loads()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('messaging.index'));

        $response->assertStatus(200);
    }

    public function test_start_direct_conversation()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $response = $this->post(route('messaging.direct'), [
            'user_id' => $user2->id,
        ]);

        $response->assertRedirect();
        // The controller's findOrCreateDirect method sets created_by and adds participants
        $this->assertDatabaseHas('conversations', [
            'type' => 'direct',
            'created_by' => $user1->id,
        ]);
        $this->assertDatabaseHas('conversation_participants', ['conversation_id' => Conversation::first()->id, 'user_id' => $user1->id]);
        $this->assertDatabaseHas('conversation_participants', ['conversation_id' => Conversation::first()->id, 'user_id' => $user2->id]);
    }

    public function test_send_message()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        // Create conversation first, ensuring 'created_by' is set
        $conversation = Conversation::create([
            'type' => 'direct',
            'created_by' => $user1->id, // Explicitly set created_by
        ]);
        // Add participants using create() for HasMany relationship
        $conversation->participants()->create(['user_id' => $user1->id]);
        $conversation->participants()->create(['user_id' => $user2->id]);

        $response = $this->post(route('messaging.messages.send', $conversation), [
            'content' => 'Hello there!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', ['content' => 'Hello there!']);
    }
}
