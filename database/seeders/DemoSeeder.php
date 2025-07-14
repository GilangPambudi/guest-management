<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds for demo/development purposes.
     */
    public function run(): void
    {
        $this->command->info('🌱 Creating demo data...');

        // Create demo users if they don't exist
        $this->createDemoUsers();
        
        $this->command->info('✅ Demo data created successfully!');
        $this->command->newLine();
        $this->showLoginCredentials();
    }

    private function createDemoUsers(): void
    {
        // Demo Admin
        User::updateOrCreate(
            ['email' => 'demo@admin.com'],
            [
                'name' => 'Demo Administrator',
                'password' => Hash::make('demo123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Demo Manager
        User::updateOrCreate(
            ['email' => 'manager@demo.com'],
            [
                'name' => 'Demo Manager',
                'password' => Hash::make('demo123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Demo Event Organizer
        User::updateOrCreate(
            ['email' => 'organizer@demo.com'],
            [
                'name' => 'Demo Event Organizer',
                'password' => Hash::make('demo123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('👥 Demo users created');
    }

    private function showLoginCredentials(): void
    {
        $this->command->info('🔐 Login Credentials:');
        $this->command->line('');
        $this->command->line('📋 ADMIN ACCESS:');
        $this->command->line('   Email: demo@admin.com');
        $this->command->line('   Password: demo123');
        $this->command->line('   Access: Full admin panel');
        $this->command->line('');
        $this->command->line('👤 USER ACCESS:');
        $this->command->line('   Email: manager@demo.com');
        $this->command->line('   Password: demo123');
        $this->command->line('   Access: Standard features');
        $this->command->line('');
        $this->command->line('🎯 ORGANIZER:');
        $this->command->line('   Email: organizer@demo.com');
        $this->command->line('   Password: demo123');
        $this->command->line('   Access: Event management');
        $this->command->line('');
        $this->command->warn('⚠️  Remember to change passwords in production!');
    }
}
