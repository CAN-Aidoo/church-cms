@extends('layouts.app')

@section('title', 'Worship Plan')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Worship Plan</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $service->name }} - {{ $service->service_date->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('services.show', $service) }}" class="text-sm text-gray-500 hover:text-gray-700">Back to Service</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Add Item Form --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Item</h3>
                <form action="{{ route('services.store-worship-item', $service) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="item_type" class="w-full rounded-lg border-gray-300 text-sm">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" class="w-full rounded-lg border-gray-300 text-sm" required placeholder="e.g. Opening Prayer">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (mins)</label>
                            <input type="number" name="duration_minutes" class="w-full rounded-lg border-gray-300 text-sm" min="1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To (Optional)</label>
                            {{-- Simplified member select, ideally AJAX search --}}
                            <input type="number" name="assigned_to" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Member ID">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium">Add Item</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Plan List --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900">Order of Service</h3>
                        <span class="text-sm text-gray-500">Total Duration: {{ $service->worshipPlans->sum('duration_minutes') }} mins</span>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100" id="worship-plan-list">
                    @forelse($service->worshipPlans->sortBy('order_number') as $item)
                        <div class="p-4 hover:bg-gray-50 transition-colors group">
                            <div class="flex items-start gap-4">
                                <div class="pt-1 cursor-move text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="font-medium text-gray-900">{{ $item->title }}</h4>
                                        <span class="text-sm text-gray-500">{{ $item->duration_minutes }}m</span>
                                    </div>
                                    <div class="flex gap-3 mt-1 text-sm text-gray-500">
                                        <span class="capitalize bg-gray-100 px-2 rounded text-xs flex items-center">{{ str_replace('_', ' ', $item->item_type) }}</span>
                                        @if($item->assignedTo)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                {{ $item->assignedTo->full_name }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($item->notes)
                                        <p class="text-sm text-gray-600 mt-2 bg-yellow-50 p-2 rounded">{{ $item->notes }}</p>
                                    @endif
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                                    {{-- Edit Trigger (Modal implementation needed) --}}
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <form action="{{ route('services.destroy-worship-item', $item) }}" method="POST" onsubmit="return confirm('Delete item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">Start adding items to build the service flow.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
