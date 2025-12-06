<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_equipment_index_loads()
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->get(route('equipment.index'));

        $response->assertStatus(200);
    }

    public function test_create_equipment()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->post(route('equipment.store'), [
            'name' => 'Yamaha Keyboard',
            'category' => 'Music',
            'purchase_date' => now()->subMonths(6)->toDateString(),
            'purchase_price' => 5000,
            'condition' => 'good',
            'status' => 'active',
            'location' => 'Main Auditorium',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('equipment', ['name' => 'Yamaha Keyboard']);
    }
}
