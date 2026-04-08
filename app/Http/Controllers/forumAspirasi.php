<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Siswa;
use App\Models\Kategori;
use Illuminate\Http\Request;

class forumAspirasi extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        
        if (!session('siswa_nis')) {
            return 'Belum login';
        }
        
        $dataSiswa = Siswa::where('nis', session('siswa_nis'))->first();
        
        if (!$dataSiswa) {
            return 'Data siswa tidak ditemukan';
        }   

        $dataInput = InputAspirasi::with('aspirasi', 'kategori')
            ->where('nis', $dataSiswa->nis)
            ->orderBy('created_at', 'desc')  // urutkan dari terbaru
            ->get();
        
        $dataInput = $dataInput->sortByDesc('created_at');

        $kategori = Kategori::all();

        return view('siswa.homeSiswa', compact('dataInput', 'dataSiswa', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            $request->validate([
                'id_kategori' => 'required',
                'lokasi' => 'required|string',
                'ket' => 'required|string',
            ]);

            if(!session('siswa_nis')) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            $dataSiswa = Siswa::where('nis', session('siswa_nis'))->first();

            if (!$dataSiswa) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
            }

            $inputAspirasi = InputAspirasi::create([
                'nis' => $dataSiswa->nis,  // ✅ Perbaiki: pakai nis dari $dataSiswa
                'id_kategori' => $request->id_kategori,
                'lokasi' => $request->lokasi,
                'ket' => $request->ket,
            ]);

            Aspirasi::create([
                'id_pelaporan' => $inputAspirasi->id_pelaporan,  // ambil id yang baru dibuat
                'id_kategori' => $request->id_kategori,
                'status' => 'menunggu',  // status default
                'feedback' => null,       // feedback masih kosong
            ]);

            return redirect()->route('forum.index')->with('success', 'Berhasil kirim keluh kesah');
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cek login
        if (!session('siswa_nis')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $dataSiswa = Siswa::where('nis', session('siswa_nis'))->first();
        
        if (!$dataSiswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }
        
        // Ambil data aspirasi yang akan diedit
        $aspirasi = InputAspirasi::with('aspirasi', 'kategori')
            ->where('id_pelaporan', $id)
            ->where('nis', $dataSiswa->nis) // Pastikan milik siswa yang login
            ->first();
        
        if (!$aspirasi) {
            return redirect()->route('forum.index')->with('error', 'Data tidak ditemukan');
        }
        
        $kategori = Kategori::all();
        
        return view('siswa.editAspirasi', compact('aspirasi', 'dataSiswa', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi
        $request->validate([
            'id_kategori' => 'required',
            'lokasi' => 'required|string',
            'ket' => 'required|string',
        ]);
        
        // Cek login
        if (!session('siswa_nis')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $dataSiswa = Siswa::where('nis', session('siswa_nis'))->first();
        
        if (!$dataSiswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }
        
        // Cari data yang akan diupdate
        $aspirasi = InputAspirasi::where('id_pelaporan', $id)
            ->where('nis', $dataSiswa->nis)
            ->first();
        
        if (!$aspirasi) {
            return redirect()->route('forum.index')->with('error', 'Data tidak ditemukan');
        }
        
        // Update data InputAspirasi
        $aspirasi->update([
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
        ]);
        
        // Optional: Update juga kategori di tabel aspirasi (jika perlu)
        if ($aspirasi->aspirasi) {
            $aspirasi->aspirasi->update([
                'id_kategori' => $request->id_kategori,
            ]);
        }
        
        return redirect()->route('forum.index')->with('success', 'Berhasil mengupdate pengaduan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek login
        if (!session('siswa_nis')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $dataSiswa = Siswa::where('nis', session('siswa_nis'))->first();
        
        if (!$dataSiswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }
        
        // Cari data
        $aspirasi = InputAspirasi::where('id_pelaporan', $id)
            ->where('nis', $dataSiswa->nis)
            ->first();
        
        if (!$aspirasi) {
            return redirect()->route('forum.index')->with('error', 'Data tidak ditemukan');
        }
        
        // Hapus data aspirasi (relasi) dulu
        if ($aspirasi->aspirasi) {
            $aspirasi->aspirasi->delete();
        }
        
        // Hapus data input aspirasi
        $aspirasi->delete();
        
        return redirect()->route('forum.index')->with('success', 'Berhasil menghapus pengaduan');
    
    }
}
