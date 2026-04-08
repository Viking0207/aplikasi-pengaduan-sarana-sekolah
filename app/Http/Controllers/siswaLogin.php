<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class siswaLogin extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $dataSiswa = Siswa::all();
        return view('siswa.loginSiswa', compact('dataSiswa'));
    }

    /* Display the specified resource. */

    public function showForm()
    {
        // Logika untuk menampilkan form login siswa
        return view('siswa.loginSiswa');
    }

    /* fungsi login */ 

    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|regex:/^[0-9]+$/|max:20',
        ]);

        $siswa = Siswa::where('nis', $request->nis)->first();

        if (!$siswa) {
            return redirect()->route('loginSiswa')->with('errorNIS', 'NIS-mu gak ketemu bos!');
        }

        session([
            'siswa_nis' => $siswa->nis,
            'siswa_kelas' => $siswa->kelas
            ]);

        return redirect()->route('forum.index')->with('success', 'Selamat datang bos!.');
    }

    public function logout()
    {
        // Logika untuk logout siswa
        return redirect()->route('loginSiswa')->with('success', 'Logout berhasil.');
    }
}
