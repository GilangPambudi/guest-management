<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invitation;
use App\Models\Guest;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendH1EventInfoReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send-h1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send H-1 event information to guests who confirmed attendance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting H-1 Event Info Reminder Job...');
        
        // Find invitations with wedding date = today + 1 day
        $targetDate = now()->addDays(1)->toDateString();
        $invitations = Invitation::where('wedding_date', $targetDate)->get();
        
        if ($invitations->isEmpty()) {
            $this->info('ℹ️  No invitations found for H-1 date: ' . $targetDate);
            return;
        }
        
        $totalSent = 0;
        $totalFailed = 0;
        
        foreach ($invitations as $invitation) {
            $this->info("📧 Processing invitation: {$invitation->wedding_name}");
            
            // Get target guests: confirmed attendance = 'Yes'
            $targetGuests = Guest::where('invitation_id', $invitation->invitation_id)
                ->where('guest_attendance_status', 'Yes')
                ->whereNull('h1_info_sent_at')
                ->get();
                
            $this->info("👥 Found {$targetGuests->count()} guests needing H-1 event info");
            
            foreach ($targetGuests as $guest) {
                try {
                    $success = $this->sendH1EventInfo($guest, $invitation);
                    
                    if ($success) {
                        // Mark info as sent
                        $guest->update(['h1_info_sent_at' => now()]);
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
                    Log::error("H-1 Event Info Error", [
                        'guest_id' => $guest->guest_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        
        $this->info("📊 H-1 Event Info Summary:");
        $this->info("✅ Successfully sent: {$totalSent}");
        $this->info("❌ Failed: {$totalFailed}");
        
        Log::info('H-1 Event Info Job Completed', [
            'date' => $targetDate,
            'sent' => $totalSent,
            'failed' => $totalFailed
        ]);
    }
    
    private function sendH1EventInfo($guest, $invitation)
    {
        $token = env('FONNTE_TOKEN');
        if (!$token) {
            throw new \Exception('Fonnte token not configured');
        }
        
        $client = new Client();
        
        $message = "🎉 *Informasi Acara Pernikahan*\n\n"
            . "Halo {$guest->guest_name},\n\n"
            . "Terima kasih telah mengkonfirmasi kehadiran Anda. Besok adalah hari bahagia kami!\n\n"
            . "📅 *Detail Acara:*\n"
            . "🗓️ *Tanggal:* " . Carbon::parse($invitation->wedding_date)->translatedFormat('d F Y') . "\n"
            . "⏰ *Waktu:* " . Carbon::parse($invitation->wedding_time_start)->format('H:i') . " - " . Carbon::parse($invitation->wedding_time_end)->format('H:i') . "\n"
            . "🏛️ *Tempat:* {$invitation->wedding_venue}\n"
            . "📍 *Alamat:* {$invitation->wedding_location}\n\n"
            . "🗺️ *Lokasi di Maps:*\n{$invitation->wedding_maps}\n\n"
            . "Kami sangat menantikan kehadiran Anda besok.\n\n"
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
