<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Guest;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'List of Guest',
            'list' => ['Home', 'Guests']
        ];

        $page = (object)[
            'title' => 'List of Guests'
        ];

        $activeMenu = 'guests';

        return view('guests.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $guest = Guest::select('guest_id', 'guest_name', 'guest_id_qr_code', 'guest_gender', 'guest_category', 'guest_contact', 'guest_address', 'guest_qr_code', 'guest_attendance_status', 'guest_invitation_status');
        return DataTables::of($guest)
            ->addIndexColumn() // Tambahkan nomor urut
            ->addColumn('action', function ($guest) {
                $btn = '<button onclick="modalAction(\'' . url('/guests/' . $guest->guest_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/guests/' . $guest->guest_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/guests/' . $guest->guest_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('guests.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guest_name' => 'required',
            'guest_id_qr_code' => 'required',
            'guest_gender' => 'required|in:Male,Female',
            'guest_category' => 'required',
            'guest_contact' => 'required|unique:guests,guest_contact',
            'guest_address' => 'required',
            'guest_qr_code' => 'required',
            'guest_attendance_status' => 'required',
            'guest_invitation_status' => 'required',
            'user_id' => 'required|exists:users,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Guest::create($request->all());

        return response()->json(['success' => 'Guest created successfully.']);
    }

    // Mengecek apakah nomor sudah terdaftar atau belum
    public function check_contact(Request $request)
    {
        $guest_contact = $request->input('guest_contact');
        $exists = Guest::where('guest_contact', $guest_contact)->exists();
        return response()->json(!$exists);
    }

    public function show_ajax($id)
    {
        $guest = Guest::find($id);

        return view('guests.show_ajax')->with('guest', $guest);
    }

    public function edit_ajax($id)
    {
        $guest = Guest::find($id);
        return view('guests.edit_ajax', ['guest' => $guest]);
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'guest_name' => 'required',
            'guest_id_qr_code' => 'required',
            'guest_gender' => 'required|in:Male,Female',
            'guest_category' => 'required',
            'guest_contact' => 'required',
            'guest_address' => 'required',
            'guest_qr_code' => 'required',
            'guest_attendance_status' => 'required',
            'guest_invitation_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Guest::find($id)->update($request->all());

        return response()->json(['success' => 'Guest updated successfully.']);
    }

    public function confirm_ajax($id)
    {
        $guest = Guest::find($id);
        return view('guests.confirm_ajax')->with('guest', $guest);
    }

    public function delete_ajax($id)
    {
        if (request()->ajax()) {
            $guest = Guest::find($id);
            if ($guest) {
                $guest->delete();
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

    public function import()
    {
        return view('guests.import');
    }

    public function import_process(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_guests' => ['required', 'mimes:xlsx']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_guests');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $row => $value) {
                    if ($row > 1) {
                        $insert[] = [
                            'guest_name' => $value['A'],
                            'guest_id_qr_code' => $value['B'],
                            'guest_gender' => $value['C'],
                            'guest_category' => $value['D'],
                            'guest_contact' => $value['E'],
                            'guest_address' => $value['F'],
                            'guest_qr_code' => $value['G'],
                            'guest_attendance_status' => $value['H'],
                            'guest_invitation_status' => $value['I'],
                            'user_id' => Auth::user()->user_id,
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    Guest::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport',
                        'refresh' => true // Add this line to indicate that the datatable should be refreshed
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang diimport'
                    ]);
                }
            }
        }
        return redirect('/');
    }
}
