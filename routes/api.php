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
