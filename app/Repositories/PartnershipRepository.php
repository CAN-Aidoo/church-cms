<?php

namespace App\Repositories;

use App\Models\Partner;
use App\Models\PartnershipAgreement;

class PartnershipRepository
{
    public function getPartners(array $filters = [])
    {
        $query = Partner::query();

        if (isset($filters['category'])) {
            $query->byCategory($filters['category']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('name')->paginate($filters['per_page'] ?? 20);
    }

    public function getAgreements(array $filters = [])
    {
        $query = PartnershipAgreement::with(['partner', 'creator']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['partner_id'])) {
            $query->where('partner_id', $filters['partner_id']);
        }

        return $query->orderBy('start_date', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    public function getDashboardStatistics(): array
    {
        return [
            'total_partners' => Partner::active()->count(),
            'active_agreements' => PartnershipAgreement::active()->count(),
            'expiring_agreements' => PartnershipAgreement::expiring()->count(),
            'total_contributions' => \App\Models\PartnershipFinancial::where('type', 'inflow')->sum('amount'),
        ];
    }
}
