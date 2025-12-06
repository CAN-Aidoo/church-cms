@extends('layouts.app')

@section('title', 'Prayer Request')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Prayer Request</h1>
        <a href="{{ route('prayer.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ $prayerRequest->request_title }}</h2>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $prayerRequest->status === 'answered' ? 'bg-green-100 text-green-800' : 
                          ($prayerRequest->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($prayerRequest->status) }}
                    </span>
                </div>

                <div class="prose max-w-none text-gray-600 mb-6">
                    {{ $prayerRequest->request_details }}
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm border-t border-gray-100 pt-4">
                    <div>
                        <span class="block text-gray-500 text-xs uppercase tracking-wide">Category</span>
                        <span class="font-medium">{{ $prayerRequest->category->name ?? 'General' }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs uppercase tracking-wide">Urgency</span>
                        <span class="font-medium capitalize {{ $prayerRequest->urgency === 'critical' ? 'text-red-600' : '' }}">{{ $prayerRequest->urgency }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs uppercase tracking-wide">Requester</span>
                        <span class="font-medium">{{ $prayerRequest->is_anonymous ? 'Anonymous' : $prayerRequest->requester_name }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs uppercase tracking-wide">Submitted</span>
                        <span class="font-medium">{{ $prayerRequest->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Updates & Notes --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Prayer Updates</h3>
                
                @if(count($prayerRequest->updates ?? []) > 0)
                    <div class="space-y-4">
                        @foreach($prayerRequest->updates as $update)
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($update->updater->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="bg-gray-50 p-3 rounded-lg rounded-tl-none">
                                        <p class="text-sm text-gray-800">{{ $update->update_text }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400 mt-1 block">{{ $update->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm italic">No updates yet.</p>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']) || (auth()->user()->member && $prayerRequest->assigned_to === auth()->user()->member->id))
                    <form action="{{ route('prayer.add-update', $prayerRequest) }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="update_type" value="note">
                        <div class="flex gap-2">
                            <input type="text" name="update_text" placeholder="Add a prayer note or update..." class="flex-1 rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500" required>
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">Post</button>
                        </div>
                        <div class="mt-2">
                            <label class="inline-flex items-center text-xs text-gray-600">
                                <input type="checkbox" name="notify_requester" value="1" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2">Notify requester</span>
                            </label>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        {{-- Actions Sidebar --}}
        <div class="space-y-6">
            @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']))
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Admin Actions</h3>
                    
                    <div class="space-y-3">
                        {{-- Assign Intercessor --}}
                        <form action="{{ route('prayer.assign', $prayerRequest) }}" method="POST">
                            @csrf
                            <label class="block text-xs font-medium text-gray-700 mb-1">Assign Intercessor</label>
                            <div class="flex gap-2">
                                <input type="number" name="intercessor_id" placeholder="Member ID" class="w-full rounded-lg border-gray-300 text-sm" required>
                                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium">Assign</button>
                            </div>
                        </form>

                        <hr class="border-gray-100">

                        {{-- Mark Answered --}}
                        @if($prayerRequest->status !== 'answered')
                            <form action="{{ route('prayer.mark-answered', $prayerRequest) }}" method="POST">
                                @csrf
                                <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium mb-2">
                                    Mark as Answered
                                </button>
                                <div class="hidden space-y-3">
                                    <textarea name="testimony" rows="3" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Enter testimony (optional)"></textarea>
                                    <label class="flex items-center text-xs text-gray-600">
                                        <input type="checkbox" name="share_testimony" value="1" class="rounded border-gray-300">
                                        <span class="ml-2">Share testimony publicly</span>
                                    </label>
                                    <button type="submit" class="w-full px-4 py-2 bg-green-700 text-white rounded-lg text-sm">Confirm</button>
                                </div>
                            </form>
                        @endif
                        
                        {{-- Delete --}}
                        <form action="{{ route('prayer.destroy', $prayerRequest) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if($prayerRequest->assignedIntercessor)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Assigned Intercessor</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                            {{ substr($prayerRequest->assignedIntercessor->first_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $prayerRequest->assignedIntercessor->full_name }}</p>
                            <p class="text-xs text-gray-500">Intercessor</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
