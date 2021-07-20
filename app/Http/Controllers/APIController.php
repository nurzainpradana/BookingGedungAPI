<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    /* Registrasi Akun Baru */
    public function registrasiAkun(Request $req) {
        $nama = $req->nama;
        $username = $req->username;
        $email = $req->email;
        $password = md5($req->password);
        $no_hp = $req->no_hp;
        $jenis_kelamin = $req->jenis_kelamin;
        $alamat = $req->alamat;
        $tipe_user = $req->tipe_user;

        // Check Username apakah sudah terdaftar atau belum
        $check_username = DB::table('tb_user')->where('username', $username)->count();
        if ($check_username == 0 ) {
            if($tipe_user == 'customer') {
                $users_query = DB::table('tb_user')->insert([
                    'nama' => $nama,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'no_hp' => $no_hp,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'tipe_user' => $tipe_user,
                    'flag' => 1
                ]);
            } else if ($tipe_user == 'pemilik'){
    
                $no_rek = $req->no_rekening;
                $nama_bank = $req->nama_bank;
                $nama_rekening = $req->nama_pemilik;
                
                $users_query = DB::table('tb_user')->insert([
                    'nama' => $nama,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'no_hp' => $no_hp,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat' => $alamat,
                    'tipe_user' => $tipe_user,
                    'flag' => 1,
                    'no_rekening' => $no_rek,
                    'nama_bank' => $nama_bank,
                    'nama_pemilik' => $nama_rekening
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed',
                    'code' => 404
                ]);
            }
    
            if ($users_query) {
                return response()->json([
                    'message' => 'success',
                    'code' => 200
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Username Already Registered',
                'code' => 202
            ]);
        }

        
    }
}
