@echo off
REM Church CMS Deployment Script for Windows
REM This script prepares the application for production deployment

echo ============================================
echo Church CMS - Production Deployment Preparation
echo ============================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo Error: artisan file not found. Please run this script from the project root.
    pause
    exit /b 1
)

echo Step 1: Installing production dependencies...
call composer install --no-dev --optimize-autoloader --no-interaction

echo.
echo Step 2: Optimizing application...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

echo.
echo Step 3: Building frontend assets...
if exist "node_modules" (
    call npm run build
) else (
    echo Warning: Node modules not found. Run 'npm install' first.
)

echo.
echo Step 4: Setting up storage...
call php artisan storage:link

echo.
echo ============================================
echo Application ready for deployment!
echo ============================================
echo.
echo Next steps:
echo   1. Initialize Git: git init
echo   2. Add files: git add .
echo   3. Commit: git commit -m "Initial commit"
echo   4. Push to GitHub: git push origin main
echo   5. Deploy on Railway.app
echo   6. Run migrations: railway run php artisan migrate --force
echo   7. Configure your domain
echo.
echo See DEPLOYMENT_GUIDE.md for detailed instructions
echo.
pause
