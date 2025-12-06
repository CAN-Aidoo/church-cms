@extends('layouts.app')

@section('title', 'Program Details')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $program->program_name }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ ucfirst(str_replace('_', ' ', $program->program_type)) }}</p>
        </div>
        <a href="{{ route('welfare.programs') }}" class="text-sm text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Program Overview --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Overview</h3>
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-medium">{{ ucfirst($program->status) }}</span>
                </div>
                
                <p class="text-gray-600 mb-6">{{ $program->description }}</p>

                <div class="grid grid-cols-2 gap-6 border-t border-gray-100 pt-6">
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Budget Allocated</label>
                        <p class="font-medium text-gray-900 mt-1">GHS {{ number_format($program->budget_allocated, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Budget Spent</label>
                        <p class="font-medium text-gray-900 mt-1">GHS {{ number_format($program->budget_spent, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Start Date</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $program->start_date ? $program->start_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">End Date</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $program->end_date ? $program->end_date->format('M d, Y') : 'Open' }}</p>
                    </div>
                </div>
            </div>

            {{-- Beneficiaries --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-semibold text-gray-900">Beneficiaries</h3>
                    <span class="text-xs bg-white px-2 py-1 rounded border border-gray-200">{{ $program->beneficiaries_count }} Total</span>
                </div>
                <div class="p-6 text-center text-gray-500 text-sm">
                    Beneficiary list will be displayed here.
                </div>
            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Program Actions</h3>
                <div class="space-y-2">
                    @if($program->status !== 'active')
                        <form action="{{ route('welfare.programs.activate', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                Activate Program
                            </button>
                        </form>
                    @endif

                    @if($program->status === 'active')
                        <form action="{{ route('welfare.programs.pause', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm font-medium">
                                Pause Program
                            </button>
                        </form>
                        <form action="{{ route('welfare.programs.complete', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                Complete Program
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Coordinator</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                        {{ substr($program->coordinator->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $program->coordinator->name ?? 'Unassigned' }}</p>
                        <p class="text-xs text-gray-500">Program Lead</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
