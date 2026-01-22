@echo off
REM Church CMS - Production Deployment Script
REM Prepares the application for deployment to Render

echo ============================================
echo Church CMS - Production Deployment
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
echo Step 2: Building frontend assets...
if exist "node_modules" (
    call npm run build
) else (
    call npm install
    call npm run build
)

echo.
echo Step 3: Optimizing application...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

echo.
echo Step 4: Setting up storage...
call php artisan storage:link

echo.
echo ============================================
echo Application ready for deployment!
echo ============================================
echo.
echo RENDER DEPLOYMENT:
echo   1. Push to GitHub: git add . ^&^& git commit -m "Deploy" ^&^& git push
echo   2. Create Web Service in Render dashboard
echo   3. Set environment variables
echo.
echo See docs\deployment\DEPLOYMENT_GUIDE.md for full instructions
echo.
pause
