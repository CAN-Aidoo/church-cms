<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        .container {
            background: white;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #667eea;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .status {
            background: #f0fdf4;
            border: 2px solid #86efac;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        .status h2 {
            color: #16a34a;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            text-align: left;
            margin-top: 2rem;
        }
        .info-item {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
        }
        .info-item strong {
            color: #667eea;
            display: block;
            margin-bottom: 0.5rem;
        }
        .footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⛪ Church Management System</h1>
        <p>Welcome to the Church Management System! Your comprehensive solution for managing church operations, members, attendance, finances, and more.</p>

        <div class="status">
            <h2>✅ System Status: Running</h2>
            <p style="margin: 0; color: #16a34a;">The application has been successfully installed and is ready to use!</p>
        </div>

        <div class="info">
            <div class="info-item">
                <strong>Laravel Version</strong>
                {{ app()->version() }}
            </div>
            <div class="info-item">
                <strong>PHP Version</strong>
                {{ PHP_VERSION }}
            </div>
            <div class="info-item">
                <strong>Environment</strong>
                {{ config('app.env') }}
            </div>
            <div class="info-item">
                <strong>Debug Mode</strong>
                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
            </div>
        </div>

        <div class="footer">
            <p>Church Management System &copy; {{ date('Y') }}</p>
            <p>Powered by Laravel Framework</p>
        </div>
    </div>
</body>
</html>
