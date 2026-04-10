<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
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
            'nama' => 'required|string|max:100',
            'kelas' => 'required',
            'pass_siswa' => 'required|string|max:8',
        ], [ 
            'nis.digits' => 'NIS harus terdiri dari 9 digit angka.',
            'nis.regex' => 'NIS harus berupa angka.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas harus diisi.',
            'password.required' => 'Password harus diisi.',
            'pass_siswa.max' => 'Password maksimal 8 karakter.',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'pass_siswa' => Hash::make($request->pass_siswa), 
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
            'nis' => 'required|string|regex:/^[0-9]+$/|digits:9|unique:siswa,nis,' . $nis . ',nis',
            'nama' => 'required|string|max:100',
            'kelas' => 'required',
            'password' => 'nullable|string|max:8',
        ], [ 
            'nis.digits' => 'NIS harus terdiri dari 9 digit angka.',
            'nis.regex' => 'NIS harus berupa angka.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas harus diisi.',
            'pass_siswa.max' => 'Password maksimal 8 karakter.',
        ]);

        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        
        $dataUpdate = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ];
        
        if ($request->filled('pass_siswa')) {
            $dataUpdate['pass_siswa'] = Hash::make($request->pass_siswa); 
        }
        
        $siswa->update($dataUpdate);

        return redirect()->route('siswa.index')->with('editSuccess', 'Data siswa berhasil diperbarui.');
    }

    /* Remove the specified resource from storage. */
    public function destroy(string $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $siswa->delete();

        return redirect()->route('siswa.index')->with('siswaDeleted', 'Data siswa berhasil dihapus.');
    }
}
