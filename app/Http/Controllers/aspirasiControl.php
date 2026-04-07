<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Siswa;

class aspirasiControl extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $dataAspirasi = Aspirasi::all();
        $dataFinal = [];

        foreach ($dataAspirasi as $aspirasi) {
            
            $input = InputAspirasi::where('id_pelaporan', $aspirasi->id_aspirasi)->first();

            $siswa = $input ? Siswa::where('nis', $input->nis)->first() : null;

            $kategori = Kategori::where('id_kategori', $aspirasi->id_kategori)->first();

            $dataFinal[] = [
                'aspirasi' => $aspirasi,
                'input' => $input,
                'siswa' => $siswa,
                'kategori' => $kategori,
            ];
        }

    
        return view('Admin.dataPengaduan', compact('dataFinal'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Admin.dataPengaduan', compact('aspirasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        // $aspirasi = Aspirasi::findOrFail($id);
        // return view('Admin.lihatDataPengaduan', compact('aspirasi'));
    }

    /* Show the form for editing the specified resource. */
    public function edit(string $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $input = InputAspirasi::where('id_pelaporan', $id)->first();
        $kategori = Kategori::where('id_kategori', $id)->first();
        $siswa = null;
        if ($input) {
            $siswa = Siswa::where('nis', $input->nis)->first();
        }

        return view('Admin.lihatDataPengaduan', compact('aspirasi','input','siswa','kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aspirasi = Aspirasi::firstOrFail();
        $aspirasi->delete();

        return redirect()->route('aspirasi.index')->with('aspiDeleted', 'Data siswa berhasil dihapus.');
    }
}
