<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Codes</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-after: always;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px;
            border: 2px solid #4e73df;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .qr-card {
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            background: white;
        }

        .qr-card.full-page {
            min-height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .qr-image {
            width: 300px;
            height: 300px;
            margin: 20px auto;
            border: 1px solid #ddd;
        }

        .qr-card.full-page .qr-image {
            width: 500px;
            height: 500px;
        }

        .qr-info {
            margin-top: 20px;
        }

        .qr-title {
            font-size: 24px;
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 10px;
        }

        .qr-card.full-page .qr-title {
            font-size: 32px;
        }

        .qr-details {
            font-size: 14px;
            color: #5a5c69;
            margin: 5px 0;
        }

        .qr-card.full-page .qr-details {
            font-size: 18px;
        }

        .qr-id {
            font-family: 'Courier New', monospace;
            background: #f8f9fc;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            margin: 10px 0;
        }

        .qr-instructions {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin-top: 20px;
            text-align: left;
        }

        .qr-instructions h4 {
            margin-top: 0;
            color: #856404;
        }

        .qr-instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }

        .qr-instructions li {
            margin: 5px 0;
        }

        .church-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .church-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }

        .expiry-warning {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-primary {
            background: #4e73df;
            color: white;
        }

        .btn-secondary {
            background: #858796;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .grid-layout .qr-card {
            margin-bottom: 0;
        }

        @media screen and (max-width: 768px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Print Controls -->
    <div class="print-controls no-print">
        <h5 style="margin-top: 0;">Print Options</h5>
        <label>
            <input type="radio" name="layout" value="single" checked onchange="changeLayout(this.value)">
            Full Page (1 per page)
        </label><br>
        <label>
            <input type="radio" name="layout" value="grid" onchange="changeLayout(this.value)">
            Grid Layout (2 per page)
        </label><br>
        <label>
            <input type="checkbox" id="showInstructions" checked onchange="toggleInstructions()">
            Show Instructions
        </label><br><br>
        <button class="btn btn-primary" onclick="window.print()">
            🖨️ Print
        </button>
        <button class="btn btn-secondary" onclick="window.close()">
            ✖️ Close
        </button>
    </div>

    <!-- Church Header -->
    <div class="church-logo no-print">
        <div class="church-name">{{ config('app.name') }}</div>
        <p style="color: #5a5c69;">QR Code Check-In System</p>
    </div>

    <!-- QR Codes Container -->
    <div id="qrContainer">
        @foreach($qrCodes as $qr)
        <div class="qr-card {{ $loop->count == 1 ? 'full-page' : '' }} {{ !$loop->last ? 'page-break' : '' }}">
            <div class="qr-title">
                {{ str_replace('_', ' ', $qr->type) }}
            </div>

            <div class="qr-image">
                <!-- QR Code Image -->
                <img src="{{ route('qr-management.image', $qr->id) }}"
                     alt="QR Code"
                     style="width: 100%; height: 100%;">
            </div>

            <div class="qr-info">
                <div class="qr-id">
                    {{ $qr->id }}
                </div>

                @if($qr->service_date)
                <div class="qr-details">
                    <strong>Service Date:</strong> {{ \Carbon\Carbon::parse($qr->service_date)->format('l, F d, Y') }}
                </div>
                <div class="qr-details">
                    <strong>Service Type:</strong> {{ ucwords(str_replace('_', ' ', $qr->service_type)) }}
                </div>
                @endif

                <div class="qr-details">
                    <strong>Valid From:</strong> {{ $qr->activation_time->format('M d, Y H:i') }}
                </div>
                <div class="qr-details">
                    <strong>Valid Until:</strong> {{ $qr->expiration_time->format('M d, Y H:i') }}
                </div>

                @if($qr->location_required)
                <div class="qr-details">
                    <strong>Location:</strong> GPS verification required ({{ $qr->location_radius }}m radius)
                </div>
                @endif

                @if($qr->expiration_time->diffInHours(now()) < 24)
                <div class="expiry-warning">
                    ⚠️ <strong>Note:</strong> This QR code expires {{ $qr->expiration_time->diffForHumans() }}
                </div>
                @endif
            </div>

            <div class="qr-instructions" style="display: block;">
                <h4>📱 How to Use This QR Code</h4>
                <ol>
                    <li>Open your mobile device camera or QR code scanner app</li>
                    <li>Point the camera at the QR code above</li>
                    <li>Wait for the notification or link to appear</li>
                    <li>Tap the notification to open the check-in page</li>
                    <li>Allow location access when prompted (required for verification)</li>
                    <li>Complete the check-in process</li>
                </ol>
                <p style="margin-bottom: 0; font-size: 12px; color: #666;">
                    <strong>Need Help?</strong> Contact the church office or a service coordinator.
                </p>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        function changeLayout(layout) {
            const container = document.getElementById('qrContainer');
            const cards = container.querySelectorAll('.qr-card');

            if (layout === 'grid') {
                container.style.display = 'grid';
                container.style.gridTemplateColumns = 'repeat(2, 1fr)';
                container.style.gap = '20px';
                cards.forEach(card => {
                    card.classList.remove('full-page', 'page-break');
                    card.querySelector('.qr-image').style.width = '200px';
                    card.querySelector('.qr-image').style.height = '200px';
                    card.querySelector('.qr-title').style.fontSize = '20px';
                    const details = card.querySelectorAll('.qr-details');
                    details.forEach(d => d.style.fontSize = '12px');
                });
            } else {
                container.style.display = 'block';
                cards.forEach((card, index) => {
                    card.classList.add('full-page');
                    if (index < cards.length - 1) {
                        card.classList.add('page-break');
                    }
                    card.querySelector('.qr-image').style.width = '500px';
                    card.querySelector('.qr-image').style.height = '500px';
                    card.querySelector('.qr-title').style.fontSize = '32px';
                    const details = card.querySelectorAll('.qr-details');
                    details.forEach(d => d.style.fontSize = '18px');
                });
            }
        }

        function toggleInstructions() {
            const show = document.getElementById('showInstructions').checked;
            const instructions = document.querySelectorAll('.qr-instructions');
            instructions.forEach(inst => {
                inst.style.display = show ? 'block' : 'none';
            });
        }

        // Auto-print dialog on load (optional)
        // window.onload = function() {
        //     setTimeout(() => window.print(), 500);
        // };
    </script>
</body>
</html>
