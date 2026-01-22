#!/bin/bash
set -e

# Handle Render's dynamic PORT environment variable
if [ -n "$PORT" ]; then
    echo "Configuring Apache to listen on port $PORT"
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/*.conf
fi

# Run Laravel optimizations with runtime environment
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Execute the main command
exec "$@"
