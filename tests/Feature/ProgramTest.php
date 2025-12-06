<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    public function test_programs_index_loads()
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->get(route('programs.index'));

        $response->assertStatus(200);
    }

    public function test_create_program()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->post(route('programs.store'), [
            'name' => 'Youth Conference',
            'description' => 'Annual youth gathering',
            'type' => 'conference',
            'category' => 'youth',
            'start_date' => now()->addMonth()->toDateString(),
            'end_date' => now()->addMonth()->addDays(2)->toDateString(),
            'requires_registration' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('programs', ['name' => 'Youth Conference']);
    }
}
