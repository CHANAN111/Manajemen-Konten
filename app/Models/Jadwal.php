<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'judul_video',
        'deskripsi',
        'status',
        'tanggal_tayang',
        'link_video',
        'menko_id',
    ];

    public function menko()
    {
        return $this->belongsTo(Menko::class);
    }

    public function analitik()
    {
        return $this->hasOne(Analitik::class);
    }

    public function getVideoIdAttribute(): ?string
    {
        // Jika tidak ada link video, kembalikan null
        if (!$this->link_video) {
            return null;
        }
        
        // Parse URL dan ambil query string 'v'
        parse_str(parse_url($this->link_video, PHP_URL_QUERY), $query);

        // Kembalikan nilai dari 'v' jika ada, jika tidak kembalikan null
        return $query['v'] ?? null;
    }
}
