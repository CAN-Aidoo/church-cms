@extends('layouts.app')

@section('title', 'Register for ' . $program->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8 text-center">
        <nav class="flex items-center justify-center gap-2 text-sm text-slate-500 mb-4">
            <a href="{{ route('programs.index') }}" class="hover:text-primary-600 transition-colors">Programs</a>
            <span>/</span>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-primary-600 transition-colors">{{ $program->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Register</span>
        </nav>
        <h1 class="text-3xl font-heading font-bold text-slate-900">Event Registration</h1>
        <p class="text-slate-500 mt-2">Complete the form below to secure your spot</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Event Summary Column -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card border border-slate-100 shadow-sm overflow-hidden">
                @if($program->flyer_path)
                <div class="h-40 w-full relative">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ Storage::url($program->flyer_path) }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                </div>
                @else
                <div class="h-32 bg-slate-900 relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/></svg>
                    </div>
                </div>
                @endif
                
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                         <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $program->getStatusBadgeClass() }} capitalize">
                            {{ ucfirst($program->status) }}
                        </span>
                         <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 capitalize">
                            {{ $program->getTypeLabel() }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $program->name }}</h3>
                    
                    <div class="space-y-3 text-sm text-slate-600">
                        <div class="flex items-start">
                             <svg class="w-4 h-4 mr-2 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $program->start_date->format('M d') }} - {{ $program->end_date->format('M d, Y') }}</span>
                        </div>
                        @if($program->venue_name)
                        <div class="flex items-start">
                             <svg class="w-4 h-4 mr-2 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $program->venue_name }}</span>
                        </div>
                        @endif
                        
                        <div class="pt-3 border-t border-slate-100 mt-3 flex justify-between items-center">
                            <span class="font-medium text-slate-700">Registration Fee</span>
                            @if($program->registration_fee > 0)
                                <span class="font-bold text-slate-900">GHS {{ number_format($program->registration_fee, 2) }}</span>
                            @else
                                <span class="font-bold text-emerald-600">Free</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-5 border border-blue-100">
                <h4 class="font-bold text-blue-900 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Need Help?
                </h4>
                <p class="text-sm text-blue-800 mb-3">Questions about registration?</p>
                <div class="text-sm text-blue-900 space-y-1">
                    <p><strong>Email:</strong> info@church.com</p>
                    <p><strong>Phone:</strong> +233 XX XXX XXXX</p>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="lg:col-span-2">
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Registration Details</h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('programs.register', $program) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        @if($errors->any())
                        <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm border border-red-100">
                             <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', Auth::user()->member->first_name ?? '') }}" required
                                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                            </div>
    
                            <div>
                                <label for="last_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', Auth::user()->member->last_name ?? '') }}" required
                                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                            </div>
    
                            <div class="md:col-span-2">
                                <label for="email" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}" required
                                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                            </div>
    
                            <div class="md:col-span-2">
                                <label for="phone" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->member->phone ?? '') }}" required
                                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-6">
                            <label for="special_requirements" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                                Special Requirements or Dietary Restrictions <span class="text-slate-400 font-normal">(Optional)</span>
                            </label>
                            <textarea name="special_requirements" id="special_requirements" rows="3"
                                      class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                      placeholder="E.g., wheelchair access, dietary restrictions...">{{ old('special_requirements') }}</textarea>
                        </div>
                        
                        @if($program->registration_fee > 0)
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-5">
                            <h4 class="font-bold text-slate-900 mb-2">Payment Summary</h4>
                            <div class="flex justify-between items-center text-sm mb-4">
                                <span class="text-slate-600">Standard Registration</span>
                                <span class="font-bold text-slate-900">GHS {{ number_format($program->registration_fee, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                                <span class="font-bold text-slate-800">Total</span>
                                <span class="font-bold text-lg text-primary-600">GHS {{ number_format($program->registration_fee, 2) }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-3">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Payment instructions will be sent to your email upon registration.
                            </p>
                        </div>
                        @endif

                        <div class="pt-2">
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="agree_terms" id="agree_terms" value="1" required
                                       class="mt-1 form-checkbox text-primary-600 border-slate-300 rounded focus:ring-primary-500">
                                <span class="text-sm text-slate-600 group-hover:text-slate-800 transition-colors">
                                    I agree to the <a href="#" class="text-primary-600 hover:underline">terms and conditions</a> and confirm that the information provided is accurate. <span class="text-red-500">*</span>
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="btn btn-primary w-full justify-center shadow-lg shadow-primary-500/20">
                                Complete Registration
                            </button>
                            <a href="{{ route('programs.show', $program) }}" class="btn btn-outline-secondary w-full justify-center lg:w-auto">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
