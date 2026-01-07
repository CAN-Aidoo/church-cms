<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberQRCardsPdfExport
{
    public function __construct(
        private Collection $members,
        private string $cardSize = 'standard',
        private bool $includePhoto = true
    ) {}

    public function download()
    {
        $pdf = PDF::loadView('reports.pdf.member-qr-cards', [
            'members' => $this->members,
            'cardSize' => $this->cardSize,
            'includePhoto' => $this->includePhoto,
        ]);

        $pdf->setPaper('A4');

        return $pdf->download('member-qr-cards-' . now()->format('Y-m-d') . '.pdf');
    }

    public function stream()
    {
        $pdf = PDF::loadView('reports.pdf.member-qr-cards', [
            'members' => $this->members,
            'cardSize' => $this->cardSize,
            'includePhoto' => $this->includePhoto,
        ]);

        $pdf->setPaper('A4');

        return $pdf->stream('member-qr-cards-' . now()->format('Y-m-d') . '.pdf');
    }
}
