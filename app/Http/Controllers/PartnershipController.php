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
}
