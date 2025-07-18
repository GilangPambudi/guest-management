<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes without register
Auth::routes(['register' => false]);

// Custom register route with /auth prefix for security
// Route::group(['prefix' => 'auth'], function () {
//     Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     Route::post('/register', [RegisterController::class, 'register']);
// });

Route::get('/dashboard', [HomeController::class, 'index']);

// Profile Routes
Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::get('/edit_ajax', [ProfileController::class, 'edit']);
    Route::put('/update_ajax', [ProfileController::class, 'update']);
    Route::get('/password_ajax', [ProfileController::class, 'editPassword']);
    Route::put('/password_ajax', [ProfileController::class, 'updatePassword']);
});

Route::group(['prefix' => 'qr'], function () {
    Route::get('/', [QRCodeController::class, 'index']);
    Route::post('/submit', [QRCodeController::class, 'submit']);
});

Route::group(['prefix' => 'invitation', 'middleware' => 'auth'], function () {
    Route::get('/', [InvitationController::class, 'index'])->name('invitation.index');
    Route::post('/list', [InvitationController::class, 'list']);
    // Route::get('/create', [InvitationController::class, 'create'])->name('invitation.create'); // Halaman create baru
    // Route::post('/store', [InvitationController::class, 'store'])->name('invitation.store'); // Store untuk halaman
    Route::get('/{id}/show', [InvitationController::class, 'show']);
    // Route::get('/{id}/edit', [InvitationController::class, 'edit'])->name('invitation.edit'); // Halaman edit baru
    // Route::put('/{id}/update', [InvitationController::class, 'update'])->name('invitation.update'); // Update untuk halaman
    Route::get('/{id}/show_ajax', [InvitationController::class, 'show_ajax']);
    Route::get('/create_ajax', [InvitationController::class, 'create_ajax']); // Keep untuk modal jika diperlukan
    Route::post('/store_ajax', [InvitationController::class, 'store_ajax']); // Keep untuk modal jika diperlukan
    Route::get('/{id}/edit_ajax', [InvitationController::class, 'edit_ajax']); // Keep untuk modal jika diperlukan
    Route::put('/{id}/update_ajax', [InvitationController::class, 'update_ajax']); // Keep untuk modal jika diperlukan
    Route::get('/{id}/delete_ajax', [InvitationController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [InvitationController::class, 'delete_ajax']);
    Route::get('/{invitation_id}/scanner', [GuestController::class, 'scanner'])->name('guest.scanner');
    Route::get('/{invitation_id}/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate'])->name('guest.welcome_gate');
    Route::get('/{invitation_id}/recent-checkins', [GuestController::class, 'recentCheckins']);
    Route::get('/{invitation_id}/guests/list', [GuestController::class, 'getGuestsList'])->name('guests.list');
    Route::post('/{invitation}/guests/{guest}/send-wa', [GuestController::class, 'sendWhatsapp'])->name('guests.send-wa');
    Route::post('/{invitation}/guests/send-wa-bulk', [GuestController::class, 'sendWhatsappBulk'])->name('guests.send-wa-bulk');
});

