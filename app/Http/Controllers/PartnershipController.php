<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnershipAgreement;
use App\Repositories\PartnershipRepository;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function __construct(private PartnershipRepository $repository) {}

    public function index()
    {
        $statistics = $this->repository->getDashboardStatistics();

        return view('partnerships.index', compact('statistics'));
    }

    public function partners(Request $request)
    {
        $filters = $request->only(['category', 'status']);
        $partners = $this->repository->getPartners($filters);

        return view('partnerships.partners.index', compact('partners', 'filters'));
    }

    public function storePartner(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:ministry,mission,corporate_sponsor,sister_church,international,media,other',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        Partner::create($validated);

        return redirect()->route('partnerships.partners')->with('success', 'Partner added successfully.');
    }

    public function agreements(Request $request)
    {
        $filters = $request->only(['status', 'partner_id']);
        $agreements = $this->repository->getAgreements($filters);

        return view('partnerships.agreements.index', compact('agreements', 'filters'));
    }

    public function storeAgreement(Request $request)
    {
        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'agreement_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'financial_commitment' => 'nullable|numeric|min:0',
        ]);

        $validated['created_by'] = auth()->id();

        PartnershipAgreement::create($validated);

        return redirect()->route('partnerships.agreements')->with('success', 'Agreement created successfully.');
    }

    public function activateAgreement(PartnershipAgreement $agreement)
    {
        $agreement->activate();

        return redirect()->back()->with('success', 'Agreement activated.');
    }

    /**
     * Display partner details.
     */
    public function showPartner(Partner $partner)
    {
        $partner->load('agreements');
        return view('partnerships.partners.show', compact('partner'));
    }

    /**
     * Show edit form for partner.
     */
    public function editPartner(Partner $partner)
    {
        return view('partnerships.partners.edit', compact('partner'));
    }

    /**
     * Update partner.
     */
    public function updatePartner(Request $request, Partner $partner)
    {
        $this->authorize('update', $partner);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:ministry,mission,corporate_sponsor,sister_church,international,media,other',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $partner->update($validated);

        return redirect()->route('partnerships.partners.show', $partner)
            ->with('success', 'Partner updated successfully.');
    }

    /**
     * Delete partner.
     */
    public function destroyPartner(Partner $partner)
    {
        $this->authorize('delete', $partner);

        // Check for active agreements
        $activeAgreements = $partner->agreements()->where('status', 'active')->count();

        if ($activeAgreements > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete partner with active agreements. Please expire or complete them first.');
        }

        $partner->delete();

        return redirect()->route('partnerships.partners')
            ->with('success', 'Partner deleted successfully.');
    }

    /**
     * Display agreement details.
     */
    public function showAgreement(PartnershipAgreement $agreement)
    {
        $agreement->load(['partner', 'createdBy']);
        return view('partnerships.agreements.show', compact('agreement'));
    }

    /**
     * Show edit form for agreement.
     */
    public function editAgreement(PartnershipAgreement $agreement)
    {
        // Only allow editing of draft or pending agreements
        if (!in_array($agreement->status, ['draft', 'pending'])) {
            return redirect()->route('partnerships.agreements.show', $agreement)
                ->with('error', 'Only draft or pending agreements can be edited.');
        }

        $partners = Partner::where('status', 'active')->get();
        return view('partnerships.agreements.edit', compact('agreement', 'partners'));
    }

    /**
     * Update agreement.
     */
    public function updateAgreement(Request $request, PartnershipAgreement $agreement)
    {
        $this->authorize('update', $agreement);

        // Only allow updating of draft or pending agreements
        if (!in_array($agreement->status, ['draft', 'pending'])) {
            return redirect()->route('partnerships.agreements.show', $agreement)
                ->with('error', 'Only draft or pending agreements can be updated.');
        }

        $validated = $request->validate([
            'agreement_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'financial_commitment' => 'nullable|numeric|min:0',
            'terms' => 'nullable|array',
        ]);

        $agreement->update($validated);

        return redirect()->route('partnerships.agreements.show', $agreement)
            ->with('success', 'Agreement updated successfully.');
    }

    /**
     * Delete agreement.
     */
    public function destroyAgreement(PartnershipAgreement $agreement)
    {
        $this->authorize('delete', $agreement);

        // Only allow deletion of draft, expired, or cancelled agreements
        if (!in_array($agreement->status, ['draft', 'expired', 'cancelled'])) {
            return redirect()->back()
                ->with('error', 'Only draft, expired, or cancelled agreements can be deleted.');
        }

        $agreement->delete();

        return redirect()->route('partnerships.agreements')
            ->with('success', 'Agreement deleted successfully.');
    }
}
