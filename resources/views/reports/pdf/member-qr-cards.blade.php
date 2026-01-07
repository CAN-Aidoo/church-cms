<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Member ID Cards</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
        }

        .card-container {
            width: 100%;
        }

        .card-row {
            width: 100%;
            margin-bottom: 10mm;
            page-break-inside: avoid;
            display: table;
        }

        .card-row:nth-child(2n) {
            page-break-after: always;
        }

        .card-cell {
            display: table-cell;
            width: 50%;
            padding: 5mm;
            vertical-align: top;
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

        .member-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 6px;
            padding: 8px;
            color: white;
            display: table;
            width: 100%;
            height: 100%;
        }

        .photo-section {
            display: table-cell;
            width: 25%;
            text-align: center;
            vertical-align: middle;
        }

        .member-photo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid white;
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
            display: inline-block;
            line-height: 45px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .card-badge .member-initials {
            width: 60px;
            height: 60px;
            line-height: 60px;
            font-size: 22px;
        }

        .info-section {
            display: table-cell;
            width: 50%;
            padding: 0 8px;
            vertical-align: middle;
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
            font-family: Courier, monospace;
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

        .qr-section {
            display: table-cell;
            width: 25%;
            text-align: center;
            vertical-align: middle;
        }

        .qr-code {
            width: 45px;
            height: 45px;
            background: white;
            padding: 2px;
            border-radius: 3px;
        }

        .card-badge .qr-code {
            width: 60px;
            height: 60px;
        }

        .church-logo {
            position: absolute;
            bottom: 5px;
            left: 8px;
            font-size: 6px;
            opacity: 0.7;
        }

        .card-badge .church-logo {
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        @php
            $cardSizeClass = 'card-' . $cardSize;
            $chunkedMembers = $members->chunk(2);
        @endphp

        @foreach($chunkedMembers as $rowMembers)
        <div class="card-row">
            @foreach($rowMembers as $member)
            <div class="card-cell">
                <div class="member-card {{ $cardSizeClass }}">
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

                    <div class="church-logo">
                        {{ config('app.name', 'Church') }}
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
</body>
</html>
