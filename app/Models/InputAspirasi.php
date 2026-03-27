<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';

    protected $fillable = [
        'id_pelaporan',
        'nis',
        'id_kategori',
        'lokasi',
        'ket',
        'tanggal'
    ];

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
