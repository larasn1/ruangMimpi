<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UnggahPembayaranController extends Controller
{
    public function index(){
    	return view('unggah-pembayaran');
    }

    public function cekKodePembayaran(Request $request){
        $kodePembayaran = $request->kode_pembayaran;
        $statusKodePembayaran = DB::table('tiket')
            ->select('kode_pembayaran')
            ->where('kode_pembayaran', '=', $kodePembayaran)
            ->count();

        if($statusKodePembayaran == 1) {
            $status = TRUE;
        } else {
            $status = FALSE;
        }

        return $status;
    }

    public function unggahBuktiPembayaran(Request $request) {
        // $status = $this->cekKodePembayaran($request);

            $this->validate($request, [
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $uploadedFile = $request->file('bukti_pembayaran');

            $path = $uploadedFile->store('public/images');

            $destinationPath = public_path('/images');
            $uploadedFile->move($destinationPath, $path);

            DB::table('bukti')->insert([
                'kode' => $request->kode_pembayaran,
                'verifikasi' => 'belum',
                'gambar' => $path
            ]);

        

        return redirect('/');
    }

}