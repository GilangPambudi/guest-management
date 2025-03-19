<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Guests';

        $breadcrumb = (object)[
            'title' => 'List of Guest',
            'list' => ['Home', 'Guests']
        ];

        $page = (object)[
            'title' => 'List of Guests'
        ];

        $activeMenu = 'guests';

        // Ambil data filter dari database
        $categories = Guest::select('guest_category')->distinct()->pluck('guest_category');
        $genders = Guest::select('guest_gender')->distinct()->pluck('guest_gender');
        $attendanceStatuses = Guest::select('guest_attendance_status')->distinct()->pluck('guest_attendance_status');
        $invitationStatuses = Guest::select('guest_invitation_status')->distinct()->pluck('guest_invitation_status');

        return view('guests.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'categories' => $categories,
            'genders' => $genders,
            'attendanceStatuses' => $attendanceStatuses,
            'invitationStatuses' => $invitationStatuses
        ]);
    }

    public function list(Request $request)
    {
        $guest = Guest::select('guest_id', 'guest_name', 'guest_id_qr_code', 'guest_gender', 'guest_category', 'guest_contact', 'guest_address', 'guest_qr_code', 'guest_attendance_status', 'guest_invitation_status');

        if ($request->category) {
            $guest->where('guest_category', $request->category);
        }

        if ($request->gender) {
            $guest->where('guest_gender', $request->gender);
        }

        if ($request->attendance_status) {
            $guest->where('guest_attendance_status', $request->attendance_status);
        }

        if ($request->invitation_status) {
            $guest->where('guest_invitation_status', $request->invitation_status);
        }

        return DataTables::of($guest)
            ->addIndexColumn()
            ->addColumn('action', function ($guest) {
                $btn = '<button onclick="copyToClipboard(\'' . $guest->guest_id_qr_code . '\')" class="btn btn-success btn-sm">Copy ID</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/guests/' . $guest->guest_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
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
            'guest_attendance_status' => 'required',
            'guest_invitation_status' => 'required',
            'user_id' => 'required|exists:users,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Generate QR Code
        $guestIdQrCode = $request->input('guest_id_qr_code');
        $qrCodePath = 'qr/guests/' . $guestIdQrCode . '.png';

        // Gunakan library QR Code untuk menghasilkan QR Code dalam bentuk string
        $qrCodeContent = QrCode::format('png')->size(300)->generate($guestIdQrCode);

        // Simpan QR Code ke storage menggunakan Storage facade
        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

        // Simpan path QR Code ke database
        $request->merge(['guest_qr_code' => 'storage/' . $qrCodePath]);

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
            'guest_gender' => 'required|in:Male,Female',
            'guest_category' => 'required',
            'guest_contact' => 'required|unique:guests,guest_contact,' . $id . ',guest_id',
            'guest_address' => 'required',
            'guest_attendance_status' => 'required',
            'guest_invitation_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['error' => 'Guest not found.'], 404);
        }

        // Periksa apakah guest_name diubah
        if ($guest->guest_name !== $request->input('guest_name')) {
            // Hapus QR Code lama jika ada
            if ($guest->guest_qr_code && Storage::disk('public')->exists(str_replace('storage/', '', $guest->guest_qr_code))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $guest->guest_qr_code));
            }

            // Generate guest_id_qr_code baru berdasarkan nama baru
            $timestamp = now()->timestamp;
            $guestNameSlug = str_replace(' ', '-', strtolower($request->input('guest_name')));
            $guestIdQrCode = $timestamp . '-' . $guestNameSlug;

            // Generate QR Code baru
            $qrCodePath = 'qr/guests/' . $guestIdQrCode . '.png';
            $qrCodeContent = QrCode::format('png')->size(300)->generate($guestIdQrCode);
            Storage::disk('public')->put($qrCodePath, $qrCodeContent);

            // Simpan guest_id_qr_code dan path QR Code baru ke request
            $request->merge([
                'guest_id_qr_code' => $guestIdQrCode,
                'guest_qr_code' => 'storage/' . $qrCodePath,
            ]);
        }

        // Perbarui data tamu
        $guest->update($request->all());

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
                // Hapus file QR Code dari storage jika ada
                if ($guest->guest_qr_code && Storage::disk('public')->exists(str_replace('storage/', '', $guest->guest_qr_code))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $guest->guest_qr_code));
                }

                // Hapus data tamu dari database
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
                    'message' => 'Validation Failed',
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
                        $timestamp = now()->timestamp;
                        $guestName = str_replace(' ', '-', strtolower($value['A']));
                        $guest_id_qr_code = $timestamp . '-' . $guestName;

                        // Generate QR Code
                        $qrCodePath = 'qr/guests/' . $guest_id_qr_code . '.png';
                        $qrCodeContent = QrCode::format('png')->size(300)->generate($guest_id_qr_code);
                        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

                        $insert[] = [
                            'guest_name' => $value['A'],
                            'guest_id_qr_code' => $guest_id_qr_code,
                            'guest_gender' => $value['B'],
                            'guest_category' => $value['C'],
                            'guest_contact' => $value['D'],
                            'guest_address' => $value['E'],
                            'guest_qr_code' => 'storage/' . $qrCodePath,
                            'guest_attendance_status' => '-',
                            'guest_invitation_status' => '-',
                            'user_id' => Auth::user()->user_id,
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    Guest::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data successfully imported',
                        'refresh' => true // Add this line to indicate that the datatable should be refreshed
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'No data to import'
                    ]);
                }
            }
        }
        return redirect('/');
    }

    public function show_qr_code($guest_id_qr_code)
    {
        // Cari tamu berdasarkan guest_id_qr_code
        $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)->first();

        if (!$guest) {
            // Jika tamu tidak ditemukan, tampilkan halaman 404
            abort(404, 'Guest not found');
        }

        // Tampilkan view dengan QR Code
        return view('guests.show_qr', compact('guest'));
    }

    public function scanner()
    {
        $title = 'Guest Scanner';

        $breadcrumb = (object)[
            'title' => 'Guest Scanner',
            'list' => ['Home', 'Guests', 'Scanner']
        ];

        $page = (object)[
            'title' => 'Guest Scanner'
        ];

        $activeMenu = 'guests';


        return view('guests.scanner', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }
}
