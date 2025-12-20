@echo off
REM Church CMS - Seed Initial Data
REM Seeds the database with default admin, pastor, staff, and member accounts

echo ============================================================
echo      Church CMS - Seed Initial Church Data
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

echo This will create default accounts for testing:
echo - Admin (admin@churchcms.com)
echo - Pastor (pastor@churchcms.com)
echo - Staff (staff@churchcms.com)
echo - Member (member@churchcms.com)
echo.
echo All with default passwords that should be changed!
echo.
pause

echo.
echo Running database seeder...
call railway run php artisan db:seed --class=InitialChurchDataSeeder

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ============================================================
    echo              Initial Data Seeded Successfully!
    echo ============================================================
    echo.
    echo Default Accounts Created:
    echo.
    echo Admin:    admin@churchcms.com   / Admin@2024!
    echo Pastor:   pastor@churchcms.com  / Pastor@2024!
    echo Staff:    staff@churchcms.com   / Staff@2024!
    echo Member:   member@churchcms.com  / Member@2024!
    echo.
    echo WARNING: Change all passwords after first login!
    echo.
) else (
    echo.
    echo ERROR: Seeding failed
    echo Check the error message above
    echo.
)

pause
