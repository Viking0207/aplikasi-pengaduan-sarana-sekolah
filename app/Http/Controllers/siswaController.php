<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class siswaController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $dataSiswa = Siswa::all();
        return view('siswa.loginSiswa', compact('dataSiswa'));
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
            'nis' => 'required|string|regex:/^[0-9]+$/|max:20|unique:siswa,nis',
            'kelas' => 'required',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }



    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
        //
    // }


    /* Update the specified resource in storage. */
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $id,
            'kelas' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
