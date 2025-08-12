<?php

namespace App\Http\Controllers;

use App\Models\Menko;
use App\Models\Tugas;
use App\Models\Jadwal;
use App\Models\Analitik;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // --- STATISTIK UNTUK KARTU-KARTU ---

        // 1. Total Konten yang masih dalam tahap ide/produksi
        // Status ini sesuai dengan yang kita definisikan untuk alur kerja konten
        $totalKontenDraft = Menko::whereIn('status', ['Rencana', 'Dubbing', 'Editing'])->count();

        // 2. Total Video yang sudah dijadwalkan tapi belum tayang
        // Status ini sesuai dengan yang kita definisikan untuk alur kerja penjadwalan
        $totalVideoTerjadwal = Jadwal::where('status', 'Draf')->count();

        // 3. Total Views dari video yang dipublish bulan ini
        // Kita mencari analitik yang relasi jadwalnya berstatus 'Dipublish' dan tanggalnya di bulan ini
        $viewsBulanIni = Analitik::whereHas('jadwal', function ($query) {
            $query->where('status', 'Dipublish')
                  ->whereMonth('tanggal_tayang', Carbon::now()->month)
                  ->whereYear('tanggal_tayang', Carbon::now()->year);
        })->sum('views');

        $likesBulanIni = Analitik::whereHas('jadwal', function ($query) {
            $query->where('status', 'Dipublish')
                  ->whereMonth('tanggal_tayang', Carbon::now()->month)
                  ->whereYear('tanggal_tayang', Carbon::now()->year);
        })->sum('likes');
        

        // 1. Ambil data, kelompokkan berdasarkan status, dan hitung jumlahnya
        $statusCounts = Menko::select('status', DB::raw('count(*) as total'))
                               ->groupBy('status')
                               ->pluck('total', 'status');

        // 2. Siapkan data 'labels' (nama status) dan 'data' (jumlah) untuk Chart.js
        $donutChartLabels = $statusCounts->keys();
        $donutChartData = $statusCounts->values();

        $myAssignedContents = Menko::where('editor_id', Auth::id())
                                  ->whereIn('status', ['Rencana', 'Dubbing', 'Editing'])
                                  ->latest()
                                  ->take(5) // Ambil 5 tugas teratas
                                  ->get();

        // Kirim semua data statistik yang sudah dihitung ke view dashboard
        return view('dashboard', [
            'totalKontenDraft'    => $totalKontenDraft,
            'totalVideoTerjadwal' => $totalVideoTerjadwal,
            'viewsBulanIni'       => $viewsBulanIni,
            'likesBulanIni'       => $likesBulanIni,

            'donutChartLabels' => $donutChartLabels,
            'donutChartData'   => $donutChartData,

            'myAssignedContents' => $myAssignedContents,
        ]);
    }
}
