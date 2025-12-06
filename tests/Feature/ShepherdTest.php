<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Shepherd;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;

class ShepherdTest extends TestCase
{
    use RefreshDatabase;

    public function test_shepherds_index_loads()
    {
        $user = User::factory()->pastor()->create();
        $this->actingAs($user);

        $response = $this->get(route('shepherds.index'));

        $response->assertStatus(200);
    }

    public function test_create_shepherd()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        
        $user = User::factory()->pastor()->create();
        $this->actingAs($user);
        
        $member = Member::factory()->create();

        $response = $this->post(route('shepherds.store'), [
            'member_id' => $member->id,
            'flock_name' => 'Grace Flock',
            'appointed_date' => now()->toDateString(),
            'max_flock_size' => 12,
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('shepherds', ['flock_name' => 'Grace Flock']);
    }
}