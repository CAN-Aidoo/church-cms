@extends('layouts.app')

@section('title', 'Edit Email Template')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                 <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                    {{ $template->category === 'member' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}
                    {{ $template->category === 'finance' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                    {{ $template->category === 'event' ? 'bg-purple-50 text-purple-600 border border-purple-100' : '' }}
                    {{ $template->category === 'notification' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                    {{ !in_array($template->category, ['member', 'finance', 'event', 'notification']) ? 'bg-slate-50 text-slate-600 border border-slate-100' : '' }}">
                    {{ ucfirst($template->category) }} Template
                </span>
                <span class="text-xs text-slate-400 font-mono">#{{ $template->slug }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Template: {{ $template->name }}</h1>
        </div>
        <a href="{{ route('settings.email-templates') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Cancel & Return
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('settings.update-email-template', $template) }}" method="POST" class="card border-slate-200 shadow-sm p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Internal Name</label>
                     <input type="text" name="name" value="{{ old('name', $template->name) }}" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 font-semibold text-slate-800" required>
                     <p class="text-xs text-slate-400 mt-1">Used for identification in admin panel</p>
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Email Subject</label>
                     <input type="text" name="subject" value="{{ old('subject', $template->subject) }}" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 font-medium" required>
                     <p class="text-xs text-slate-400 mt-1">Supports variables (e.g. <code>@{{name}}</code>)</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1 flex justify-between">
                        HTML Content
                        <span class="text-slate-400 font-normal normal-case">Supports inline CSS</span>
                    </label>
                    <div class="relative rounded-lg border border-slate-200 overflow-hidden">
                         <textarea name="body_html" rows="18" class="form-textarea w-full border-0 focus:ring-0 font-mono text-sm bg-slate-50 resize-y p-4" required>{{ old('body_html', $template->body_html) }}</textarea>
                    </div>
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1 flex justify-between">
                        Plain Text Fallback
                        <span class="text-slate-400 font-normal normal-case">Optional</span>
                    </label>
                    <textarea name="body_text" rows="6" class="form-textarea w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 font-mono text-xs text-slate-600">{{ old('body_text', $template->body_text) }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $template->is_active) ? 'checked' : '' }} class="form-checkbox rounded text-primary-600 border-slate-300 focus:ring-primary-500 w-5 h-5">
                        <span class="ml-2 text-sm font-bold text-slate-700">Active Template</span>
                    </label>

                    <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Helper -->
        <div class="space-y-6">
            @if($template->available_variables && count($template->available_variables) > 0)
                <div class="card border-slate-200 shadow-sm p-5">
                    <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                        Available Variables
                    </h3>
                    <p class="text-xs text-slate-500 mb-4">Click to copy variables to clipboard for use in subject or body.</p>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($template->available_variables as $variable)
                            <button onclick="navigator.clipboard.writeText('{{ '{' . '{' . $variable . '}' . '}' }}')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-600 hover:text-slate-800 text-xs font-mono transition-colors active:scale-95" title="Click to Copy">
                                {{ '{' . '{' . $variable . '}' . '}' }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-amber-50 border border-amber-100 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900 mb-1">Designing Emails</h4>
                        <ul class="space-y-1.5 text-xs text-amber-800 list-disc list-outside ml-3">
                            <li>Use table-based layouts for best compatibility across email clients (Outlook, Gmail, etc).</li>
                            <li>Keep styles inline. External CSS sheets are often ignored.</li>
                            <li>Avoid JavaScript, IFrames, or complex forms.</li>
                            <li>Always test critical templates.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
