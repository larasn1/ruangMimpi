<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('pesan-tiket', 'PesanTiketController@index');
Route::post('/pesan-tiket/tambah','PesanTiketController@tambah');
Route::get('unggah-pembayaran','UnggahPembayaranController@index');
Route::post('/unggah-pembayaran/unggah','UnggahPembayaranController@unggahBuktiPembayaran');
Route::get('verifikasi-pembayaran','VerifikasiPembayaranController@index');
Route::get('/verifikasi-pembayaran/gantiStatus/{kode}','VerifikasiPembayaranController@gantiStatus');

Auth::routes([
    
]);

Route::get('/home', 'HomeController@index')->name('home');
