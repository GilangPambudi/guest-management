<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\InvitationTemplateMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PublicInvitationController extends Controller
{
    // Tidak ada middleware auth - semua method bisa diakses publik

    /**
     * Display invitation for guest
     */

    public function old_invitation($slug, $guest_id_qr_code)
    {
        // Cari invitation berdasarkan slug
        $invitation = Invitation::where('slug', $slug)->first();
        if (!$invitation) {
            abort(404, 'Invitation not found');
        }

        // Cari guest berdasarkan guest_id_qr_code dan pastikan dia milik invitation yang benar
        $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
            ->where('invitation_id', $invitation->invitation_id)
            ->first();

        if (!$guest) {
            abort(404, 'Guest not found or does not belong to this invitation');
        }

        // Jangan langsung update status di sini
        // Biarkan JavaScript di frontend yang handle update status setelah user interaction
        
        // Log untuk debugging
        Log::info('Guest accessed invitation', [
            'guest_id' => $guest->guest_id,
            'guest_name' => $guest->guest_name,
            'invitation_id' => $invitation->invitation_id,
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'current_status' => $guest->guest_invitation_status,
            'timestamp' => now()
        ]);

        // Ambil data dari undangan
        $groomName = $invitation->groom_name;
        $brideName = $invitation->bride_name;
        $weddingDate = $invitation->wedding_date;
        $weddingTimeStart = $invitation->wedding_time_start;
        $weddingTimeEnd = $invitation->wedding_time_end;
        $weddingVenue = $invitation->wedding_venue;
        $weddingLocation = $invitation->wedding_location;
        $weddingMaps = $invitation->wedding_maps;
        $weddingImage = $invitation->wedding_image;

        return view('guests.old_invitation', [
            'guest' => $guest,
            'invitation' => $invitation,
            'groomName' => $groomName,
            'brideName' => $brideName,
            'weddingDate' => $weddingDate,
            'weddingTimeStart' => $weddingTimeStart,
            'weddingTimeEnd' => $weddingTimeEnd,
            'weddingVenue' => $weddingVenue,
            'weddingLocation' => $weddingLocation,
            'weddingMaps' => $weddingMaps,
            'weddingImage' => $weddingImage
        ]);
    }

    public function preview($slug)
    {
        // Cari invitation berdasarkan slug
        $invitation = Invitation::where('slug', $slug)->first();
        if (!$invitation) {
            abort(404, 'Invitation not found');
        }

        // Kirim semua data invitation ke template
        return view('guests.preview', [
            'invitation' => $invitation,
            // Data yang sesuai dengan migration fields
            'groom_name' => $invitation->groom_name,
            'bride_name' => $invitation->bride_name,
            'groom_alias' => $invitation->groom_alias,
            'bride_alias' => $invitation->bride_alias,
            'groom_image' => $invitation->groom_image,
            'bride_image' => $invitation->bride_image,
            'groom_child_number' => $invitation->groom_child_number,
            'bride_child_number' => $invitation->bride_child_number,
            'groom_father' => $invitation->groom_father,
            'groom_mother' => $invitation->groom_mother,
            'bride_father' => $invitation->bride_father,
            'bride_mother' => $invitation->bride_mother,
            'wedding_date' => $invitation->wedding_date,
            'wedding_time_start' => $invitation->wedding_time_start,
            'wedding_time_end' => $invitation->wedding_time_end,
            'wedding_venue' => $invitation->wedding_venue,
            'wedding_location' => $invitation->wedding_location,
            'wedding_maps' => $invitation->wedding_maps,
            'wedding_image' => $invitation->wedding_image
        ]);
        
    }
    
    public function invitation($slug, $guest_id_qr_code)
    {
        // Cari invitation berdasarkan slug
        $invitation = Invitation::where('slug', $slug)->first();
        if (!$invitation) {
            abort(404, 'Invitation not found');
        }

        // Cari guest berdasarkan guest_id_qr_code dan pastikan dia milik invitation yang benar
        $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
            ->where('invitation_id', $invitation->invitation_id)
            ->first();

        if (!$guest) {
            abort(404, 'Guest not found or does not belong to this invitation');
        }

        // Jangan langsung update status di sini
        // Biarkan JavaScript di frontend yang handle update status setelah user interaction
        
        // Log untuk debugging
        Log::info('Guest accessed invitation', [
            'guest_id' => $guest->guest_id,
            'guest_name' => $guest->guest_name,
            'invitation_id' => $invitation->invitation_id,
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'current_status' => $guest->guest_invitation_status,
            'timestamp' => now()
        ]);

        // Tentukan template berdasarkan kategori tamu
        $templateName = 'invitation_1'; // Default template
        
        if (!empty($guest->guest_category)) {
            // Cari template mapping untuk kategori tamu ini
            $templateMapping = InvitationTemplateMapping::where('invitation_id', $invitation->invitation_id)
                ->where('guest_category', $guest->guest_category)
                ->first();
            
            if ($templateMapping) {
                $templateName = $templateMapping->template_name;
                Log::info('Template selected based on guest category', [
                    'guest_category' => $guest->guest_category,
                    'template_name' => $templateName,
                    'guest_id' => $guest->guest_id
                ]);
            } else {
                Log::info('No template mapping found for guest category, using default', [
                    'guest_category' => $guest->guest_category,
                    'default_template' => $templateName,
                    'guest_id' => $guest->guest_id
                ]);
            }
        }

        // Pastikan template view ada, jika tidak fallback ke invitation_1
        $templatePath = "guests.{$templateName}";
        if (!view()->exists($templatePath)) {
            Log::warning('Template not found, falling back to default', [
                'requested_template' => $templatePath,
                'fallback_template' => 'guests.invitation_1'
            ]);
            $templatePath = 'guests.invitation_1';
        }

        // Kirim semua data invitation ke template
        return view($templatePath, [
            'guest' => $guest,
            'invitation' => $invitation,
            // Data yang sesuai dengan migration fields
            'groom_name' => $invitation->groom_name,
            'bride_name' => $invitation->bride_name,
            'groom_alias' => $invitation->groom_alias,
            'bride_alias' => $invitation->bride_alias,
            'groom_image' => $invitation->groom_image,
            'bride_image' => $invitation->bride_image,
            'groom_child_number' => $invitation->groom_child_number,
            'bride_child_number' => $invitation->bride_child_number,
            'groom_father' => $invitation->groom_father,
            'groom_mother' => $invitation->groom_mother,
            'bride_father' => $invitation->bride_father,
            'bride_mother' => $invitation->bride_mother,
            'wedding_date' => $invitation->wedding_date,
            'wedding_time_start' => $invitation->wedding_time_start,
            'wedding_time_end' => $invitation->wedding_time_end,
            'wedding_venue' => $invitation->wedding_venue,
            'wedding_location' => $invitation->wedding_location,
            'wedding_maps' => $invitation->wedding_maps,
            'wedding_image' => $invitation->wedding_image
        ]);
    }

    /**
     * Update guest attendance status via RVSP
     */
    public function update_attendance_ajax(Request $request, $slug, $guest_id_qr_code)
    {
        try {
            $validator = Validator::make($request->all(), [
                'attendance_status' => 'required|in:Yes,No,-'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid attendance status',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cari invitation berdasarkan slug
            $invitation = Invitation::where('slug', $slug)->first();
            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invitation not found'
                ], 404);
            }

            // Cari guest berdasarkan guest_id_qr_code dan pastikan dia milik invitation yang benar
            $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
                ->where('invitation_id', $invitation->invitation_id)
                ->first();

            if (!$guest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guest not found or does not belong to this invitation'
                ], 404);
            }

            // Cek apakah RVSP masih bisa dilakukan (3 hari sebelum acara)
            $weddingDate = \Carbon\Carbon::parse($invitation->wedding_date);
            $today = \Carbon\Carbon::now();
            $daysUntilWedding = $today->diffInDays($weddingDate, false);

            if ($daysUntilWedding < 3) {
                // Hitung tanggal deadline (3 hari sebelum wedding_date)
                $deadlineDate = $weddingDate->copy()->subDays(3);
                $deadlineDateFormatted = $deadlineDate->locale('id')->translatedFormat('l, j F Y \p\u\k\u\l H:i');
                
                return response()->json([
                    'success' => false,
                    'message' => "Konfirmasi RVSP ditutup pada {$deadlineDateFormatted} WIB.",
                    'deadline_reached' => true,
                    'deadline_date' => $deadlineDateFormatted
                ], 403);
            }

            $newStatus = $request->attendance_status;
            $oldStatus = $guest->guest_attendance_status;

            // Update status kehadiran
            $updateData = ['guest_attendance_status' => $newStatus];

            // Jika status berubah menjadi No atau -, reset arrival time
            if ($newStatus === 'No' || $newStatus === '-') {
                $updateData['guest_arrival_time'] = '-';
            }

            $guest->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'RVSP status updated successfully',
                'new_status' => $newStatus,
                'old_status' => $oldStatus,
                'days_until_wedding' => $daysUntilWedding
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Welcome gate for QR scanner check-in
     */
    public function welcome_gate($invitation_id, $guest_id_qr_code)
    {
        // Cari invitation terlebih dahulu
        $invitation = Invitation::findOrFail($invitation_id);

        // Cari tamu berdasarkan guest_id_qr_code dan pastikan milik invitation yang benar
        $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
            ->where('invitation_id', $invitation_id)
            ->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found or does not belong to this invitation'
            ], 404);
        }

        // Cek apakah sudah check-in sebelumnya
        $alreadyCheckedIn = $guest->guest_attendance_status === 'Yes' && $guest->guest_arrival_time;

        // Perbarui waktu kedatangan tamu dan status kehadiran
        $guest->update([
            'guest_attendance_status' => 'Yes',
            'guest_arrival_time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => $alreadyCheckedIn ?
                "Welcome back, {$guest->guest_name}! (Already checked in)" :
                "Welcome, {$guest->guest_name}! Check-in successful",
            'guest_name' => $guest->guest_name,
            'guest_category' => $guest->guest_category,
            'already_checked_in' => $alreadyCheckedIn,
            'arrival_time' => now()->setTimezone('Asia/Jakarta')->format('H:i:s')
        ]);
    }

    /**
     * Mark invitation as opened after user interaction
     */
    public function mark_as_opened($slug, $guest_id_qr_code)
    {
        try {
            // Cari invitation berdasarkan slug
            $invitation = Invitation::where('slug', $slug)->first();
            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invitation not found'
                ], 404);
            }

            // Cari guest berdasarkan guest_id_qr_code dan pastikan dia milik invitation yang benar
            $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
                ->where('invitation_id', $invitation->invitation_id)
                ->first();

            if (!$guest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guest not found'
                ], 404);
            }

            // Update invitation status to "Opened" hanya jika masih "Sent"
            if ($guest->guest_invitation_status === 'Sent' && !$guest->invitation_opened_at) {
                Log::info('Guest invitation status changed to Opened by user interaction', [
                    'guest_id' => $guest->guest_id,
                    'guest_name' => $guest->guest_name,
                    'invitation_id' => $invitation->invitation_id,
                    'user_agent' => request()->header('User-Agent'),
                    'ip_address' => request()->ip(),
                    'timestamp' => now()
                ]);
                
                $guest->update([
                    'guest_invitation_status' => 'Opened',
                    'invitation_opened_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Status updated to opened'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Status already updated or not eligible'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
