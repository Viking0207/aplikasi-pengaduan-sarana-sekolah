<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Siswa;

class aspirasiControl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ✅ Cara terbaik: Langsung pakai relasi dari InputAspirasi
        $dataInput = InputAspirasi::with(['aspirasi', 'kategori', 'siswa'])->get();
        
        $dataFinal = [];
        
        foreach ($dataInput as $input) {
            $dataFinal[] = [
                'input' => $input,
                'aspirasi' => $input->aspirasi,  // dari relasi
                'kategori' => $input->kategori,  // dari relasi
                'siswa' => $input->siswa,        // dari relasi
            ];
        }
        
        // Alternative: Kalau dataFinal langsung bisa pakai $dataInput
        // $dataFinal = $dataInput;
        
        return view('Admin.dataPengaduan', compact('dataFinal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('Admin.tambahPengaduan', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,nis',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi' => 'required|string',
            'ket' => 'required|string',
            'status' => 'required|in:menunggu,proses,selesai,ditolak',
        ]);

        // Simpan ke InputAspirasi
        $input = InputAspirasi::create([
            'nis' => $request->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
        ]);

        // Simpan ke Aspirasi
        Aspirasi::create([
            'id_pelaporan' => $input->id_pelaporan,
            'id_kategori' => $request->id_kategori,
            'status' => $request->status,
            'feedback' => $request->feedback ?? null,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Data pengaduan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $input = InputAspirasi::where('id_pelaporan', $id)->first();
        $siswa = $input ? Siswa::where('nis', $input->nis)->first() : null;
        $kategori = Kategori::find($aspirasi->id_kategori);
        
        return view('Admin.lihatDataPengaduan', compact('aspirasi', 'input', 'siswa', 'kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data dari InputAspirasi berdasarkan id_pelaporan
        $input = InputAspirasi::with(['aspirasi', 'kategori', 'siswa'])
            ->where('id_pelaporan', $id)
            ->first();
        
        if (!$input) {
            return redirect()->route('aspirasi.index')->with('error', 'Data tidak ditemukan');
        }
        
        $aspirasi = $input->aspirasi;
        $siswa = $input->siswa;
        $kategori = Kategori::all(); // Ini untuk pilihan kategori di form (jika perlu edit kategori)
        $kategoriTerpilih = $input->kategori; // Ini kategori yang dipilih
        
        return view('Admin.lihatDataPengaduan', compact('input', 'aspirasi', 'siswa', 'kategori', 'kategoriTerpilih'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,ditolak',
            'feedback' => 'nullable|string',
        ]);

        // Cari aspirasi berdasarkan id_aspirasi atau id_pelaporan
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->orWhere('id_pelaporan', $id)->first();
        
        if (!$aspirasi) {
            return redirect()->route('aspirasi.index')->with('error', 'Data tidak ditemukan');
        }

        // Update aspirasi
        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Status dan feedback berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data berdasarkan id_pelaporan
        $input = InputAspirasi::where('id_pelaporan', $id)->first();
        
        if ($input) {
            // Hapus aspirasi terkait dulu
            if ($input->aspirasi) {
                $input->aspirasi->delete();
            }
            // Hapus input aspirasi
            $input->delete();
        } else {
            // Kalau tidak ditemukan di InputAspirasi, coba hapus langsung dari Aspirasi
            $aspirasi = Aspirasi::where('id_pelaporan', $id)->first();
            if ($aspirasi) {
                $aspirasi->delete();
            }
        }

        return redirect()->route('aspirasi.index')->with('aspiDeleted', 'Data pengaduan berhasil dihapus.');
    }
}