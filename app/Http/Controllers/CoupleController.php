<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class CoupleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Couple';

        $breadcrumb = (object)[
            'title' => 'List of Couple',
            'list' => ['Home', 'Couple']
        ];

        $page = (object)[
            'title' => 'List of couple'
        ];

        $activeMenu = 'couple';

        return view('couple.index', [ 'title' => $title, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $couple = Couple::select('couple_id', 'couple_name', 'couple_gender', 'couple_alias', 'is_groom', 'is_bride');
        return DataTables::of($couple)
            ->addIndexColumn() // Tambahkan nomor urut
            ->addColumn('action', function ($couple) {
                // $btn = '<button onclick="modalAction(\'' . url('/couple/' . $couple->couple_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<button onclick="modalAction(\'' . url('/couple/' . $couple->couple_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/couple/' . $couple->couple_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('couple.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'couple_name' => 'required',
            'couple_alias' => 'required',
            'couple_gender' => 'required|in:Male,Female',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Couple::create($request->all());

        return response()->json(['success' => 'Couple created successfully.']);
    }

    public function show_ajax($id)
    {
        $couple = Couple::find($id);
        return view('couple.show_ajax', ['couple' => $couple]);
    }

    public function edit_ajax($id)
    {
        $couple = Couple::find($id);
        return view('couple.edit_ajax', ['couple' => $couple]);
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'couple_name' => 'required',
            'couple_alias' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Couple::find($id)->update($request->all());

        return response()->json(['success' => 'Couple updated successfully.']);
    }

    public function confirm_ajax($id)
    {
        $couple = Couple::find($id);
        return view('couple.confirm_ajax')->with('couple', $couple);
    }

    public function delete_ajax($id)
    {
        if (request()->ajax()) {
            $couple = Couple::find($id);
            if ($couple) {
                $couple->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Data successfully deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid request'
        ]);
    }
}
