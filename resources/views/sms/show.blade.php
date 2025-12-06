@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('sms.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $broadcast->title }}</h1>
                    <p class="text-gray-600">SMS Broadcast Details</p>
                </div>
            </div>
            <div class="flex gap-2">
                <span class="badge badge-lg
                    @if($broadcast->status === 'completed') badge-success
                    @elseif($broadcast->status === 'sending') badge-info
                    @elseif($broadcast->status === 'scheduled') badge-warning
                    @elseif($broadcast->status === 'failed') badge-danger
                    @else badge-secondary
                    @endif">
                    {{ ucfirst($broadcast->status) }}
                </span>

                @if($broadcast->status === 'scheduled' || $broadcast->status === 'draft' || $broadcast->status === 'pending')
                <form method="POST" action="{{ route('sms.send', $broadcast) }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Send this broadcast now?')">
                        <i class="fas fa-paper-plane mr-2"></i>Send Now
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-users text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600">{{ number_format($recipientStats->total) }}</p>
                <p class="text-sm text-gray-600">Total Recipients</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600">{{ number_format($recipientStats->sent) }}</p>
                <p class="text-sm text-gray-600">Sent</p>
                @if($recipientStats->total > 0)
                <p class="text-xs text-gray-500 mt-1">{{ number_format(($recipientStats->sent / $recipientStats->total) * 100, 1) }}%</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-clock text-yellow-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-yellow-600">{{ number_format($recipientStats->pending) }}</p>
                <p class="text-sm text-gray-600">Pending</p>
                @if($recipientStats->total > 0)
                <p class="text-xs text-gray-500 mt-1">{{ number_format(($recipientStats->pending / $recipientStats->total) * 100, 1) }}%</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-circle text-red-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-red-600">{{ number_format($recipientStats->failed) }}</p>
                <p class="text-sm text-gray-600">Failed</p>
                @if($recipientStats->total > 0)
                <p class="text-xs text-gray-500 mt-1">{{ number_format(($recipientStats->failed / $recipientStats->total) * 100, 1) }}%</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    @if($broadcast->status === 'sending' && $recipientStats->total > 0)
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Sending Progress</span>
                <span class="text-sm font-medium text-gray-700">{{ number_format(($recipientStats->sent / $recipientStats->total) * 100, 1) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-blue-600 h-4 rounded-full transition-all flex items-center justify-end pr-2"
                     style="width: {{ ($recipientStats->sent / $recipientStats->total) * 100 }}%">
                    <span class="text-xs text-white font-medium">{{ number_format($recipientStats->sent) }} / {{ number_format($recipientStats->total) }}</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-info-circle mr-1"></i>
                This page auto-refreshes every 10 seconds while sending
            </p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message Content -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Message Content</h2>
                </div>
                <div class="card-body">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $broadcast->message }}</p>
                    </div>
                    <div class="flex gap-4 mt-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Length:</span> {{ strlen($broadcast->message) }} characters
                        </div>
                        <div>
                            <span class="font-medium">Segments:</span> {{ $broadcast->message_segments }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipients Table -->
            @if($recentRecipients->count() > 0)
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Recipients</h2>
                    <span class="text-sm text-gray-600">Showing latest 50</span>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Recipient</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th>Sent At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRecipients as $recipient)
                                <tr>
                                    <td>{{ $recipient->first_name }} {{ $recipient->last_name }}</td>
                                    <td>{{ $recipient->phone_number }}</td>
                                    <td>
                                        <span class="badge
                                            @if($recipient->status === 'sent') badge-success
                                            @elseif($recipient->status === 'failed') badge-danger
                                            @else badge-secondary
                                            @endif">
                                            {{ ucfirst($recipient->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($recipient->sent_at)
                                        {{ \Carbon\Carbon::parse($recipient->sent_at)->format('M d, Y H:i') }}
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($recipient->status === 'failed' && $recipient->error_message)
                                <tr>
                                    <td colspan="4" class="bg-red-50 text-red-700 text-sm">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Error: {{ $recipient->error_message }}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Broadcast Info -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Broadcast Info</h2>
                </div>
                <div class="card-body space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Sent By</p>
                        <p class="font-medium text-gray-800">{{ $broadcast->sender->full_name }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Created At</p>
                        <p class="font-medium text-gray-800">{{ $broadcast->created_at->format('M d, Y H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $broadcast->created_at->diffForHumans() }}</p>
                    </div>

                    @if($broadcast->scheduled_at)
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Scheduled For</p>
                        <p class="font-medium text-gray-800">{{ $broadcast->scheduled_at->format('M d, Y H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $broadcast->scheduled_at->diffForHumans() }}</p>
                    </div>
                    @endif

                    @if($broadcast->sent_at)
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Sent At</p>
                        <p class="font-medium text-gray-800">{{ $broadcast->sent_at->format('M d, Y H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $broadcast->sent_at->diffForHumans() }}</p>
                    </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Recipient Type</p>
                        <p class="font-medium text-gray-800">{{ ucwords(str_replace('_', ' ', $broadcast->recipient_type)) }}</p>
                    </div>
                </div>
            </div>

            <!-- Cost Info -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Cost Information</h2>
                </div>
                <div class="card-body space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Estimated Cost</p>
                        <p class="text-2xl font-bold text-blue-600">GHS {{ number_format($broadcast->estimated_cost, 2) }}</p>
                    </div>

                    @if($broadcast->actual_cost)
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Actual Cost</p>
                        <p class="text-2xl font-bold text-green-600">GHS {{ number_format($broadcast->actual_cost, 2) }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Cost Difference</p>
                        @php
                            $diff = $broadcast->actual_cost - $broadcast->estimated_cost;
                        @endphp
                        <p class="font-semibold {{ $diff > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $diff > 0 ? '+' : '' }}GHS {{ number_format($diff, 2) }}
                        </p>
                    </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Cost is GHS 0.05 per SMS segment. Multi-part messages use multiple segments.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($broadcast->status === 'sending')
<script>
    // Auto-refresh page every 10 seconds while sending
    setTimeout(function() {
        window.location.reload();
    }, 10000);
</script>
@endif
@endsection
