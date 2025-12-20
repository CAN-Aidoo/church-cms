@echo off
REM Church CMS - Admin Account Creator
REM Creates the initial admin account via Railway CLI

echo ============================================================
echo         Church CMS - Create Admin Account
echo ============================================================
echo.

REM Check if Railway CLI is installed
where railway >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Railway CLI not found
    echo Please run auto-deploy.bat first
    pause
    exit /b 1
)

echo This will create your admin account.
echo.
set /p ADMIN_EMAIL="Enter admin email (default: admin@churchcms.com): "
if "%ADMIN_EMAIL%"=="" set ADMIN_EMAIL=admin@churchcms.com

set /p ADMIN_PASSWORD="Enter admin password (default: Admin@2024!): "
if "%ADMIN_PASSWORD%"=="" set ADMIN_PASSWORD=Admin@2024!

set /p ADMIN_NAME="Enter admin full name (default: Admin): "
if "%ADMIN_NAME%"=="" set ADMIN_NAME=Admin

echo.
echo Creating admin account...
echo Email: %ADMIN_EMAIL%
echo Name: %ADMIN_NAME%
echo.

REM Create temporary PHP script
echo ^<?php > create_admin_temp.php
echo require __DIR__.'/vendor/autoload.php'; >> create_admin_temp.php
echo $app = require_once __DIR__.'/bootstrap/app.php'; >> create_admin_temp.php
echo $app-^>make('Illuminate\Contracts\Console\Kernel'^)-^>bootstrap(); >> create_admin_temp.php
echo. >> create_admin_temp.php
echo $user = new App\Models\User(); >> create_admin_temp.php
echo $user-^>full_name = '%ADMIN_NAME%'; >> create_admin_temp.php
echo $user-^>email = '%ADMIN_EMAIL%'; >> create_admin_temp.php
echo $user-^>password = Hash::make('%ADMIN_PASSWORD%'^); >> create_admin_temp.php
echo $user-^>role = 'admin'; >> create_admin_temp.php
echo $user-^>is_active = true; >> create_admin_temp.php
echo $user-^>save(); >> create_admin_temp.php
echo. >> create_admin_temp.php
echo echo "Admin account created successfully!\n"; >> create_admin_temp.php
echo echo "Email: %ADMIN_EMAIL%\n"; >> create_admin_temp.php
echo echo "Password: %ADMIN_PASSWORD%\n"; >> create_admin_temp.php
echo echo "Please save these credentials!\n"; >> create_admin_temp.php

REM Execute via Railway
call railway run php create_admin_temp.php

REM Cleanup
del create_admin_temp.php

echo.
echo ============================================================
echo              Admin Account Created!
echo ============================================================
echo.
echo SAVE THESE CREDENTIALS:
echo Email: %ADMIN_EMAIL%
echo Password: %ADMIN_PASSWORD%
echo.
echo Login at: https://your-domain/login
echo.
pause
