<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvitationController extends Controller
{
    /**
     * Check if the current user has access to the specified invitation
     * Returns invitation object if accessible, aborts with 403/404 if not
     */
    private function checkInvitationAccess($invitation_id)
    {
        $invitation = Invitation::find($invitation_id);
        
        if (!$invitation) {
            abort(404, 'Invitation not found');
        }
        
        // If user is admin, allow access to all invitations
        if (Auth::user()->role === 'admin') {
            return $invitation;
        }
        
        // If invitation has no owner, only admin can access it
        if ($invitation->user_id === null) {
            abort(403, 'This invitation has not been assigned to any user yet');
        }
        
        // If user is regular user, only allow access to their own invitation
        if (Auth::user()->role === 'user') {
            if ($invitation->user_id !== Auth::id()) {
                abort(403, 'You do not have permission to access this invitation');
            }
        }
        
        return $invitation;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // User-specific invitation flow
        if (Auth::user()->role === 'user') {
            // Check if user already has an invitation
            $userInvitation = Invitation::where('user_id', Auth::id())->first();
            
            if ($userInvitation) {
                // User has invitation, redirect to show page
                return redirect()->route('invitation.show', $userInvitation->invitation_id);
            } else {
                // User doesn't have invitation, redirect to create page
                return redirect()->route('invitation.create');
            }
        }

        // Admin flow - show index page with all invitations
        $title = 'Invitation';

        $breadcrumb = (object)[
            'title' => 'List of Invitations',
            'list' => ['Home', 'Invitations']
        ];

        $page = (object)[
            'title' => 'List of Invitations'
        ];

        $activeMenu = 'invitation';

        // Admin bisa lihat semua invitation
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
        // Role-based filtering query
        if (Auth::user()->role === 'admin') {
            // Admin bisa lihat semua invitation dengan info user
            $invitation = Invitation::with('user:user_id,name')
                ->select(
                    'invitation_id',
                    'user_id',
                    'wedding_name',
                    'slug',
                    'wedding_date',
                    'wedding_time_start',
                    'wedding_time_end',
                    'wedding_venue',
                    'wedding_location',
                    'wedding_maps',
                );
        } else {
            // User hanya bisa lihat invitation milik sendiri
            $invitation = Invitation::where('user_id', Auth::id())
                ->select(
                    'invitation_id',
                    'user_id',
                    'wedding_name',
                    'slug',
                    'wedding_date',
                    'wedding_time_start',
                    'wedding_time_end',
                    'wedding_venue',
                    'wedding_location',
                    'wedding_maps',
                );
        }

        return DataTables::of($invitation)
            ->addIndexColumn()
            ->addColumn('owner_info', function ($event) {
                if ($event->user) {
                    return '<span class="badge badge-success">' . $event->user->name . '</span>';
                } else {
                    return '<span class="badge badge-warning">Unassigned</span>';
                }
            })
            ->addColumn('action', function ($event) {
                $btn = '<a href="' . url('/invitation/' . $event->invitation_id) . '/show' . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $event->invitation_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit </button> ';
                $btn .= '<a href="' . url('/invitation/' . $event->invitation_id . '/guests') . '" class="btn btn-success btn-sm"><i class="fas fa-users"></i> Manage Guests</a> ';
                $btn .= '<a href="' . url($event->slug . '/preview') . '" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-external-link"></i> Preview</a> ';

                return $btn;
            })
            ->rawColumns(['action', 'owner_info'])
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

        // Set user_id based on role
        if (Auth::user()->role === 'admin') {
            // Admin can create invitation without owner (can be assigned later)
            $data['user_id'] = null;
        } else {
            // Regular user creates invitation for themselves
            $data['user_id'] = Auth::id();
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

        // Set user_id based on role
        if (Auth::user()->role === 'admin') {
            // Admin can create invitation without owner (can be assigned later)
            $data['user_id'] = null;
        } else {
            // Regular user creates invitation for themselves
            $data['user_id'] = Auth::id();
        }

        $invitation = Invitation::create($data);

        // Role-based redirect
        if (Auth::user()->role === 'admin') {
            return redirect()->route('invitation.index')
                ->with('success', 'Invitation created successfully.');
        } else {
            // User langsung diarahkan ke invitation mereka
            return redirect()->route('invitation.show', $invitation->invitation_id)
                ->with('success', 'Invitation created successfully.');
        }
    }

    public function show($id)
    {
        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

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
        $notSentGuests = $invitation->guests->where('guest_invitation_status', '-')->count();
        $sentGuests = $invitation->guests->where('guest_invitation_status', 'Sent')->count();

        $unconfirmedGuests = $invitation->guests
            ->where('guest_invitation_status', 'Opened')
            ->where('guest_attendance_status', '-')
            ->count();

        $attendedGuests = $invitation->guests->where('guest_attendance_status', 'Yes')->count();
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
            'notAttendedGuests' => $notAttendedGuests,
            'unconfirmedGuests' => $unconfirmedGuests,
            'guestCategories' => $guestCategories,
            'notSentGuests' => $notSentGuests,
            'sentGuests' => $sentGuests
        ]);
    }

    public function show_ajax($id)
    {
        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

        if ($invitation) {
            $invitation->wedding_time_start = Carbon::parse($invitation->wedding_time_start)->format('H:i');
            $invitation->wedding_time_end = Carbon::parse($invitation->wedding_time_end)->format('H:i');
        }
        return view('invitation.show_ajax', ['invitation' => $invitation]);
    }

    public function edit_ajax($id)
    {
        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

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
        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

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

        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

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

        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

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
        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

        return view('invitation.confirm_ajax')->with('invitation', $invitation);
    }

    public function delete_ajax($id)
    {
        // Check invitation access permission
        $invitation = $this->checkInvitationAccess($id);

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

    /**
     * Check slug availability for real-time validation
     */
    public function checkSlugAvailability(Request $request)
    {
        $slug = $request->input('slug');
        
        if (empty($slug)) {
            return response()->json([
                'available' => false,
                'message' => 'Slug cannot be empty'
            ]);
        }

        // Check if slug already exists
        $exists = Invitation::where('slug', $slug)->exists();
        
        if ($exists) {
            // Generate suggestions
            $suggestions = [];
            for ($i = 1; $i <= 3; $i++) {
                $suggestionSlug = $slug . '-' . $i;
                if (!Invitation::where('slug', $suggestionSlug)->exists()) {
                    $suggestions[] = $suggestionSlug;
                }
            }
            
            return response()->json([
                'available' => false,
                'message' => 'Slug already taken',
                'suggestions' => $suggestions
            ]);
        }
        
        return response()->json([
            'available' => true,
            'message' => 'Slug is available'
        ]);
    }
}
