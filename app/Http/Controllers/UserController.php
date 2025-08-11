<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Check if the current user has admin access
     */
    private function checkAdminAccess()
    {
        if (!Auth::check()) {
            abort(404, 'Page not found');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAdminAccess();
        
        $title = 'User Management';

        $breadcrumb = (object)[
            'title' => 'List of Users',
            'list' => ['Home', 'Users']
        ];

        $page = (object)[
            'title' => 'List of Users'
        ];

        $activeMenu = 'users';

        return view('users.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $this->checkAdminAccess();
        $users = User::with('invitation:invitation_id,user_id,wedding_name')
            ->select(
                'user_id',
                'name',
                'email',
                'role',
                'created_at',
                'updated_at'
            );

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/users/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/users/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i> Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/users/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button> ';

                return $btn;
            })
            ->addColumn('invitation_info', function ($user) {
                if ($user->invitation) {
                    return '<span class="badge badge-success">' . $user->invitation->wedding_name . '</span>';
                } else {
                    return '<span class="badge badge-secondary">No Invitation</span>';
                }
            })
            ->addColumn('created_at_formatted', function ($user) {
                return $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-';
            })
            ->addColumn('role_badge', function ($user) {
                if ($user->role === 'admin') {
                    return '<span class="badge badge-success">Admin</span>';
                } else {
                    return '<span class="badge badge-secondary">User</span>';
                }
            })
            ->rawColumns(['action', 'role_badge', 'invitation_info'])
            ->make(true);
    }

    public function create_ajax()
    {
        $this->checkAdminAccess();
        
        return view('users.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $this->checkAdminAccess();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ]);
    }

    public function show_ajax($id)
    {
        $this->checkAdminAccess();
        
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('users.show_ajax', compact('user'));
    }

    public function edit_ajax($id)
    {
        $this->checkAdminAccess();
        
        $user = User::with('invitation')->find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get unassigned invitations (user_id is null) 
        $unassignedInvitations = \App\Models\Invitation::whereNull('user_id')
            ->select('invitation_id', 'wedding_name')
            ->get();

        return view('users.edit_ajax', compact('user', 'unassignedInvitations'));
    }

    public function update_ajax(Request $request, $id)
    {
        $this->checkAdminAccess();
        
        $user = User::with('invitation')->find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'invitation_id' => 'nullable|exists:invitation,invitation_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Handle invitation assignment
        $currentInvitationId = $user->invitation ? $user->invitation->invitation_id : null;
        $newInvitationId = $request->invitation_id;

        // If invitation changed
        if ($currentInvitationId != $newInvitationId) {
            // Unassign current invitation if exists
            if ($currentInvitationId) {
                \App\Models\Invitation::where('invitation_id', $currentInvitationId)
                    ->update(['user_id' => null]);
            }

            // Assign new invitation if selected
            if ($newInvitationId) {
                // Check if invitation is still available
                $invitation = \App\Models\Invitation::where('invitation_id', $newInvitationId)
                    ->whereNull('user_id')
                    ->first();

                if (!$invitation) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Selected invitation is no longer available for assignment'
                    ], 422);
                }

                $invitation->update(['user_id' => $user->user_id]);
            }
        }

        // Remove invitation_id from user data as it's not a user field
        unset($data['invitation_id']);
        
        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully'
        ]);
    }

    public function confirm_ajax($id)
    {
        $this->checkAdminAccess();
        
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('users.confirm_ajax', compact('user'));
    }

    public function delete_ajax($id)
    {
        $this->checkAdminAccess();
        
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
