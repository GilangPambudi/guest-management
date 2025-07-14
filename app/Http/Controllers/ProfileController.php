<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitation;
use App\Models\Guest;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $title = 'My Profile';

        $breadcrumb = (object)[
            'title' => 'User Profile',
            'list' => ['Home', 'Profile']
        ];

        $page = (object)[
            'title' => 'My Profile'
        ];

        $activeMenu = 'profile';
        $user = Auth::user();

        // Get user statistics
        $stats = [
            'total_invitations' => Invitation::count(),
            'total_guests' => Guest::count(),
            'recent_invitations' => Invitation::latest()->limit(5)->get(),
        ];

        return view('profile.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user,
            'stats' => $stats
        ]);
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit_ajax', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully'
        ]);
    }

    /**
     * Show the form for changing password.
     */
    public function editPassword()
    {
        return view('profile.change_password_ajax');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::find(Auth::id());

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'errors' => ['current_password' => ['Current password is incorrect']]
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
