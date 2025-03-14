<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Couple;
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
        $breadcrumb = (object)[
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];

        $page = (object)[
            'title' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';
        $totalGuests = Guest::count();
        $groom = Couple::where('is_groom', true)->first();
        $bride = Couple::where('is_bride', true)->first();

        return view('home', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'totalGuests' => $totalGuests,
            'groom' => $groom,
            'bride' => $bride
        ]);
    }
}
