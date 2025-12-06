<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;

class VisitorTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_index_loads()
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->get(route('visitors.index'));

        $response->assertStatus(200);
    }

    public function test_create_visitor()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->post(route('visitors.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'visit_date' => now()->toDateString(),
            'service_type' => 'Sunday Service',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('visitors', ['email' => 'john.doe@example.com']);
    }
}