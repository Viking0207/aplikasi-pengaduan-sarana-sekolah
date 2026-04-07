<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    
    public $primaryKey = 'nis';
    
    protected $fillable = [
        'nis',
        'kelas',
    ];

    public $incrementing = false;

    public $timestamps = false;
    
    public function InputAspirasi()
    {
        return $this->hasMany(InputAspirasi::class);
    }

    public function Aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'nis', 'nis');
    }
}
