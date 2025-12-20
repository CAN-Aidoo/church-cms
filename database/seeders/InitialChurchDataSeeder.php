<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InitialChurchDataSeeder extends Seeder
{
    /**
     * Seed initial church data for production.
     */
    public function run(): void
    {
        // Create Admin User (if not exists)
        if (!User::where('email', 'admin@churchcms.com')->exists()) {
            User::create([
                'full_name' => 'System Administrator',
                'email' => 'admin@churchcms.com',
                'password' => Hash::make('Admin@2024!'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✓ Admin user created');
        }

        // Create Pastor User (if not exists)
        if (!User::where('email', 'pastor@churchcms.com')->exists()) {
            User::create([
                'full_name' => 'Lead Pastor',
                'email' => 'pastor@churchcms.com',
                'password' => Hash::make('Pastor@2024!'),
                'role' => 'pastor',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✓ Pastor user created');
        }

        // Create Staff User (if not exists)
        if (!User::where('email', 'staff@churchcms.com')->exists()) {
            User::create([
                'full_name' => 'Church Staff',
                'email' => 'staff@churchcms.com',
                'password' => Hash::make('Staff@2024!'),
                'role' => 'staff',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✓ Staff user created');
        }

        // Create Demo Member User (if not exists)
        if (!User::where('email', 'member@churchcms.com')->exists()) {
            User::create([
                'full_name' => 'Demo Member',
                'email' => 'member@churchcms.com',
                'password' => Hash::make('Member@2024!'),
                'role' => 'member',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✓ Member user created');
        }

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('  Initial church data seeded successfully!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Default Accounts Created:');
        $this->command->info('');
        $this->command->info('Admin:');
        $this->command->info('  Email: admin@churchcms.com');
        $this->command->info('  Password: Admin@2024!');
        $this->command->info('');
        $this->command->info('Pastor:');
        $this->command->info('  Email: pastor@churchcms.com');
        $this->command->info('  Password: Pastor@2024!');
        $this->command->info('');
        $this->command->info('Staff:');
        $this->command->info('  Email: staff@churchcms.com');
        $this->command->info('  Password: Staff@2024!');
        $this->command->info('');
        $this->command->info('Member:');
        $this->command->info('  Email: member@churchcms.com');
        $this->command->info('  Password: Member@2024!');
        $this->command->info('');
        $this->command->info('⚠️  IMPORTANT: Change these passwords immediately after first login!');
        $this->command->info('');
    }
}
