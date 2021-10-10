<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    /* Registrasi Akun Baru */
    public function registrasiAkun(Request $req)
    {
        $nama           = $req->name;
        $username       = $req->username;
        $email          = $req->email;
        $password       = md5($req->password);
        $no_hp          = $req->no_hp;
        $jenis_kelamin  = $req->jenis_kelamin;
        $alamat         = $req->alamat;
        $tipe_user      = $req->tipe_user;
        $tanggal= date("Y-m-d H:i:s");

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
                    'flag' => 1,
                    'created_date'=>$tanggal
                ]);
            } else if ($tipe_user == 'pemilik') {

                $no_rek         = $req->no_rek;
                $nama_bank      = $req->nama_bank;
                $nama_rekening  = $req->nama_pemilik;

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
                    'nama_pemilik' => $nama_rekening,
                    'created_date'  =>  $tanggal
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

    /* Update Akun */
    public function updateAkun(Request $req)
    {
        $nama           = $req->name;
        $username       = $req->username;
        $email          = $req->email;
        $password       = md5($req->password);
        $no_hp          = $req->no_hp;
        $jenis_kelamin  = $req->jenis_kelamin;
        $alamat         = $req->alamat;
        $tipe_user      = $req->tipe_user;
        $tanggal        = date("Y-m-d H:i:s");
        $id             = $req->id;

        // Check Username apakah sudah terdaftar atau belum
            if ($tipe_user == 'customer') {
                if ($password != "" || $password != null) {
                    $users_query = DB::table('tb_user')
                    ->where('username', $username)
                    ->update([
                        'nama' => $nama,
                        'email' => $email,
                        'password' => $password,
                        'no_hp' => $no_hp,
                        'jenis_kelamin' => $jenis_kelamin,
                        'alamat' => $alamat,
                        'tipe_user' => $tipe_user,
                        'flag' => 1,
                        'created_date'=>$tanggal
                    ]);
                } else {
                    $users_query = DB::table('tb_user')
                    ->where('username', $username)
                    ->update([
                        'nama' => $nama,
                        'email' => $email,
                        'no_hp' => $no_hp,
                        'jenis_kelamin' => $jenis_kelamin,
                        'alamat' => $alamat,
                        'tipe_user' => $tipe_user,
                        'flag' => 1,
                        'created_date'=>$tanggal
                    ]);
                }
                
            } else if ($tipe_user == 'pemilik') {

                $no_rek         = $req->no_rek;
                $nama_bank      = $req->nama_bank;
                $nama_rekening  = $req->nama_pemilik;

                
                if ($password != "" || $password != null) 
                {
                    $users_query = DB::table('tb_user')
                    ->where('username', $username)
                    ->update([
                        'nama' => $nama,
                        'email' => $email,
                        'password' => $password,
                        'no_hp' => $no_hp,
                        'jenis_kelamin' => $jenis_kelamin,
                        'alamat' => $alamat,
                        'tipe_user' => $tipe_user,
                        'flag' => 1,
                        'no_rekening' => $no_rek,
                        'nama_bank' => $nama_bank,
                        'nama_pemilik' => $nama_rekening,
                        'created_date'  =>  $tanggal
                    ]);
                } else {
                    $users_query = DB::table('tb_user')
                    ->where('username', $username)
                    ->update([
                        'nama' => $nama,
                        'email' => $email,
                        'no_hp' => $no_hp,
                        'jenis_kelamin' => $jenis_kelamin,
                        'alamat' => $alamat,
                        'tipe_user' => $tipe_user,
                        'flag' => 1,
                        'no_rekening' => $no_rek,
                        'nama_bank' => $nama_bank,
                        'nama_pemilik' => $nama_rekening,
                        'created_date'  =>  $tanggal
                    ]);
                }

                
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
        $tanggal            = date("Y-m-d H:i:s");

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
                'pemilik' => $pemilik,
                'created_date'  =>$tanggal
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
            ->select(DB::Raw('id, nama, gambar, kapasitas, harga'))
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
            ->select(DB::Raw('id, nama, gambar, kapasitas, harga'))
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
            ->select(DB::Raw('id, nama, gambar, kapasitas, harga'))
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
            ->select(DB::Raw('id, nama, gambar, kapasitas, harga'))
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
            ->where('status', '!=', 'Batal')
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

    /* Registrasi Akun Baru */
    public function bookingGedung(Request $req)
    {
        $id_gedung          = $req->id_gedung;
        $username           = $req->username;
        $tanggal_booking    = $req->tanggal_booking;
        $tanggal_sewa       = $req->tanggal_sewa;
        $waktu_sewa         = $req->waktu_sewa;
        $biaya              = $req->biaya;
        $status             = "Menunggu Pembayaran";

        if ($id_gedung != null && $username != null) {
            $query = DB::table('tb_booking')->insert([
                'id_gedung'         => $id_gedung,
                'username'           => $username,
                'tanggal_booking'   => $tanggal_booking,
                'tanggal_sewa'      => $tanggal_sewa,
                'jam_sewa'        => $waktu_sewa,
                'biaya'             => $biaya,
                'status'            => $status
            ]);

            if ($query) {
                $query2 = DB::table('tb_booking')
                ->where('username', $username)
                ->where('id_gedung', $id_gedung)
                ->orderBy('id', 'DESC')
                ->first('id');

                if ($query2) {
                    return response()->json([
                        'message' => $query2->id,
                        'status' => 'success',
                        'code' => 200
                        // 200 OK
                    ]);
                } else {
                    return response()->json([
                        'message' => null,
                        'status' => 'success',
                        'code' => 200
                        // 200 OK
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Booking Failed',
                    'status' => 'failed',
                    'code' => 202
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Booking Failed',
                'status' => 'failed',
                'code' => 202
            ]);
        }
    }

    public function getBookingDetail(Request $req) {
        $idBooking = $req->idBooking;

        if($idBooking != "") {
            $query = DB::table('tb_booking AS B')
            ->selectRaw("B.id, G.nama as nama_gedung, P.nama_bank, P.no_rekening, P.nama_pemilik, C.nama as nama_customer, B.tanggal_sewa, B.jam_sewa, B.status")
            ->leftJoin("tb_gedung AS G", "G.id", "B.id_gedung")
            ->leftJoin("tb_user AS C", "C.username", "B.username")
            ->leftJoin("tb_user AS P", "P.username", "G.pemilik")
            ->where('B.id', $idBooking)
            ->first();
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'bookingDetail' => $query
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

    public function getAkunDetail(Request $req) {
        $username = $req->username;

        if($username != "") {
            $query = DB::table('tb_user')
            ->selectRaw('id, username, nama, email, password, no_hp, jenis_kelamin, alamat, tipe_user, no_rekening, nama_bank, nama_pemilik')
            ->where('username', $username)
            ->first();
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'akunDetail' => $query
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

    public function getRiwayatBookingCustomer(Request $req) 
    {
        $username = $req->username;

        if($username != "" || $username != null) {

            $query = DB::table('tb_booking as B')
            ->select(DB::Raw('B.id, G.nama as nama_gedung, C.nama as nama_customer, B.tanggal_sewa, B.status'))
            ->leftJoin("tb_gedung AS G", "G.id", "B.id_gedung")
            ->leftJoin("tb_user AS C", "C.username", "B.username")
            ->where('B.username', $username)
            ->get();
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'listRiwayatBooking' => $query
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
                'message' => 'Failed',
                'status' => 'failed',
                'code' => 404
            ]);
        }

        
    }

    public function getRiwayatBookingPemilik(Request $req) 
    {
        $username = $req->username;

        if($username != "" || $username != null) {

            $query = DB::table('tb_booking as B')
            ->select(DB::Raw('B.id, G.nama as nama_gedung, C.nama as nama_customer, B.tanggal_sewa, B.status'))
            ->leftJoin("tb_gedung AS G", "G.id", "B.id_gedung")
            ->leftJoin("tb_user AS C", "C.username", "B.username")
            ->where('G.pemilik', $username)
            ->orderBy('B.tanggal_sewa', 'DESC')
            ->get();
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200,
                    'listRiwayatBooking' => $query
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
                'message' => 'Failed',
                'status' => 'failed',
                'code' => 404
            ]);
        }

        
    }

    public function cancelBooking(Request $req) 
    {
        $idBooking = $req->id_booking;

        if($idBooking != "" || $idBooking != null) {

            $query = DB::table('tb_booking')
            ->where('id', $idBooking)
            ->update(
                ["status" => "Batal"]
            );
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200
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
                'message' => 'Failed',
                'status' => 'failed',
                'code' => 404
            ]);
        }
    }

    public function hapusGedung(Request $req) 
    {
        $idGedung = $req->id_gedung;

        if($idGedung != "" || $idGedung != null) {

            $query = DB::table('tb_gedung')
            ->where('id', $idGedung)
            ->update(
                ["flag" => "0"]
            );
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200
                        // 200 OK
                ]);
            } else {
                return response()->json([
                    'message' => 'data gagal dihapus',
                    'status' => 'failed',
                    'code' => 404
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 'failed',
                'code' => 404
            ]);
        }
    }

    public function konfirmasiPembayaran(Request $req) 
    {
        $idBooking = $req->id_booking;

        if($idBooking != "" || $idBooking != null) {

            $query = DB::table('tb_booking')
            ->where('id', $idBooking)
            ->update(
                ["status" => "Sudah Bayar"]
            );
    
            if ($query) {
                return response()->json([
                    'message' => 'success',
                    'status' => 'success',
                    'code' => 200
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
                'message' => 'Failed',
                'status' => 'failed',
                'code' => 404
            ]);
        }
    }
}
