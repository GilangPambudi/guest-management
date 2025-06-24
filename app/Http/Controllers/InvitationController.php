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
            'slug',
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
                $btn = '<a href="' . url('/invitation/' . $event->invitation_id) . '/show' . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a> ';
                $btn .= '<a href="' . url('/invitation/' . $event->invitation_id . '/guests') . '" class="btn btn-success btn-sm"><i class="fas fa-users"></i> Manage Guests</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $event->invitation_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i> Edit</button> ';

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
            'slug' => 'nullable|string|max:255|unique:invitation,slug',
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

    public function show($id)
    {
        $invitation = Invitation::with(['guests' => function ($query) {
            $query->orderBy('guest_name');
        }])->find($id);

        if (!$invitation) {
            return redirect()->route('invitation.index')->with('error', 'Invitation not found');
        }

        // Format times for display
        $invitation->wedding_time_start = Carbon::parse($invitation->wedding_time_start)->format('H:i');
        $invitation->wedding_time_end = Carbon::parse($invitation->wedding_time_end)->format('H:i');

        $title = 'Invitation Details';
        $breadcrumb = (object)[
            'title' => 'Invitation Details',
            'list' => ['Home', 'Invitations', $invitation->wedding_name]
        ];

        $page = (object)[
            'title' => 'Invitation Details - ' . $invitation->wedding_name
        ];

        $activeMenu = 'invitation';

        // Get statistics
        $totalGuests = $invitation->guests->count();
        $attendedGuests = $invitation->guests->where('guest_attendance_status', 'Yes')->count();
        $pendingGuests = $invitation->guests->where('guest_attendance_status', 'Pending')->count();
        $notAttendedGuests = $invitation->guests->where('guest_attendance_status', 'No')->count();

        // Get guest categories
        $guestCategories = $invitation->guests->groupBy('guest_category')->map->count();

        return view('invitation.show', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitation' => $invitation,
            'totalGuests' => $totalGuests,
            'attendedGuests' => $attendedGuests,
            'pendingGuests' => $pendingGuests,
            'notAttendedGuests' => $notAttendedGuests,
            'guestCategories' => $guestCategories
        ]);
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
            'slug' => 'nullable|string|max:255|unique:invitation,slug,' . $id . ',invitation_id',
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
            // Cek apakah invitation memiliki guests
            $guestCount = $invitation->guests()->count();

            if ($guestCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete invitation. This invitation has {$guestCount} guest(s). Please delete all guests first."
                ], 422);
            }

            // Hapus file gambar jika ada
            if ($invitation->wedding_image && file_exists(public_path($invitation->wedding_image))) {
                unlink(public_path($invitation->wedding_image));
            }

            $invitation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Invitation deleted successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invitation not found.'
        ], 404);
    }
}
