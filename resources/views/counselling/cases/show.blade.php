@extends('layouts.app')

@section('title', 'Case Details')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Case: {{ $case->case_title }}
    </h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Case Information</h3>
                    <div class="prose max-w-none mb-6">
                        {!! nl2br(e($case->case_description)) !!}
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                             <p class="text-sm text-gray-500">Member</p>
                             <p class="font-medium">{{ $case->member->full_name ?? 'Unknown' }}</p>
                        </div>
                         <div>
                             <p class="text-sm text-gray-500">Start Date</p>
                             <p class="font-medium">{{ $case->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Status</h3>
                 <p class="text-lg font-bold capitalize mb-2">{{ $case->status }}</p>
                 <p class="text-sm text-gray-500">Priority: <span class="font-medium capitalize">{{ $case->priority }}</span></p>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Assigned Counsellor</h3>
                 <p class="font-medium">{{ $case->primaryCounsellor->user->name ?? 'Unknown' }}</p>
            </div>
        </div>
    </div>
@endsection
