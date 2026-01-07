@extends('layouts.app')

@section('title', 'Manage Partners')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Partners</h1>
            <p class="text-slate-500 mt-1">Directory of strategic alliances and organizations.</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('partnerships.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Dashboard
            </a>
            <button onclick="document.getElementById('createPartnerModal').classList.remove('hidden')" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Add Partner
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Content -->
    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <!-- Filter Toolbar -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-2 w-full md:w-auto">
                 <div class="relative w-full md:w-64">
                    <input type="text" placeholder="Search partners..." class="form-input w-full pl-10 rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 text-sm">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
             <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
                <select name="category" class="form-select rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="ministry" {{ request('category') == 'ministry' ? 'selected' : '' }}>Ministry</option>
                    <option value="corporate_sponsor" {{ request('category') == 'corporate_sponsor' ? 'selected' : '' }}>Corporate</option>
                    <option value="mission" {{ request('category') == 'mission' ? 'selected' : '' }}>Mission</option>
                     <option value="media" {{ request('category') == 'media' ? 'selected' : '' }}>Media</option>
                </select>
                <select name="status" class="form-select rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Organization</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Contact</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                         <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                        {{ substr($partner->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $partner->name }}</div>
                                        <div class="text-xs text-slate-400">Since {{ $partner->created_at->format('Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="capitalize text-sm font-medium text-slate-600 bg-slate-100 px-2 py-1 rounded text-xs border border-slate-200">
                                    {{ str_replace('_', ' ', $partner->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-700">{{ $partner->contact_person ?? 'N/A' }}</div>
                                @if($partner->email)
                                    <div class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        {{ $partner->email }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold capitalize
                                    {{ $partner->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    @if($partner->status === 'active') <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> @endif
                                    {{ $partner->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button class="text-slate-400 hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">No partners found.</p>
                                <p class="text-xs text-slate-400 mt-1">Get started by adding a new strategic partner.</p>
                                <button onclick="document.getElementById('createPartnerModal').classList.remove('hidden')" class="mt-4 px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium text-sm transition-colors">
                                    Add New Partner
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($partners->hasPages())
        <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
            {{ $partners->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Create Partner Modal -->
<div id="createPartnerModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-800">Add New Partner</h3>
             <button onclick="document.getElementById('createPartnerModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('partnerships.store-partner') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Organization Name <span class="text-rose-500">*</span></label>
                     <input type="text" name="name" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 font-semibold text-slate-800">
                </div>
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Category <span class="text-rose-500">*</span></label>
                     <select name="category" required class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Category</option>
                        <option value="ministry">Ministry / Church</option>
                        <option value="mission">Mission Agency</option>
                        <option value="corporate_sponsor">Corporate Sponsor</option>
                        <option value="media">Media Partner</option>
                        <option value="sister_church">Sister Church</option>
                        <option value="international">International Body</option>
                        <option value="other">Other</option>
                     </select>
                </div>
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Contact Person</label>
                     <input type="text" name="contact_person" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                </div>
                 <div class="grid grid-cols-2 gap-4">
                    <div>
                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Email</label>
                         <input type="email" name="email" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Phone</label>
                         <input type="text" name="phone" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                 <button type="button" onclick="document.getElementById('createPartnerModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm hover:bg-slate-50">Cancel</button>
                 <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-bold text-sm shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Save Partner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
