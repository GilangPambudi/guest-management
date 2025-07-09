<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicInvitationController extends Controller
{
    // Tidak ada middleware auth - semua method bisa diakses publik

    /**
     * Display invitation letter for guest
     */
    public function invitation_letter($slug, $guest_id_qr_code)
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

        // Update invitation status to "Opened" when guest opens the invitation letter
        // Only update if status is currently "Sent" and hasn't been opened yet
        if ($guest->guest_invitation_status === 'Sent' && !$guest->invitation_opened_at) {
            $guest->update([
                'guest_invitation_status' => 'Opened',
                'invitation_opened_at' => now()
            ]);
        }

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

        return view('guests.invitation_letter', [
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

    /**
     * Update guest attendance status via RSVP
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
                'message' => 'RSVP status updated successfully',
                'new_status' => $newStatus,
                'old_status' => $oldStatus
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
}
