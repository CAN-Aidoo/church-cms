@extends('layouts.app')

@section('title', 'Media Library')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Media Library</h1>
            <p class="text-slate-500 mt-1">Organize and manage your digital assets.</p>
        </div>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/></svg>
            Upload Content
        </button>
    </div>

    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <!-- Filters Toolbar -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('media.content') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                <div class="relative flex-1 w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" name="search" placeholder="Search by title..." class="form-input pl-9 w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" value="{{ request('search') }}">
                </div>
                
                <div class="flex gap-4 w-full md:w-auto">
                    <select name="content_type" class="form-select rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500 w-full md:w-48">
                        <option value="">All Types</option>
                        <option value="sermon_video" {{ request('content_type') == 'sermon_video' ? 'selected' : '' }}>Sermon Video</option>
                        <option value="sermon_audio" {{ request('content_type') == 'sermon_audio' ? 'selected' : '' }}>Sermon Audio</option>
                        <option value="worship_session" {{ request('content_type') == 'worship_session' ? 'selected' : '' }}>Worship Session</option>
                        <option value="photo_gallery" {{ request('content_type') == 'photo_gallery' ? 'selected' : '' }}>Photo Gallery</option>
                    </select>

                    <select name="is_published" class="form-select rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500 w-full md:w-36">
                        <option value="">All Status</option>
                        <option value="1" {{ request('is_published') == '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ request('is_published') == '0' ? 'selected' : '' }}>Draft</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-colors font-bold text-sm shadow-sm md:w-auto w-full">
                        Filter
                    </button>
                    
                    @if(request()->anyFilled(['search', 'content_type', 'is_published']))
                        <a href="{{ route('media.content') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-bold text-sm text-center md:w-auto w-full">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Content Grid -->
        <div class="p-6 bg-slate-50/30 min-h-[400px]">
             @if(count($content) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($content as $item)
                        <div class="group bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                            <!-- Thumbnail -->
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                @if($item->thumbnail_path)
                                    <img src="{{ asset('storage/' . $item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300">
                                        @if(Str::contains($item->content_type, ['video']))
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @elseif(Str::contains($item->content_type, 'audio'))
                                             <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>
                                        @else
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                     <button class="p-2 bg-white rounded-full text-slate-800 hover:text-primary-600 transition-colors shadow-lg transform hover:scale-110" title="Preview">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>
                                     <button class="p-2 bg-white rounded-full text-slate-800 hover:text-primary-600 transition-colors shadow-lg transform hover:scale-110" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                </div>
                                
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-1 rounded-md bg-black/50 text-white text-[10px] font-bold backdrop-blur-sm uppercase tracking-wide">
                                        {{ str_replace('_', ' ', $item->content_type) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content Info -->
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 leading-tight" title="{{ $item->title }}">{{ $item->title }}</h3>
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                     <span class="text-xs text-slate-400 font-medium">{{ $item->content_date->format('M d, Y') }}</span>
                                    <span class="w-2 h-2 rounded-full {{ $item->is_published ? 'bg-emerald-400' : 'bg-amber-400' }}" title="{{ $item->is_published ? 'Published' : 'Draft' }}"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                 <div class="mt-8">
                    {{ $content->links() }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No content found</h3>
                    <p class="text-slate-500 max-w-sm mt-1 mb-6">Start building your library by uploading sermons, videos, or photos.</p>
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-bold text-sm shadow-sm transition-colors">
                        Upload Your First File
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-800">Upload Media</h3>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('media.content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Title</label>
                     <input type="text" name="title" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. Sunday Service - Faith">
                </div>
                
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Type</label>
                     <select name="content_type" required class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="sermon_video">Sermon Video</option>
                        <option value="sermon_audio">Sermon Audio</option>
                        <option value="worship_session">Worship Session</option>
                        <option value="photo_gallery">Photo Gallery</option>
                        <option value="other">Other</option>
                     </select>
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Date</label>
                     <input type="date" name="content_date" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500" value="{{ date('Y-m-d') }}">
                </div>

                <div class="p-4 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 text-center hover:bg-slate-100 transition-colors cursor-pointer relative">
                    <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="flex flex-col items-center">
                         <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                         <p class="text-sm font-bold text-slate-600">Click to upload file</p>
                         <p class="text-xs text-slate-400">MP4, MP3, JPG, PNG (Max 500MB)</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                 <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm">Cancel</button>
                 <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-bold text-sm shadow-sm">Upload File</button>
            </div>
        </form>
    </div>
</div>
@endsection
