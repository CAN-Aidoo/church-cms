<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelfareTest extends TestCase
{
    use RefreshDatabase;

    public function test_welfare_dashboard_loads()
    {
        $user = User::factory()->admin()->create(); // User needs admin role
        $this->actingAs($user);

        $response = $this->get(route('welfare.index'));

        $response->assertStatus(200);
    }

    public function test_create_welfare_case()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->admin()->create(); // User needs admin role
        $this->actingAs($user);

        $response = $this->post(route('welfare.cases.store'), [
            'beneficiary_name' => 'John Doe',
            'case_title' => 'Medical Emergency',
            'case_description' => 'Need funds for surgery',
            'case_category' => 'medical',
            'priority' => 'high',
            'amount_requested' => 5000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('welfare_cases', ['beneficiary_name' => 'John Doe']);
    }

    public function test_create_welfare_program()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->admin()->create(); // User needs admin role
        $this->actingAs($user);

        $response = $this->post(route('welfare.programs.store'), [
            'program_name' => 'Scholarship Fund',
            'program_type' => 'scholarships',
            'budget_allocated' => 10000,
            'coordinator_id' => $user->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('welfare_programs', ['program_name' => 'Scholarship Fund']);
    }
}
