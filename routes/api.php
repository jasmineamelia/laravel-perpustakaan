<?php

use App\Http\Controllers\bukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\SiswaController;
use App\http\Controllers\bukuControllerController;
use App\Http\Controllers\peminjamanController;
use App\Http\Controllers\pengembalianController;
use App\Http\Controllers\userrController;
use App\Http\Controllers\registerController;
use App\Models\siswa;

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

Route::post('/siswa', [SiswaController::class, 'createsiswa']);
Route::put('/updatesiswa/{id}', [SiswaController::class,'updatesiswa']);
Route::get('/Siswa/{id}', 'App\Http\Controllers\SiswaController@getSiswaById');
Route::delete('/deletesiswa/{id}', 'App\Http\Controllers\SiswaController@deleteSiswa');
Route::get('/allsiswa', [SiswaController::class, 'getAllSiswa']);

Route::post('/createbuku', [bukuController::class,'createbuku']);
Route::get('/buku/{id_buku}', 'App\Http\Controllers\bukuController@getbukuById');
Route::get('/all', [bukuController::class, 'getAllbuku']);
Route::put('/updatebuku/{id_buku}', [bukuController::class,'updatebuku']);
Route::delete('/deletebuku/{id}', 'App\Http\Controllers\bukuController@deletebuku');
Route::post('/peminjaman', [PeminjamanController::class, 'store']);
Route::post('/allpeminjaman', [PeminjamanController::class, 'store']);
Route::get('/allpeminjaman', [PeminjamanController::class, 'index']);  // Menampilkan semua peminjaman
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);  // Menampilkan peminjaman berdasarkan ID

Route::get('/pengembalian/{id}', [pengembalianController::class, 'pengembalian']); // API untuk mengembalikan buku
Route::get('/pengembalian', [pengembalianController::class, 'getALLpengembalian']); // API untuk mendapatkan semua pengembalian
Route::get('/pengembalian/detail/{id}', [pengembalianController::class, 'getpengembalianByid']); // API untuk mendapatkan pengembalian berdasarkan ID




Route::post('/createuserr', [userrController::class, 'createuser']);
Route::get('/userr/{id}', 'App\Http\Controllers\userrController@getuserrById');
Route::get('/userrAll', 'App\Http\Controllers\userrController@userrAll');
Route::put('/updateuserr/{id}', [userrController::class,'updateuserr']);
Route::delete('/deleteuserr/{id}', [userrController::class,'deleteuserr']);

// Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

// Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
// Route::middleware('auth:api')->get('/User', function (Request $request) {
//     return $request->User();
// });