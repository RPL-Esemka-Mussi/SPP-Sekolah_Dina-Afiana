<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SPPController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

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


//Route Group Guest
Route::group(['middleware' => 'guest'], function () {
    // Route Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [LoginController::class, 'register']);
});


Route::get('/dashboard', [PageController::class, 'index']);


//Route Register
Route::post('/register', [RegisterController::class, 'store']);


// Mid Siswa + Admin + Petugas
Route::group(['middleware' => 'auth'], function () {
    // Home Auth + Logout
    Route::get('/', [LoginController::class, 'index']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/pembayaran/transaksi/{id}', [PembayaranController::class, 'transaksi']);
});

// Mid Petugas + Admin
Route::group(['middleware' =>  'level:admin,petugas,siswa', 'auth'], function () {
    // Route Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index']);
    Route::post('/pembayaran/simpan', [PembayaranController::class, 'simpan']);
    Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit']);
    Route::post('/pembayaran/update', [PembayaranController::class, 'update']);
    Route::get('/pembayaran/hapus/{id}', [PembayaranController::class, 'hapus']);
    Route::get('/pembayaran/cetak', [pembayaranController::class, 'cetak']);
    Route::get('/pembayaran/cetak/{id}', [pembayaranController::class, 'cetakid']);
    Route::get('/pembayaran/history/{id}', [PembayaranController::class, 'history']);

});

// Mid Admin Only
Route::group(['middleware' => 'level:admin', 'auth'], function () {
    // Route User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'tambah']);
    Route::post('/user/simpan', [UserController::class, 'simpan']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

    // Route Kelas
    Route::get('/kelas', [KelasController::class, 'index']);
    Route::get('/kelas/tambah', [KelasController::class, 'tambah']);
    Route::post('/kelas/simpan', [KelasController::class, 'simpan']);
    Route::get('/kelas/edit/{id}', [KelasController::class, 'edit']);
    Route::post('/kelas/update', [KelasController::class, 'update']);
    Route::get('/kelas/hapus/{id}', [KelasController::class, 'hapus']);

    // Route SPP
    Route::get('/spp', [SPPController::class, 'index']);
    Route::get('/spp/tambah', [SPPController::class, 'tambah']);
    Route::post('/spp/simpan', [SPPController::class, 'simpan']);
    Route::get('/spp/edit/{id}', [SPPController::class, 'edit']);
    Route::post('/spp/update', [SPPController::class, 'update']);
    Route::get('/spp/hapus/{id}', [SPPController::class, 'hapus']);

    // Route Siswa
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/tambah', [SiswaController::class, 'tambah']);
    Route::post('/siswa/simpan', [SiswaController::class, 'simpan']);
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit']);
    Route::post('/siswa/update', [SiswaController::class, 'update']);
    Route::get('/siswa/hapus/{id}', [SiswaController::class, 'hapus']);
});
