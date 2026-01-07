@extends('layouts.app')

@section('title', 'Worship Plan')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Manage Worship Plan</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary-600 transition-colors">Services</a>
            <span>/</span>
            <a href="{{ route('services.show', $service) }}" class="hover:text-primary-600 transition-colors">{{ $service->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Plan</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1 bg-slate-100 rounded-full text-slate-600 text-sm font-medium border border-slate-200">
            {{ $service->service_date->format('M d, Y') }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add Item Form -->
    <div class="lg:col-span-1">
        <div class="card border border-slate-100 shadow-sm sticky top-6">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Add Item</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('services.store-worship-item', $service) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="item_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Type</label>
                        <select name="item_type" id="item_type" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                            <option value="worship_song">Worship Song</option>
                            <option value="opening_prayer">Opening Prayer</option>
                            <option value="scripture_reading">Scripture Reading</option>
                            <option value="sermon">Sermon</option>
                            <option value="announcements">Announcements</option>
                            <option value="offering">Offering</option>
                            <option value="benediction">Benediction</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="title" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Title</label>
                        <input type="text" name="title" id="title" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required placeholder="e.g. Opening Prayer">
                    </div>

                    <div>
                        <label for="duration_minutes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Duration (mins)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" min="1" placeholder="5">
                    </div>

                    <div>
                        <label for="assigned_to" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Assigned To (Optional)</label>
                        <!-- Simple input for now, ideally an AJAX search -->
                        <input type="number" name="assigned_to" id="assigned_to" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" placeholder="Member ID">
                    </div>

                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl" placeholder="Lyrics, scripture references, etc."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                         Add to Plan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Plan List -->
    <div class="lg:col-span-2">
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Order of Service</h3>
                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold bg-slate-100 text-slate-600 uppercase tracking-wide">
                    Total: {{ $service->worshipPlans->sum('duration_minutes') }} mins
                </span>
            </div>
            
            <div class="divide-y divide-slate-100" id="worship-plan-list">
                @forelse($service->worshipPlans->sortBy('order_number') as $item)
                <div class="p-4 hover:bg-slate-50 transition-colors group">
                    <div class="flex items-start gap-4">
                        <div class="pt-1 cursor-move text-slate-300 hover:text-slate-500" title="Drag to reorder">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-slate-900 text-sm">{{ $item->title }}</h4>
                                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">{{ $item->duration_minutes }}m</span>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full 
                                        {{ $item->item_type == 'worship_song' ? 'bg-purple-400' : 
                                          ($item->item_type == 'sermon' ? 'bg-blue-400' : 
                                          ($item->item_type == 'offering' ? 'bg-emerald-400' : 'bg-slate-300')) }}">
                                    </span>
                                    <span class="text-xs text-slate-500 uppercase font-medium tracking-wide">{{ str_replace('_', ' ', $item->item_type) }}</span>
                                </div>
                                
                                @if($item->assignedTo)
                                    <span class="text-slate-300">|</span>
                                    <span class="flex items-center gap-1.5 text-slate-600 text-xs">
                                        <div class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                            {{ substr($item->assignedTo->first_name, 0, 1) }}
                                        </div>
                                        {{ $item->assignedTo->full_name }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($item->notes)
                                <div class="mt-2 text-xs text-amber-800 bg-amber-50 p-2 rounded border border-amber-100 inline-block">
                                    {{ $item->notes }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                             <button type="button" 
                                        onclick="alert('Edit functionality to be implemented via modal')"
                                        class="p-1.5 text-slate-400 hover:text-primary-600 rounded hover:bg-slate-100 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('services.destroy-worship-item', $item) }}" method="POST" onsubmit="return confirm('Delete item?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded hover:bg-red-50 transition-colors" title="Remove">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Empty Plan</h3>
                    <p class="text-slate-500 text-xs mt-1">Add items on the left to build the service flow.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
