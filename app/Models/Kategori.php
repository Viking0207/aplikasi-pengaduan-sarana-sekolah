<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    
    public $primaryKey = 'id_kategori';

    protected $fillable = [
        'ket_kategori',
    ];

    public $timestamps = false;

    public function Aspirasi()
    {
        return $this->hasMany (Aspirasi::class, 'id_kategori');
    }

    public function InputAspirasi()
    {
        return $this->hasMany(InputAspirasi::class);
    }
    
}
