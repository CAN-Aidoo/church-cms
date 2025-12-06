<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_partnerships_dashboard_loads()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $response = $this->get(route('partnerships.index'));

        $response->assertStatus(200);
    }

    public function test_create_partner()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $response = $this->post(route('partnerships.partners.store'), [
            'name' => 'Global Missions Inc.',
            'category' => 'mission',
            'email' => 'contact@globalmissions.org',
        ]);

        $response->assertRedirect(route('partnerships.partners'));
        $this->assertDatabaseHas('partners', ['name' => 'Global Missions Inc.']);
    }

    public function test_create_agreement()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $partner = Partner::create([
            'name' => 'Test Partner',
            'category' => 'other',
            'status' => 'active',
        ]);

        $response = $this->post(route('partnerships.agreements.store'), [
            'partner_id' => $partner->id,
            'agreement_title' => '2024 Sponsorship',
            'start_date' => now()->toDateString(),
            'financial_commitment' => 5000,
        ]);

        $response->assertRedirect(route('partnerships.agreements'));
        $this->assertDatabaseHas('partnership_agreements', ['agreement_title' => '2024 Sponsorship']);
    }
}
