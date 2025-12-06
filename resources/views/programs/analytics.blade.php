@extends('layouts.app')

@section('title', 'Analytics - ' . $program->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-blue-600">Programs</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-blue-600">{{ $program->name }}</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span>Analytics</span>
        </div>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Program Analytics</h1>
                <p class="text-gray-600 mt-1">{{ $program->name }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="exportReport('pdf')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Export PDF
                </button>
                <button onclick="exportReport('excel')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    {{-- Key Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-12 h-12 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                </svg>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Registrations</p>
            <p class="text-4xl font-bold">{{ $statistics['total_registrations'] }}</p>
            <p class="text-sm opacity-80 mt-2">{{ $statistics['confirmed_registrations'] }} confirmed</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-12 h-12 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-sm opacity-90 mb-1">Attendance Rate</p>
            <p class="text-4xl font-bold">{{ number_format($statistics['attendance_rate'], 1) }}%</p>
            <p class="text-sm opacity-80 mt-2">{{ $attendanceStats['sessions_completed'] }} of {{ $attendanceStats['total_sessions'] }} sessions</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-12 h-12 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Revenue</p>
            <p class="text-4xl font-bold">GHS {{ number_format($statistics['total_revenue'], 2) }}</p>
            <p class="text-sm opacity-80 mt-2">Net: GHS {{ number_format($statistics['net_revenue'], 2) }}</p>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-lg shadow-md p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <svg class="w-12 h-12 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <p class="text-sm opacity-90 mb-1">Average Rating</p>
            <p class="text-4xl font-bold">
                @if($statistics['average_rating'])
                    {{ number_format($statistics['average_rating'], 1) }}
                @else
                    N/A
                @endif
            </p>
            <p class="text-sm opacity-80 mt-2">{{ $statistics['feedback_count'] }} reviews</p>
        </div>
    </div>

    {{-- Registration Analytics --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Registration Status</h3>
            <canvas id="registrationStatusChart" height="250"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Status</h3>
            <canvas id="paymentStatusChart" height="250"></canvas>
        </div>
    </div>

    {{-- Daily Registrations Trend --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Registration Trend</h3>
        <canvas id="registrationTrendChart" height="80"></canvas>
    </div>

    {{-- Session Attendance --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Session Attendance Breakdown</h3>
        <canvas id="sessionAttendanceChart" height="100"></canvas>
    </div>

    {{-- Financial Summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Financial Overview</h3>
            <canvas id="financialChart" height="250"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Financial Details</h3>
            <dl class="space-y-4">
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Total Revenue</dt>
                    <dd class="text-sm text-gray-900 font-semibold">GHS {{ number_format($statistics['total_revenue'], 2) }}</dd>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Total Expenses</dt>
                    <dd class="text-sm text-gray-900 font-semibold">GHS {{ number_format($statistics['total_expenses'], 2) }}</dd>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Net Revenue</dt>
                    <dd class="text-sm font-semibold {{ $statistics['net_revenue'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        GHS {{ number_format($statistics['net_revenue'], 2) }}
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-600">Capacity Utilization</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ number_format($statistics['capacity_percentage'], 1) }}%</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Feedback Analysis --}}
    @if($feedbackSummary['total_responses'] > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Rating Distribution</h3>
            <canvas id="ratingDistributionChart" height="250"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Feedback Summary</h3>
            <dl class="space-y-4">
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Total Responses</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ $feedbackSummary['total_responses'] }}</dd>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Average Overall Rating</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ number_format($feedbackSummary['average_overall'], 1) }} / 5.0</dd>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Content Rating</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ number_format($feedbackSummary['average_content'], 1) }} / 5.0</dd>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Organization Rating</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ number_format($feedbackSummary['average_organization'], 1) }} / 5.0</dd>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-3">
                    <dt class="text-sm font-medium text-gray-600">Venue Rating</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ number_format($feedbackSummary['average_venue'], 1) }} / 5.0</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm font-medium text-gray-600">Would Recommend</dt>
                    <dd class="text-sm text-gray-900 font-semibold">{{ number_format($feedbackSummary['would_recommend_percentage'], 1) }}%</dd>
                </div>
            </dl>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Registration Status Chart
new Chart(document.getElementById('registrationStatusChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($registrationStats['by_status']->toArray())) !!}.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        datasets: [{
            data: {!! json_encode(array_values($registrationStats['by_status']->toArray())) !!},
            backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#6B7280', '#3B82F6']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Payment Status Chart
new Chart(document.getElementById('paymentStatusChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($registrationStats['by_payment_status']->toArray())) !!}.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        datasets: [{
            data: {!! json_encode(array_values($registrationStats['by_payment_status']->toArray())) !!},
            backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#6B7280']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Registration Trend Chart
new Chart(document.getElementById('registrationTrendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($registrationStats['daily_registrations']->toArray())) !!},
        datasets: [{
            label: 'Daily Registrations',
            data: {!! json_encode(array_values($registrationStats['daily_registrations']->toArray())) !!},
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Session Attendance Chart
new Chart(document.getElementById('sessionAttendanceChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($attendanceStats['session_attendance']->pluck('title')->toArray()) !!},
        datasets: [{
            label: 'Attendance',
            data: {!! json_encode($attendanceStats['session_attendance']->pluck('attendance_count')->toArray()) !!},
            backgroundColor: '#3B82F6'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Financial Chart
new Chart(document.getElementById('financialChart'), {
    type: 'bar',
    data: {
        labels: ['Revenue', 'Expenses', 'Net'],
        datasets: [{
            data: [
                {{ $statistics['total_revenue'] }},
                {{ $statistics['total_expenses'] }},
                {{ $statistics['net_revenue'] }}
            ],
            backgroundColor: ['#10B981', '#EF4444', {{ $statistics['net_revenue'] >= 0 ? "'#3B82F6'" : "'#F59E0B'" }}]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

@if($feedbackSummary['total_responses'] > 0)
// Rating Distribution Chart
new Chart(document.getElementById('ratingDistributionChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($feedbackSummary['rating_distribution']->toArray())) !!}.map(r => r + ' Stars'),
        datasets: [{
            label: 'Number of Ratings',
            data: {!! json_encode(array_values($feedbackSummary['rating_distribution']->toArray())) !!},
            backgroundColor: '#F59E0B'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
@endif

function exportReport(format) {
    alert(`Export to ${format.toUpperCase()} feature coming soon`);
}
</script>
@endsection
