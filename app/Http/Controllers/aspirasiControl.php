<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\HistoriAspirasi;
use App\Models\Kategori;
use App\Models\Siswa;

class aspirasiControl extends Controller
{
    public function index()
    {
        $dataInput = InputAspirasi::with(['aspirasi', 'kategori', 'siswa'])->get();
        
        $dataFinal = [];
        
        foreach ($dataInput as $input) {
            $dataFinal[] = [
                'input' => $input,
                'aspirasi' => $input->aspirasi,
                'kategori' => $input->kategori,
                'siswa' => $input->siswa,
            ];
        }
        
        return view('Admin.dataPengaduan', compact('dataFinal'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('Admin.tambahPengaduan', compact('kategori'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nis' => 'required|exists:siswa,nis',
    //         'id_kategori' => 'required|exists:kategori,id_kategori',
    //         'lokasi' => 'required|string',
    //         'ket' => 'required|string',
    //         'status' => 'required|in:menunggu,proses,selesai,ditolak',
    //     ]);

    //     $input = InputAspirasi::create([
    //         'nis' => $request->nis,
    //         'id_kategori' => $request->id_kategori,
    //         'lokasi' => $request->lokasi,
    //         'ket' => $request->ket,
    //     ]);

    //     Aspirasi::create([
    //         'id_pelaporan' => $input->id_pelaporan,
    //         'id_kategori' => $request->id_kategori,
    //         'status' => $request->status,
    //         'feedback' => $request->feedback ?? null,
    //     ]);

    //     return redirect()->route('aspirasi.index')->with('success', 'Data pengaduan berhasil ditambahkan.');
    // }

    public function show(string $id)
    {
        // Cari berdasarkan id_aspirasi ATAU id_pelaporan
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->orWhere('id_pelaporan', $id)->first();
        
        if (!$aspirasi) {
            return redirect()->route('aspirasi.index')->with('error', 'Data tidak ditemukan');
        }
        
        $input = InputAspirasi::where('id_pelaporan', $aspirasi->id_pelaporan)->first();
        $siswa = $input ? Siswa::where('nis', $input->nis)->first() : null;
        $kategori = Kategori::find($aspirasi->id_kategori);
        
        return view('Admin.lihatDataPengaduan', compact('aspirasi', 'input', 'siswa', 'kategori'));
    }

    /**
     * PERBAIKAN UTAMA: edit() sekarang bisa menerima id_aspirasi ATAU id_pelaporan
     */
    public function edit(string $id)
    {
        // Langkah 1: Cari aspirasi berdasarkan id_aspirasi atau id_pelaporan
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->orWhere('id_pelaporan', $id)->first();
        
        if (!$aspirasi) {
            return redirect()->route('aspirasi.index')->with('error', 'Data aspirasi tidak ditemukan untuk ID: ' . $id);
        }
        
        // Langkah 2: Cari input berdasarkan id_pelaporan dari aspirasi
        $input = InputAspirasi::with(['kategori', 'siswa'])
            ->where('id_pelaporan', $aspirasi->id_pelaporan)
            ->first();
        
        if (!$input) {
            return redirect()->route('aspirasi.index')->with('error', 'Data input aspirasi tidak ditemukan');
        }
        
        // Langkah 3: Siapkan data untuk view
        $siswa = $input->siswa;
        $kategoriTerpilih = $input->kategori;
        $allKategori = Kategori::all();
        
        return view('Admin.lihatDataPengaduan', compact('aspirasi', 'input', 'siswa', 'kategoriTerpilih', 'allKategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,ditolak',
            'feedback' => 'nullable|string|max:500',
        ]);

        // Cari berdasarkan id_pelaporan (prioritas) atau id_aspirasi
        $input = InputAspirasi::where('id_pelaporan', $id)->first();
        
        if ($input) {
            $aspirasi = Aspirasi::where('id_pelaporan', $input->id_pelaporan)->first();
        } else {
            $aspirasi = Aspirasi::where('id_aspirasi', $id)->first();
        }
        
        if (!$aspirasi) {
            return redirect()->route('aspirasi.index')->with('error', 'Data tidak ditemukan');
        }

        // Update aspirasi
        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);
        
        // Ambil nis dengan aman
        $nis = null;
        $namaSiswa = null;
        $input = InputAspirasi::where('id_pelaporan', $aspirasi->id_pelaporan)->first();
        if ($input) {
            $nis = $input->nis;
            $siswa = Siswa::where('nis', $input->nis)->first();
            $namaSiswa = $siswa->nama ?? null;
        }
        
        // ✅ CEK APAKAH SUDAH ADA DI HISTORI
        $histori = HistoriAspirasi::where('id_aspirasi', $aspirasi->id_aspirasi)->first();
        
        if ($histori) {
            // ✅ UPDATE jika sudah ada
            $histori->update([
                'status' => $request->status,
                'feedback' => $request->feedback,
                'nama' => $namaSiswa,
                'tanggal_update' => now(),
            ]);
        } else {
            // ✅ CREATE jika belum ada
            HistoriAspirasi::create([
                'id_aspirasi' => $aspirasi->id_aspirasi,
                'nis' => $nis,
                'nama' => $namaSiswa,
                'status' => $request->status,
                'feedback' => $request->feedback,
                'tanggal_update' => now(),
            ]);
        }

        return redirect()->route('aspirasi.index')->with('success', 'Status dan feedback berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        // Cari aspirasi dulu
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->orWhere('id_pelaporan', $id)->first();
        
        if ($aspirasi) {
            // Hapus histori terkait
            HistoriAspirasi::where('id_aspirasi', $aspirasi->id_aspirasi)->delete();
            
            // Hapus aspirasi
            $aspirasi->delete();
            
            // Hapus input aspirasi
            $input = InputAspirasi::where('id_pelaporan', $aspirasi->id_pelaporan)->first();
            if ($input) {
                $input->delete();
            }
        }

        return redirect()->route('aspirasi.index')->with('aspiDeleted', 'Data pengaduan berhasil dihapus.');
    }

    /* Edit berdasarkan id_pelaporan (dari tabel input_aspirasi) */
    public function editByPelaporan(string $id_pelaporan)
    {
        // Cari input berdasarkan id_pelaporan
        $input = InputAspirasi::with(['kategori', 'siswa'])
            ->where('id_pelaporan', $id_pelaporan)
            ->first();
        
        if (!$input) {
            return redirect()->route('aspirasi.index')->with('error', 'Data tidak ditemukan untuk ID Pelaporan: ' . $id_pelaporan);
        }
        
        // Cari atau buat aspirasi
        $aspirasi = Aspirasi::where('id_pelaporan', $input->id_pelaporan)->first();
        
        if (!$aspirasi) {
            $aspirasi = Aspirasi::create([
                'id_pelaporan' => $input->id_pelaporan,
                'id_kategori' => $input->id_kategori,
                'status' => 'menunggu',
                'feedback' => null,
            ]);
        }
        
        $siswa = $input->siswa;
        $kategoriTerpilih = $input->kategori;
        $allKategori = Kategori::all();
        
        return view('Admin.lihatDataPengaduan', compact('aspirasi', 'input', 'siswa', 'kategoriTerpilih', 'allKategori'));
    }

    /**
     * Edit berdasarkan id_aspirasi (dari tabel aspirasi)
     */
    public function editByAspirasi(string $id_aspirasi)
    {
        // Cari aspirasi berdasarkan id_aspirasi
        $aspirasi = Aspirasi::where('id_aspirasi', $id_aspirasi)->first();
        
        if (!$aspirasi) {
            return redirect()->route('aspirasi.index')->with('error', 'Data tidak ditemukan untuk ID Aspirasi: ' . $id_aspirasi);
        }
        
        // Cari input berdasarkan id_pelaporan
        $input = InputAspirasi::with(['kategori', 'siswa'])
            ->where('id_pelaporan', $aspirasi->id_pelaporan)
            ->first();
        
        if (!$input) {
            return redirect()->route('aspirasi.index')->with('error', 'Data input tidak ditemukan');
        }
        
        $siswa = $input->siswa;
        $kategoriTerpilih = $input->kategori;
        $allKategori = Kategori::all();
        
        return view('Admin.lihatDataPengaduan', compact('aspirasi', 'input', 'siswa', 'kategoriTerpilih', 'allKategori'));
    }

    /* Search data pengaduan berdasarkan NIS, Nama, atau Kategori */
    public function search(Request $request)
    {
        $search = $request->search;
        
        $dataInput = InputAspirasi::with(['aspirasi', 'kategori', 'siswa'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nis', 'like', "%$search%")
                    ->orWhere('nama', 'like', "%$search%");
                })->orWhereHas('kategori', function ($q) use ($search) {
                    $q->where('ket_kategori', 'like', "%$search%");
                });
            })
            ->get();
        
        $dataFinal = [];
        foreach ($dataInput as $input) {
            $dataFinal[] = [
                'input' => $input,
                'aspirasi' => $input->aspirasi,
                'kategori' => $input->kategori,
                'siswa' => $input->siswa,
            ];
        }
        
        return view('Admin.dataPengaduan', compact('dataFinal', 'search'));
    }
}