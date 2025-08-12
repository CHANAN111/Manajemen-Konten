<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalApiController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal yang memiliki tanggal tayang
        $jadwals = Jadwal::whereNotNull('tanggal_tayang')->get();

        // Ubah format data agar sesuai dengan yang dibutuhkan FullCalendar
        $events = $jadwals->map(function ($jadwal) {
            $color = '#f59e0b'; 
        
            // Jika statusnya sudah 'Dipublish', ganti warnanya menjadi hijau
            if ($jadwal->status == 'Dipublish') {
                $color = '#10b981'; // Hijau/Emerald
            }
            return [
                'id'    => $jadwal->id,
                'title' => $jadwal->judul_video,
                'start' => $jadwal->tanggal_tayang,
                'end'   => $jadwal->tanggal_tayang, // Bisa diisi tanggal selesai jika ada
                // Kita akan tambahkan URL dan warna di bagian selanjutnya
                'url'   => route('jadwals.show', $jadwal->id),
                'backgroundColor' => $color,
                'borderColor'     => $color,
            ];
        });

        // Kembalikan data dalam format JSON
        return response()->json($events);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        // Validasi sederhana untuk memastikan tanggal yang dikirim valid
        $request->validate([
            'start' => 'required|date',
        ]);

        // Update kolom tanggal_tayang
        $jadwal->update([
            'tanggal_tayang' => $request->start,
        ]);

        // Kirim respon sukses dalam format JSON
        return response()->json(['success' => true]);
    }
}
