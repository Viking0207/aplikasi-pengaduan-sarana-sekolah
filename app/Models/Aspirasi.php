<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';

    protected $primaryKey = 'id_aspirasi';

    protected $fillable = [
        'status',
        'id_kategori',
        'feedback',
    ];

    public $timestamps = false;

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function inputAspirasi()
    {
        return $this->hasOne(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan',);
    }

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }   
    
}
