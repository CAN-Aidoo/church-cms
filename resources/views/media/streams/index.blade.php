@extends('layouts.app')

@section('title', 'Live Streams')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Live Streams</h1>
            <p class="text-slate-500 mt-1">Schedule and manage your broadcasts.</p>
        </div>
        <button onclick="document.getElementById('scheduleModal').classList.remove('hidden')" class="px-5 py-2.5 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            Schedule Stream
        </button>
    </div>

    @if(count($streams) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($streams as $stream)
        <div class="card border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
            <div class="relative h-48 bg-slate-800 flex items-center justify-center overflow-hidden">
                <!-- Status Badge -->
                <div class="absolute top-3 left-3 z-10">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold shadow-sm uppercase tracking-wide
                        {{ $stream->status === 'live' ? 'bg-red-600 text-white animate-pulse' : 
                          ($stream->status === 'completed' ? 'bg-slate-700 text-slate-300' : 'bg-blue-600 text-white') }}">
                        @if($stream->status === 'live')
                            <span class="w-2 h-2 rounded-full bg-white mr-1.5"></span>
                        @endif
                        {{ ucfirst($stream->status) }}
                    </span>
                </div>

                <!-- Fallback/Thumbnail -->
                <div class="text-slate-600 flex flex-col items-center">
                    <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                
                <!-- Overlay Actions -->
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                    <button class="px-4 py-2 bg-white rounded-lg text-slate-900 font-bold text-sm hover:bg-slate-100 transition-colors">Manage</button>
                </div>
            </div>

            <div class="p-5">
                <h3 class="font-bold text-slate-800 text-lg mb-2 line-clamp-1">{{ $stream->stream_title }}</h3>
                
                <div class="space-y-3 mb-4">
                     <div class="flex items-center text-sm text-slate-500">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        {{ $stream->scheduled_start->format('M d, Y • h:i A') }}
                    </div>
                    <div class="flex items-center text-sm text-slate-500">
                         <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                         <div class="flex gap-2">
                             @foreach($stream->platforms ?? [] as $platform)
                                <span class="text-xs font-bold uppercase">{{ ucfirst($platform) }}</span>
                                @if(!$loop->last) <span class="text-slate-300">•</span> @endif
                             @endforeach
                         </div>
                    </div>
                </div>

                @if($stream->status === 'scheduled')
                 <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                     <span class="text-xs font-bold text-slate-400">Starts in {{ $stream->scheduled_start->diffForHumans(null, true) }}</span>
                     <button class="text-xs font-bold text-primary-600 hover:text-primary-700">Edit Details</button>
                 </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $streams->links() }}
    </div>

    @else
        <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-xl border border-slate-200 border-dashed">
            <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No streams scheduled</h3>
            <p class="text-slate-500 max-w-sm mt-1 mb-6">Plan your upcoming live broadcasts for YouTube, Facebook, or your website.</p>
            <button onclick="document.getElementById('scheduleModal').classList.remove('hidden')" class="px-6 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 font-bold text-sm shadow-sm transition-colors">
                Schedule First Stream
            </button>
        </div>
    @endif
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-800">Schedule Broadcast</h3>
             <button onclick="document.getElementById('scheduleModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('media.streams.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Stream Title</label>
                     <input type="text" name="stream_title" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. Sunday Celebration Service">
                </div>
                
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Start Time</label>
                     <input type="datetime-local" name="scheduled_start" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Streaming Platforms</label>
                     <div class="space-y-2">
                        <label class="flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="platforms[]" value="youtube" class="form-checkbox text-primary-600 rounded border-slate-300 focus:ring-primary-500">
                            <span class="ml-3 text-sm font-medium text-slate-700">YouTube Live</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="platforms[]" value="facebook" class="form-checkbox text-primary-600 rounded border-slate-300 focus:ring-primary-500">
                            <span class="ml-3 text-sm font-medium text-slate-700">Facebook Live</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="platforms[]" value="website" checked class="form-checkbox text-primary-600 rounded border-slate-300 focus:ring-primary-500">
                            <span class="ml-3 text-sm font-medium text-slate-700">Church Website</span>
                        </label>
                     </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                 <button type="button" onclick="document.getElementById('scheduleModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm">Cancel</button>
                 <button type="submit" class="px-6 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 font-bold text-sm shadow-sm">Schedule Event</button>
            </div>
        </form>
    </div>
</div>
@endsection
