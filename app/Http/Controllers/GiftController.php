<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Midtrans\Config;
use Midtrans\Transaction;

class GiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);
    }

    /**
     * Display a listing of invitations for gift selection.
     */
    public function select()
    {
        $invitations = Invitation::select('invitation_id', 'wedding_name', 'groom_name', 'bride_name', 'wedding_date', 'wedding_venue')
            ->withCount('guests')
            ->orderBy('wedding_date', 'desc')
            ->get();

        $title = 'Gift Management';
        $breadcrumb = (object)[
            'title' => 'Gift Management - Select Invitation',
            'list' => ['Home', 'Gifts']
        ];
        $page = (object)[
            'title' => 'Select Invitation for Gift Management'
        ];
        $activeMenu = 'gifts';

        return view('gifts.select', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitations' => $invitations
        ]);
    }

    /**
     * Display payment logs (gifts) for specific invitation.
     */
    public function index($invitation_id)
    {
        $invitation = Invitation::findOrFail($invitation_id);

        // Get dynamic filter data from payments
        $paymentStatuses = Payment::where('invitation_id', $invitation_id)
            ->distinct()
            ->pluck('transaction_status')
            ->filter()
            ->sort()
            ->values();

        $paymentTypes = Payment::where('invitation_id', $invitation_id)
            ->distinct()
            ->pluck('payment_type')
            ->filter()
            ->sort()
            ->values();

        $title = 'Gift Payment Logs';
        $breadcrumb = (object)[
            'title' => 'Gift Payment Logs - ' . $invitation->wedding_name,
            'list' => ['Home', 'Gifts', 'Select Invitation', $invitation->wedding_name]
        ];
        $page = (object)[
            'title' => 'Gift Payment Logs - ' . $invitation->wedding_name
        ];
        $activeMenu = 'gifts';

        return view('gifts.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'invitation' => $invitation,
            'paymentStatuses' => $paymentStatuses,
            'paymentTypes' => $paymentTypes
        ]);
    }

    /**
     * Get payment data for DataTables.
     */
    public function data(Request $request, $invitation_id)
    {
        $payments = Payment::leftJoin('guests', 'payments.guest_id', '=', 'guests.guest_id')
            ->where('payments.invitation_id', $invitation_id)
            ->select(
                'payments.payment_id',
                'payments.guest_id',
                'payments.order_id',
                'payments.gross_amount',
                'payments.transaction_status',
                'payments.payment_type',
                'payments.created_at',
                'payments.updated_at',
                'guests.guest_name',
                'guests.guest_category'
            );

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $payments->where('payments.transaction_status', $request->status);
        }

        if ($request->has('payment_type') && $request->payment_type != '') {
            $payments->where('payments.payment_type', $request->payment_type);
        }

        return DataTables::of($payments)
            ->addIndexColumn()
            ->addColumn('formatted_amount', function ($payment) {
                return 'Rp ' . number_format($payment->gross_amount, 0, ',', '.');
            })
            ->addColumn('status_badge', function ($payment) {
                $status = $payment->transaction_status;
                $badgeClass = match($status) {
                    'settlement' => 'badge-success',
                    'pending' => 'badge-warning',
                    'cancel', 'expire' => 'badge-danger',
                    'deny' => 'badge-secondary',
                    default => 'badge-info'
                };
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
            })
            ->addColumn('payment_method', function ($payment) {
                return $payment->payment_type ?: 'Not Set';
            })
            ->addColumn('transaction_time', function ($payment) {
                // Convert to Asia/Jakarta timezone (UTC+7)
                return $payment->created_at
                    ? $payment->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i')
                    : '-';
            })
            ->addColumn('updated_time', function ($payment) {
                // Convert to Asia/Jakarta timezone (UTC+7)
                return $payment->updated_at
                    ? $payment->updated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i')
                    : '-';
            })
            ->addColumn('action', function ($payment) {
                $btn = '<button class="btn btn-info btn-sm mr-1" onclick="showPaymentDetail(' . $payment->payment_id . ')" title="View payment details">
                            <i class="fa fa-eye"></i> Detail
                        </button>';
                
                // Add sync button for non-completed payments
                if (in_array($payment->transaction_status, ['pending', 'authorize'])) {
                    $btn .= '<button class="btn btn-warning btn-sm" onclick="checkSingleStatus(' . $payment->payment_id . ')" title="Check status from Midtrans">
                                <i class="fa fa-sync"></i> Check
                            </button>';
                }
                
                return $btn;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Show payment detail modal.
     */
    public function detail($payment_id)
    {
        $payment = Payment::with(['guest', 'invitation'])->findOrFail($payment_id);
        return response()->json($payment);
    }

    /**
     * Get payment summary for specific invitation.
     */
    public function summary($invitation_id)
    {
        $payments = Payment::where('invitation_id', $invitation_id)->get();

        $totalPayments = $payments->count();
        $totalAmount = $payments->sum('gross_amount');
        $averageAmount = $totalPayments > 0 ? $totalAmount / $totalPayments : 0;
        
        $successfulPayments = $payments->where('transaction_status', 'settlement')->count();
        $pendingPayments = $payments->where('transaction_status', 'pending')->count();
        $failedPayments = $payments->whereIn('transaction_status', ['cancel', 'expire', 'deny'])->count();

        return response()->json([
            'total_payments' => $totalPayments,
            'total_amount' => $totalAmount,
            'average_amount' => $averageAmount,
            'successful_payments' => $successfulPayments,
            'pending_payments' => $pendingPayments,
            'failed_payments' => $failedPayments
        ]);
    }

    /**
     * Sync all payment statuses (including completed ones)
     */
    public function syncAllStatus($invitation_id)
    {
        try {
            $payments = Payment::where('invitation_id', $invitation_id)->get();

            $syncedCount = 0;
            $errors = [];

            foreach ($payments as $payment) {
                try {
                    // Get status from Midtrans
                    $status = Transaction::status($payment->order_id);
                    
                    if ($status && isset($status->transaction_status)) {
                        $oldStatus = $payment->transaction_status;
                        
                        $payment->update([
                            'transaction_status' => $status->transaction_status,
                            'payment_type' => $status->payment_type ?? $payment->payment_type,
                            'midtrans_response' => json_decode(json_encode($status), true)
                        ]);
                        
                        if ($oldStatus !== $status->transaction_status) {
                            $syncedCount++;
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = "Order {$payment->order_id}: " . $e->getMessage();
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Full sync completed. {$syncedCount} payments updated.",
                'synced_count' => $syncedCount,
                'total_checked' => $payments->count(),
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Full sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check single payment status
     */
    public function checkStatus($payment_id)
    {
        try {
            $payment = Payment::findOrFail($payment_id);
            
            // Get status from Midtrans
            $status = Transaction::status($payment->order_id);
            
            if ($status && isset($status->transaction_status)) {
                $oldStatus = $payment->transaction_status;
                
                $payment->update([
                    'transaction_status' => $status->transaction_status,
                    'payment_type' => $status->payment_type ?? $payment->payment_type,
                    'midtrans_response' => json_decode(json_encode($status), true)
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully',
                    'old_status' => $oldStatus,
                    'new_status' => $status->transaction_status,
                    'data' => $payment->fresh()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not get status from Midtrans'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Check failed: ' . $e->getMessage()
            ], 500);
        }
    }
}