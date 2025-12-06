@extends('layouts.app')

@section('title', 'Custom Report Builder')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Custom Report Builder</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span>/</span>
            <span>Custom Builder</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Reports
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Report Configuration -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Build Your Report</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('reports.custom.store') }}" id="reportBuilderForm">
                    @csrf

                    <!-- Report Name -->
                    <div class="mb-6">
                        <label for="name" class="form-label">Report Name *</label>
                        <input type="text" id="name" name="name" class="form-input" required placeholder="e.g., Monthly Attendance Summary">
                    </div>

                    <!-- Report Type -->
                    <div class="mb-6">
                        <label for="type" class="form-label">Report Type *</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="">Select Report Type</option>
                            @foreach($reportTypes as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                            <option value="custom">Custom Query</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="3" class="form-input" placeholder="Describe what this report shows..."></textarea>
                    </div>

                    <!-- Columns Selection -->
                    <div class="mb-6">
                        <label class="form-label">Columns to Include</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-lg">
                            <label class="flex items-center">
                                <input type="checkbox" name="columns[]" value="name" class="form-checkbox">
                                <span class="ml-2 text-sm">Name</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="columns[]" value="email" class="form-checkbox">
                                <span class="ml-2 text-sm">Email</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="columns[]" value="phone" class="form-checkbox">
                                <span class="ml-2 text-sm">Phone</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="columns[]" value="gender" class="form-checkbox">
                                <span class="ml-2 text-sm">Gender</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="columns[]" value="status" class="form-checkbox">
                                <span class="ml-2 text-sm">Status</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="columns[]" value="date" class="form-checkbox">
                                <span class="ml-2 text-sm">Date</span>
                            </label>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6">
                        <label class="form-label">Filters</label>
                        <div class="space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label for="date_from" class="text-sm text-gray-600">From Date</label>
                                    <input type="date" id="date_from" name="filters[date_from]" class="form-input">
                                </div>
                                <div>
                                    <label for="date_to" class="text-sm text-gray-600">To Date</label>
                                    <input type="date" id="date_to" name="filters[date_to]" class="form-input">
                                </div>
                                <div>
                                    <label for="status_filter" class="text-sm text-gray-600">Status</label>
                                    <select id="status_filter" name="filters[status]" class="form-select">
                                        <option value="">All</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grouping -->
                    <div class="mb-6">
                        <label for="group_by" class="form-label">Group By</label>
                        <select id="group_by" name="group_by" class="form-select">
                            <option value="">No Grouping</option>
                            <option value="gender">Gender</option>
                            <option value="status">Status</option>
                            <option value="date">Date</option>
                            <option value="month">Month</option>
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="mb-6">
                        <label for="sort_by" class="form-label">Sort By</label>
                        <div class="grid grid-cols-2 gap-3">
                            <select id="sort_by" name="sort_by" class="form-select">
                                <option value="name">Name</option>
                                <option value="date">Date</option>
                                <option value="amount">Amount</option>
                            </select>
                            <select name="sort_direction" class="form-select">
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Save Options -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_favorite" value="1" class="form-checkbox">
                            <span class="ml-2 text-sm">Add to Favorites</span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3">
                        <button type="button" class="btn btn-secondary" onclick="previewReport()">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column - Templates & Help -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Report Templates -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Templates</h3>
            </div>
            <div class="card-body p-0">
                @if($templates && $templates->count() > 0)
                    <div class="divide-y">
                        @foreach($templates as $template)
                            <div class="p-4 hover:bg-gray-50 cursor-pointer" onclick="loadTemplate({{ $template->id }})">
                                <h4 class="font-medium text-sm text-gray-900">{{ $template->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $template->description }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-8">No templates available</p>
                @endif
            </div>
        </div>

        <!-- Quick Help -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Help</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3 text-sm text-gray-600">
                    <div>
                        <h4 class="font-medium text-gray-900">Report Types</h4>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Membership - Member data</li>
                            <li>Financial - Income/expenses</li>
                            <li>Attendance - Service attendance</li>
                            <li>Program - Event participation</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Grouping</h4>
                        <p class="mt-1">Group data by common fields for summary reports</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Filters</h4>
                        <p class="mt-1">Narrow down results using date ranges and status filters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewReport() {
    alert('Preview functionality coming soon!');
}

function loadTemplate(templateId) {
    alert('Loading template ' + templateId);
}
</script>
@endsection
