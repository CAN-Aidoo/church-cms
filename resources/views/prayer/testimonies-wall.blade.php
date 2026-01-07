@extends('layouts.app')

@section('title', 'Testimonies')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white py-16">
        <div class="container mx-auto px-4 max-w-7xl text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Testimonies of Faith</h1>
            <p class="text-emerald-100 text-lg md:text-xl max-w-2xl mx-auto mb-8">
                Celebrating answered prayers and God's faithfulness in our community.
            </p>
            <div class="flex justify-center gap-4">
                 <a href="{{ route('prayer.create') }}" class="px-8 py-3 bg-white text-emerald-700 rounded-full font-bold shadow-lg hover:shadow-xl hover:bg-slate-50 transition-all transform hover:-translate-y-1">
                    Share Your Story
                </a>
                <a href="{{ route('prayer.wall') }}" class="px-8 py-3 bg-emerald-700/50 text-white border border-white/20 rounded-full font-bold hover:bg-emerald-700/70 transition-all backdrop-blur-sm">
                    Prayer Wall
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-7xl -mt-8">
        @if($testimonies->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonies as $testimony)
            <div class="card p-6 shadow-sm hover:shadow-lg transition-all group bg-white border-t-4 border-emerald-500 h-full flex flex-col">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold shadow-sm">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                             <h3 class="font-bold text-slate-900 leading-tight">Answered Prayer</h3>
                             <span class="text-xs text-slate-500">{{ $testimony->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="relative mb-6">
                        <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-2 h-8 w-8 text-slate-200" fill="currentColor" viewBox="0 0 32 32">
                             <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                        </svg>
                        <p class="relative z-10 text-slate-600 italic text-lg leading-relaxed pt-2 pl-4">
                            "{{ $testimony->testimony ?? $testimony->title }}"
                        </p>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-100 flex justify-between items-center mt-4">
                    <span class="text-sm font-bold text-slate-700">
                        {{ $testimony->member->name ?? 'Anonymous' }}
                    </span>
                     @if($testimony->prayerRequest)
                    <a href="{{ route('prayer.show', $testimony->prayerRequest) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 hover:underline">
                        View Original Request
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-12 flex justify-center">
             {{ $testimonies->links() }}
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-slate-100">
            <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No testimonies yet</h3>
            <p class="text-slate-500 mb-6">Be the first to share your testimony!</p>
             <a href="{{ route('prayer.create') }}" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Share Testimony
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
