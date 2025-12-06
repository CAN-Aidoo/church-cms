@extends('layouts.app')

@section('title', 'Create Welfare Program')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Create New Program</h1>
        <a href="{{ route('welfare.programs') }}" class="text-sm text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('welfare.programs.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Name</label>
                    <input type="text" name="program_name" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Type</label>
                    <select name="program_type" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        @foreach($programTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Budget Allocated (GHS)</label>
                    <input type="number" name="budget_allocated" step="0.01" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Coordinator ID</label>
                    <input type="number" name="coordinator_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required placeholder="User ID">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('welfare.programs') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">Create Program</button>
            </div>
        </form>
    </div>
@endsection
