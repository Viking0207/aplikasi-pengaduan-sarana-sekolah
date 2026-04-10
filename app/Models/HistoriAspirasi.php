<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriAspirasi extends Model
{
    protected $table = 'histori_aspirasi';
    protected $primaryKey = 'id_histori';
    
    public $timestamps = false; 
    
    protected $fillable = [
        'id_aspirasi',
        'nis',
        'nama',
        'status',
        'feedback',
        'tanggal_update'
    ];
    
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_aspirasi', 'id_aspirasi');
    }
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}
