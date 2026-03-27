<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';

    protected $fillable = [
        'id_aspirasi',
        'status',
        'id_kategori',
        'feedback',
    ];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
