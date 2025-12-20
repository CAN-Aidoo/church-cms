@echo off
REM Church CMS - Automated Deployment Assistant
REM This script automates the Railway CLI deployment process

echo ============================================================
echo            Church CMS - Auto Deploy Assistant
echo ============================================================
echo.

REM Check if Railway CLI is installed
where railway >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [1/6] Installing Railway CLI...
    call npm install -g @railway/cli
    if %ERRORLEVEL% NEQ 0 (
        echo ERROR: Failed to install Railway CLI
        echo Please install Node.js first: https://nodejs.org
        pause
        exit /b 1
    )
) else (
    echo [1/6] Railway CLI already installed
)

echo.
echo [2/6] Logging into Railway...
echo Please complete the login in your browser...
call railway login
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Railway login failed
    pause
    exit /b 1
)

echo.
echo [3/6] Linking to Railway project...
echo Please select your church-cms project from the list
call railway link
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Failed to link project
    pause
    exit /b 1
)

echo.
echo [4/6] Running database migrations...
call railway run php artisan migrate --force
if %ERRORLEVEL% NEQ 0 (
    echo WARNING: Migration failed - you may need to run this manually
)

echo.
echo [5/6] Creating storage link...
call railway run php artisan storage:link
if %ERRORLEVEL% NEQ 0 (
    echo WARNING: Storage link failed - non-critical
)

echo.
echo [6/6] Checking migration status...
call railway run php artisan migrate:status

echo.
echo ============================================================
echo                 Deployment Complete!
echo ============================================================
echo.
echo Next steps:
echo 1. Create admin account (run: create-admin.bat)
echo 2. Get free domain from Freenom.com
echo 3. Connect domain in Railway dashboard
echo 4. Update APP_URL environment variable
echo.
echo Your Railway URL: Check Railway dashboard for deployment URL
echo.
pause
