<?php

/**
 * Church CMS - Deployment Verification Script
 *
 * This script checks if your application is ready for production deployment
 * Run: php verify-deployment.php
 */
echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   Church CMS - Production Deployment Verification         ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

$errors = [];
$warnings = [];
$passed = 0;
$total = 0;

function check($description, $condition, $error = null, $isWarning = false)
{
    global $errors, $warnings, $passed, $total;
    $total++;

    if ($condition) {
        echo "✓ $description\n";
        $passed++;

        return true;
    } else {
        $symbol = $isWarning ? '⚠' : '✗';
        echo "$symbol $description\n";
        if ($error) {
            if ($isWarning) {
                $warnings[] = $error;
            } else {
                $errors[] = $error;
            }
        }

        return false;
    }
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING APPLICATION STRUCTURE\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

check('artisan file exists', file_exists('artisan'));
check('composer.json exists', file_exists('composer.json'));
check('package.json exists', file_exists('package.json'));
check('public/index.php exists', file_exists('public/index.php'));
check('app directory exists', is_dir('app'));
check('resources directory exists', is_dir('resources'));
check('database directory exists', is_dir('database'));

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING DEPLOYMENT FILES\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

check('Procfile exists', file_exists('Procfile'));
check('railway.json exists', file_exists('railway.json'));
check('nixpacks.toml exists', file_exists('nixpacks.toml'));
check('.gitignore exists', file_exists('.gitignore'));
check('DEPLOYMENT_GUIDE.md exists', file_exists('DEPLOYMENT_GUIDE.md'));
check('QUICK_DEPLOY.md exists', file_exists('QUICK_DEPLOY.md'));

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING ENVIRONMENT CONFIGURATION\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

check('.env file exists', file_exists('.env'), 'Create .env from .env.example');
check('.env.example exists', file_exists('.env.example'));
check('.env.production.example exists', file_exists('.env.production.example'));

if (file_exists('.env')) {
    $env = file_get_contents('.env');
    check('APP_KEY is set', strpos($env, 'APP_KEY=base64:') !== false, 'Run: php artisan key:generate');
    check('APP_NAME is set', strpos($env, 'APP_NAME=') !== false);
    check('DB_DATABASE is set', strpos($env, 'DB_DATABASE=') !== false);
}

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING DIRECTORIES & PERMISSIONS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

check('storage directory exists', is_dir('storage'));
check('storage/app directory exists', is_dir('storage/app'));
check('storage/framework directory exists', is_dir('storage/framework'));
check('storage/logs directory exists', is_dir('storage/logs'));
check('bootstrap/cache directory exists', is_dir('bootstrap/cache'));

check('storage directory is writable', is_writable('storage'), 'Make storage writable', true);
check('bootstrap/cache is writable', is_writable('bootstrap/cache'), 'Make bootstrap/cache writable', true);

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING DEPENDENCIES\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

check('vendor directory exists', is_dir('vendor'), 'Run: composer install');
check('node_modules exists', is_dir('node_modules'), 'Run: npm install', true);

if (is_dir('vendor')) {
    check('autoload.php exists', file_exists('vendor/autoload.php'));
}

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING DATABASE MIGRATIONS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$migrationFiles = glob('database/migrations/*.php');
check('Migration files exist', count($migrationFiles) > 0, 'No migrations found');
echo '  Found '.count($migrationFiles)." migration files\n";

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING PRODUCTION READINESS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

// Check if .env has production settings
if (file_exists('.env')) {
    $env = file_get_contents('.env');
    check('APP_DEBUG should be false for production',
        strpos($env, 'APP_DEBUG=false') !== false || strpos($env, 'APP_DEBUG=true') === false,
        'Set APP_DEBUG=false in production',
        true);

    check('APP_ENV should be production',
        strpos($env, 'APP_ENV=production') !== false || strpos($env, 'APP_ENV=local') === false,
        'Set APP_ENV=production',
        true);
}

check('public/storage symlink recommended',
    file_exists('public/storage') || is_link('public/storage'),
    'Run: php artisan storage:link',
    true);

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "CHECKING GIT REPOSITORY\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

check('.git directory exists', is_dir('.git'), 'Run: git init', true);
check('.gitignore configured', file_exists('.gitignore') && filesize('.gitignore') > 0);

if (is_dir('.git')) {
    exec('git remote -v', $output);
    check('Git remote configured', count($output) > 0, 'Run: git remote add origin <url>', true);
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "VERIFICATION SUMMARY\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "\n";

$percentage = round(($passed / $total) * 100);

echo "Total Checks: $total\n";
echo "Passed: $passed ✓\n";
echo 'Failed: '.count($errors)." ✗\n";
echo 'Warnings: '.count($warnings)." ⚠\n";
echo "Score: $percentage%\n";
echo "\n";

if (count($errors) > 0) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "CRITICAL ERRORS (Must Fix Before Deployment)\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    foreach ($errors as $i => $error) {
        echo ($i + 1).". $error\n";
    }
    echo "\n";
}

if (count($warnings) > 0) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "WARNINGS (Recommended to Fix)\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    foreach ($warnings as $i => $warning) {
        echo ($i + 1).". $warning\n";
    }
    echo "\n";
}

if ($percentage >= 80 && count($errors) == 0) {
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║  ✓ READY FOR DEPLOYMENT!                                  ║\n";
    echo "║                                                            ║\n";
    echo "║  Your application is ready for production deployment.     ║\n";
    echo "║  See QUICK_DEPLOY.md for deployment instructions.         ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n";
} elseif (count($errors) == 0) {
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║  ⚠ READY WITH WARNINGS                                    ║\n";
    echo "║                                                            ║\n";
    echo "║  Application can be deployed but has some warnings.       ║\n";
    echo "║  Review warnings above before deploying.                  ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n";
} else {
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║  ✗ NOT READY FOR DEPLOYMENT                               ║\n";
    echo "║                                                            ║\n";
    echo "║  Critical errors must be fixed before deployment.         ║\n";
    echo "║  See errors above and fix them.                           ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n";
}

echo "\n";
exit(count($errors) > 0 ? 1 : 0);
