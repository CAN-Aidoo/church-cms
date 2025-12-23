<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendance_index_loads()
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->get(route('attendance.index'));

        $response->assertStatus(200);
    }

    public function test_mark_attendance()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $member = Member::factory()->create();

        $response = $this->post(route('attendance.store'), [
            'member_id' => $member->id,
            'service_date' => now()->toDateString(),
            'service_type' => 'sunday_first',
            'status' => 'present',
            'notes' => 'Test attendance',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('attendance', [
            'member_id' => $member->id,
            'status' => 'present',
            'service_type' => 'sunday_first',
        ]);
    }

    public function test_bulk_mark_attendance()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $member1 = Member::factory()->create();
        $member2 = Member::factory()->create();

        $response = $this->post(route('attendance.bulk'), [
            'service_date' => now()->toDateString(),
            'service_type' => 'midweek',
            'attendance' => [
                [
                    'member_id' => $member1->id,
                    'status' => 'present',
                ],
                [
                    'member_id' => $member2->id,
                    'status' => 'absent',
                ],
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendance', ['member_id' => $member1->id, 'status' => 'present']);
        $this->assertDatabaseHas('attendance', ['member_id' => $member2->id, 'status' => 'absent']);
    }
}
