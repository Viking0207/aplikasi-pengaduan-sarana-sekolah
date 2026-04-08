<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriAspirasi;
use App\Models\Aspirasi;
use App\Models\Siswa;
use App\Models\Kategori;

class rekapanController extends Controller
{
    /**
     * Menampilkan semua histori/rekapan
     */
    public function index()
    {
        // Ambil semua histori dengan relasi
        $histori = HistoriAspirasi::with(['aspirasi', 'siswa'])
            ->orderBy('tanggal_update', 'desc')
            ->get();
        
        // Statistik
        $statistik = [
            'total' => $histori->count(),
            'proses' => HistoriAspirasi::where('status', 'proses')->count(),
            'selesai' => HistoriAspirasi::where('status', 'selesai')->count(),
            'hari_ini' => HistoriAspirasi::whereDate('tanggal_update', today())->count(),
        ];
        
        return view('Admin.rekapanAspirasi', compact('histori', 'statistik'));
    }
    
    /**
     * Filter berdasarkan tanggal
     */
    public function filter(Request $request)
    {
        $query = HistoriAspirasi::with(['aspirasi', 'siswa']);
        
        if ($request->start_date) {
            $query->whereDate('tanggal_update', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('tanggal_update', '<=', $request->end_date);
        }
        
        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        $histori = $query->orderBy('tanggal_update', 'desc')->get();
        
        $statistik = [
            'total' => $histori->count(),
            'proses' => $histori->where('status', 'proses')->count(),
            'selesai' => $histori->where('status', 'selesai')->count(),
            'hari_ini' => $histori->where('tanggal_update', '>=', today())->count(),
        ];
        
        return view('Admin.rekapanAspirasi', compact('histori', 'statistik'));
    }
    
    /**
     * Export ke CSV (opsional)
     */
    public function export()
    {
        $histori = HistoriAspirasi::with(['aspirasi', 'siswa'])
            ->orderBy('tanggal_update', 'desc')
            ->get();
        
        $filename = 'rekapan_aspirasi_' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['No', 'Tanggal Update', 'NIS', 'Nama Siswa', 'ID Aspirasi', 'Status', 'Feedback']);
        
        $no = 1;
        foreach ($histori as $item) {
            fputcsv($handle, [
                $no++,
                $item->tanggal_update,
                $item->nis,
                $item->siswa->nama ?? '-',
                $item->id_aspirasi,
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
