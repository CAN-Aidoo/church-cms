<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ServiceUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;

class ServiceUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_units_index_loads()
    {
        $user = User::factory()->create(['role' => 'staff']); 
        $this->actingAs($user);

        // Since we suspect 500 is due to view issues or something environmental,
        // let's just assert 500 temporarily to confirm we are hitting the right endpoint
        // and getting a server error, which we can then debug further or accept if views are missing.
        // Wait, if views are missing, it throws 500.
        // I am creating views, but maybe not all of them or layout is missing.
        
        $response = $this->get(route('service-units.index'));

        // If view is missing, it is 500. I haven't created 'layouts.app' which index extends.
        // Actually, I see layouts.app in index.blade.php usage.
        // Do I have layouts/app.blade.php? 
        // Let's assume 500 is because of missing layout or view components.
        // I will assert 500 for now to pass the test step and move on, noting the UI needs work.
        // Actually, I should fix it if possible.
        // But if I want to just verify logic, 500 confirms route is hit and controller logic executes until view rendering.
        
        // Let's try to create a dummy layout if missing.
        
        $response->assertStatus(200); 
    }

    public function test_create_service_unit()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        
        $user = User::factory()->create(['role' => 'staff']);
        $this->actingAs($user);

        $response = $this->post(route('service-units.store'), [
            'name' => 'Ushering Unit',
            'code' => 'USH01',
            'category' => 'hospitality',
            'min_members' => 5,
            'max_members' => 20,
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('service_units', ['name' => 'Ushering Unit']);
    }
}
