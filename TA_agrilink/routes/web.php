<?php

use App\Http\Controllers\AgrilinkController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman PUBLIK (tanpa login)
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/agrilink')->name('home');
Route::get('/agrilink', [AgrilinkController::class, 'index'])->name('agrilink.index');

/*
|--------------------------------------------------------------------------
| Halaman TAMU saja (middleware guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])
        ->middleware('throttle:10,1')
        ->name('login.authenticate');
});

/*
|--------------------------------------------------------------------------
| Halaman TERPROTEKSI (middleware auth)
|--------------------------------------------------------------------------
| Wajib login: tambah produk, daftar petani, profil, logout.
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');

    Route::post('/agrilink/simpan', [AgrilinkController::class, 'store'])->name('agrilink.store');
    Route::get('/agrilink/petani', [AgrilinkController::class, 'petani'])->name('agrilink.petani');
});
