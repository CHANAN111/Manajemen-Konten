<?php

namespace App\Console\Commands;

use App\Models\Jadwal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncYouTubeStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:sync-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi statistik video (views, likes, comments) dari YouTube Data API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi statistik YouTube...');

    // 1. Ambil semua jadwal yang relevan untuk di-sync
    $jadwalsToSync = Jadwal::where('status', 'Dipublish')
                             ->whereNotNull('link_video')
                             ->get();

    if ($jadwalsToSync->isEmpty()) {
        $this->info('Tidak ada video yang perlu disinkronisasi.');
        return self::SUCCESS; // Beritahu bahwa command sukses tanpa ada pekerjaan
    }

    $apiKey = config('services.youtube.key');
    if (!$apiKey) {
        $this->error('YouTube API Key tidak ditemukan di file .env. Proses dibatalkan.');
        return self::FAILURE; // Beritahu bahwa command gagal
    }

    // Membuat progress bar agar terlihat profesional
    $progressBar = $this->output->createProgressBar($jadwalsToSync->count());
    $progressBar->start();

    foreach ($jadwalsToSync as $jadwal) {
        $videoId = $jadwal->video_id; // Menggunakan accessor dari Model Jadwal

        if ($videoId) {
            $apiUrl = "https://www.googleapis.com/youtube/v3/videos?part=statistics&id={$videoId}&key={$apiKey}";
            $response = Http::get($apiUrl);

            if ($response->successful() && !empty($response->json()['items'])) {
                $stats = $response->json()['items'][0]['statistics'];

                $jadwal->analitik()->updateOrCreate(
                    ['jadwal_id' => $jadwal->id],
                    [
                        'views'    => $stats['viewCount'] ?? 0,
                        'likes'    => $stats['likeCount'] ?? 0,
                        'comments' => $stats['commentCount'] ?? 0,
                    ]
                );
            }
        }
        $progressBar->advance(); // Lanjutkan progress bar
    }

    $progressBar->finish();
    $this->info("\nSinkronisasi selesai. " . $jadwalsToSync->count() . " video telah diperbarui.");
    return self::SUCCESS;
    }
}
