<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    
    protected $fillable = [
        'id_kategori',
        'ket_kategori',
    ];

    public function Aspirasi()
    {
        return $this->hasMany (Aspirasi::class);
    }

    public function InputAspirasi()
    {
        return $this->hasMany(InputAspirasi::class);
    }
}
