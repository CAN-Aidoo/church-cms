#!/bin/bash

# Railway Deployment Start Script
# This script ensures the Laravel app starts even if migrations fail

echo "========================================"
echo "Church CMS - Railway Startup"
echo "========================================"

# Create required directories
echo "Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/testing
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Clear config cache to pick up fresh environment
echo "Clearing config cache..."
php artisan config:clear 2>/dev/null || true

# Try to create storage link
echo "Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Test database connection
echo "Testing database connection..."
if php artisan tinker --execute="DB::connection()->getPDO(); echo 'Connected';" 2>/dev/null; then
    echo "Database connected successfully!"
    
    # Run migrations only if database is accessible
    echo "Running migrations..."
    if php artisan migrate --force --no-interaction 2>&1; then
        echo "Migrations completed successfully!"
    else
        echo "WARNING: Migration failed, but server will still start"
    fi
else
    echo "WARNING: Could not connect to database"
    echo "Server will start anyway - check your database configuration"
fi

# Start the server - this MUST happen regardless of above errors
echo "========================================"
echo "Starting Laravel server on port $PORT..."
echo "========================================"

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
