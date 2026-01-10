#!/bin/bash
set -e

echo "Starting Church CMS deployment..."

# Clear old cache
echo "Clearing old cache files..."
rm -rf bootstrap/cache/*.php

# Wait for database to be ready (lightweight connection test)
echo "Waiting for database..."
until php -r "new PDO(getenv('DB_CONNECTION').':host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));" 2>/dev/null; do
    echo "Database not ready yet, waiting 2 seconds..."
    sleep 2
done

echo "Database is ready!"

# Run migrations (only once, after DB is ready)
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Seed admin user (only if doesn't exist)
echo "Checking admin user..."
php artisan db:seed --class=AdminUserSeeder --force --no-interaction 2>/dev/null || true

# Create storage link
echo "Creating storage link..."
php artisan storage:link --force || true

# Clear and cache config
echo "Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions (only if running as root)
if [ "$(id -u)" -eq 0 ]; then
    echo "Setting permissions (running as root)..."
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
else
    echo "Skipping permission changes (not running as root)..."
    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
fi

echo "Deployment complete! Starting Apache..."

# Execute the main container command
exec "$@"
