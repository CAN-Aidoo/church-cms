@extends('layouts.app')

@section('title', 'Edit Email Template')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Email Template</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $template->name }}</p>
        </div>
        <a href="{{ route('settings.email-templates') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            Back to Templates
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Edit Form -->
    <form action="{{ route('settings.update-email-template', $template) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <!-- Template Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Template Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $template->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Template Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Subject <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="subject"
                       name="subject"
                       value="{{ old('subject', $template->subject) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
                <p class="mt-1 text-xs text-gray-500">You can use variables like {{name}}, {{email}}, etc.</p>
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- HTML Body -->
            <div>
                <label for="body_html" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Body (HTML) <span class="text-red-500">*</span>
                </label>
                <textarea id="body_html"
                          name="body_html"
                          rows="15"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                          required>{{ old('body_html', $template->body_html) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">HTML content with inline CSS for best email client compatibility</p>
                @error('body_html')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Plain Text Body -->
            <div>
                <label for="body_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Body (Plain Text)
                </label>
                <textarea id="body_text"
                          name="body_text"
                          rows="10"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ old('body_text', $template->body_text) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Plain text version for email clients that don't support HTML</p>
                @error('body_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center">
                <input type="checkbox"
                       id="is_active"
                       name="is_active"
                       value="1"
                       {{ old('is_active', $template->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                    Template is active
                </label>
            </div>
        </div>

        <!-- Available Variables Info -->
        @if($template->available_variables && count($template->available_variables) > 0)
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-sm font-medium text-blue-800 mb-3">Available Variables</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($template->available_variables as $variable)
                        <div class="bg-white rounded px-3 py-2">
                            <code class="text-sm font-mono text-blue-700">{{ '{{' . $variable . '}}' }}</code>
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 text-xs text-blue-700">Copy and paste these variables into your template subject and body</p>
            </div>
        @endif

        <!-- Template Preview Tips -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-yellow-800">Template Best Practices</h4>
                    <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                        <li>Use inline CSS styles for best email client compatibility</li>
                        <li>Test templates with actual data before activating</li>
                        <li>Keep HTML simple and avoid complex layouts</li>
                        <li>Always provide a plain text alternative</li>
                        <li>Use tables for layout structure in HTML emails</li>
                        <li>Make sure all variables are properly closed with double curly braces</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('settings.email-templates') }}" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Save Changes
            </button>
        </div>
    </form>

    <!-- Template Info Card -->
    <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Template Information</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Template Slug</dt>
                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $template->slug }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $template->category === 'member' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $template->category === 'finance' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $template->category === 'event' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $template->category === 'notification' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ !in_array($template->category, ['member', 'finance', 'event', 'notification']) ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ ucfirst($template->category) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Created</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $template->created_at->format('M d, Y h:i A') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $template->updated_at->format('M d, Y h:i A') }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
