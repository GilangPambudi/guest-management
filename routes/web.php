<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CoupleController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\QRCodeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index']);

Route::group(['prefix' => 'qr'], function () {
    Route::get('/', [QRCodeController::class, 'index']);
    Route::post('/submit', [QRCodeController::class, 'submit']);
});

Route::group(['prefix' => 'couple', 'middleware' => 'auth'], function () {
    Route::get('/', [CoupleController::class, 'index']);
    Route::post('/list', [CoupleController::class, 'list']);
    Route::get('/{id}/show_ajax', [CoupleController::class, 'show_ajax']);
    Route::get('/create_ajax', [CoupleController::class, 'create_ajax']);
    Route::post('/store_ajax', [CoupleController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [CoupleController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [CoupleController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [CoupleController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [CoupleController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'guests', 'middleware' => 'auth'], function () {
    Route::get('/', [GuestController::class, 'index']);
    Route::post('/list', [GuestController::class, 'list']);
    Route::get('/import', [GuestController::class, 'import']);
    Route::post('/import_ajax', [GuestController::class, 'import_process']);
    Route::post('/check-contact', [GuestController::class, 'check_contact']);
    Route::get('/{id}/show_ajax', [GuestController::class, 'show_ajax']);
    Route::get('/create_ajax', [GuestController::class, 'create_ajax']);
    Route::post('/store_ajax', [GuestController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [GuestController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [GuestController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [GuestController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [GuestController::class, 'delete_ajax']);
    Route::post('/delete_multiple', [GuestController::class, 'delete_multiple']);
});

Route::group(['prefix' => 'invitation', 'middleware' => 'auth'], function () {
    Route::get('/', [InvitationController::class, 'index']);
    Route::post('/list', [InvitationController::class, 'list']);
    Route::get('/{id}/show_ajax', [InvitationController::class, 'show_ajax']);
    Route::get('/create_ajax', [InvitationController::class, 'create_ajax']);
    Route::post('/store_ajax', [InvitationController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [InvitationController::class, 'edit_ajax']);
});

Route::get('/invitation/{guest_id_qr_code}', [GuestController::class, 'show_qr_code']);
Route::get('/guests/scanner', [GuestController::class, 'scanner']);