<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\siswaController;
use App\Http\Controllers\siswaLogin;
use App\Models\Siswa;

Route::get('/', function () {
    return view('home');
});

Route::get('/login-siswa', [siswaController::class, 'index'])->name('loginSiswa');
Route::get('/siswa/create', [siswaController::class, 'create'])->name('siswa.create');
Route::post('/siswa', [siswaController::class, 'store'])->name('siswa.store');
Route::put('/siswa/{id}', [siswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{id}', [siswaController::class, 'destroy'])->name('siswa.destroy');

Route::post('/siswa/login', [siswaLogin::class, 'login'])->name('siswa.login');
Route::post('/siswa/logout', [siswaLogin::class, 'logout'])->name('siswa.logout');

Route::get('/home-siswa', function () {
    if (!session('siswa_nis')) {
        return 'Belum login';
    }

    $dataSiswa = Siswa::where('nis', session('siswa_nis'))->first();

    if (!$dataSiswa) {
        return 'Data siswa tidak ditemukan';
    }

    return view('siswa.homeSiswa', compact('dataSiswa'));
})->name('siswa.homeSiswa');

// Route::get('/home-siswa', function () {
//     dd([
//         'session_siswa_nis' => session('siswa_nis'),
//         'siswa_data' => Siswa::where('nis', session('siswa_nis'))->first(),
//     ]);
// })->name('siswa.homeSiswa');