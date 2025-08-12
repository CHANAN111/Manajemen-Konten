<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'menko_id',
        'nama_tugas',
        'is_done',
    ];

    /**
     * Satu Tugas dimiliki oleh satu Konten (Menko).
     */
    public function menko()
    {
        return $this->belongsTo(Menko::class);
    }
}
