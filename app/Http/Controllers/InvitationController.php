<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $event->invitation_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm ml-1"><i class="fas fa-edit"></i> Edit </button> ';

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

    /**
     * Show create form page (not modal)
     */
    public function create()
    {
        $title = 'Create Invitation';
        $breadcrumb = (object)[
            'title' => 'Create New Invitation',
            'list' => ['Home', 'Invitations', 'Create']
        ];
        $page = (object)[
            'title' => 'Create New Invitation'
        ];
        $activeMenu = 'invitation';

        return view('invitation.create', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wedding_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:invitation,slug',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_alias' => 'required|string|max:50',
            'bride_alias' => 'required|string|max:50',
            'groom_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bride_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'groom_child_number' => 'required|integer|min:1',
            'bride_child_number' => 'required|integer|min:1',
            'groom_father' => 'required|string|max:255',
            'groom_mother' => 'required|string|max:255',
            'bride_father' => 'required|string|max:255',
            'bride_mother' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required|date_format:H:i',
            'wedding_time_end' => 'required|date_format:H:i|after:wedding_time_start',
            'wedding_venue' => 'required|string|max:255',
            'wedding_location' => 'required|string|max:255',
            'wedding_maps' => 'required|url',
            'wedding_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle file upload for groom_image
        if ($request->hasFile('groom_image')) {
            $file = $request->file('groom_image');
            $filename = time() . '_groom_' . $file->getClientOriginalName();
            $destinationPath = public_path('invitations/groom-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['groom_image'] = 'invitations/groom-image/' . $filename;
        }

        // Handle file upload for bride_image
        if ($request->hasFile('bride_image')) {
            $file = $request->file('bride_image');
            $filename = time() . '_bride_' . $file->getClientOriginalName();
            $destinationPath = public_path('invitations/bride-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['bride_image'] = 'invitations/bride-image/' . $filename;
        }

        // Handle file upload for wedding_image
        if ($request->hasFile('wedding_image')) {
            $file = $request->file('wedding_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('invitations/wedding-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['wedding_image'] = 'invitations/wedding-image/' . $filename;
        }

        Invitation::create($data);

        return response()->json(['success' => 'Invitation created successfully.']);
    }

    /**
     * Store invitation (for page, not modal)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wedding_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:invitation,slug',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_alias' => 'required|string|max:50',
            'bride_alias' => 'required|string|max:50',
            'groom_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bride_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'groom_child_number' => 'required|integer|min:1',
            'bride_child_number' => 'required|integer|min:1',
            'groom_father' => 'required|string|max:255',
            'groom_mother' => 'required|string|max:255',
            'bride_father' => 'required|string|max:255',
            'bride_mother' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required|date_format:H:i',
            'wedding_time_end' => 'required|date_format:H:i|after:wedding_time_start',
            'wedding_venue' => 'required|string|max:255',
            'wedding_location' => 'required|string|max:255',
            'wedding_maps' => 'nullable|url',
            'wedding_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Handle file upload for groom_image
        if ($request->hasFile('groom_image')) {
            $file = $request->file('groom_image');
            $filename = time() . '_groom_' . $file->getClientOriginalName();
            $destinationPath = public_path('invitations/groom-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['groom_image'] = 'invitations/groom-image/' . $filename;
        }

        // Handle file upload for bride_image
        if ($request->hasFile('bride_image')) {
            $file = $request->file('bride_image');
            $filename = time() . '_bride_' . $file->getClientOriginalName();
            $destinationPath = public_path('invitations/bride-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['bride_image'] = 'invitations/bride-image/' . $filename;
        }

        // Handle file upload for wedding_image
        if ($request->hasFile('wedding_image')) {
            $file = $request->file('wedding_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('invitations/wedding-image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['wedding_image'] = 'invitations/wedding-image/' . $filename;
        }

        Invitation::create($data);

        return redirect()->route('invitation.index')
            ->with('success', 'Invitation created successfully.');
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

    /**
     * Show edit form page (not modal)
     */
    public function edit($id)
    {
        $invitation = Invitation::find($id);

        if (!$invitation) {
            return redirect()->route('invitation.index')
                ->with('error', 'Invitation not found');
        }

        // Format waktu menjadi hh:mm
        $invitation->wedding_time_start = Carbon::parse($invitation->wedding_time_start)->format('H:i');
        $invitation->wedding_time_end = Carbon::parse($invitation->wedding_time_end)->format('H:i');

        $title = 'Edit Invitation';
        $breadcrumb = (object)[
            'title' => 'Edit Invitation',
            'list' => ['Home', 'Invitations', $invitation->wedding_name, 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Invitation - ' . $invitation->wedding_name
        ];
        $activeMenu = 'invitation';

        return view('invitation.edit', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitation' => $invitation
        ]);
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'wedding_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:invitation,slug,' . $id . ',invitation_id',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_alias' => 'required|string|max:50',
            'bride_alias' => 'required|string|max:50',
            'groom_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bride_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'groom_child_number' => 'required|integer|min:1',
            'bride_child_number' => 'required|integer|min:1',
            'groom_father' => 'required|string|max:255',
            'groom_mother' => 'required|string|max:255',
            'bride_father' => 'required|string|max:255',
            'bride_mother' => 'required|string|max:255',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required|date_format:H:i',
            'wedding_time_end' => 'required|date_format:H:i|after:wedding_time_start',
            'wedding_venue' => 'required|string|max:255',
            'wedding_location' => 'required|string|max:255',
            'wedding_maps' => 'nullable|url',
            'wedding_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $invitation = Invitation::find($id);
        if (!$invitation) {
            return response()->json([
                'success' => false,
                'message' => 'Invitation not found'
            ], 404);
        }

        try {
            $data = $request->all();

            // Handle file upload for groom_image
            if ($request->hasFile('groom_image')) {
                // Delete old image if exists
                if ($invitation->groom_image && file_exists(public_path($invitation->groom_image))) {
                    unlink(public_path($invitation->groom_image));
                }

                $file = $request->file('groom_image');
                $filename = time() . '_groom_' . $file->getClientOriginalName();
                $destinationPath = public_path('invitations/groom-image');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $filename);
                $data['groom_image'] = 'invitations/groom-image/' . $filename;
            }

            // Handle file upload for bride_image
            if ($request->hasFile('bride_image')) {
                // Delete old image if exists
                if ($invitation->bride_image && file_exists(public_path($invitation->bride_image))) {
                    unlink(public_path($invitation->bride_image));
                }

                $file = $request->file('bride_image');
                $filename = time() . '_bride_' . $file->getClientOriginalName();
                $destinationPath = public_path('invitations/bride-image');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $filename);
                $data['bride_image'] = 'invitations/bride-image/' . $filename;
            }

            // Handle file upload for wedding_image
            if ($request->hasFile('wedding_image')) {
                // Delete old image if exists
                if ($invitation->wedding_image && file_exists(public_path($invitation->wedding_image))) {
                    unlink(public_path($invitation->wedding_image));
                }

                $file = $request->file('wedding_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('invitations/wedding-image');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $filename);
                $data['wedding_image'] = 'invitations/wedding-image/' . $filename;
            }

            $invitation->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Invitation updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update invitation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update invitation (page-based)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'wedding_name' => 'required|max:100',
            'groom_name' => 'required|max:100',
            'bride_name' => 'required|max:100',
            'wedding_date' => 'required|date',
            'wedding_time_start' => 'required',
            'wedding_time_end' => 'required',
            'location' => 'required|max:255',
            'maps_url' => 'required|max:500',
            'message' => 'required|max:1000',
            'gallery.*' => 'image|mimes:jpeg,png,jpg|max:10240',
            'wedding_image' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'groom_image' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'bride_image' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'groom_child_number' => 'nullable|integer|min:1',
            'bride_child_number' => 'nullable|integer|min:1',
            'groom_father' => 'nullable|max:100',
            'groom_mother' => 'nullable|max:100',
            'bride_father' => 'nullable|max:100',
            'bride_mother' => 'nullable|max:100',
        ]);

        $invitation = Invitation::find($id);
        if (!$invitation) {
            return redirect()->route('invitation.index')
                ->with('error', 'Invitation not found');
        }

        try {
            $data = $request->all();

            // Handle main wedding image upload
            if ($request->hasFile('wedding_image')) {
                // Delete old image if exists
                if ($invitation->wedding_image && Storage::disk('public')->exists($invitation->wedding_image)) {
                    Storage::disk('public')->delete($invitation->wedding_image);
                }

                $image = $request->file('wedding_image');
                $fileName = time() . '_wedding_' . $image->getClientOriginalName();
                $path = $image->storeAs('invitations', $fileName, 'public');
                $data['wedding_image'] = $path;
            }

            // Handle groom image upload
            if ($request->hasFile('groom_image')) {
                // Delete old image if exists
                if ($invitation->groom_image && Storage::disk('public')->exists($invitation->groom_image)) {
                    Storage::disk('public')->delete($invitation->groom_image);
                }

                $image = $request->file('groom_image');
                $fileName = time() . '_groom_' . $image->getClientOriginalName();
                $path = $image->storeAs('invitations', $fileName, 'public');
                $data['groom_image'] = $path;
            }

            // Handle bride image upload
            if ($request->hasFile('bride_image')) {
                // Delete old image if exists
                if ($invitation->bride_image && Storage::disk('public')->exists($invitation->bride_image)) {
                    Storage::disk('public')->delete($invitation->bride_image);
                }

                $image = $request->file('bride_image');
                $fileName = time() . '_bride_' . $image->getClientOriginalName();
                $path = $image->storeAs('invitations', $fileName, 'public');
                $data['bride_image'] = $path;
            }

            // Generate slug and alias if wedding name changed
            if ($request->wedding_name !== $invitation->wedding_name) {
                $data['slug'] = Str::slug($request->wedding_name);
                $data['alias'] = Str::slug($request->wedding_name);
            }

            // Format wedding times
            $data['wedding_time_start'] = Carbon::createFromFormat('H:i', $request->wedding_time_start)->format('H:i:s');
            $data['wedding_time_end'] = Carbon::createFromFormat('H:i', $request->wedding_time_end)->format('H:i:s');

            $invitation->update($data);

            return redirect()->route('invitation.index')
                ->with('success', 'Invitation updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update invitation: ' . $e->getMessage());
        }
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
            if ($invitation->groom_image && file_exists(public_path($invitation->groom_image))) {
                unlink(public_path($invitation->groom_image));
            }
            if ($invitation->bride_image && file_exists(public_path($invitation->bride_image))) {
                unlink(public_path($invitation->bride_image));
            }
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
