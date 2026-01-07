@extends('layouts.app')

@section('title', 'Media Team')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Media Team</h1>
            <p class="text-slate-500 mt-1">Manage volunteers and technicians.</p>
        </div>
        <button onclick="document.getElementById('addMemberModal').classList.remove('hidden')" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Add Team Member
        </button>
    </div>

    @if(count($members) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($members as $member)
        <div class="card p-6 border-slate-100 hover:shadow-lg transition-all group relative overflow-hidden">
             <!-- Status Dot -->
             <div class="absolute top-4 right-4">
                <span class="w-3 h-3 rounded-full {{ $member->is_active ? 'bg-emerald-400 shadow-sm' : 'bg-slate-300' }} block" title="{{ $member->is_active ? 'Active' : 'Inactive' }}"></span>
            </div>

            <!-- Avatar -->
            <div class="flex flex-col items-center text-center">
                 <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-bold text-2xl mb-4 shadow-inner ring-4 ring-white">
                    {{ substr($member->user->name ?? 'U', 0, 1) }}
                </div>
                
                <h3 class="text-lg font-bold text-slate-800">{{ $member->user->name }}</h3>
                <p class="text-sm font-medium text-primary-600 uppercase tracking-wide mb-4">{{ ucfirst(str_replace('_', ' ', $member->primary_role)) }}</p>
                
                <!-- Skills -->
                <div class="flex flex-wrap gap-1.5 justify-center mb-6 min-h-[48px]">
                    @foreach(array_slice($member->skills ?? [], 0, 3) as $skill)
                        <span class="px-2 py-1 text-[10px] bg-slate-50 border border-slate-200 rounded-md text-slate-600 font-bold uppercase">{{ $skill }}</span>
                    @endforeach
                    @if(count($member->skills ?? []) > 3)
                        <span class="px-2 py-1 text-[10px] bg-slate-50 border border-slate-200 rounded-md text-slate-400 font-bold">+{{ count($member->skills) - 3 }}</span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="w-full grid grid-cols-2 gap-2 opacity-0 group-hover:opacity-100 transition-opacity translate-y-2 group-hover:translate-y-0">
                    <button class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-xs font-bold transition-colors">Edit</button>
                    <button class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-xs font-bold transition-colors">Profile</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $members->links() }}
    </div>

    @else
        <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-xl border border-slate-200 border-dashed">
            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No team members</h3>
            <p class="text-slate-500 max-w-sm mt-1 mb-6">Build your media team by adding technicians, camera operators, and editors.</p>
            <button onclick="document.getElementById('addMemberModal').classList.remove('hidden')" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-bold text-sm shadow-sm transition-colors">
                Add First Member
            </button>
        </div>
    @endif
</div>

<!-- Add Member Modal -->
<div id="addMemberModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-800">Add Team Member</h3>
             <button onclick="document.getElementById('addMemberModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="#" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Select User</label>
                     <select name="user_id" required class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Search church members...</option>
                        {{-- Mock options for UI --}}
                        <option value="1">John Doe (Member)</option>
                        <option value="2">Jane Smith (Volunteer)</option>
                     </select>
                </div>
                
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Primary Role</label>
                     <select name="primary_role" required class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="camera_operator">Camera Operator</option>
                        <option value="sound_engineer">Sound Engineer</option>
                        <option value="video_editor">Video Editor</option>
                        <option value="streaming_technician">Streaming Technician</option>
                        <option value="photographer">Photographer</option>
                     </select>
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Skills (Select multiple)</label>
                     <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center p-2 border border-slate-200 rounded hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="mixing" class="form-checkbox text-primary-600 rounded border-slate-300">
                            <span class="ml-2 text-sm text-slate-600">Audio Mixing</span>
                        </label>
                        <label class="flex items-center p-2 border border-slate-200 rounded hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="editing" class="form-checkbox text-primary-600 rounded border-slate-300">
                            <span class="ml-2 text-sm text-slate-600">Video Editing</span>
                        </label>
                         <label class="flex items-center p-2 border border-slate-200 rounded hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="lighting" class="form-checkbox text-primary-600 rounded border-slate-300">
                            <span class="ml-2 text-sm text-slate-600">Stage Lighting</span>
                        </label>
                         <label class="flex items-center p-2 border border-slate-200 rounded hover:bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="obs" class="form-checkbox text-primary-600 rounded border-slate-300">
                            <span class="ml-2 text-sm text-slate-600">OBS Studio</span>
                        </label>
                     </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                 <button type="button" onclick="document.getElementById('addMemberModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm">Cancel</button>
                 <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-bold text-sm shadow-sm">Add Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
