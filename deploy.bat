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
    if errorlevel 1 (
        echo Error: npm install failed. Please check your package.json and try again.
        pause
        exit /b 1
    )
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
echo   1. Verify .gitignore includes .env and sensitive files
echo   2. Review changes: git status
echo   3. Stage files safely: git add -p (interactive) or git add ^<specific-files^>
echo   4. Commit and push: git commit -m "Deploy" ^&^& git push
echo   5. Create Web Service in Render dashboard
echo   6. Set environment variables
echo.
echo See docs\deployment\DEPLOYMENT_GUIDE.md for full instructions
echo.
pause
