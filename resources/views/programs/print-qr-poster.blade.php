<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $program->name }} - QR {{ ucfirst($qrType) }} Poster</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    
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
            font-family: 'Inter', sans-serif;
            background: #e2e8f0;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* Print Controls */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 10px;
        }

        .print-controls button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-print {
            background: #2563eb;
            color: white;
        }
        .btn-print:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-close {
            background: #f1f5f9;
            color: #475569;
        }
        .btn-close:hover {
            background: #e2e8f0;
        }

        @media print {
            .print-controls {
                display: none !important;
            }

            body {
                background: white;
                display: block;
            }
            .poster {
                margin: 0;
                box-shadow: none;
            }
        }

        .poster {
            width: 210mm;
            height: 297mm;
            padding: 0;
            background: white;
            position: relative;
            margin: 20px auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .poster-bg-top {
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            height: 35%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            border-bottom-left-radius: 100% 20%;
            border-bottom-right-radius: 100% 20%;
            z-index: 0;
        }

        .poster-content {
            position: relative;
            z-index: 10;
            padding: 20mm;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .church-name {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .program-name {
            font-family: 'Outfit', sans-serif;
            font-size: 48px;
            font-weight: 700;
            color: white;
            line-height: 1.1;
            margin-bottom: 20px;
            text-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 100%;
            word-wrap: break-word;
        }

        .card-info {
            background: white;
            border-radius: 20px;
            padding: 20px 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 10px;
            margin-bottom: 30px;
            min-width: 60%;
        }

        .program-dates {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }
        
        .program-venue {
            font-size: 16px;
            color: #64748b;
        }

        .qr-section {
            background: white;
            border: 4px solid #e2e8f0;
            border-radius: 30px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
        }

        .qr-code-large {
            width: 90mm;
            height: 90mm;
            display: block;
        }

        .cta-badge {
            background: #0f172a;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            margin-top: -30px;
            position: relative;
            z-index: 20;
        }

        .scan-arrow {
            color: #94a3b8;
            margin: 20px 0 10px;
        }

        .instructions {
            margin-top: auto;
            margin-bottom: 20px;
            color: #475569;
        }
        
        .instructions h3 {
            font-size: 18px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
        }
        
        .step-list {
            display: flex;
            gap: 20px;
            justify-content: center;
        }
        
        .step {
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        
        .step-num {
            width: 24px;
            height: 24px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
            margin-right: 8px;
            color: #1e293b;
        }

        .footer-branding {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #f8fafc;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- Print Controls -->
    <div class="print-controls">
        <button onclick="window.print()" class="btn-print">
            Print Poster
        </button>
        <button onclick="window.close()" class="btn-close">
            Close
        </button>
    </div>

    <!-- Poster -->
    <div class="poster">
        <div class="poster-bg-top"></div>
        
        <div class="poster-content">
            <div class="church-name">{{ config('app.name', 'Church Name') }}</div>
            <div class="program-name">{{ $program->name }}</div>

            <div class="card-info">
                @if($program->start_date)
                <div class="program-dates">
                    @if($program->end_date && !$program->start_date->equalTo($program->end_date))
                        {{ $program->start_date->format('M j') }} - {{ $program->end_date->format('M j, Y') }}
                    @else
                        {{ $program->start_date->format('F j, Y') }}
                    @endif
                </div>
                @endif

                @if($program->venue_name)
                <div class="program-venue">
                    {{ $program->venue_name }}
                </div>
                @endif
            </div>

            <div class="qr-section">
                @php
                    $qrCodeData = $qrType === 'registration' ?
                        ($program->registration_qr_code ?? 'REG-' . $program->id) :
                        ($program->check_in_qr_code ?? 'CHK-' . $program->id);
                @endphp
                <img src="{{ route('programs.qr-image', ['program' => $program->id, 'type' => $qrType]) }}"
                     class="qr-code-large"
                     alt="QR Code">
            </div>

            <div class="cta-badge">
                @if($qrType === 'registration')
                    Scan to Register
                @else
                    Scan to Check In
                @endif
            </div>

            <div class="scan-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M12 19L5 12M12 19L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="instructions">
                <h3>Quick Steps</h3>
                <div class="step-list">
                    <div class="step">
                        <span class="step-num">1</span> Open Camera
                    </div>
                    <div class="step">
                        <span class="step-num">2</span> Scan Code
                    </div>
                    <div class="step">
                        <span class="step-num">3</span> 
                        @if($qrType === 'registration') Register @else Check In @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-branding">
            Powered by {{ config('app.name') }} • Generated on {{ now()->format('M j, Y') }}
        </div>
    </div>
</body>
</html>