Route::group(['prefix' => 'invitation/{invitation}/guests', 'middleware' => 'auth'], function () {
    Route::get('/', [GuestController::class, 'index']);
    Route::post('/list', [GuestController::class, 'list']);
    Route::get('/filters', [GuestController::class, 'getFilters']);
    Route::get('/import', [GuestController::class, 'import']);
    Route::post('/import_process', [GuestController::class, 'import_process']);
    Route::get('/template', [GuestController::class, 'template']);
    Route::get('/create_ajax', [GuestController::class, 'create_ajax']);
    Route::post('/check-contact', [GuestController::class, 'check_contact']);
    Route::post('/store_ajax', [GuestController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [GuestController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [GuestController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [GuestController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [GuestController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [GuestController::class, 'delete_ajax']);
    Route::post('/{id}/delete_ajax', [GuestController::class, 'delete_ajax']); // Tambahkan untuk AJAX
    Route::post('/bulk-action', [GuestController::class, 'bulkAction']);
});

Route::get('/guests', [GuestController::class, 'guestSelect'])->name('guests.select');
Route::get('/scanner', [GuestController::class, 'scannerSelect'])->name('scanner.select');
Route::get('/scanner/{invitation_id}', [GuestController::class, 'scanner'])->name('scanner.index');

// User Management Routes - moved up to avoid conflicts
Route::group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/store_ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
});

// Gift Management Routes
Route::get('/gifts', [GiftController::class, 'select'])->name('gifts.select');
Route::get('/gifts/{invitation_id}', [GiftController::class, 'index'])->name('gifts.index');
Route::get('/gifts/{invitation_id}/data', [GiftController::class, 'data'])->name('gifts.data');
Route::get('/gifts/{invitation_id}/summary', [GiftController::class, 'summary'])->name('gifts.summary');
Route::get('/gifts/payment/{payment_id}/detail', [GiftController::class, 'detail'])->name('gifts.detail');
Route::post('/gifts/{invitation_id}/sync-all-status', [GiftController::class, 'syncAllStatus'])->name('gifts.sync-all-status');
Route::post('/gifts/payment/{payment_id}/check-status', [GiftController::class, 'checkStatus'])->name('gifts.check-status');
Route::post('/gifts/{invitation_id}/auto-expire', [GiftController::class, 'autoExpirePayments'])->name('gifts.auto-expire');

Route::post('/payment/create/{slug}/{guest_id_qr_code}', [PaymentController::class, 'createPayment']);
Route::get('/payment/check/{slug}/{guest_id_qr_code}', [PaymentController::class, 'checkPaymentStatus']);
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::post('/midtrans/webhook', [PaymentController::class, 'handleCallback'])->name('midtrans.webhook'); // Alternative webhook URL

Route::prefix('wishes')->middleware('auth')->group(function () {
    Route::get('/', [WishController::class, 'wishSelect'])->name('wishes.select');
    Route::get('/invitation/{invitation_id}', [WishController::class, 'index'])->name('wishes.index');
    Route::post('/invitation/{invitation_id}/list', [WishController::class, 'list'])->name('wishes.list');
    Route::get('/{id}/show_ajax', [WishController::class, 'show_ajax']);
    Route::delete('/{id}/delete_ajax', [WishController::class, 'delete_ajax']);
    Route::post('/bulk-action', [WishController::class, 'bulkAction']);
});

// Guest facing wishes routes
Route::get('/wishes/{slug}', [WishController::class, 'getWishesForInvitation']);
Route::get('/wishes/{slug}/{guest_id_qr_code}/check', [WishController::class, 'checkUserWish']);
Route::post('/wishes/create/{slug}/{guest_id_qr_code}', [WishController::class, 'storeGuestWish']);
Route::post('/wishes/update/{slug}/{guest_id_qr_code}', [WishController::class, 'update']);

// Route::get('/old/{slug}/{guest_id_qr_code}', [PublicInvitationController::class, 'old_invitation_letter']);
Route::get('/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate']);

// Invitation route with constraints to avoid conflicts
Route::get('/{slug}/{guest_id_qr_code}', [PublicInvitationController::class, 'letter'])
    ->where([
        'slug' => '[a-z0-9\-]+',  // Only lowercase letters, numbers, and hyphens
        'guest_id_qr_code' => '[a-zA-Z0-9_\-]+' // Letters, numbers, underscore, hyphens
    ])
    ->name('public.invitation-letter');

Route::post('/update-attendance/{slug}/{guest_id_qr_code}', [PublicInvitationController::class, 'update_attendance_ajax'])->name('public.update-attendance-ajax');
Route::post('/mark-opened/{slug}/{guest_id_qr_code}', [PublicInvitationController::class, 'mark_as_opened'])->name('public.mark-as-opened');
