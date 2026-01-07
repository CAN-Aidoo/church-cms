<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Program;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QRAnalyticsController extends Controller
{
    /**
     * Display QR analytics dashboard
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 30); // days
        $startDate = now()->subDays($period);

        return view('qr-analytics.index', [
            'period' => $period,
            'totalMemberQRs' => $this->getTotalMemberQRs(),
            'totalProgramQRs' => $this->getTotalProgramQRs(),
            'totalScans' => $this->getTotalScans($startDate),
            'uniqueScanners' => $this->getUniqueScanners($startDate),
            'scanTrends' => $this->getScanTrends($startDate),
            'checkInMethods' => $this->getCheckInMethodBreakdown($startDate),
            'topMembers' => $this->getTopScannedMembers(10),
            'peakTimes' => $this->getPeakScanTimes($startDate),
            'programStats' => $this->getProgramQRStats($startDate),
        ]);
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        $period = $request->get('period', 30);
        $startDate = now()->subDays($period);

        $data = [
            ['Metric', 'Value'],
            ['Total Member QR Codes', $this->getTotalMemberQRs()],
            ['Total Program QR Codes', $this->getTotalProgramQRs()],
            ['Total Scans (Period)', $this->getTotalScans($startDate)],
            ['Unique Scanners (Period)', $this->getUniqueScanners($startDate)],
            [''],
            ['Top Scanned Members'],
            ['Member', 'Total Scans', 'Last Scan'],
        ];

        $topMembers = $this->getTopScannedMembers(20);
        foreach ($topMembers as $member) {
            $data[] = [
                $member->full_name,
                $member->qr_scan_count ?? 0,
                $member->last_qr_scan ? $member->last_qr_scan->format('Y-m-d H:i:s') : 'Never'
            ];
        }

        // Create CSV
        $filename = 'qr-analytics-' . now()->format('Y-m-d') . '.csv';

        $handle = fopen('php://output', 'w');
        ob_start();

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
        $csv = ob_get_clean();

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get total member QR codes generated
     */
    private function getTotalMemberQRs(): int
    {
        return Member::whereNotNull('member_qr_code')->count();
    }

    /**
     * Get total program QR codes generated
     */
    private function getTotalProgramQRs(): int
    {
        return Program::where(function($query) {
            $query->whereNotNull('registration_qr_code')
                  ->orWhereNotNull('check_in_qr_code');
        })->count();
    }

    /**
     * Get total scans since start date
     */
    private function getTotalScans($startDate): int
    {
        return Attendance::where('check_in_method', 'qr')
            ->where('created_at', '>=', $startDate)
            ->count();
    }

    /**
     * Get unique scanners count
     */
    private function getUniqueScanners($startDate): int
    {
        return Attendance::where('check_in_method', 'qr')
            ->where('created_at', '>=', $startDate)
            ->distinct('member_id')
            ->count('member_id');
    }

    /**
     * Get scan trends data for charts
     */
    private function getScanTrends($startDate): array
    {
        $scans = Attendance::where('check_in_method', 'qr')
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $counts = [];

        // Fill in missing dates with 0
        $period = \Carbon\CarbonPeriod::create($startDate, now());
        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $scan = $scans->firstWhere('date', $dateStr);
            $dates[] = $date->format('M d');
            $counts[] = $scan ? $scan->count : 0;
        }

        return [
            'dates' => $dates,
            'counts' => $counts,
        ];
    }

    /**
     * Get check-in method breakdown
     */
    private function getCheckInMethodBreakdown($startDate): array
    {
        $methods = Attendance::where('created_at', '>=', $startDate)
            ->select('check_in_method', DB::raw('COUNT(*) as count'))
            ->groupBy('check_in_method')
            ->pluck('count', 'check_in_method')
            ->toArray();

        return [
            $methods['qr'] ?? 0,
            $methods['manual'] ?? 0,
            ($methods['other'] ?? 0) + array_sum(array_diff_key($methods, array_flip(['qr', 'manual']))),
        ];
    }

    /**
     * Get top scanned members
     */
    private function getTopScannedMembers(int $limit = 10)
    {
        return Member::whereNotNull('member_qr_code')
            ->where('qr_scan_count', '>', 0)
            ->orderByDesc('qr_scan_count')
            ->take($limit)
            ->get(['id', 'first_name', 'last_name', 'photo_url', 'qr_scan_count', 'last_qr_scan']);
    }

    /**
     * Get peak scan times
     */
    private function getPeakScanTimes($startDate): array
    {
        $hourlyScans = Attendance::where('check_in_method', 'qr')
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $peakTimes = [];
        $maxCount = $hourlyScans->max('count') ?: 1;

        for ($hour = 0; $hour < 24; $hour++) {
            $scan = $hourlyScans->firstWhere('hour', $hour);
            $count = $scan ? $scan->count : 0;

            $peakTimes[] = [
                'hour' => sprintf('%02d:00 - %02d:00', $hour, $hour + 1),
                'count' => $count,
                'percentage' => round(($count / $maxCount) * 100),
            ];
        }

        // Return only hours with scans, sorted by count
        return collect($peakTimes)
            ->filter(fn($item) => $item['count'] > 0)
            ->sortByDesc('count')
            ->values()
            ->take(10)
            ->toArray();
    }

    /**
     * Get program QR statistics
     */
    private function getProgramQRStats($startDate)
    {
        return Program::where(function($query) {
                $query->whereNotNull('registration_qr_code')
                      ->orWhereNotNull('check_in_qr_code');
            })
            ->withCount([
                'registrations as reg_scans' => function($query) use ($startDate) {
                    $query->whereNotNull('qr_scanned_at')
                          ->where('qr_scanned_at', '>=', $startDate);
                },
                'registrations as checkin_scans' => function($query) use ($startDate) {
                    $query->where('check_in_method', 'qr')
                          ->where('created_at', '>=', $startDate);
                }
            ])
            ->having('reg_scans', '>', 0)
            ->orHaving('checkin_scans', '>', 0)
            ->orderByDesc('reg_scans')
            ->take(10)
            ->get(['id', 'name', 'registration_qr_code', 'check_in_qr_code', 'status']);
    }
}
