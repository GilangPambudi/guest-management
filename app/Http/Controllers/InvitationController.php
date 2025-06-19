<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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

        // Ambil semua data invitation dengan relasi guests untuk counting
        $invitations = Invitation::withCount('guests')->get();

        return view('invitation.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitations' => $invitations
        ]);
    }

    public function list(Request $request)
    {
        $invitation = Invitation::select(
            'invitation_id',
            'wedding_name',
            'wedding_date',
            'wedding_time_start',
            'wedding_time_end',
            'wedding_venue',
            'wedding_location',
            'wedding_maps',
        );

        return DataTables::of($invitation)
            ->addIndexColumn()
            ->addColumn('action', function ($event) {
                $btn = '<button onclick="modalAction(\'' . url('/invitation/' . $event->invitation_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">View</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $event->invitation_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $event->invitation_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';
                $btn .= '<a href="' . url('/invitation/' . $event->invitation_id . '/guests') . '" class="btn btn-success btn-sm">Manage Guests</a> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $guests = Guest::all();
        return view('invitation.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wedding_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_alias' => 'nullable|string|max:50',
            'bride_alias' => 'nullable|string|max:50',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required|date_format:H:i',
            'wedding_time_end' => 'required|date_format:H:i|after:wedding_time_start',
            'wedding_venue' => 'required|string|max:255',
            'wedding_location' => 'required|string|max:255',
            'wedding_maps' => 'nullable|url',
            'wedding_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle file upload for wedding_image
        if ($request->hasFile('wedding_image')) {
            $file = $request->file('wedding_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/wedding_images'), $filename);
            $data['wedding_image'] = 'uploads/wedding_images/' . $filename;
        }

        Invitation::create($data);

        return response()->json(['success' => 'Invitation created successfully.']);
    }

    public function show_ajax($id)
    {
        $invitation = Invitation::find($id);
        if ($invitation) {
            $invitation->wedding_time_start = Carbon::parse($invitation->wedding_time_start)->format('H:i');
            $invitation->wedding_time_end = Carbon::parse($invitation->wedding_time_end)->format('H:i');
        }
        return view('invitation.show_ajax', ['invitation' => $invitation]);
    }

    public function edit_ajax($id)
    {
        $invitation = Invitation::find($id);

        // Format waktu menjadi hh:mm
        if ($invitation) {
            $invitation->wedding_time_start = Carbon::parse($invitation->wedding_time_start)->format('H:i');
            $invitation->wedding_time_end = Carbon::parse($invitation->wedding_time_end)->format('H:i');
        }

        return view('invitation.edit_ajax', ['invitation' => $invitation]);
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'wedding_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required|date_format:H:i',
            'wedding_time_end' => 'required|date_format:H:i|after:wedding_time_start',
            'wedding_venue' => 'required|string|max:255',
            'wedding_location' => 'required|string|max:255',
            'wedding_maps' => 'nullable|url',
            'wedding_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invitation = Invitation::find($id);
        $data = $request->all();

        // Handle file upload for wedding_image
        if ($request->hasFile('wedding_image')) {
            // Hapus gambar lama jika ada
            if ($invitation->wedding_image && file_exists(public_path($invitation->wedding_image))) {
                unlink(public_path($invitation->wedding_image));
            }

            // Simpan gambar baru
            $file = $request->file('wedding_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/wedding_images'), $filename);
            $data['wedding_image'] = 'uploads/wedding_images/' . $filename;
        }

        $invitation->update($data);

        return response()->json(['success' => 'Invitation updated successfully.']);
    }

    public function confirm_ajax($id)
    {
        $invitation = Invitation::find($id);
        return view('invitation.confirm_ajax')->with('invitation', $invitation);
    }

    public function delete_ajax($id)
    {
        $invitation = Invitation::find($id);

        if ($invitation) {
            // Hapus file gambar jika ada
            if ($invitation->wedding_image && file_exists(public_path($invitation->wedding_image))) {
                unlink(public_path($invitation->wedding_image));
            }

            $invitation->delete();
        }

        return response()->json(['success' => 'Invitation deleted successfully.']);
    }
}
