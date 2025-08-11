<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashboard';

        $breadcrumb = (object)[
            'title' => 'Dashboard',
            'list' => ['Dashboard']
        ];

        $page = (object)[
            'title' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';
        
        // Role-based filtering for invitations
        if (Auth::user()->role === 'admin') {
            // Admin bisa lihat semua invitation
            $invitationsQuery = Invitation::with(['guests.payments']);
        } else {
            // User hanya bisa lihat invitation milik sendiri
            $invitationsQuery = Invitation::where('user_id', Auth::id())
                ->with(['guests.payments']);
        }
        
        $invitations = $invitationsQuery->get()->map(function ($invitation) {
            $guests = $invitation->guests;
            $totalGuests = $guests->count();
            $confirmedAttendance = $guests->where('guest_attendance_status', 'Yes')->count();
            $checkedIn = $guests->whereNotNull('guest_arrival_time')
                ->where('guest_arrival_time', '!=', '-')
                ->count();
            
            // Calculate total gift amount (like in GiftController)
            $payments = Payment::where('invitation_id', $invitation->invitation_id)
                ->where('transaction_status', 'settlement')
                ->get();
            $totalGiftAmount = $payments->sum('gross_amount');
            $totalGiftCount = $payments->count();
            
            // Calculate attendance percentage
            $attendancePercentage = $totalGuests > 0 ? round(($confirmedAttendance / $totalGuests) * 100, 1) : 0;
            
            return [
                'id' => $invitation->invitation_id,
                'name' => $invitation->wedding_name,
                'groom_name' => $invitation->groom_name,
                'bride_name' => $invitation->bride_name,
                'wedding_date' => $invitation->wedding_date,
                'wedding_time_start' => $invitation->wedding_time_start,
                'wedding_time_end' => $invitation->wedding_time_end,
                'wedding_venue' => $invitation->wedding_venue,
                'total_guests' => $totalGuests,
                'confirmed_attendance' => $confirmedAttendance,
                'checked_in' => $checkedIn,
                'total_gift_amount' => $totalGiftAmount,
                'total_gift_count' => $totalGiftCount,
                'attendance_percentage' => $attendancePercentage,
                'slug' => $invitation->slug,
            ];
        });

        return view('home', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitations' => $invitations,
        ]);
    }
}
