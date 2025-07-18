<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update Admin User
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin@admin.com'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create or update Regular User
        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('user@user.com'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Users created/updated successfully!');
        $this->command->info('Admin: admin@admin.com / admin@admin.com');
        $this->command->info('User: user@user.com / user@user.com');
    }
}
