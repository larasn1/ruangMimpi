<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VerifikasiPembayaranController extends Controller
{
    public function index(){

        $data = DB::table('bukti')
            ->join('tiket','bukti.kode','=','tiket.kode_pembayaran')
            ->select('bukti.*','tiket.nama')
            ->get();
    	return view('verifikasi-pembayaran',['data' => $data]);
    }

    public function gantiStatus($kode){
        DB::table('bukti')
            ->where('kode',$kode)
            ->update(['verifikasi' => 'sudah']);

        return redirect('verifikasi-pembayaran');
    }

}