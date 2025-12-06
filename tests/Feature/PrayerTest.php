<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_prayer_dashboard_loads()
    {
        $user = User::factory()->staff()->create(); // User needs staff role
        $this->actingAs($user);

        $response = $this->get(route('prayer.index'));

        $response->assertStatus(200);
    }

    public function test_submit_prayer_request()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create(); // Standard user (member) should be able to submit
        $this->actingAs($user);

        $response = $this->post(route('prayer.store'), [
            'requester_name' => $user->name ?? 'Test User',
            'request_title' => 'Healing for friend',
            'request_details' => 'Please pray for my friend who is sick.',
            'urgency' => 'high',
            'privacy_level' => 'public',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prayer_requests', ['request_title' => 'Healing for friend']);
    }
}
