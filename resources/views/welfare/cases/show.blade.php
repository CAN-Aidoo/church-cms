@extends('layouts.app')

@section('title', 'Case Details')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Case #{{ $case->case_number }}</h1>
            <p class="text-sm text-gray-500 mt-1">Submitted on {{ $case->created_at->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('welfare.cases') }}" class="text-sm text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Case Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $case->case_title }}</h3>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $case->status === 'approved' ? 'bg-green-100 text-green-800' : 
                          ($case->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                          ($case->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                        {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                    </span>
                </div>

                <div class="prose max-w-none text-gray-600 mb-6">
                    {{ $case->case_description }}
                </div>

                <div class="grid grid-cols-2 gap-6 border-t border-gray-100 pt-6">
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Category</label>
                        <p class="font-medium text-gray-900 mt-1 capitalize">{{ str_replace('_', ' ', $case->case_category) }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Priority</label>
                        <p class="font-medium text-gray-900 mt-1 capitalize">{{ $case->priority }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Requested Amount</label>
                        <p class="font-medium text-gray-900 mt-1">GHS {{ number_format($case->amount_requested, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Approved Amount</label>
                        <p class="font-medium text-gray-900 mt-1">
                            {{ $case->amount_approved ? 'GHS ' . number_format($case->amount_approved, 2) : 'Pending' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Actions Section (Only visible to authorized users) --}}
            @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Administrative Actions</h3>
                
                @if($case->status === 'submitted')
                    <form action="{{ route('welfare.cases.under-review', $case) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Mark Under Review
                        </button>
                    </form>
                @endif

                @if($case->status === 'under_review')
                    <div class="flex gap-3">
                        <form action="{{ route('welfare.cases.approve', $case) }}" method="POST" class="flex-1">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Approved Amount</label>
                                <input type="number" name="amount_approved" value="{{ $case->amount_requested }}" class="w-full rounded-lg border-gray-300 text-sm" required>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                Approve Case
                            </button>
                        </form>
                        <form action="{{ route('welfare.cases.reject', $case) }}" method="POST" class="flex-1">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason</label>
                                <input type="text" name="rejection_reason" class="w-full rounded-lg border-gray-300 text-sm" required>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                Reject Case
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            @endif
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-6">
            {{-- Beneficiary Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Beneficiary</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold">
                        {{ substr($case->beneficiary_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $case->beneficiary_name }}</p>
                        <p class="text-xs text-gray-500">{{ $case->beneficiary_phone }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Email</span>
                        <span class="text-gray-900">{{ $case->beneficiary_email ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Address</span>
                        <span class="text-gray-900">{{ $case->address ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Timeline</h3>
                <div class="space-y-4 border-l-2 border-gray-100 ml-2 pl-4">
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full bg-blue-500 border-2 border-white"></div>
                        <p class="text-sm font-medium text-gray-900">Case Submitted</p>
                        <p class="text-xs text-gray-500">{{ $case->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    @if($case->verified_at)
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full bg-yellow-500 border-2 border-white"></div>
                            <p class="text-sm font-medium text-gray-900">Verified</p>
                            <p class="text-xs text-gray-500">{{ $case->verified_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                    @if($case->approved_at)
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full bg-green-500 border-2 border-white"></div>
                            <p class="text-sm font-medium text-gray-900">Approved</p>
                            <p class="text-xs text-gray-500">{{ $case->approved_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
