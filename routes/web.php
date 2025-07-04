<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index']);

Route::group(['prefix' => 'qr'], function () {
    Route::get('/', [QRCodeController::class, 'index']);
    Route::post('/submit', [QRCodeController::class, 'submit']);
});

Route::group(['prefix' => 'invitation', 'middleware' => 'auth'], function () {
    Route::get('/', [InvitationController::class, 'index']);
    Route::post('/list', [InvitationController::class, 'list']);
    Route::get('/{id}/show_ajax', [InvitationController::class, 'show_ajax']);
    Route::get('/create_ajax', [InvitationController::class, 'create_ajax']);
    Route::post('/store_ajax', [InvitationController::class, 'store_ajax']);
    Route::get('/{id}/show', [InvitationController::class, 'show']);
    Route::get('/{id}/edit_ajax', [InvitationController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [InvitationController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [InvitationController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [InvitationController::class, 'delete_ajax']);
    Route::get('/{invitation_id}/scanner', [GuestController::class, 'scanner'])->name('guest.scanner');
    Route::get('/{invitation_id}/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate'])->name('guest.welcome_gate');
    Route::get('/{invitation_id}/recent-checkins', [GuestController::class, 'recentCheckins']);
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
    // Route::get('/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate'])
    // ->where('guest_id_qr_code', '.*'); // Allow forward slashes in the parameter
});
Route::get('/guests', [GuestController::class, 'guestSelect'])->name('guests.select');
Route::get('/scanner', [GuestController::class, 'scannerSelect'])->name('scanner.select');
Route::get('/scanner/{invitation_id}', [GuestController::class, 'scanner'])->name('scanner.index');

Route::get('/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate']);
Route::get('/invitation-letter/{slug}/{guest_id_qr_code}', [GuestController::class, 'invitation_letter'])->name('invitation.letter');
Route::post('/update-attendance/{slug}/{guest_id_qr_code}', [GuestController::class, 'update_attendance_ajax'])->name('update.attendance');
