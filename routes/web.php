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
    Route::get('/{id}/edit_ajax', [InvitationController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [InvitationController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [InvitationController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [InvitationController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'invitation/{invitation}/guests', 'middleware' => 'auth'], function () {
    Route::get('/', [GuestController::class, 'index']);
    Route::post('/list', [GuestController::class, 'list']);
    Route::get('/filters', [GuestController::class, 'getFilters']);
    Route::get('/import', [GuestController::class, 'import']);
    Route::post('/import_process', [GuestController::class, 'import_process']);
    Route::get('/template', [GuestController::class, 'template']);
    Route::get('/create_ajax', [GuestController::class, 'create_ajax']);
    Route::post('/store_ajax', [GuestController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [GuestController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [GuestController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [GuestController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [GuestController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [GuestController::class, 'delete_ajax']);
    Route::get('/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate'])
    ->where('guest_id_qr_code', '.*'); // Allow forward slashes in the parameter
});


Route::get('/welcome-gate/{guest_id_qr_code}', [GuestController::class, 'welcome_gate']);
Route::get('/invitation-letter/{guest_id_qr_code}', [GuestController::class, 'invitation_letter']);
