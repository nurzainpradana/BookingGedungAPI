<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    /* Registrasi Akun Baru */
    public function registrasiAkun(Request $req)
    {
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
        if ($check_username == 0) {
            if ($tipe_user == 'customer') {
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
            } else if ($tipe_user == 'pemilik') {

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
                    'message' => 'Failed when insert data',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }

            if ($users_query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Username Already Registered',
                'status' => 'failed',
                'code' => 202
            ]);
        }
    }

    /* Check Login */
    public function checkLogin(Request $req)
    {
        $username = $req->username;
        $password = md5($req->password);
        $tipe_user = $req->tipe_user;

        $checkLogin = DB::table('tb_user')
            ->where('username', $username)
            ->where('password', $password)
            ->where('tipe_user', $tipe_user);

        if ($checkLogin->count() == 0) {
            return response()->json([
                'message' => 'Username / Password Salah',
                'status' => 'failed',
                'code' => 202
            ]);
        } else {
            return response()->json([
                'message' => 'Login Berhasil',
                'status' => 'success',
                'code' => 200
                // OK
            ]);
        }
    }

    /* Upload Photo */
    public function uploadPhoto(Request $req)
    {

        //get image string posted from android app
        $imgPath = $req->imgPath;

        //get file name posted from android app
        $imgName = $req->imgName;

        // $img = Image::make($imgPath)->fit(300);

        // //Decode Image
        $binary = base64_decode($imgPath);

        header('Content-Type: bitmap; charset=utf-8');

        // //images will be saved under folder img
        $file = fopen(public_path("photo_upload/" . $imgName), 'wb');

        fwrite($file, $binary);
        fclose($file);

        if ($file != null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Succes Upload Photo',
                'code' => 200
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed When Upload Photo',
                'code' => 404
            ]);
        }
    }

    /* Registrasi Akun Baru */
    public function buatGedungBaru(Request $req)
    {
        $nama               = $req->nama;
        $gambar             = $req->gambar;
        $kapasitas          = $req->kapasitas;
        $fasilitas          = $req->fasilitas;
        $jam_operasional    = $req->jam_operasional;
        $maps               = $req->maps;
        $harga              = $req->harga;
        $pemilik            = $req->pemilik;

        // Check Username apakah sudah terdaftar atau belum
        $check_name = DB::table('tb_gedung')->where('nama', $nama)->count();
        if ($check_name == 0) {
            $query = DB::table('tb_gedung')->insert([
                'nama' => $nama,
                'gambar' => $gambar,
                'kapasitas' => $kapasitas,
                'fasilitas' => $fasilitas,
                'jam_operasional' => $jam_operasional,
                'maps' => $maps,
                'harga' => $harga,
                'pemilik' => $pemilik
            ]);

            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Nama Gedung Already Registered',
                'status' => 'failed',
                'code' => 202
            ]);
        }
    }

    // GET GEDUNG LIST PEMILIK

    public function getGedungListPemilik(Request $req) {
        $pemilik = $req->pemilik;

        if($pemilik != "") {
            $query = DB::table('tb_gedung')
            ->select(DB::Raw('id, nama, gambar, kapasitas, rating, harga'))
            ->where('pemilik', $pemilik)
            ->where('flag', 1)
            ->get();
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'listGedung' => $query
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'data tidak ditemukan',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 'failed',
                'code' => 202
            ]);
        }
    }

    public function getGedungListPemilikFilter(Request $req) {
        // enable query log
        DB::enableQueryLog();

        $pemilik = $req->pemilik;
        $filter_by = $req->filterBy;
        

        if($pemilik != "") {

            $whereQuery = "";

            switch ($filter_by) {
                case "Harga < 3 Jt" : {
                    $whereQuery = "`harga` <= 3000000";
                    break;
                }
                case "Harga > 3 Jt" : {
                    $whereQuery = "`harga` >= 3000000";
                    break;
                }
                case "Kapasitas > 500" : {
                    $whereQuery = "`kapasitas` >= 500";
                    break;
                }
                case "Kapasitas < 500" : {
                    $whereQuery = "`kapasitas` <= 500";
                    break;
                }
            }

            $query = DB::table('tb_gedung')
            ->select(DB::Raw('id, nama, gambar, kapasitas, rating, harga'))
            ->whereRaw($whereQuery . " && `pemilik` = '" . $pemilik . "' && `flag` = 1")
            // ->where('pemilik', $pemilik)
            // ->where('flag', 1)
            ->get();

            // display log query
            // dd(DB::getQueryLog());
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'listGedung' => $query,
                    'rawQuery' => $whereQuery,
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'data tidak ditemukan',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 'failed',
                'code' => 202
            ]);
        }

        
    }

    
    // GET GEDUNG LIST CUSTOMER

    public function getGedungListCustomer() {
        $query = DB::table('tb_gedung')
            ->select(DB::Raw('id, nama, gambar, kapasitas, rating, harga'))
            ->where('flag', 1)
            ->get();
    
        if ($query) {
            return response()->json([
                'message' => 'success',
                'status' => 'success',
                'code' => 200,
                'listGedung' => $query
                    // 200 OK
            ]);
        } else {
            return response()->json([
                'message' => 'data tidak ditemukan',
                'status' => 'failed',
                'code' => 404
            ]);
        }
    }

    public function getGedungListCustomerFilter(Request $req) {
        // enable query log
        // DB::enableQueryLog();

        $filter_by = $req->filterBy;
        

        $whereQuery = "";

            switch ($filter_by) {
                case "Harga < 3 Jt" : {
                    $whereQuery = "`harga` <= 3000000";
                    break;
                }
                case "Harga > 3 Jt" : {
                    $whereQuery = "`harga` >= 3000000";
                    break;
                }
                case "Kapasitas > 500" : {
                    $whereQuery = "`kapasitas` >= 500";
                    break;
                }
                case "Kapasitas < 500" : {
                    $whereQuery = "`kapasitas` <= 500";
                    break;
                }
            }

            $query = DB::table('tb_gedung')
            ->select(DB::Raw('id, nama, gambar, kapasitas, rating, harga'))
            ->whereRaw($whereQuery . " && `flag` = 1")
            // ->where('pemilik', $pemilik)
            // ->where('flag', 1)
            ->get();

            // display log query
            // dd(DB::getQueryLog());
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'listGedung' => $query,
                    'rawQuery' => $whereQuery,
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'data tidak ditemukan',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
    }

    // GET GEDUNG DETAIL

    public function getGedungDetail(Request $req) {
        $idGedung = $req->idGedung;

        if($idGedung != "") {
            $query = DB::table('tb_gedung')
            ->where('id', $idGedung)
            ->first();
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'gedungDetail' => $query
                    // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'data tidak ditemukan',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 'failed',
                'code' => 202
            ]);
        }
    }

    public function checkBooking(Request $req) {
        $id_gedung = $req->id_gedung;
        $tgl_sewa = $req->tgl_sewa;

        $query = DB::table('tb_booking')
            ->where('tanggal_sewa', $tgl_sewa)
            ->where('id_gedung', $id_gedung)
            ->get('jam_sewa');

        $query2 = DB::table('tb_gedung')
            ->where('id', $id_gedung)
            ->first('jam_operasional');

        $jam_sudah_booking = "";
        foreach($query as $item) {
            if($jam_sudah_booking == ""){
                $jam_sudah_booking = $jam_sudah_booking . $item->jam_sewa;
            } else {
                $jam_sudah_booking = $jam_sudah_booking . ", " . $item->jam_sewa;
            }
            
        }

        $data = array (
            'jam_sudah_booking' => $jam_sudah_booking,
            'jam_operasional' => $query2->jam_operasional
        );

        // echo $jam_sudah_booking;

        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $data,
            'code' => 202
        ]);

            
    }
}
