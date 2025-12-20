@echo off
REM Church CMS - Production Verification Script
REM Verifies that the production deployment is working correctly

echo ============================================================
echo       Church CMS - Production Deployment Verification
echo ============================================================
echo.

set /p PROD_URL="Enter your production URL (e.g., https://gracechurch.tk): "

if "%PROD_URL%"=="" (
    echo ERROR: URL is required
    pause
    exit /b 1
)

echo.
echo Testing deployment at: %PROD_URL%
echo.
echo ============================================================
echo [1/8] Testing Main Site...
echo ============================================================
curl -s -o nul -w "HTTP Status: %%{http_code}\n" %PROD_URL%

echo.
echo ============================================================
echo [2/8] Testing Admin Login Page...
echo ============================================================
curl -s -o nul -w "HTTP Status: %%{http_code}\n" %PROD_URL%/login

echo.
echo ============================================================
echo [3/8] Testing Mobile App...
echo ============================================================
curl -s -o nul -w "HTTP Status: %%{http_code}\n" %PROD_URL%/mobile

echo.
echo ============================================================
echo [4/8] Testing Mobile Login...
echo ============================================================
curl -s -o nul -w "HTTP Status: %%{http_code}\n" %PROD_URL%/mobile/login

echo.
echo ============================================================
echo [5/8] Testing API Endpoint...
echo ============================================================
curl -s -o nul -w "HTTP Status: %%{http_code}\n" %PROD_URL%/api/v1/login -X POST -H "Content-Type: application/json"

echo.
echo ============================================================
echo [6/8] Testing SSL Certificate...
echo ============================================================
echo Checking if HTTPS is enabled...
curl -s -I %PROD_URL% | findstr /i "https"
if %ERRORLEVEL% EQU 0 (
    echo SSL: OK - Site is using HTTPS
) else (
    echo WARNING: Site may not be using HTTPS
)

echo.
echo ============================================================
echo [7/8] Checking DNS Resolution...
echo ============================================================
nslookup %PROD_URL:~8%

echo.
echo ============================================================
echo [8/8] Testing Railway CLI Connection...
echo ============================================================
where railway >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    echo Railway CLI: Installed
    call railway status
) else (
    echo Railway CLI: Not installed
    echo Install with: npm install -g @railway/cli
)

echo.
echo ============================================================
echo              Verification Complete!
echo ============================================================
echo.
echo Next steps:
echo 1. Visit %PROD_URL% in your browser
echo 2. Login to admin panel: %PROD_URL%/login
echo 3. Test mobile app: %PROD_URL%/mobile
echo 4. Change default passwords
echo 5. Customize church information
echo.
pause
