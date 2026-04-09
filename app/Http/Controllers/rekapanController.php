<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriAspirasi;
use App\Models\Aspirasi;
use App\Models\Siswa;
use App\Models\Kategori;

class rekapanController extends Controller
{
    public function index()
    {
        // Ambil semua histori dengan relasi
        $histori = HistoriAspirasi::with(['aspirasi.inputAspirasi', 'siswa'])
            ->orderBy('tanggal_update', 'desc')
            ->get()
            ->unique('id_aspirasi');
        
        // ✅ PASTIKAN STATISTIK DI DEFINISIKAN
        $statistik = [
            'total' => $histori->count(),
            'proses' => HistoriAspirasi::where('status', 'proses')->count(),
            'selesai' => HistoriAspirasi::where('status', 'selesai')->count(),
            'ditolak' => HistoriAspirasi::where('status', 'ditolak')->count(),
            'hari_ini' => HistoriAspirasi::whereDate('tanggal_update', today())->count(),
        ];
        
        // ✅ CEK APAKAH DATA TERKIRIM
        // dd($statistik, $histori); // Hapus tanda // untuk debug
        
        return view('Admin.laporanAdmin', compact('histori', 'statistik'));
    }

    /**
     * Filter data berdasarkan tanggal dan status
     */
    public function filter(Request $request)
    {
        $query = HistoriAspirasi::with(['aspirasi.inputAspirasi', 'siswa']);
        
        // ✅ VALIDASI TANGGAL TIDAK MELEBIHI HARI INI
        $today = date('Y-m-d');
        
        if ($request->filter_type != 'bulan') {
            // Validasi tanggal tidak boleh > hari ini
            if ($request->start_date && $request->start_date > $today) {
                return redirect()->route('rekapan.index')->with('error', 'Tanggal mulai tidak boleh melebihi hari ini!');
            }
            if ($request->end_date && $request->end_date > $today) {
                return redirect()->route('rekapan.index')->with('error', 'Tanggal akhir tidak boleh melebihi hari ini!');
            }
            
            // Filter range tanggal
            if ($request->start_date) {
                $query->whereDate('tanggal_update', '>=', $request->start_date);
            }
            if ($request->end_date) {
                $query->whereDate('tanggal_update', '<=', $request->end_date);
            }
        } else {
            // Filter per bulan
            if ($request->tahun) {
                $query->whereYear('tanggal_update', $request->tahun);
            }
            if ($request->bulan && $request->bulan != 'semua') {
                $query->whereMonth('tanggal_update', $request->bulan);
            }
        }
        
        // Filter status
        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        $histori = $query->orderBy('tanggal_update', 'desc')->get();
        
        $statistik = [
            'total' => $histori->count(),
            'proses' => $histori->where('status', 'proses')->count(),
            'selesai' => $histori->where('status', 'selesai')->count(),
            'ditolak' => $histori->where('status', 'ditolak')->count(),
            'hari_ini' => $histori->where('tanggal_update', '>=', today())->count(),
        ];
        
        return view('Admin.laporanAdmin', compact('histori', 'statistik'));
    }

    /**
     * Export ke CSV
     */
    public function export()
    {
        $histori = HistoriAspirasi::with(['aspirasi.inputAspirasi', 'siswa'])
            ->orderBy('tanggal_update', 'desc')
            ->get();
        
        $filename = 'rekapan_aspirasi_' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['No', 'Tanggal Update', 'NIS', 'Nama', 'Kelas', 'Lokasi', 'Pengaduan', 'Status', 'Feedback']);
        
        $no = 1;
        foreach ($histori as $item) {
            $input = $item->aspirasi->inputAspirasi ?? null;
            $siswa = $item->siswa;
            
            fputcsv($handle, [
                $no++,
                $item->tanggal_update,
                $item->nis ?? '-',
                $item->nama ?? '-',
                $siswa->kelas ?? '-',
                $input->lokasi ?? '-',
                $input->ket ?? '-',
                $item->status,
                $item->feedback ?? '-'
            ]);
        }
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        fclose($handle);
        exit;
    }
}
