@extends('layouts.app')

@section('title', 'Edit QR Code')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('qr-management.show', $qrCode['id']) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit QR Code</h1>
        </div>
        <p class="text-gray-600">Update QR code settings</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('qr-management.update', $qrCode['id']) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">QR Code Settings</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="expiration_time" class="block text-sm font-medium text-gray-700 mb-1">Expiration Time</label>
                            <input type="datetime-local" name="expiration_time" id="expiration_time" value="{{ old('expiration_time', isset($qrCode['expiration_time']) ? \Carbon\Carbon::parse($qrCode['expiration_time'])->format('Y-m-d\TH:i') : '') }}" min="{{ now()->format('Y-m-d\TH:i') }}" class="form-input w-full @error('expiration_time') border-red-500 @enderror">
                            @error('expiration_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration</p>
                        </div>

                        <div>
                            <label for="max_scans" class="block text-sm font-medium text-gray-700 mb-1">Maximum Scans</label>
                            <input type="number" name="max_scans" id="max_scans" min="1" value="{{ old('max_scans', $qrCode['max_scans'] ?? '') }}" class="form-input w-full @error('max_scans') border-red-500 @enderror">
                            @error('max_scans')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Leave empty for unlimited scans</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="location_required" id="location_required" value="1" {{ old('location_required', $qrCode['location_required'] ?? false) ? 'checked' : '' }} class="form-checkbox">
                        <label for="location_required" class="ml-2 text-sm text-gray-700">Require location verification</label>
                    </div>

                    <div x-data="{ locationRequired: {{ old('location_required', $qrCode['location_required'] ?? false) ? 'true' : 'false' }} }">
                        <div x-show="locationRequired" class="mt-4">
                            <label for="location_radius" class="block text-sm font-medium text-gray-700 mb-1">Location Radius (meters)</label>
                            <input type="number" name="location_radius" id="location_radius" min="10" max="1000" value="{{ old('location_radius', $qrCode['location_radius'] ?? 50) }}" class="form-input w-full @error('location_radius') border-red-500 @enderror">
                            @error('location_radius')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Allowed distance from designated location (10-1000 meters)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-blue-50 border border-blue-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">Current Status: {{ ucfirst($qrCode['status']) }}</h3>
                            <p class="text-sm text-blue-800">
                                Type: {{ $qrCode['type'] }}
                                @if(isset($qrCode['scan_count']))
                                    | Scans: {{ $qrCode['scan_count'] }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('qr-management.show', $qrCode['id']) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
