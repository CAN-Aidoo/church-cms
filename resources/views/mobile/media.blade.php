@extends('layouts.mobile')

@section('title', 'Media')
@section('header', 'Sermons & Media')

@section('content')
<div class="pb-24 pt-4">
    <!-- Featured Sermon (Hero) -->
    <div class="px-6 mb-8">
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Latest Message</h2>
        <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-lg group cursor-pointer" onclick="playMedia('featured')">
            <img src="https://images.unsplash.com/photo-1438232992991-995b7058bbb3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Featured Sermon">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent opacity-80"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                 <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 group-hover:scale-110 transition-transform">
                     <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                 </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-4">
                 <span class="inline-block px-2 py-0.5 rounded bg-primary-600 text-white text-[10px] font-bold uppercase tracking-wide mb-1">New Series</span>
                 <h3 class="text-lg font-bold text-white leading-tight">Walking in Divine Purpose</h3>
                 <p class="text-xs text-slate-300 mt-1">Pastor Michael • 45 mins</p>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-8">
        <div class="flex overflow-x-auto hide-scrollbar px-6 gap-3 pb-2">
             @foreach(['Sermons', 'Worship', 'Podcasts', 'Series'] as $cat)
             <button class="flex-shrink-0 px-5 py-2.5 rounded-xl bg-white border border-slate-100 shadow-sm text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-primary-600 hover:border-primary-100 transition-colors">
                 {{ $cat }}
             </button>
             @endforeach
        </div>
    </div>

    <!-- Recent Media List -->
    <div class="px-6 space-y-4">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-bold text-slate-900">Recent Uploads</h3>
            <a href="#" class="text-xs font-bold text-primary-600">View All</a>
        </div>
        
        <!-- Media Items -->
        <div id="mediaList" class="space-y-4">
             <!-- Skeleton -->
             @foreach(range(1,4) as $i)
             <div class="flex gap-3 items-center">
                  <div class="w-24 h-16 bg-slate-100 rounded-lg flex-shrink-0 animate-pulse"></div>
                  <div class="flex-1 space-y-2">
                       <div class="h-4 bg-slate-100 rounded w-3/4 animate-pulse"></div>
                       <div class="h-3 bg-slate-100 rounded w-1/2 animate-pulse"></div>
                  </div>
             </div>
             @endforeach
        </div>
    </div>
</div>

<!-- Mini Player (Floating) -->
<div id="miniPlayer" class="fixed bottom-[74px] left-2 right-2 bg-slate-900/95 backdrop-blur-md text-white rounded-xl p-3 flex items-center gap-3 shadow-2xl z-40 transform translate-y-24 transition-transform duration-300">
     <img src="https://images.unsplash.com/photo-1438232992991-995b7058bbb3?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-lg object-cover bg-slate-800">
     <div class="flex-1 min-w-0">
          <h4 class="text-sm font-bold truncate">Walking in Divine Purpose</h4>
          <p class="text-xs text-slate-400 truncate">Pastor Michael</p>
     </div>
     <div class="flex items-center gap-3 pr-2">
         <button class="text-slate-300 hover:text-white"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-4h2V7h-2v4z"/></svg><!-- Pause icon actually --></button>
         <button class="text-slate-300 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
     </div>
</div>

@endsection

@push('scripts')
<script>
    async function loadMedia() {
        // Mock data loading
        const media = [
            { id: 1, title: 'Understanding Faith', preacher: 'Pastor Michael', thumb: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=400&q=80', date: '2 days ago' },
            { id: 2, title: 'The Power of Prayer', preacher: 'Rev. Sarah', thumb: 'https://images.unsplash.com/photo-1478147427282-58a87a120781?auto=format&fit=crop&w=400&q=80', date: '5 days ago' },
            { id: 3, title: 'Grace Abounds', preacher: 'Pastor Michael', thumb: 'https://images.unsplash.com/photo-1504052434569-70ad5836ab65?auto=format&fit=crop&w=400&q=80', date: '1 week ago' },
             { id: 4, title: 'Sunday Service', preacher: 'Live Stream', thumb: 'https://images.unsplash.com/photo-1438232992991-995b7058bbb3?auto=format&fit=crop&w=400&q=80', date: '2 weeks ago' },
        ];

        const html = media.map(m => `
            <div onclick="playMedia(${m.id})" class="flex gap-3 items-center group cursor-pointer active:opacity-70 transition-opacity">
                  <div class="relative w-28 h-20 rounded-xl overflow-hidden flex-shrink-0">
                      <img src="${m.thumb}" class="w-full h-full object-cover">
                      <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                          <div class="w-8 h-8 rounded-full bg-white/30 backdrop-blur-sm flex items-center justify-center text-white scale-75 group-hover:scale-100 transition-transform">
                              <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                          </div>
                      </div>
                  </div>
                  <div class="flex-1 min-w-0 py-1">
                       <h4 class="font-bold text-slate-800 leading-tight mb-1 truncate">${m.title}</h4>
                       <p class="text-xs text-slate-500 mb-1">${m.preacher}</p>
                       <span class="text-[10px] text-slate-400 font-medium bg-slate-50 px-1.5 py-0.5 rounded border border-slate-100">${m.date}</span>
                  </div>
                  <button class="p-2 text-slate-300">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                  </button>
             </div>
        `).join('');
        
        document.getElementById('mediaList').innerHTML = html;
    }

    function playMedia(id) {
        // Show mini player
        document.getElementById('miniPlayer').classList.remove('translate-y-24');
    }

    document.addEventListener('DOMContentLoaded', loadMedia);
</script>
@endpush
