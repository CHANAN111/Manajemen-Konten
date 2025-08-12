<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Analitik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalitikController extends Controller
{
    public function edit(Jadwal $jadwal)
    {
        // Temukan analitik yang ada, atau buat instance baru jika belum ada
        $analitik = $jadwal->analitik ?? new Analitik();

        return view('analitiks.edit', [
            'title'  => 'Analitik untuk: ' . $jadwal->judul_video,
            'jadwal' => $jadwal,
            'analitik' => $analitik
        ]);
    }

    /**
     * Menyimpan atau memperbarui data analitik.
     */
    public function store(Request $request, Jadwal $jadwal)
    {
        $this->validate($request, [
            'views'    => 'required|integer|min:0',
            'likes'    => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'catatan'  => 'nullable|string',
        ]);

        // Metode canggih: Update jika ada, atau Create jika tidak ada.
        $jadwal->analitik()->updateOrCreate(
            ['jadwal_id' => $jadwal->id], // Kunci untuk mencari
            [ // Data untuk diisi atau di-update
                'views' => $request->views,
                'likes' => $request->likes,
                'comments' => $request->comments,
                'catatan' => $request->catatan,
            ]
        );

        return redirect()->route('jadwals.index')->with('success', 'Data analitik berhasil disimpan!');
    }

    public function fetchStats(Jadwal $jadwal)
    {
        // 1. Ambil API Key dari config dan Video ID dari accessor model
        $apiKey = config('services.youtube.key');
        $videoId = $jadwal->video_id; // Menggunakan accessor yang kita buat!

        // Validasi awal
        if (!$apiKey) {
            return back()->with('error', 'YouTube API Key belum diatur di file .env');
        }
        if (!$videoId) {
            return back()->with('error', 'URL video pada jadwal ini tidak valid atau tidak ada.');
        }

        // 2. Buat URL lengkap untuk YouTube Data API
        $apiUrl = "https://www.googleapis.com/youtube/v3/videos?part=statistics&id={$videoId}&key={$apiKey}";

        // 3. Lakukan panggilan API menggunakan HTTP Client bawaan Laravel
        $response = Http::get($apiUrl);

        // Periksa apakah request berhasil
        if ($response->failed()) {
            return back()->with('error', 'Gagal terhubung ke YouTube API.');
        }

        $data = $response->json();

        // 4. Proses respon dan simpan/update ke database
        if (!empty($data['items'])) {
            $stats = $data['items'][0]['statistics'];

            // Gunakan updateOrCreate yang sudah kita buat sebelumnya
            $jadwal->analitik()->updateOrCreate(
                ['jadwal_id' => $jadwal->id],
                [
                    'views'    => $stats['viewCount'] ?? 0,
                    'likes'    => $stats['likeCount'] ?? 0,
                    'comments' => $stats['commentCount'] ?? 0,
                ]
            );

            return back()->with('success', 'Statistik video berhasil di-sinkronisasi!');
        }

        return back()->with('error', 'Gagal mengambil data dari YouTube. Pastikan Video ID benar dan video tidak private.');
    }
}
