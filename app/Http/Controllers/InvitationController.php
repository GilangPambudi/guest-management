<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Couple;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Invitation';

        $breadcrumb = (object)[
            'title' => 'List of Invitations',
            'list' => ['Home', 'Invitations']
        ];

        $page = (object)[
            'title' => 'List of Invitations'
        ];

        $activeMenu = 'invitation';

        return view('invitation.index', ['title' => $title, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $invitation = Invitation::select('invitation_id', 'guest_id', 'wedding_name', 'groom_id', 'bride_id', 'wedding_date', 'wedding_time_start', 'wedding_time_end', 'location', 'status', 'opened_at');
        return DataTables::of($invitation)
            ->addIndexColumn() // Tambahkan nomor urut
            ->addColumn('action', function ($invitation) {
                $btn = '<button onclick="modalAction(\'' . url('/invitation/' . $invitation->invitation_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $invitation->invitation_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $invitation->invitation_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $grooms = Couple::where('couple_gender', 'Male')->get();
        $brides = Couple::where('couple_gender', 'Female')->get();
        $guests = Guest::all();
        return view('invitation.create_ajax', compact('grooms', 'brides', 'guests'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guest_id' => 'required|exists:guests,guest_id',
            'wedding_name' => 'required',
            'groom_id' => 'required|exists:couple,couple_id',
            'bride_id' => 'required|exists:couple,couple_id',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required|date_format:H:i',
            'wedding_time_end' => 'required|date_format:H:i',
            'location' => 'required',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Invitation::create($request->all());

        return response()->json(['success' => 'Invitation created successfully.']);
    }
}
