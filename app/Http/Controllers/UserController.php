<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $users = User::select(
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
            ->rawColumns(['action', 'role_badge'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('users.create_ajax');
    }

    public function store_ajax(Request $request)
    {
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('users.show_ajax', compact('user'));
    }

    public function edit_ajax($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('users.edit_ajax', compact('user'));
    }

    public function update_ajax(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
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

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully'
        ]);
    }

    public function confirm_ajax($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('users.confirm_ajax', compact('user'));
    }

    public function delete_ajax($id)
    {
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
