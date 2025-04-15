<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;

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
            'list' => ['Home', 'Dashboard']
        ];

        $page = (object)[
            'title' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';
        $totalInvitation = Invitation::count();
        $totalGuests = Guest::count();
        $totalAttendance = Guest::where('guest_attendance_status', 'Yes')->count();
    

        return view('home', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'totalInvitation' => $totalInvitation,
            'totalGuests' => $totalGuests,
            'totalAttendance' => $totalAttendance,
        ]);
    }
}
