<?php

namespace App\Http\Controllers;

use App\Models\LiveStream;
use App\Models\MediaContent;
use App\Repositories\MediaRepository; // Corrected from App->Repositories
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(private MediaRepository $repository) {}

    public function index()
    {
        $statistics = $this->repository->getDashboardStatistics();

        return view('media.index', compact('statistics'));
    }

    public function content(Request $request)
    {
        $filters = $request->only(['content_type', 'is_published']);
        $content = $this->repository->getContent($filters);

        return view('media.content.index', compact('content', 'filters'));
    }

    public function storeContent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:sermon_video,sermon_audio,event_video,testimony,worship_session,photo_gallery,other',
            'content_date' => 'required|date',
            'file' => 'required|file|max:512000',
        ]);

        $validated['file_paths'] = [$request->file('file')->store('media-content', 'public')];
        $validated['uploaded_by'] = auth()->id();

        MediaContent::create($validated);

        return redirect()->route('media.content')->with('success', 'Content uploaded successfully.');
    }

    public function publishContent(MediaContent $content)
    {
        $content->publish();

        return redirect()->back()->with('success', 'Content published.');
    }

    public function streams(Request $request)
    {
        $filters = $request->only(['status']);
        $streams = $this->repository->getStreams($filters);

        return view('media.streams.index', compact('streams', 'filters'));
    }

    public function storeStream(Request $request)
    {
        $validated = $request->validate([
            'stream_title' => 'required|string|max:255',
            'scheduled_start' => 'required|date_format:Y-m-d H:i:s', // Changed from datetime
            'platforms' => 'required|array',
        ]);

        $validated['technician_id'] = auth()->user()->mediaTeamMember->id ?? null;

        LiveStream::create($validated);

        return redirect()->route('media.streams')->with('success', 'Stream scheduled successfully.');
    }

    public function teamMembers(Request $request)
    {
        $filters = $request->only(['is_active', 'primary_role']);
        $members = $this->repository->getTeamMembers($filters);

        return view('media.team.index', compact('members', 'filters'));
    }

    /**
     * Display media content details.
     */
    public function showContent(MediaContent $content)
    {
        $content->load('uploader');
        return view('media.content.show', compact('content'));
    }

    /**
     * Show edit form for media content.
     */
    public function editContent(MediaContent $content)
    {
        return view('media.content.edit', compact('content'));
    }

    /**
     * Update media content.
     */
    public function updateContent(Request $request, MediaContent $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'required|in:sermon_video,sermon_audio,event_video,testimony,worship_session,photo_gallery,other',
            'content_date' => 'required|date',
        ]);

        $content->update($validated);

        return redirect()->route('media.content.show', $content)
            ->with('success', 'Content updated successfully.');
    }

    /**
     * Delete media content.
     */
    public function destroyContent(MediaContent $content)
    {
        // Delete associated files
        foreach ($content->file_paths ?? [] as $filePath) {
            if (\Storage::disk('public')->exists($filePath)) {
                \Storage::disk('public')->delete($filePath);
            }
        }

        $content->delete();

        return redirect()->route('media.content')
            ->with('success', 'Media content deleted successfully.');
    }

    /**
     * Display stream details.
     */
    public function showStream(LiveStream $stream)
    {
        $stream->load('technician');
        return view('media.streams.show', compact('stream'));
    }

    /**
     * Show edit form for stream.
     */
    public function editStream(LiveStream $stream)
    {
        return view('media.streams.edit', compact('stream'));
    }

    /**
     * Update stream.
     */
    public function updateStream(Request $request, LiveStream $stream)
    {
        $validated = $request->validate([
            'stream_title' => 'required|string|max:255',
            'scheduled_start' => 'required|date_format:Y-m-d H:i:s',
            'platforms' => 'required|array',
        ]);

        $stream->update($validated);

        return redirect()->route('media.streams.show', $stream)
            ->with('success', 'Stream updated successfully.');
    }

    /**
     * Delete stream.
     */
    public function destroyStream(LiveStream $stream)
    {
        // Only allow deletion if not currently live
        if ($stream->status === 'live') {
            return redirect()->back()
                ->with('error', 'Cannot delete a stream that is currently live. End it first.');
        }

        $stream->delete();

        return redirect()->route('media.streams')
            ->with('success', 'Live stream deleted successfully.');
    }
}
