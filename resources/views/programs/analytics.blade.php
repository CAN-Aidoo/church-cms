@extends('layouts.app')

@section('title', 'Analytics - ' . $program->name)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-primary-600 transition-colors">Programs</a>
            <span>/</span>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-primary-600 transition-colors">{{ $program->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Analytics</span>
        </nav>
        <h1 class="text-3xl font-heading font-bold text-slate-900">Program Analytics</h1>
    </div>
    
    <div class="flex gap-3">
        <button onclick="exportReport('pdf')" class="btn btn-outline-danger">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export PDF
        </button>
        <button onclick="exportReport('excel')" class="btn btn-outline-success">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel
        </button>
    </div>
</div>

<!-- Key Metrics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-primary-500 to-indigo-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-primary-100 text-sm font-medium mb-1">Total Registrations</p>
            <h3 class="text-4xl font-bold mb-2">{{ $statistics['total_registrations'] }}</h3>
            <p class="text-primary-100 text-xs">{{ $statistics['confirmed_registrations'] }} confirmed</p>
        </div>
        <div class="absolute bottom-4 right-4 text-primary-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-emerald-500 to-teal-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-emerald-100 text-sm font-medium mb-1">Attendance Rate</p>
            <h3 class="text-4xl font-bold mb-2">{{ number_format($statistics['attendance_rate'], 1) }}%</h3>
            <p class="text-emerald-100 text-xs">{{ $attendanceStats['sessions_completed'] }} of {{ $attendanceStats['total_sessions'] }} sessions</p>
        </div>
         <div class="absolute bottom-4 right-4 text-emerald-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-purple-500 to-fuchsia-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-purple-100 text-sm font-medium mb-1">Total Revenue</p>
            <h3 class="text-4xl font-bold mb-2">GHS {{ number_format($statistics['total_revenue'], 2) }}</h3>
            <p class="text-purple-100 text-xs">Net: GHS {{ number_format($statistics['net_revenue'], 2) }}</p>
        </div>
         <div class="absolute bottom-4 right-4 text-purple-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-amber-500 to-orange-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-amber-100 text-sm font-medium mb-1">Average Rating</p>
            <h3 class="text-4xl font-bold mb-2">
                 @if($statistics['average_rating'])
                    {{ number_format($statistics['average_rating'], 1) }}
                @else
                    N/A
                @endif
            </h3>
            <p class="text-amber-100 text-xs">{{ $statistics['feedback_count'] }} reviews</p>
        </div>
         <div class="absolute bottom-4 right-4 text-amber-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
        </div>
    </div>
</div>

<!-- Charts Section 1 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Registration Status</h4>
        <div class="relative h-64">
            <canvas id="registrationStatusChart"></canvas>
        </div>
    </div>

    <div class="card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Payment Status</h4>
        <div class="relative h-64">
             <canvas id="paymentStatusChart"></canvas>
        </div>
    </div>
</div>

<!-- Trend & Attendance -->
<div class="grid grid-cols-1 gap-6 mb-8">
    <div class="card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Registration Trend</h4>
        <div class="relative h-64">
            <canvas id="registrationTrendChart"></canvas>
        </div>
    </div>
    
     <div class="card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Session Attendance Breakdown</h4>
        <div class="relative h-64">
            <canvas id="sessionAttendanceChart"></canvas>
        </div>
    </div>
</div>

<!-- Financials -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Financial Overview</h4>
         <div class="relative h-64">
            <canvas id="financialChart"></canvas>
        </div>
    </div>

    <div class="card border border-slate-200 shadow-sm bg-slate-50 p-6">
         <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Financial Details</h4>
         <dl class="space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                <dt class="text-sm text-slate-600">Total Revenue</dt>
                <dd class="text-sm font-bold text-emerald-600">GHS {{ number_format($statistics['total_revenue'], 2) }}</dd>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                <dt class="text-sm text-slate-600">Total Expenses</dt>
                <dd class="text-sm font-bold text-red-600">GHS {{ number_format($statistics['total_expenses'], 2) }}</dd>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                <dt class="text-sm font-bold text-slate-700">Net Revenue</dt>
                <dd class="text-lg font-bold {{ $statistics['net_revenue'] >= 0 ? 'text-primary-600' : 'text-red-500' }}">
                     GHS {{ number_format($statistics['net_revenue'], 2) }}
                </dd>
            </div>
            <div class="flex justify-between items-center pt-2">
                <dt class="text-sm text-slate-600">Capacity Utilization</dt>
                <dd class="text-sm font-medium text-slate-800">{{ number_format($statistics['capacity_percentage'], 1) }}%</dd>
            </div>
        </dl>
    </div>
</div>

<!-- Feedback -->
@if($feedbackSummary['total_responses'] > 0)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Rating Distribution</h4>
         <div class="relative h-64">
            <canvas id="ratingDistributionChart"></canvas>
        </div>
    </div>

    <div class="card border border-slate-100 shadow-sm p-6">
        <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Feedback Summary</h4>
        <dl class="space-y-4 divide-y divide-slate-100">
             <div class="flex justify-between py-2">
                <dt class="text-sm text-slate-600">Total Responses</dt>
                <dd class="font-bold text-slate-900">{{ $feedbackSummary['total_responses'] }}</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-sm text-slate-600">Average Overall</dt>
                <dd class="font-bold text-amber-500">{{ number_format($feedbackSummary['average_overall'], 1) }} / 5.0</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-sm text-slate-600">Content</dt>
                <dd class="font-medium text-slate-800">{{ number_format($feedbackSummary['average_content'], 1) }}</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-sm text-slate-600">Organization</dt>
                <dd class="font-medium text-slate-800">{{ number_format($feedbackSummary['average_organization'], 1) }}</dd>
            </div>
             <div class="flex justify-between py-2">
                <dt class="text-sm text-slate-600">Venue</dt>
                <dd class="font-medium text-slate-800">{{ number_format($feedbackSummary['average_venue'], 1) }}</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-sm text-slate-600">Would Recommend</dt>
                <dd class="font-bold text-emerald-600">{{ number_format($feedbackSummary['would_recommend_percentage'], 1) }}%</dd>
            </div>
        </dl>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

    // Chart configs (kept logic, updated styling)
    const chartColors = {
        primary: '#3B82F6',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        slate: '#94a3b8'
    };

    // Registration Status Chart
    new Chart(document.getElementById('registrationStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($registrationStats['by_status']->toArray())) !!}.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: {!! json_encode(array_values($registrationStats['by_status']->toArray())) !!},
                backgroundColor: [chartColors.success, chartColors.warning, chartColors.danger, chartColors.slate, chartColors.primary],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            },
            cutout: '70%'
        }
    });

    // Payment Status Chart
    new Chart(document.getElementById('paymentStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($registrationStats['by_payment_status']->toArray())) !!}.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: {!! json_encode(array_values($registrationStats['by_payment_status']->toArray())) !!},
                backgroundColor: [chartColors.success, chartColors.warning, chartColors.danger, chartColors.slate],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            },
            cutout: '70%'
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
                borderColor: chartColors.primary,
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
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
                backgroundColor: chartColors.primary,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
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
                backgroundColor: [chartColors.success, chartColors.danger, {{ $statistics['net_revenue'] >= 0 ? "chartColors.primary" : "chartColors.warning" }}],
                borderRadius: 4,
                barThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
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
                backgroundColor: chartColors.warning,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
    @endif

    function exportReport(format) {
        alert(`Export to ${format.toUpperCase()} feature coming soon`);
    }
</script>
@endsection
