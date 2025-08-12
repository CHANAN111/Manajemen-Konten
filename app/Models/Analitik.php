<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analitik extends Model
{
     use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'views',
        'likes',
        'comments',
        'catatan',
    ];

    /**
     * Satu catatan Analitik dimiliki oleh satu Jadwal.
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
