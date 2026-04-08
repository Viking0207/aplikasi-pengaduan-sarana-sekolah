<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriAspirasi extends Model
{
    protected $table = 'histori_aspirasi';
    protected $primaryKey = 'id_histori';
    
    public $timestamps = false; // karena pakai tanggal_update otomatis
    
    protected $fillable = [
        'id_aspirasi',
        'nis',
        'status',
        'feedback',
        'tanggal_update'
    ];
    
    // Relasi ke Aspirasi
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_aspirasi', 'id_aspirasi');
    }
    
    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}
