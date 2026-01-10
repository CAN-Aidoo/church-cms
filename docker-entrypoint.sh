#!/bin/bash
set -e

echo "Starting Church CMS deployment..."

# Clear old cache
echo "Clearing old cache files..."
rm -rf bootstrap/cache/*.php

# Wait for database to be ready
echo "Waiting for database..."
until php artisan migrate --force --no-interaction 2>/dev/null; do
    echo "Database not ready yet, waiting 2 seconds..."
    sleep 2
done

echo "Database is ready!"

# Run migrations
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

# Set proper permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Deployment complete! Starting Apache..."

# Execute the main container command
exec "$@"
