#!/bin/bash

# Church CMS - Production Deployment Script
# Prepares the application for deployment to Render

echo "Church CMS - Production Deployment"
echo "==================================="
echo ""

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "Error: artisan file not found. Please run this script from the project root."
    exit 1
fi

echo "Step 1: Installing production dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo ""
echo "Step 2: Building frontend assets..."
if [ -d "node_modules" ]; then
    npm run build
else
    npm install
    npm run build
fi

echo ""
echo "Step 3: Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "Step 4: Setting up storage..."
php artisan storage:link 2>/dev/null || true

echo ""
echo "==================================="
echo "Application ready for deployment!"
echo "==================================="
echo ""
echo "RENDER DEPLOYMENT:"
echo "  1. Push to GitHub: git add . && git commit -m 'Deploy' && git push"
echo "  2. Create Web Service in Render dashboard"
echo "  3. Set environment variables"
echo ""
echo "See docs/deployment/DEPLOYMENT_GUIDE.md for full instructions"
