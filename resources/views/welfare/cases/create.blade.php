@extends('layouts.app')

@section('title', 'Create Welfare Case')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">New Welfare Case</h1>
        <a href="{{ route('welfare.cases') }}" class="text-sm text-gray-500 hover:text-gray-700">Back to List</a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('welfare.cases.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Beneficiary Details --}}
                <div class="col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Beneficiary Information</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Member (Optional)</label>
                    <input type="number" name="beneficiary_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Member ID if applicable" value="{{ $member ? $member->id : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Beneficiary Name</label>
                    <input type="text" name="beneficiary_name" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required value="{{ $member ? $member->full_name : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="beneficiary_phone" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" value="{{ $member ? $member->phone : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="beneficiary_email" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" value="{{ $member ? $member->email : '' }}">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" value="{{ $member ? $member->address : '' }}">
                </div>

                {{-- Case Details --}}
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Case Details</h3>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Case Title</label>
                    <input type="text" name="case_title" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required placeholder="e.g. Emergency Medical Assistance">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="case_category" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Requested (GHS)</label>
                    <input type="number" name="amount_requested" step="0.01" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="case_description" rows="4" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('welfare.cases') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">Submit Case</button>
            </div>
        </form>
    </div>
@endsection
