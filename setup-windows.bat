@echo off
echo ========================================
echo Church Management System - Setup Script
echo ========================================
echo.

REM Check if composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Composer is not installed or not in PATH
    echo Please install Composer from: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Check if PHP is installed
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] PHP is not found in PATH
    echo Please add PHP to your PATH or use full path to php.exe
    echo XAMPP PHP is usually at: C:\xampp\php\php.exe
    pause
    exit /b 1
)

REM Check if Node.js is installed
where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Node.js is not found in PATH
    echo Node.js is required for frontend assets
    echo Please install Node.js from: https://nodejs.org/
    pause
)

echo [1/8] Installing PHP dependencies...
call composer install
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Failed to install PHP dependencies
    pause
    exit /b 1
)

echo.
echo [2/8] Installing Node.js dependencies...
where npm >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    call npm install
    if %ERRORLEVEL% NEQ 0 (
        echo [WARNING] Failed to install Node.js dependencies
        echo You can run this manually later: npm install
    )
) else (
    echo [WARNING] npm not found. Skipping Node.js dependencies.
    echo Please install Node.js and run: npm install
)

echo.
echo [3/8] Creating .env file...
if not exist .env (
    if exist .env.example (
        copy .env.example .env
        echo [OK] .env file created from .env.example
    ) else (
        echo [WARNING] .env.example not found. Creating empty .env file.
        echo. > .env
        echo APP_NAME="Church Management System" >> .env
        echo APP_ENV=local >> .env
        echo APP_DEBUG=true >> .env
        echo APP_URL=http://localhost:8000 >> .env
        echo. >> .env
        echo DB_CONNECTION=mysql >> .env
        echo DB_HOST=127.0.0.1 >> .env
        echo DB_PORT=3306 >> .env
        echo DB_DATABASE=church_management >> .env
        echo DB_USERNAME=root >> .env
        echo DB_PASSWORD= >> .env
    )
) else (
    echo [INFO] .env file already exists. Skipping...
)

echo.
echo [4/8] Generating application key...
call php artisan key:generate
if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Failed to generate application key
    echo You can run this manually: php artisan key:generate
)

echo.
echo [5/8] Creating storage link...
call php artisan storage:link
if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Failed to create storage link
    echo You can run this manually: php artisan storage:link
)

echo.
echo ========================================
echo Manual Steps Required:
echo ========================================
echo.
echo 1. Make sure XAMPP is running (Apache and MySQL)
echo.
echo 2. Create the database:
echo    - Open phpMyAdmin: http://localhost/phpmyadmin
echo    - Create database named: church_management
echo    - Or run: mysql -u root -e "CREATE DATABASE church_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo.
echo 3. Edit the .env file and configure:
echo    - DB_DATABASE (should be: church_management)
echo    - DB_PASSWORD (leave empty if XAMPP default)
echo    - CHURCH_NAME, CHURCH_ADDRESS, CHURCH_PHONE
echo.
echo 4. Run database migrations:
echo    php artisan migrate
echo.
echo 5. (Optional) Seed sample data:
echo    php artisan db:seed
echo.
echo 6. Build frontend assets:
echo    npm run build
echo    OR for development: npm run dev
echo.
echo 7. Start the server:
echo    php artisan serve
echo.
echo 8. Open in browser: http://localhost:8000
echo.
echo ========================================
echo For detailed instructions, see:
echo BEGINNER_INSTALLATION_GUIDE.md
echo ========================================
echo.
pause



