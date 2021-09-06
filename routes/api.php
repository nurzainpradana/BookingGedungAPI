<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Registrasi Akun Baru
Route::post('registrasi_akun','APIController@registrasiAkun');

// Check Login
Route::post('check_login','APIController@checkLogin');

// Upload Photo Gedung
Route::post('upload_photo','APIController@uploadPhoto');

// Buat Gedung Baru
Route::post('buat_gedung_baru','APIController@buatGedungBaru');

// Get Gedung List (Pemilik)
Route::post('get_gedung_list_pemilik','APIController@getGedungListPemilik');

// Get Gedung List Filter (Pemilik)
Route::post('get_gedung_list_pemilik_filter','APIController@getGedungListPemilikFilter');

// Get Gedung List (Customer)
Route::get('get_gedung_list_customer','APIController@getGedungListCustomer');

// Get Gedung List Filter (Customer)
Route::post('get_gedung_list_customer_filter','APIController@getGedungListCustomerFilter');


// Get Detail Gedung
Route::post('get_gedung_detail','APIController@getGedungDetail');

// Check Booking Gedung
Route::post('check_booking_gedung','APIController@checkBooking');

// Check Booking Gedung
Route::post('booking_gedung','APIController@bookingGedung');

// Detail Booking Gedung
Route::post('get_detail_booking','APIController@getBookingDetail');

// Detail Akun
Route::post('get_detail_akun','APIController@getAkunDetail');

// Get Riwayat Booking Customer
Route::post('get_riwayat_booking_customer','APIController@getRiwayatBookingCustomer');


// Get Riwayat Booking Pemilik
Route::post('get_riwayat_booking_pemilik','APIController@getRiwayatBookingPemilik');

// Cancel Booking
Route::post('cancel_booking','APIController@cancelBooking');


// Cancel Booking
Route::post('konfirmasi_pembayaran','APIController@konfirmasiPembayaran');