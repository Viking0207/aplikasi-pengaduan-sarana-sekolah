<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';

    protected $primaryKey = 'id_pelaporan';

    protected $fillable = [
        'nis',
        'id_kategori',
        'lokasi',
        'ket',
        'tanggal'
    ];

    public $timestamps = false;

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
