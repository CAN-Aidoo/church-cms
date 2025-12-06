<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePlanningTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_planning_dashboard_loads()
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->get(route('services.index'));

        $response->assertStatus(200);
    }

    public function test_create_service_schedule()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->post(route('services.store'), [
            'name' => 'Sunday Service',
            'service_type' => 'regular',
            'service_date' => now()->addWeek()->toDateString(),
            'start_time' => '09:00',
            'end_time' => '11:00',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('service_schedules', ['name' => 'Sunday Service']);
    }
}
