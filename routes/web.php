<?php

use Illuminate\Support\Facades\Route;

/* CONTROLLER */
use App\Http\Controllers\siswaController;
use App\Http\Controllers\siswaLogin;
use App\Http\Controllers\adminLogin;
use App\Http\Controllers\adminController;
use App\Http\Controllers\aspirasiControl;
use App\Http\Controllers\forumAspirasi;
use App\Http\Controllers\kategoriContoller;
use App\Http\Controllers\laporanAdmin;
use App\Http\Controllers\rekapanController;
/* MODELS */
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
Route::get('/siswa/{nis}/edit', [siswaController::class, 'edit'])->name('siswa.edit');

/* CRUD ADMIN (ADMIN) */
Route::get('/admin', [adminController::class, 'index'])->name('admin.index');
Route::get('/admin/create', [adminController::class, 'create'])->name('admin.create');
Route::post('/admin', [adminController::class, 'store'])->name('admin.store');
Route::put('/admin/{id}/update', [adminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{id}', [adminController::class, 'destroy'])->name('admin.destroy');
Route::get('/admin/{id}/edit', [adminController::class, 'edit'])->name('admin.edit');

/* LOGIN SISWA */
Route::get('/login-siswa', [siswaLogin::class, 'index'])->name('loginSiswa');
Route::post('/siswa/login', [siswaLogin::class, 'login'])->name('siswa.login');
Route::post('/siswa/logout', [siswaLogin::class, 'logout'])->name('siswa.logout');

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
            
/* Data Aspirasi */
Route::get('/data-pengaduan', [aspirasiControl::class, 'index'])->name('aspirasi.index');
Route::put('/data-pengaduan/{id}/update', [aspirasiControl::class, 'update'])->name('aspirasi.update');
Route::delete('/data-pengaduan/{id}', [aspirasiControl::class, 'destroy'])->name('aspirasi.destroy');
Route::get('/data-pengaduan/{id}/edit', [aspirasiControl::class, 'edit'])->name('aspirasi.edit');
// ✅ Route untuk edit berdasarkan id_pelaporan (PASTI UNIK)
Route::get('/data-pengaduan/pelaporan/{id}', [aspirasiControl::class, 'editByPelaporan'])->name('aspirasi.edit.pelaporan');

// ✅ Route untuk edit berdasarkan id_aspirasi
Route::get('/data-pengaduan/aspirasi/{id}', [aspirasiControl::class, 'editByAspirasi'])->name('aspirasi.edit.aspirasi');

/* Kategori */
Route::get('/kategori', [kategoriContoller::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [kategoriContoller::class, 'create'])->name('kategori.create');
Route::post('/kategori', [kategoriContoller::class, 'store'])->name('kategori.store');
Route::delete('/kategori/{id}', [kategoriContoller::class, 'destroy'])->name('kategori.destroy');
Route::get('/kategori/search', [kategoriContoller::class, 'search'])->name('kategori.search');

/* Histori Admin */
Route::get('/Laporan', [laporanAdmin::class, 'index'])->name('laporan.index');

/* Input Aspirasi Siswa */
Route::get('/home-siswa', [forumAspirasi::class, 'index'])->name('forum.index');
Route::post('/aspirasi', [forumAspirasi::class, 'store'])->name('forum.store');
Route::get('/aspirasi/{id}/edit', [forumAspirasi::class, 'edit'])->name('forum.edit');
Route::put('/aspirasi/{id}', [forumAspirasi::class, 'update'])->name('forum.update');
Route::delete('/aspirasi/{id}', [forumAspirasi::class, 'destroy'])->name('forum.destroy');

/* Rekapan histori (admin) */
Route::prefix('admin')->group(function () {
    Route::get('/laporan', [rekapanController::class, 'index'])->name('rekapan.index');
    Route::get('/laporan/filter', [rekapanController::class, 'filter'])->name('rekapan.filter');
    Route::get('/laporan/export', [rekapanController::class, 'export'])->name('rekapan.export');
});









/* jaga jaga kalo error */
// Route::get('/home-siswa', function () {
//     dd([
//         'session_siswa_nis' => session('siswa_nis'),
//         'siswa_data' => Siswa::where('nis', session('siswa_nis'))->first(),
//     ]);
// })->name('siswa.homeSiswa');