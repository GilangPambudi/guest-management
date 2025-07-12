<?php

namespace App\Http\Controllers;

use Hidehalo\Nanoid\Client;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of guests for specific invitation.
     */
    public function index($invitation_id)
    {
        $invitation = Invitation::findOrFail($invitation_id);

        // Get dynamic filter data from database
        $categories = Guest::where('invitation_id', $invitation_id)
            ->distinct()
            ->pluck('guest_category')
            ->filter()
            ->sort()
            ->values();

        $genders = Guest::where('invitation_id', $invitation_id)
            ->distinct()
            ->pluck('guest_gender')
            ->filter()
            ->sort()
            ->values();

        $attendanceStatuses = Guest::where('invitation_id', $invitation_id)
            ->distinct()
            ->pluck('guest_attendance_status')
            ->filter()
            ->sort()
            ->values();

        $invitationStatuses = Guest::where('invitation_id', $invitation_id)
            ->distinct()
            ->pluck('guest_invitation_status')
            ->filter()
            ->sort()
            ->values();

        $title = 'Guests';

        $breadcrumb = (object)[
            'title' => 'List of Guests - ' . $invitation->wedding_name,
            'list' => ['Home', 'Invitations - ' . $invitation->wedding_name, 'Guests']
        ];

        $page = (object)[
            'title' => 'List of Guests - ' . $invitation->wedding_name
        ];

        $activeMenu = 'guests';

        return view('guests.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitation' => $invitation,
            'categories' => $categories,
            'genders' => $genders,
            'attendanceStatuses' => $attendanceStatuses,
            'invitationStatuses' => $invitationStatuses
        ]);
    }

    public function list(Request $request, $invitation_id)
    {
        $guests = Guest::select(
            'guest_id', // Tambahkan guest_id untuk checkbox
            'guest_id_qr_code',
            'guest_name',
            'guest_gender',
            'guest_category',
            'guest_contact',
            'guest_address',
            'guest_attendance_status',
            'guest_arrival_time',
            'guest_invitation_status'
        )->where('invitation_id', $invitation_id);

        // Apply filters
        if ($request->has('category') && $request->category != '') {
            $guests->where('guest_category', $request->category);
        }

        if ($request->has('gender') && $request->gender != '') {
            $guests->where('guest_gender', $request->gender);
        }

        if ($request->has('attendance_status') && $request->attendance_status != '') {
            $guests->where('guest_attendance_status', $request->attendance_status);
        }

        if ($request->has('invitation_status') && $request->invitation_status != '') {
            $guests->where('guest_invitation_status', $request->invitation_status);
        }

        return DataTables::of($guests)
            ->addIndexColumn()
            ->editColumn('guest_arrival_time', function ($guest) {
                if ($guest->guest_arrival_time && $guest->guest_arrival_time != '-') {
                    return \Carbon\Carbon::parse($guest->guest_arrival_time)->format('H:i');
                }
                return $guest->guest_arrival_time;
            })
            ->addColumn('action', function ($guest) use ($invitation_id) {
                // Get invitation slug for invitation letter link
                $invitation = Invitation::find($invitation_id);
                $slug = $invitation ? $invitation->slug : '';

                $btn = '<button onclick="copyToClipboard(\'' . $guest->guest_id_qr_code . '\')" class="btn btn-primary btn-sm"><i class="fas fa-copy"></i> Copy ID</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $invitation_id . '/guests/' . $guest->guest_id . '/show_ajax') . '\')" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail</button> ';

                 $btn .= '<button class="btn btn-success btn-sm btn-send-wa" data-guest-id="' . $guest->guest_id . '" data-invitation-id="' . $invitation_id . '"><i class="fab fa-whatsapp"></i> Send WA</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $invitation_id . '/guests/' . $guest->guest_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/invitation/' . $invitation_id . '/guests/' . $guest->guest_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Method untuk bulk actions
    public function bulkAction(Request $request, $invitation_id)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,mark_sent,mark_pending',
            'guest_ids' => 'required|array|min:1',
            'guest_ids.*' => 'integer|exists:guests,guest_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request data',
                'errors' => $validator->errors()
            ], 422);
        }

        $action = $request->input('action');
        $guestIds = $request->input('guest_ids');

        // Pastikan semua guest_ids milik invitation yang benar
        $validGuestIds = Guest::where('invitation_id', $invitation_id)
            ->whereIn('guest_id', $guestIds)
            ->pluck('guest_id')
            ->toArray();

        if (count($validGuestIds) !== count($guestIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Some selected guests do not belong to this invitation'
            ], 422);
        }

        try {
            switch ($action) {
                case 'delete':
                    return $this->bulkDelete($invitation_id, $validGuestIds);

                case 'mark_sent':
                    return $this->bulkUpdateInvitationStatus($invitation_id, $validGuestIds, 'Sent');

                case 'mark_pending':
                    return $this->bulkUpdateInvitationStatus($invitation_id, $validGuestIds, 'Pending');

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid action'
                    ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    private function bulkDelete($invitation_id, $guestIds)
    {
        $guests = Guest::where('invitation_id', $invitation_id)
            ->whereIn('guest_id', $guestIds)
            ->get();

        $deletedCount = 0;
        $errors = [];

        foreach ($guests as $guest) {
            try {
                // Hapus file QR Code dari storage jika ada
                if ($guest->guest_qr_code && Storage::disk('public')->exists(str_replace('storage/', '', $guest->guest_qr_code))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $guest->guest_qr_code));
                }

                // Hapus data tamu dari database
                $guest->delete();
                $deletedCount++;
            } catch (\Exception $e) {
                $errors[] = "Failed to delete guest {$guest->guest_name}: " . $e->getMessage();
            }
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} guest(s) successfully deleted";
            if (!empty($errors)) {
                $message .= ", but some errors occurred: " . implode(', ', $errors);
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'refresh' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No guests were deleted. Errors: ' . implode(', ', $errors)
            ], 500);
        }
    }

    private function bulkUpdateInvitationStatus($invitation_id, $guestIds, $status)
    {
        $updatedCount = Guest::where('invitation_id', $invitation_id)
            ->whereIn('guest_id', $guestIds)
            ->update(['guest_invitation_status' => $status]);

        if ($updatedCount > 0) {
            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} guest(s) invitation status updated to '{$status}'",
                'refresh' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No guests were updated'
            ], 500);
        }
    }

    public function create_ajax($invitation_id)
    {
        $invitation = Invitation::findOrFail($invitation_id);
        return view('guests.create_ajax', ['invitation' => $invitation]);
    }

    // Mengecek apakah nomor sudah terdaftar atau belum
    public function check_contact(Request $request, $invitation_id)
    {
        $guest_contact = $request->input('guest_contact');
        $guest_id = $request->input('guest_id'); // For edit mode

        // Check if contact exists in ANY invitation (global check)
        $query = Guest::where('guest_contact', $guest_contact);

        // Exclude current guest when editing
        if ($guest_id) {
            $query->where('guest_id', '!=', $guest_id);
        }

        $exists = $query->exists();

        // Return true if contact is available (doesn't exist), false if taken
        return response()->json(!$exists);
    }

    public function store_ajax(Request $request, $invitation_id)
    {
        $validator = Validator::make($request->all(), [
            'guest_name' => 'required',
            'guest_gender' => 'required|in:Male,Female',
            'guest_category' => 'required',
            'guest_contact' => 'required|unique:guests,guest_contact',
            'guest_address' => 'required',
            'guest_attendance_status' => 'required',
            'guest_invitation_status' => 'required|in:-,Sent,Opened,Pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Generate guest_id_qr_code
        $client = new Client();
        $nanoId = $client->generateId(10); // Generate 10 character NanoID
        $guestNameSlug = str_replace(' ', '-', strtolower($request->input('guest_name')));
        $guestIdQrCode = "{$nanoId}-{$guestNameSlug}";

        // Generate QR Code
        $qrCodePath = "qr/guests/{$guestIdQrCode}.png";
        $qrCodeContent = QrCode::format('png')->size(300)->generate($guestIdQrCode);

        // Simpan QR Code ke storage
        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

        // Prepare data
        $data = $request->all();
        $data['guest_id_qr_code'] = $guestIdQrCode;
        $data['guest_qr_code'] = "storage/{$qrCodePath}";
        $data['user_id'] = Auth::id();
        $data['invitation_id'] = $invitation_id;

        // Simpan data tamu ke database
        Guest::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Guest created successfully.',
            'refresh' => true
        ]);
    }

    public function show_ajax($invitation_id, $id)
    {
        $guest = Guest::where('invitation_id', $invitation_id)->findOrFail($id);
        $invitation = Invitation::find($invitation_id);
        return view('guests.show_ajax', ['guest' => $guest, 'invitation' => $invitation]);
    }

    public function edit_ajax($invitation_id, $id)
    {
        $guest = Guest::where('invitation_id', $invitation_id)->findOrFail($id);
        return view('guests.edit_ajax', ['guest' => $guest]);
    }

    public function update_ajax(Request $request, $invitation_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'guest_name' => 'required',
            'guest_gender' => 'required|in:Male,Female',
            'guest_category' => 'required',
            'guest_contact' => 'required|unique:guests,guest_contact,' . $id . ',guest_id',
            'guest_address' => 'required',
            'guest_attendance_status' => 'required',
            'guest_invitation_status' => 'required|in:-,Sent,Opened,Pending',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $guest = Guest::where('invitation_id', $invitation_id)->findOrFail($id);

        // Periksa apakah guest_name diubah
        if ($guest->guest_name !== $request->input('guest_name')) {
            // Hapus QR Code lama jika ada
            if ($guest->guest_qr_code && Storage::disk('public')->exists(str_replace(
                'storage/',
                '',
                $guest->guest_qr_code
            ))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $guest->guest_qr_code));
            }

            // Generate guest_id_qr_code baru
            $client = new Client();
            $nanoId = $client->generateId(10); // Generate 10 character NanoID
            $guestNameSlug = str_replace(' ', '-', strtolower($request->input('guest_name')));
            $guestIdQrCode = "{$nanoId}-{$guestNameSlug}";

            // Generate QR Code baru
            $qrCodePath = "qr/guests/{$guestIdQrCode}.png";
            $qrCodeContent = QrCode::format('png')->size(300)->generate($guestIdQrCode);
            Storage::disk('public')->put($qrCodePath, $qrCodeContent);

            // Tambahkan guest_id_qr_code dan guest_qr_code ke request
            $request->merge([
                'guest_id_qr_code' => $guestIdQrCode,
                'guest_qr_code' => "storage/{$qrCodePath}",
            ]);
        }

        // Periksa apakah attendance status diubah menjadi "-" (Not Set)
        if ($request->input('guest_attendance_status') === '-') {
            // Set arrival time menjadi "-" jika attendance status diubah ke "Not Set"
            $request->merge([
                'guest_arrival_time' => '-',
            ]);
        }

        // Jika invitation status diubah ke "-", kosongkan sent_at dan opened_at
        if ($request->input('guest_invitation_status') === '-') {
            $request->merge([
                'invitation_sent_at' => null,
                'invitation_opened_at' => null,
            ]);
        }

        // Perbarui data tamu
        $guest->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Guest updated successfully.',
            'refresh' => true
        ]);
    }

    public function confirm_ajax($invitation_id, $id)
    {
        $guest = Guest::where('invitation_id', $invitation_id)->findOrFail($id);
        return view('guests.confirm_ajax', ['guest' => $guest]);
    }

    public function delete_ajax($invitation_id, $id)
    {
        if (request()->ajax()) {
            $guest = Guest::where('invitation_id', $invitation_id)->find($id);
            if ($guest) {
                // Hapus file QR Code dari storage jika ada
                if ($guest->guest_qr_code && Storage::disk('public')->exists(str_replace('storage/', '', $guest->guest_qr_code))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $guest->guest_qr_code));
                }

                // Hapus data tamu dari database
                $guest->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Data successfully deleted',
                    'refresh' => true
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

    public function import($invitation_id)
    {
        $invitation = Invitation::findOrFail($invitation_id);
        return view('guests.import', ['invitation' => $invitation]);
    }

    public function import_process(Request $request, $invitation_id)
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
                        $client = new Client();
                        $nanoId = $client->generateId(10); // Generate 10 character NanoID
                        $guestNameSlug = str_replace(' ', '-', strtolower($value['A']));
                        $guestIdQrCode = "{$nanoId}-{$guestNameSlug}";

                        // Generate QR Code
                        $qrCodePath = "qr/guests/{$guestIdQrCode}.png";
                        $qrCodeContent = QrCode::format('png')->size(300)->generate($guestIdQrCode);
                        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

                        $insert[] = [
                            'guest_name' => $value['A'],
                            'guest_id_qr_code' => $guestIdQrCode,
                            'guest_gender' => $value['B'],
                            'guest_category' => $value['C'],
                            'guest_contact' => $value['D'],
                            'guest_address' => $value['E'],
                            'guest_qr_code' => "storage/{$qrCodePath}",
                            'guest_attendance_status' => '-',
                            'guest_invitation_status' => '-',
                            'user_id' => Auth::user()->user_id,
                            'invitation_id' => $invitation_id,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    Guest::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data successfully imported',
                        'refresh' => true
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

    /**
     * Download Excel template
     */
    public function template($invitation_id)
    {
        $invitation = Invitation::findOrFail($invitation_id);

        // Path ke template file yang ada
        $templatePath = public_path('template_guests.xlsx');

        // Generate filename dengan nama wedding
        $filename = 'guest_template_' . str_replace([' ', '&', '/'], ['_', 'and', '_'], $invitation->wedding_name) . '.xlsx';

        // Cek apakah file template exists
        if (file_exists($templatePath)) {
            // Jika file template ada, gunakan file tersebut
            return response()->download($templatePath, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } else {
            // Fallback: buat template baru jika file tidak ada
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $sheet->setCellValue('A1', 'Guest Name');
            $sheet->setCellValue('B1', 'Gender');
            $sheet->setCellValue('C1', 'Category');
            $sheet->setCellValue('D1', 'Contact');
            $sheet->setCellValue('E1', 'Address');

            // Add sample data
            $sheet->setCellValue('A2', 'John Doe');
            $sheet->setCellValue('B2', 'Male');
            $sheet->setCellValue('C2', 'VIP');
            $sheet->setCellValue('D2', '08123456789');
            $sheet->setCellValue('E2', 'Jl. Example Street No. 123');

            $sheet->setCellValue('A3', 'Jane Smith');
            $sheet->setCellValue('B3', 'Female');
            $sheet->setCellValue('C3', 'Regular');
            $sheet->setCellValue('D3', '08987654321');
            $sheet->setCellValue('E3', 'Jl. Sample Road No. 456');

            // Style headers
            $sheet->getStyle('A1:E1')->getFont()->setBold(true);
            $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('CCE5FF');

            // Auto size columns
            foreach (range('A', 'E') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);

            // Set headers untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        }
    }

    public function scannerSelect()
    {
        $invitations = Invitation::select('invitation_id', 'wedding_name', 'groom_name', 'bride_name', 'wedding_date', 'wedding_venue')
            ->withCount('guests')
            ->orderBy('wedding_date', 'desc')
            ->get();

        $title = 'Scanner';
        $breadcrumb = (object)[
            'title' => 'QR Scanner - Select Invitation',
            'list' => ['Home', 'Scanner']
        ];
        $page = (object)[
            'title' => 'QR Scanner'
        ];
        $activeMenu = 'scanner';

        return view('scanner.select', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitations' => $invitations
        ]);
    }

    public function guestSelect()
    {
        $invitations = Invitation::select('invitation_id', 'wedding_name', 'groom_name', 'bride_name', 'wedding_date', 'wedding_venue')
            ->withCount('guests')
            ->orderBy('wedding_date', 'desc')
            ->get();

        $title = 'Guest Management';
        $breadcrumb = (object)[
            'title' => 'Guest Management - Select Invitation',
            'list' => ['Home', 'Guests']
        ];
        $page = (object)[
            'title' => 'Guest Management'
        ];
        $activeMenu = 'guests';

        return view('guests.select', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitations' => $invitations
        ]);
    }

    public function scanner($invitation_id)
    {
        $invitation = Invitation::findOrFail($invitation_id);

        $title = 'Guest Scanner';
        $breadcrumb = (object)[
            'title' => 'Guest Scanner - ' . $invitation->wedding_name,
            'list' => ['Home', 'Scanner', 'Select Invitation', $invitation->wedding_name]
        ];
        $page = (object)[
            'title' => 'Guest Scanner - ' . $invitation->wedding_name
        ];
        $activeMenu = 'scanner';

        return view('scanner.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitation' => $invitation
        ]);
    }

    public function welcome_gate($invitation_id, $guest_id_qr_code)
    {
        // Cari invitation terlebih dahulu
        $invitation = Invitation::findOrFail($invitation_id);

        // Cari tamu berdasarkan guest_id_qr_code dan pastikan milik invitation yang benar
        $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
            ->where('invitation_id', $invitation_id)
            ->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found or does not belong to this invitation'
            ], 404);
        }

        // Cek apakah sudah check-in sebelumnya
        $alreadyCheckedIn = $guest->guest_attendance_status === 'Yes' && $guest->guest_arrival_time;

        // Perbarui waktu kedatangan tamu dan status kehadiran
        $guest->update([
            'guest_attendance_status' => 'Yes',
            'guest_arrival_time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => $alreadyCheckedIn ?
                "Welcome back, {$guest->guest_name}! (Already checked in)" :
                "Welcome, {$guest->guest_name}! Check-in successful",
            'guest_name' => $guest->guest_name,
            'guest_category' => $guest->guest_category,
            'already_checked_in' => $alreadyCheckedIn,
            'arrival_time' => now()->setTimezone('Asia/Jakarta')->format('H:i:s')
        ]);
    }

    public function recentCheckins($invitation_id)
    {
        $guests = Guest::where('invitation_id', $invitation_id)
            ->where('guest_attendance_status', 'Yes')
            ->whereDate('guest_arrival_time', now()->setTimezone('Asia/Jakarta')->toDateString())
            ->orderBy('guest_arrival_time', 'desc')
            ->limit(10)
            ->get(['guest_name', 'guest_category', 'guest_attendance_status', 'guest_arrival_time'])
            ->map(function ($guest) {
                if ($guest->guest_arrival_time) {
                    $guest->guest_arrival_time_formatted = \Carbon\Carbon::parse($guest->guest_arrival_time)
                        ->setTimezone('Asia/Jakarta')
                        ->format('H:i:s');
                }
                return $guest;
            });

        return response()->json($guests);
    }

    public function sendWhatsapp($invitation_id, $guest_id)
    {
        try {
            $guest = Guest::find($guest_id);
            if (!$guest) {
                return response()->json(['success' => false, 'message' => 'Guest not found']);
            }

            // Validasi apakah guest belong to invitation
            if ($guest->invitation_id != $invitation_id) {
                return response()->json(['success' => false, 'message' => 'Guest does not belong to this invitation']);
            }

            // Validasi nomor telepon
            if (!$guest->guest_contact) {
                return response()->json(['success' => false, 'message' => 'Guest contact number is empty']);
            }

            $token = env('FONNTE_TOKEN');
            if (!$token) {
                return response()->json(['success' => false, 'message' => 'Fonnte token not configured']);
            }

            // Ambil invitation terkait tamu
            $invitation = Invitation::find($invitation_id);
            if (!$invitation) {
                return response()->json(['success' => false, 'message' => 'Invitation not found']);
            }

            $slug = $invitation->slug;
            $url = url("/invitation/{$slug}/{$guest->guest_id_qr_code}");

            $message = "> *Pesan Otomatis* — Mohon balas pesan ini agar link dapat dibuka\n\n"
                . "━━━━━━━━━━━━━━━━━━━━\n"
                . "💌 *Quick Response Elegant Wedding — Invitation*\n"
                . "━━━━━━━━━━━━━━━━━━━━\n\n"
                . "Halo {$guest->guest_name},\n\n"
                . "Dengan penuh kebahagiaan, kami mengundang Anda untuk hadir di acara pernikahan kami.\n\n"
                . "🗓️ *Tanggal:* " . \Carbon\Carbon::parse($invitation->wedding_date)->translatedFormat('d F Y') . "\n"
                . "⏰ *Waktu:* " . \Carbon\Carbon::parse($invitation->wedding_time_start)->format('H:i') . " - " . \Carbon\Carbon::parse($invitation->wedding_time_end)->format('H:i') . "\n"
                . "🏛️ *Tempat:* {$invitation->wedding_venue}\n\n"
                . "📍 *Link Undangan Digital:*\n{$url}\n\n"
                . "Kami sangat menantikan kehadiran dan doa restu Anda.\n\n"
                . "Salam hangat,\n"
                . "*{$invitation->groom_name} & {$invitation->bride_name}*\n\n"
                . "_(Pesan ini dikirim untuk keperluan testing skripsi oleh GILANG PAMBUDI)_";


            $response = Http::withHeaders([
                'Authorization' => $token
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $guest->guest_contact,
                'message' => $message,
            ]);

            if ($response->successful()) {
                // Update invitation status to "Sent" when WhatsApp is successfully sent
                $guest->update([
                    'guest_invitation_status' => 'Sent',
                    'invitation_sent_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'WhatsApp message sent successfully',
                    'data' => $response->json()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send WhatsApp message',
                    'error' => $response->json()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function sendWhatsappBulk(Request $request, $invitation_id)
    {
        try {
            $guestIds = $request->input('guest_ids', []);

            if (empty($guestIds)) {
                return response()->json(['success' => false, 'message' => 'No guests selected']);
            }

            $token = env('FONNTE_TOKEN');
            if (!$token) {
                return response()->json(['success' => false, 'message' => 'Fonnte token not configured']);
            }

            $invitation = Invitation::find($invitation_id);
            if (!$invitation) {
                return response()->json(['success' => false, 'message' => 'Invitation not found']);
            }

            $results = [];
            $successCount = 0;
            $failedCount = 0;

            foreach ($guestIds as $guestId) {
                $guest = Guest::find($guestId);
                if (!$guest || !$guest->guest_contact) {
                    $failedCount++;
                    continue;
                }

                $slug = $invitation->slug;
                $url = url("/invitation/{$slug}/{$guest->guest_id_qr_code}");

                $message = "> *Pesan Otomatis* — Mohon balas pesan ini agar link dapat dibuka\n\n"
                . "━━━━━━━━━━━━━━━━━━━━\n"
                . "💌 *Quick Response Elegant Wedding — Invitation*\n"
                . "━━━━━━━━━━━━━━━━━━━━\n\n"
                . "Halo {$guest->guest_name},\n\n"
                . "Dengan penuh kebahagiaan, kami mengundang Anda untuk hadir di acara pernikahan kami.\n\n"
                . "🗓️ *Tanggal:* " . \Carbon\Carbon::parse($invitation->wedding_date)->translatedFormat('d F Y') . "\n"
                . "⏰ *Waktu:* " . \Carbon\Carbon::parse($invitation->wedding_time_start)->format('H:i') . " - " . \Carbon\Carbon::parse($invitation->wedding_time_end)->format('H:i') . "\n"
                . "🏛️ *Tempat:* {$invitation->wedding_venue}\n\n"
                . "📍 *Link Undangan Digital:*\n{$url}\n\n"
                . "Kami sangat menantikan kehadiran dan doa restu Anda.\n\n"
                . "Salam hangat,\n"
                . "*{$invitation->groom_name} & {$invitation->bride_name}*\n\n"
                . "_(Pesan ini dikirim untuk keperluan testing skripsi oleh GILANG PAMBUDI)_";

                $response = Http::withHeaders([
                    'Authorization' => $token
                ])->asForm()->post('https://api.fonnte.com/send', [
                    'target' => $guest->guest_contact,
                    'message' => $message,
                ]);

                if ($response->successful()) {
                    $successCount++;
                    // Update invitation status to "Sent" when WhatsApp is successfully sent
                    $guest->update([
                        'guest_invitation_status' => 'Sent',
                        'invitation_sent_at' => now()
                    ]);
                } else {
                    $failedCount++;
                }

                $results[] = [
                    'guest_id' => $guestId,
                    'guest_name' => $guest->guest_name,
                    'success' => $response->successful(),
                    'response' => $response->json()
                ];

                // Add small delay to prevent rate limiting
                usleep(rand(5, 10) * 1000000); // 5-10 second delay
            }

            return response()->json([
                'success' => true,
                'message' => "WhatsApp sent: {$successCount} success, {$failedCount} failed",
                'data' => [
                    'total' => count($guestIds),
                    'success_count' => $successCount,
                    'failed_count' => $failedCount,
                    'results' => $results
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get list of guests for specific invitation (for dropdowns).
     */
    public function getGuestsList($invitation_id)
    {
        $guests = Guest::where('invitation_id', $invitation_id)
            ->select('guest_id', 'guest_name', 'guest_category')
            ->orderBy('guest_name')
            ->get();

        return response()->json($guests);
    }
}
