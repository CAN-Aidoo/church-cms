<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $program->name }} - QR Code Poster</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .poster {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            text-align: center;
            position: relative;
        }

        .poster-header {
            margin-bottom: 20mm;
        }

        .church-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .program-name {
            font-size: 32px;
            font-weight: bold;
            margin: 15px 0;
            line-height: 1.3;
        }

        .program-dates {
            font-size: 16px;
            margin: 10px 0;
            opacity: 0.95;
        }

        .qr-container {
            background: white;
            padding: 15mm;
            border-radius: 15px;
            display: inline-block;
            margin: 20mm auto;
        }

        .qr-code-large {
            width: 120mm;
            height: 120mm;
        }

        .qr-type-badge {
            background: #fbbf24;
            color: #1f2937;
            padding: 12px 25px;
            border-radius: 40px;
            font-size: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 15px 0;
        }

        .instructions {
            font-size: 16px;
            line-height: 1.7;
            margin: 20mm 0;
            max-width: 160mm;
            margin-left: auto;
            margin-right: auto;
        }

        .instructions h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .instructions ol {
            text-align: left;
            display: inline-block;
            margin-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
        }

        .footer {
            position: absolute;
            bottom: 20mm;
            left: 20mm;
            right: 20mm;
            text-align: center;
            font-size: 11px;
            opacity: 0.8;
        }

        .program-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            margin: 10px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="poster">
        <div class="poster-header">
            <div class="church-name">{{ config('app.name', 'Church Name') }}</div>
        </div>

        <div class="program-name">{{ $program->name }}</div>

        @if($program->start_date || $program->end_date)
        <div class="program-dates">
            @if($program->start_date->equalTo($program->end_date))
                {{ $program->start_date->format('F j, Y') }}
            @else
                {{ $program->start_date->format('F j') }} - {{ $program->end_date->format('F j, Y') }}
            @endif
        </div>
        @endif

        @if($program->venue_name)
        <div class="program-info">
            {{ $program->venue_name }}
        </div>
        @endif

        <div class="qr-container">
            @php
                $qrCodeData = $qrType === 'registration' ?
                    ($program->registration_qr_code ?? 'REG-' . $program->id) :
                    ($program->check_in_qr_code ?? 'CHK-' . $program->id);

                $qrCode = base64_encode(
                    QrCode::format('png')
                        ->size(480)
                        ->errorCorrection('H')
                        ->generate($qrCodeData)
                );
            @endphp
            <img src="data:image/png;base64,{{ $qrCode }}"
                 class="qr-code-large"
                 alt="QR Code">
        </div>

        <div class="qr-type-badge">
            @if($qrType === 'registration')
                SCAN TO REGISTER
            @else
                SCAN TO CHECK IN
            @endif
        </div>

        <div class="instructions">
            <h3>How to Scan:</h3>
            <ol>
                <li>Open your camera app or QR scanner</li>
                <li>Point camera at the QR code above</li>
                <li>Tap the notification to proceed</li>
                @if($qrType === 'registration')
                <li>Complete the registration form</li>
                @else
                <li>Confirm your check-in</li>
                @endif
            </ol>
        </div>

        <div class="footer">
            Generated on {{ now()->format('F j, Y') }}
            @if($program->start_time && $program->end_time)
            <br>
            Program Time: {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
            @endif
        </div>
    </div>
</body>
</html>
