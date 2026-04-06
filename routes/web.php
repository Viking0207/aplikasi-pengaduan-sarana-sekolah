<?php

use Illuminate\Support\Facades\Route;

/* CONTROLLER */
use App\Http\Controllers\siswaController;
use App\Http\Controllers\siswaLogin;
use App\Http\Controllers\adminLogin;

/* MODELS */
use App\Models\Siswa;
use App\Models\Admin;

Route::get('/', function () {
    return view('home');
});


/* CRUD SISWA (ADMIN) */
Route::get('/siswa', [siswaController::class, 'index'])->name('siswa.index');
Route::get('/siswa/create', [siswaController::class, 'create'])->name('siswa.create');
Route::post('/siswa', [siswaController::class, 'store'])->name('siswa.store');
Route::put('/siswa/{nis}/update', [siswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{nis}', [siswaController::class, 'destroy'])->name('siswa.destroy');

/* EDIT CRUD SISWA (ADMIN) */
Route::get('/siswa/{nis}/edit', [siswaController::class, 'edit'])->name('siswa.edit');



/* LOGIN SISWA */
Route::get('/login-siswa', [siswaLogin::class, 'index'])->name('loginSiswa');
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

/* LOGIN ADMIN */
Route::get('/login-admin', [adminLogin::class, 'index'])->name('loginAdmin');
Route::post('/admin/login', [adminLogin::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [adminLogin::class, 'logout'])->name('admin.logout');
Route::get('/home-admin', function () {
    if (!session('admin_username')) {
        return 'Belum login';
    }

    $dataAdmin = Admin::where('username', session('admin_username'))->first();

    if (!$dataAdmin) {
        return 'Data admin tidak ditemukan';
    }

    return view('Admin.homeAdmin', compact('dataAdmin'));
})->name('admin.homeAdmin');



















/* jaga jaga kalo error */
// Route::get('/home-siswa', function () {
//     dd([
//         'session_siswa_nis' => session('siswa_nis'),
//         'siswa_data' => Siswa::where('nis', session('siswa_nis'))->first(),
//     ]);
// })->name('siswa.homeSiswa');