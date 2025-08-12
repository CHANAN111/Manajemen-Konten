<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menko extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'konten',
        'file_naskah',
        'file_dubbing',
        'status',
        'editor_id',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function editor()
    {
        // Relasi ke model User, dengan foreign key 'editor_id'
        return $this->belongsTo(User::class, 'editor_id');
    }
}
