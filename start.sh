#!/bin/bash

# Railway Deployment Start Script
# This script ensures the Laravel app starts even if migrations fail

echo "========================================"
echo "Church CMS - Railway Startup"
echo "========================================"

# Debug: Show important environment variables (safely)
echo "Environment check:"
echo "- PORT: ${PORT:-NOT_SET}"
echo "- APP_ENV: ${APP_ENV:-NOT_SET}"
echo "- DB_HOST: ${DB_HOST:-NOT_SET}"
echo "- DB_DATABASE: ${DB_DATABASE:-NOT_SET}"
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

# Test database connection and run migrations
echo "Testing database connection..."
set +e  # Don't exit on error

# Quick connection test
php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'Connected'; exit(0); } catch(Exception \$e) { exit(1); }" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "Database connected successfully!"

    # Run migrations
    echo "Running migrations..."
    php artisan migrate --force --no-interaction 2>&1 || echo "WARNING: Migration failed, but server will still start"
else
    echo "WARNING: Could not connect to database"
    echo "Server will start anyway - check database configuration in Railway"
fi

set -e  # Re-enable exit on error

# Start the server - this MUST happen regardless of above errors
echo "========================================"
echo "Starting Laravel server..."
echo "PORT: ${PORT:-8080}"
echo "Environment: $APP_ENV"
echo "========================================"

# Ensure PORT is set
export PORT=${PORT:-8080}

# Start server
exec php artisan serve --host=0.0.0.0 --port=$PORT
