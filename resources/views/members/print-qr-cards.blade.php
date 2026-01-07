<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member ID Cards - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: #f3f4f6;
        }

        /* Print Controls */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .print-controls button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-print {
            background: #2563eb;
            color: white;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        .btn-close {
            background: #6b7280;
            color: white;
        }

        .btn-close:hover {
            background: #4b5563;
        }

        @media print {
            .print-controls {
                display: none !important;
            }

            body {
                background: white;
            }

            .card-container {
                page-break-after: avoid;
            }

            .card-row:nth-child(2n) {
                page-break-after: always;
            }
        }

        /* Card Container */
        .card-container {
            width: 100%;
            padding: 20px;
        }

        .card-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 15mm;
            page-break-inside: avoid;
        }

        .card-cell {
            flex: 0 0 48%;
        }

        /* Card Sizes */
        .card-standard {
            width: 85.6mm;
            height: 53.98mm;
        }

        .card-mini {
            width: 90mm;
            height: 50mm;
        }

        .card-badge {
            width: 105mm;
            height: 74mm;
        }

        /* Card Styling */
        .member-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            padding: 8px;
            color: white;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .member-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        /* Photo Section */
        .photo-section {
            flex: 0 0 25%;
            text-align: center;
            z-index: 1;
        }

        .member-photo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            background: #cbd5e1;
        }

        .card-badge .member-photo {
            width: 60px;
            height: 60px;
        }

        .member-initials {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            margin: 0 auto;
        }

        .card-badge .member-initials {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        /* Info Section */
        .info-section {
            flex: 1;
            padding: 0 8px;
            z-index: 1;
        }

        .member-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .card-badge .member-name {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .member-detail {
            font-size: 8px;
            opacity: 0.95;
            margin-bottom: 2px;
        }

        .card-badge .member-detail {
            font-size: 10px;
            margin-bottom: 3px;
        }

        .member-id {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 9px;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 3px;
        }

        .card-badge .member-id {
            font-size: 11px;
            padding: 3px 8px;
        }

        /* QR Section */
        .qr-section {
            flex: 0 0 25%;
            text-align: center;
            z-index: 1;
        }

        .qr-code {
            width: 45px;
            height: 45px;
            background: white;
            padding: 2px;
            border-radius: 4px;
        }

        .card-badge .qr-code {
            width: 60px;
            height: 60px;
        }

        /* Church Logo/Watermark */
        .church-logo {
            position: absolute;
            bottom: 5px;
            left: 8px;
            font-size: 7px;
            opacity: 0.7;
            z-index: 1;
        }

        .card-badge .church-logo {
            font-size: 9px;
        }
    </style>
</head>
<body>
    <!-- Print Controls -->
    <div class="print-controls">
        <button onclick="window.print()" class="btn-print">
            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 5px;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
            </svg>
            Print Cards
        </button>
        <button onclick="window.close()" class="btn-close">
            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 5px;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
            Close
        </button>
    </div>

    <!-- Card Container -->
    <div class="card-container">
        @php
            $cardSizeClass = 'card-' . ($cardSize ?? 'standard');
            $chunkedMembers = $members->chunk(2);
        @endphp

        @foreach($chunkedMembers as $rowMembers)
        <div class="card-row">
            @foreach($rowMembers as $member)
            <div class="card-cell">
                <div class="member-card {{ $cardSizeClass }}">
                    <!-- Photo Section -->
                    <div class="photo-section">
                        @if($includePhoto && $member->photo_url)
                        <img src="{{ public_path('storage/' . $member->photo_url) }}"
                             alt="{{ $member->full_name }}"
                             class="member-photo">
                        @else
                        <div class="member-initials">
                            {{ strtoupper(substr($member->first_name ?? '', 0, 1) . substr($member->last_name ?? '', 0, 1)) }}
                        </div>
                        @endif
                    </div>

                    <!-- Info Section -->
                    <div class="info-section">
                        <div class="member-name">{{ $member->full_name }}</div>
                        <div class="member-detail">
                            @if($member->department)
                            {{ $member->department }}
                            @endif
                        </div>
                        <div class="member-detail">
                            Member Since {{ $member->created_at->format('Y') }}
                        </div>
                        <div class="member-id">{{ $member->member_id }}</div>
                    </div>

                    <!-- QR Section -->
                    <div class="qr-section">
                        @php
                            $qrCode = base64_encode(
                                QrCode::format('png')
                                    ->size(200)
                                    ->errorCorrection('H')
                                    ->generate($member->member_qr_code ?? 'MBR-' . $member->id)
                            );
                        @endphp
                        <img src="data:image/png;base64,{{ $qrCode }}"
                             alt="QR Code"
                             class="qr-code">
                    </div>

                    <!-- Church Logo/Name -->
                    <div class="church-logo">
                        {{ config('app.name', 'Church Name') }}
                    </div>
                </div>
            </div>
            @endforeach

            @if($rowMembers->count() == 1)
            <div class="card-cell"></div>
            @endif
        </div>
        @endforeach
    </div>

    <script>
        // Auto-print option (commented out by default)
        // window.addEventListener('load', function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // });
    </script>
</body>
</html>
