<?php

namespace Tests\Feature;

use App\Models\LiveStream;
use App\Models\MediaContent;
use App\Models\MediaTeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_media_dashboard_displays_statistics()
    {
        $user = User::factory()->staff()->create(); // User needs staff role
        $this->actingAs($user);

        // Ensure a MediaTeamMember exists for LiveStreamFactory to use
        MediaTeamMember::factory()->create(['user_id' => $user->id]);

        MediaContent::factory()->count(3)->create(['is_published' => true, 'uploaded_by' => $user->id]);
        LiveStream::factory()->count(2)->create(); // Factory now handles technician_id

        $response = $this->get(route('media.index'));

        $response->assertStatus(200);
        $response->assertViewHas('statistics');
    }

    public function test_content_upload()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->staff()->create(); // User needs staff role
        $this->actingAs($user);

        Storage::fake('public');
        $file = UploadedFile::fake()->create('sermon.mp4', 10000);

        $response = $this->post(route('media.content.store'), [
            'title' => 'Sunday Service',
            'content_type' => 'sermon_video',
            'content_date' => now()->toDateString(),
            'file' => $file,
        ]);

        $response->assertRedirect(route('media.content'));
        $this->assertDatabaseHas('media_content', ['title' => 'Sunday Service']);
    }

    public function test_stream_scheduling()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->staff()->create(); // User needs staff role
        $this->actingAs($user);

        MediaTeamMember::factory()->create(['user_id' => $user->id]); // Ensure a technician exists

        $response = $this->post(route('media.streams.store'), [
            'stream_title' => 'Midweek Service',
            'scheduled_start' => now()->addDays(2)->toDateTimeString(),
            'platforms' => ['youtube', 'facebook'],
        ]);

        $response->assertRedirect(route('media.streams'));
        $this->assertDatabaseHas('live_streams', ['stream_title' => 'Midweek Service']);
    }
}
