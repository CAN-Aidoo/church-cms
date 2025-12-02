<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $existingUser = DB::table('users')->where('email', 'admin@church.com')->first();

        if ($existingUser) {
            echo "Admin user already exists!\n";
            echo "Email: admin@church.com\n";
            echo "Password: password\n";

            return;
        }

        // Create admin user
        $userId = DB::table('users')->insertGetId([
            'full_name' => 'System Administrator',
            'email' => 'admin@church.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+233200000000',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create corresponding member record
        DB::table('members')->insert([
            'user_id' => $userId,
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => 'admin@church.com',
            'phone' => '+233200000000',
            'date_of_birth' => '1980-01-01',
            'gender' => 'other',
            'marital_status' => 'single',
            'occupation' => 'Administrator',
            'address' => 'Church Office',
            'city' => 'Accra',
            'country' => 'Ghana',
            'join_date' => Carbon::now(),
            'member_status' => 'active',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        echo "Admin user created successfully!\n";
        echo "Email: admin@church.com\n";
        echo "Password: password\n";
        echo "\nPlease change the password after first login!\n";
    }
}
