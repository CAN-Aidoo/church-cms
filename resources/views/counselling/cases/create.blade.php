@extends('layouts.app')

@section('title', 'Create Case')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create New Case') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="POST" action="{{ route('counselling.cases.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                     <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Case Title</label>
                        <input type="text" name="case_title" value="{{ old('case_title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Member (ID)</label>
                        <input type="number" name="member_id" value="{{ $member ? $member->id : old('member_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Primary Counsellor (ID)</label>
                        <input type="number" name="primary_counsellor_id" value="{{ old('primary_counsellor_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Issue Categories</label>
                         <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach($issueCategories ?? ['General'] as $cat)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="issue_categories[]" value="{{ $cat }}" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2">{{ $cat }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                     <div>
                         <label class="block text-sm font-medium text-gray-700">Priority</label>
                        <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="case_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('case_description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('counselling.cases.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Case
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
