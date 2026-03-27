<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'kelas',
    ];

    public function InputAspirasi()
    {
        return $this->hasMany(InputAspirasi::class);
    }
}
