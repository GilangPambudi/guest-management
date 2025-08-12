<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invitation;
use App\Models\Guest;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendH4ConfirmationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send-h4';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send H-4 confirmation reminder to guests who have received invitation but not confirmed yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting H-4 Confirmation Reminder Job...');
        
        // Find invitations with wedding date = today + 4 days (using Asia/Jakarta timezone)
        $targetDate = now('Asia/Jakarta')->addDays(4)->toDateString();
        $invitations = Invitation::where('wedding_date', $targetDate)->get();
        
        if ($invitations->isEmpty()) {
            $this->info('ℹ️  No invitations found for H-4 date: ' . $targetDate);
            return;
        }
        
        $totalSent = 0;
        $totalFailed = 0;
        
        foreach ($invitations as $invitation) {
            $this->info("📧 Processing invitation: {$invitation->wedding_name}");
            
            // Get target guests: invitation sent/opened but attendance not confirmed
            $targetGuests = Guest::where('invitation_id', $invitation->invitation_id)
                ->whereIn('guest_invitation_status', ['Sent', 'Opened'])
                ->where('guest_attendance_status', '-')
                ->whereNull('h4_reminder_sent_at')
                ->get();
                
            $this->info("👥 Found {$targetGuests->count()} guests needing H-4 reminder");
            
            foreach ($targetGuests as $guest) {
                try {
                    $success = $this->sendH4Reminder($guest, $invitation);
                    
                    if ($success) {
                        // Mark reminder as sent
                        $guest->update(['h4_reminder_sent_at' => now()]);
                        $totalSent++;
                        $this->line("✅ Sent to: {$guest->guest_name}");
                    } else {
                        $totalFailed++;
                        $this->error("❌ Failed to send to: {$guest->guest_name}");
                    }
                    
                    // Small delay to respect API rate limits
                    sleep(1);
                    
                } catch (\Exception $e) {
                    $totalFailed++;
                    $this->error("❌ Error sending to {$guest->guest_name}: " . $e->getMessage());
                    Log::error("H-4 Reminder Error", [
                        'guest_id' => $guest->guest_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        
        $this->info("📊 H-4 Reminder Summary:");
        $this->info("✅ Successfully sent: {$totalSent}");
        $this->info("❌ Failed: {$totalFailed}");
        
        Log::info('H-4 Reminder Job Completed', [
            'date' => $targetDate,
            'sent' => $totalSent,
            'failed' => $totalFailed
        ]);
    }
    
    private function sendH4Reminder($guest, $invitation)
    {
        $token = env('FONNTE_TOKEN');
        if (!$token) {
            throw new \Exception('Fonnte token not configured');
        }
        
        $client = new Client();
        $url = url("/{$invitation->slug}/{$guest->guest_id_qr_code}");
        
        $message = "💌 *Pengingat Konfirmasi Kehadiran*\n\n"
            . "Halo {$guest->guest_name},\n\n"
            . "Kami mengingatkan bahwa acara pernikahan kami akan berlangsung dalam 4 hari.\n\n"
            . "🗓️ *Tanggal:* " . Carbon::parse($invitation->wedding_date)->translatedFormat('d F Y') . "\n"
            . "⏰ *Waktu:* " . Carbon::parse($invitation->wedding_time_start)->format('H:i') . " - " . Carbon::parse($invitation->wedding_time_end)->format('H:i') . "\n"
            . "🏛️ *Tempat:* {$invitation->wedding_venue}\n\n"
            . "⚠️ *Konfirmasi kehadiran akan ditutup dalam 24 jam.*\n\n"
            . "📍 *Link Konfirmasi:*\n{$url}\n\n"
            . "Mohon segera konfirmasi kehadiran Anda sebelum batas waktu berakhir.\n\n"
            . "Salam hangat,\n"
            . "*{$invitation->groom_name} & {$invitation->bride_name}*\n\n"
            . "_(Pesan ini dikirim untuk keperluan testing skripsi oleh GILANG PAMBUDI)_";
        
        try {
            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'target' => $guest->guest_contact,
                    'message' => $message,
                ]
            ]);
            
            $responseBody = json_decode($response->getBody()->getContents(), true);
            return isset($responseBody['status']) && $responseBody['status'] === true;
            
        } catch (\Exception $e) {
            throw new \Exception("WhatsApp API Error: " . $e->getMessage());
        }
    }
}
