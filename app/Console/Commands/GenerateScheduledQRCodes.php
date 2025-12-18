<?php

namespace App\Console\Commands;

use App\Models\QRCode;
use App\Services\QRManagementService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateScheduledQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:generate-scheduled
                            {--date= : Date to generate QR codes for (defaults to today)}
                            {--force : Force generation even if QR codes already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR codes for scheduled services';

    private QRManagementService $qrService;

    /**
     * Create a new command instance.
     */
    public function __construct(QRManagementService $qrService)
    {
        parent::__construct();
        $this->qrService = $qrService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : now();
        $force = $this->option('force');

        $this->info("Generating QR codes for {$date->format('Y-m-d')}...");

        $services = $this->getServicesForDate($date);
        $generated = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($services as $service) {
            // Check if QR already exists
            if (!$force) {
                $existing = QRCode::where('service_date', $service['date'])
                    ->where('service_type', $service['type'])
                    ->where('revoked', false)
                    ->first();

                if ($existing) {
                    $this->warn("  Skipping {$service['name']} - QR code already exists");
                    $skipped++;
                    continue;
                }
            }

            try {
                $config = [
                    'type' => QRCode::TYPE_SERVICE_ATTENDANCE,
                    'service_date' => $service['date'],
                    'service_type' => $service['type'],
                    'service_time' => $service['time'],
                    'location_required' => true,
                    'location_radius' => 100,
                    'offline_allowed' => true,
                    'requires_verification' => true,
                ];

                $result = $this->qrService->generateQRCode($config);

                $this->info("  ✓ Generated QR for {$service['name']} (ID: {$result['id']})");
                $generated++;

            } catch (\Exception $e) {
                $this->error("  ✗ Failed to generate QR for {$service['name']}: {$e->getMessage()}");
                $errors++;
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("  Generated: {$generated}");
        $this->info("  Skipped: {$skipped}");
        $this->info("  Errors: {$errors}");

        return $errors > 0 ? 1 : 0;
    }

    /**
     * Get services that should have QR codes for the given date.
     */
    private function getServicesForDate(Carbon $date): array
    {
        $services = [];
        $dayOfWeek = $date->dayOfWeek;

        // Sunday services
        if ($dayOfWeek === 0) { // Sunday
            $services[] = [
                'name' => 'Sunday First Service',
                'type' => 'sunday_first',
                'date' => $date->format('Y-m-d'),
                'time' => '07:00',
            ];
            $services[] = [
                'name' => 'Sunday Second Service',
                'type' => 'sunday_second',
                'date' => $date->format('Y-m-d'),
                'time' => '09:30',
            ];
            $services[] = [
                'name' => 'Sunday Third Service',
                'type' => 'sunday_third',
                'date' => $date->format('Y-m-d'),
                'time' => '12:00',
            ];
        }

        // Wednesday midweek service
        if ($dayOfWeek === 3) { // Wednesday
            $services[] = [
                'name' => 'Wednesday Service',
                'type' => 'wednesday',
                'date' => $date->format('Y-m-d'),
                'time' => '18:00',
            ];
        }

        // Friday service
        if ($dayOfWeek === 5) { // Friday
            $services[] = [
                'name' => 'Friday Service',
                'type' => 'friday',
                'date' => $date->format('Y-m-d'),
                'time' => '18:00',
            ];
        }

        return $services;
    }
}
