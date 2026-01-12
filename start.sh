#!/bin/bash
set -e  # Exit on error (we'll disable this for optional steps)

echo "========================================"
echo "Church CMS - Railway Startup (Fast Mode)"
echo "========================================"

# Ensure PORT is set early
export PORT=${PORT:-8080}

echo "Port: $PORT"
echo "Environment: ${APP_ENV:-local}"
echo "========================================"

# Create required directories (parallel)
echo "Setting up directories..."
mkdir -p storage/framework/{sessions,views,cache/data,testing} storage/logs bootstrap/cache

# Set permissions with proper error handling
echo "Setting permissions..."
if ! chmod -R 775 storage bootstrap/cache 2>&1; then
    echo "WARNING: Failed to set permissions on storage/bootstrap - this may cause issues"
    echo "Attempting to continue anyway..."
fi

# CRITICAL: Clear all Laravel caches for fresh package discovery
echo "Clearing Laravel caches..."
set +e  # Don't exit on error for cache clearing
rm -f bootstrap/cache/packages.php bootstrap/cache/services.php bootstrap/cache/config.php bootstrap/cache/routes*.php 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
echo "Caches cleared successfully!"

# Optional: Quick database setup (don't let it fail)
echo "Quick setup..."
php artisan storage:link --force 2>/dev/null || true

# Quick migration attempt (5 second timeout)
if [ -n "$DB_HOST" ]; then
    echo "Attempting migrations (max 10s)..."
    timeout 10 php artisan migrate --force --no-interaction 2>&1 || echo "Skipped migrations (DB not ready or timeout)"
else
    echo "No DB_HOST set, skipping migrations"
fi

set -e  # Re-enable exit on error

# Start server immediately
echo "========================================"
echo "Starting server on port $PORT..."
echo "========================================"

exec php artisan serve --host=0.0.0.0 --port=$PORT --no-reload
