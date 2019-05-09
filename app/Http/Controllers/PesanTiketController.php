<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PesanTiketController extends Controller
{
    public function index(){
    	return view('pesan-tiket');
    }

    public function tambah(Request $request)
    {
        #Menggabungkan nama
        $nama_awal = $request->nama_depan;
        $nama_belakang = $request->nama_belakang;
        $nama = $nama_awal . " " . $nama_belakang;
        
        do {
            #Generate kode_pembayaran
            $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $max = mb_strlen($keyspace, '8bit') - 1;
            $kode_pembayaran = $keyspace[random_int(0, $max)];
            
            for ($i = 0; $i < 5; ++$i) {
                $kode_pembayaran .= $keyspace[random_int(0, $max)];
            }

            #Generate kode
            $keyspace = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $max = mb_strlen($keyspace, '8bit') - 1;
            $kode = $keyspace[random_int(0, $max)];
            $kode .= $keyspace[random_int(0, $max)];

            $status_kode_pembayaran = DB::table('tiket')
                ->select('kode_pembayaran')
                ->where('kode_pembayaran', '=', $kode_pembayaran)
                ->count();

            $status_kode = DB::table('tiket')
                ->select('kode')
                ->where('kode', '=', $kode)
                ->count();
            
        } while(($status_kode_pembayaran > 0) && ($status_kode > 0));

        DB::table('tiket')->insert([
            'kode' => $kode,
            'nama' => $nama,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'jumlah_tiket' => $request->jumlah_tiket,
            'jenis_tiket' => $request->jenis_tiket,
            'undangan' => 'False',
            'kode_pembayaran' => $kode_pembayaran,
            'kode_penyanyi' => $request->penyanyi
        ]);

        return redirect('/');
    }
}