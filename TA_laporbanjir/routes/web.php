<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporBanjirController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman PUBLIK (tanpa login)
|--------------------------------------------------------------------------
| Warga tetap dapat mengirim laporan banjir tanpa harus punya akun.
*/
Route::redirect('/', '/lapor')->name('home');

Route::get('/lapor', [LaporBanjirController::class, 'create'])->name('laporan.create');
Route::post('/lapor', [LaporBanjirController::class, 'store'])->name('laporan.store');

// URL lama dari Modul 4 dialihkan ke halaman baru.
Route::redirect('/form', '/lapor');
Route::redirect('/daftar-laporan', '/laporan'); // tetap dilindungi auth di bawah

/*
|--------------------------------------------------------------------------
| Halaman TAMU saja (middleware guest)
|--------------------------------------------------------------------------
| Jika sudah login, pengguna dialihkan ke daftar laporan.
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
| Hanya petugas yang sudah login. Tamu otomatis diarahkan ke /login.
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // LaporBanjir: pengelolaan laporan
    Route::get('/laporan', [LaporBanjirController::class, 'index'])->name('laporan.index');
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');

});
