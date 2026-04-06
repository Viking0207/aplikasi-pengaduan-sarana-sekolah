<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Siswa;

class siswaController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $dataSiswa = Siswa::all();
        return view('Admin.buatSiswa', compact('dataSiswa'));
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        return view('siswa.loginSiswa');
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|regex:/^[0-9]+$/|digits:9|unique:siswa,nis',
            'kelas' => 'required',
        ], [ 
            'nis.digits' => 'NIS harus terdiri dari 9 digit angka.',
            'nis.regex' => 'NIS harus berupa angka.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'kelas.required' => 'Kelas harus diisi.',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('siswa.index')->with('inputSuccess', 'Data siswa berhasil ditambahkan.');
    }



    /* Show the form for editing the specified resource.*/
    
    public function edit(string $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        return view('Admin.editSiswa', compact('siswa'));
    }


    /* Update the specified resource in storage. */
    
    public function update(Request $request, string $nis)
    {
        $request->validate([
            'nis' => 'required','string','regex:/^[0-9]+$/','digits:9',Rule::unique('siswa', 'nis')->ignore($nis, 'nis'),
            'kelas' => 'required',
        ]);

        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $siswa->update([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
        ], [
            'nis.digits' => 'NIS harus terdiri dari 9 digit angka.',
            'nis.regex' => 'NIS harus berupa angka.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'kelas.required' => 'Kelas harus diisi.',
        ]);

        return redirect()->route('siswa.index')->with('editSuccess', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $siswa->delete();

        return redirect()->route('siswa.index')->with('siswaDeleted', 'Data siswa berhasil dihapus.');
    }
}
