<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    protected $equipmentRepository;

    public function __construct(EquipmentRepository $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    /**
     * Display a listing of equipment.
     */
    public function index(Request $request)
    {
        $query = Equipment::query();

        // Apply filters
        if ($request->filled('search')) {
            $query = $this->equipmentRepository->search($request->search);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $equipment = $query->orderBy('name')->paginate(20);

        // Get unique values for filters
        $categories = Equipment::distinct()->pluck('category')->sort();
        $locations = Equipment::distinct()->pluck('location')->sort();

        return view('equipment.index', compact('equipment', 'categories', 'locations'));
    }

    /**
     * Show the form for creating new equipment.
     */
    public function create()
    {
        // Get unique categories and locations for dropdowns
        $categories = Equipment::distinct()->pluck('category')->sort();
        $locations = Equipment::distinct()->pluck('location')->sort();

        return view('equipment.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created equipment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'serial_number' => 'nullable|string|max:100|unique:equipment,serial_number',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'warranty_expiry' => 'nullable|date|after:purchase_date',
            'condition' => 'required|in:excellent,good,fair,poor',
            'status' => 'required|in:active,inactive,maintenance,retired',
            'location' => 'required|string|max:255',
            'assigned_to' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date|after:last_service_date',
        ]);

        $validated['added_by'] = Auth::id();

        $equipment = $this->equipmentRepository->create($validated);

        return redirect()
            ->route('equipment.show', $equipment)
            ->with('success', 'Equipment added successfully.');
    }

    /**
     * Display the specified equipment.
     */
    public function show(Equipment $equipment)
    {
        // Calculate depreciation
        $age = $equipment->purchase_date ? $equipment->purchase_date->diffInYears(now()) : 0;
        $depreciationRate = 0.15; // 15% per year
        $currentValue = $equipment->purchase_price * pow(1 - $depreciationRate, $age);
        $totalDepreciation = $equipment->purchase_price - $currentValue;

        // Check warranty status
        $warrantyStatus = 'N/A';
        $warrantyDaysRemaining = null;
        if ($equipment->warranty_expiry) {
            if ($equipment->warranty_expiry->isFuture()) {
                $warrantyDaysRemaining = now()->diffInDays($equipment->warranty_expiry);
                $warrantyStatus = 'Active';
            } else {
                $warrantyStatus = 'Expired';
            }
        }

        // Check if maintenance is due
        $maintenanceDue = false;
        if ($equipment->next_service_date && $equipment->next_service_date->isPast()) {
            $maintenanceDue = true;
        }

        return view('equipment.show', compact(
            'equipment',
            'currentValue',
            'totalDepreciation',
            'warrantyStatus',
            'warrantyDaysRemaining',
            'maintenanceDue'
        ));
    }

    /**
     * Show the form for editing the specified equipment.
     */
    public function edit(Equipment $equipment)
    {
        // Get unique categories and locations for dropdowns
        $categories = Equipment::distinct()->pluck('category')->sort();
        $locations = Equipment::distinct()->pluck('location')->sort();

        return view('equipment.edit', compact('equipment', 'categories', 'locations'));
    }

    /**
     * Update the specified equipment in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'serial_number' => 'nullable|string|max:100|unique:equipment,serial_number,'.$equipment->id,
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'warranty_expiry' => 'nullable|date|after:purchase_date',
            'condition' => 'required|in:excellent,good,fair,poor',
            'status' => 'required|in:active,inactive,maintenance,retired',
            'location' => 'required|string|max:255',
            'assigned_to' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date|after:last_service_date',
            'maintenance_notes' => 'nullable|string',
        ]);

        $this->equipmentRepository->update($equipment, $validated);

        return redirect()
            ->route('equipment.show', $equipment)
            ->with('success', 'Equipment updated successfully.');
    }

    /**
     * Remove the specified equipment from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $this->equipmentRepository->delete($equipment);

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Equipment deleted successfully.');
    }

    /**
     * Display equipment requiring maintenance.
     */
    public function maintenance()
    {
        $equipment = $this->equipmentRepository->getRequiringMaintenance();

        return view('equipment.maintenance', compact('equipment'));
    }

    /**
     * Show form to record maintenance for equipment.
     */
    public function maintenanceForm(Equipment $equipment)
    {
        return view('equipment.maintenance-form', compact('equipment'));
    }

    /**
     * Record maintenance for equipment.
     */
    public function recordMaintenance(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'service_date' => 'required|date',
            'notes' => 'required|string',
            'next_service_months' => 'nullable|integer|min:1|max:24',
            'cost' => 'nullable|numeric|min:0',
        ]);

        $this->equipmentRepository->recordMaintenance($equipment, $validated);

        return redirect()
            ->route('equipment.show', $equipment)
            ->with('success', 'Maintenance recorded successfully.');
    }

    /**
     * Schedule maintenance for equipment.
     */
    public function scheduleMaintenance(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date|after:today',
            'description' => 'required|string|max:500',
        ]);

        $this->equipmentRepository->scheduleMaintenance(
            $equipment,
            Carbon::parse($validated['scheduled_date']),
            $validated['description']
        );

        return redirect()
            ->route('equipment.maintenance')
            ->with('success', 'Maintenance scheduled successfully.');
    }

    /**
     * Display equipment reports.
     */
    public function reports()
    {
        // Get statistics
        $totalEquipment = $this->equipmentRepository->countAll();
        $activeEquipment = $this->equipmentRepository->countByStatus('active');
        $maintenanceEquipment = $this->equipmentRepository->countByStatus('maintenance');
        $retiredEquipment = $this->equipmentRepository->countByStatus('retired');

        // Get equipment by category
        $equipmentByCategory = $this->equipmentRepository->getValueByCategory();

        // Get status breakdown
        $conditionBreakdown = Equipment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Get depreciation report
        $depreciationReport = $this->equipmentRepository->getDepreciationReport();

        // Get warranty expiring soon
        $warrantyExpiring = $this->equipmentRepository->getWarrantyExpiringSoon(3); // 3 months

        // Get equipment requiring maintenance
        $requireMaintenance = $this->equipmentRepository->getRequiringMaintenance()->take(10);

        // Monthly maintenance schedule
        $maintenanceSchedule = $this->equipmentRepository->getMaintenanceSchedule();

        return view('equipment.reports', compact(
            'totalEquipment',
            'activeEquipment',
            'maintenanceEquipment',
            'retiredEquipment',
            'equipmentByCategory',
            'conditionBreakdown',
            'depreciationReport',
            'warrantyExpiring',
            'requireMaintenance',
            'maintenanceSchedule'
        ));
    }

    /**
     * Export equipment data to CSV.
     */
    public function export(Request $request)
    {
        $query = Equipment::query();

        // Apply same filters as index
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $equipment = $query->orderBy('name')->get();

        $filename = 'equipment_export_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($equipment) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Name',
                'Category',
                'Serial Number',
                'Purchase Date',
                'Purchase Price',
                'Current Value (Est.)',
                'Condition',
                'Status',
                'Location',
                'Assigned To',
                'Warranty Expiry',
                'Last Service',
                'Next Service',
            ]);

            // Add data rows
            foreach ($equipment as $item) {
                // Calculate current value
                $age = $item->purchase_date ? $item->purchase_date->diffInYears(now()) : 0;
                $depreciationRate = 0.15;
                $currentValue = $item->purchase_price * pow(1 - $depreciationRate, $age);

                fputcsv($file, [
                    $item->name,
                    $item->category,
                    $item->serial_number,
                    $item->purchase_date ? $item->purchase_date->format('Y-m-d') : '',
                    number_format($item->purchase_price, 2),
                    number_format($currentValue, 2),
                    ucfirst($item->condition),
                    ucfirst($item->status),
                    $item->location,
                    $item->assigned_to,
                    $item->warranty_expiry ? $item->warranty_expiry->format('Y-m-d') : '',
                    $item->last_service_date ? $item->last_service_date->format('Y-m-d') : '',
                    $item->next_service_date ? $item->next_service_date->format('Y-m-d') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
