#!/bin/bash

# Church CMS Deployment Script
# This script prepares the application for production deployment

echo "🚀 Church CMS - Production Deployment Preparation"
echo "=================================================="
echo ""

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this script from the project root."
    exit 1
fi

echo "📋 Step 1: Installing production dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo ""
echo "🔧 Step 2: Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "📦 Step 3: Building frontend assets..."
if [ -d "node_modules" ]; then
    npm run build
else
    echo "⚠️  Node modules not found. Run 'npm install' first."
fi

echo ""
echo "🗄️  Step 4: Setting up storage..."
php artisan storage:link

echo ""
echo "✅ Application ready for deployment!"
echo ""
echo "📝 Next steps:"
echo "   1. Push to GitHub: git push origin main"
echo "   2. Deploy on Railway.app"
echo "   3. Run migrations: railway run php artisan migrate --force"
echo "   4. Configure your domain"
echo ""
echo "📖 See DEPLOYMENT_GUIDE.md for detailed instructions"
