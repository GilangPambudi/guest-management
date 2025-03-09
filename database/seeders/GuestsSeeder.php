<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // saya mau buat 2 tamu nih
        $guests = [
            [
                'guest_name' => 'Budi',
                'guest_category' => 'VIP',
                'guest_contact' => '08123456789',
                'guest_address' => 'Jl. Jalan No. 1',
                'guest_qr_code' => 'QR001',
                'guest_attendance_status' => '-',
                'guest_invitation_status' => '-',
                'user_id' => 1,
            ],
            [
                'guest_name' => 'Andi',
                'guest_category' => 'VIP',
                'guest_contact' => '08123456789',
                'guest_address' => 'Jl. Jalan No. 2',
                'guest_qr_code' => 'QR002',
                'guest_attendance_status' => '-',
                'guest_invitation_status' => '-',
                'user_id' => 1,
            ],
        ];
        
        DB::table('guests')->insert($guests);
    }
}
