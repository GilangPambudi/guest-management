<?php
namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);
    }
    
    public function createPayment(Request $request, $slug, $guest_id_qr_code)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        $guest = Guest::where('guest_id_qr_code', $guest_id_qr_code)
            ->where('invitation_id', $invitation->invitation_id)
            ->firstOrFail();
            
        $amount = $request->input('amount', 50000); // Default 50k
        $orderId = 'WED-' . $invitation->invitation_id . '-' . $guest->guest_id . '-' . time();
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $guest->guest_name,
                'phone' => $guest->guest_contact,
            ],
            'item_details' => [
                [
                    'id' => 'wedding_gift',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Wedding Gift for ' . $invitation->groom_name . ' & ' . $invitation->bride_name
                ]
            ],
        ];
        
        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan ke database
            Payment::create([
                'guest_id' => $guest->guest_id,
                'invitation_id' => $invitation->invitation_id,
                'order_id' => $orderId,
                'gross_amount' => $amount,
                'snap_token' => $snapToken,
            ]);
            
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function handleCallback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $payment = Payment::where('order_id', $request->order_id)->first();
            
            if ($payment) {
                $payment->update([
                    'transaction_status' => $request->transaction_status,
                    'payment_type' => $request->payment_type ?? null,
                    'payment_status' => $request->transaction_status == 'settlement' ? 'success' : 'pending',
                    'midtrans_response' => $request->all()
                ]);
            }
        }
        
        return response('OK');
    }
}