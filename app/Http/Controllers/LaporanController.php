<?php

namespace App\Http\Controllers;

use App\Models\Analitik;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    
    public function exportPDF(Request $request)
    {
        // 1. Logika query yang sama dengan method index() untuk sorting
        $query = Analitik::with('jadwal');
        
        if ($request->has('sort')) {
            $direction = $request->get('direction', 'desc');
            $query->orderBy($request->get('sort'), $direction);
        } else {
            // Urutan default adalah data terbaru
            $query->latest('created_at');
        }

        // 2. Ambil SEMUA data yang cocok (gunakan get(), bukan paginate())
        $analitiks = $query->get();

        // 3. Siapkan data untuk dikirim ke view PDF
        $data = [
            'title'     => 'Laporan Analitik Video - Channel Ilmuwan Top',
            'date'      => date('d/m/Y'),
            'analitiks' => $analitiks // Kirim data analitik yang sudah diambil
        ];
            
        // 4. Muat view PDF dengan data yang sudah lengkap
        $pdf = Pdf::loadView('laporan.pdf_template', $data);

        // 5. Download file PDF dengan nama file dinamis berdasarkan tanggal
        return $pdf->download('laporan-analitik-' . date('Y-m-d') . '.pdf');
    }
    public function index(Request $request)
    {
            $query = Analitik::with('jadwal');
        if ($request->has('sort')) {
            $direction = $request->get('direction', 'desc');
            $query->orderBy($request->get('sort'), $direction);
        } else {
            $query->latest();
        }
        $analitiks = $query->paginate(15);
        // -----------------------------------------


        // =======================================================
        // LOGIKA BARU UNTUK DATA GRAFIK
        // =======================================================
        // 1. Ambil 5 data analitik dengan views terbanyak
        $topVideos = Analitik::with('jadwal')
                            ->orderBy('views', 'desc')
                            ->take(5)
                            ->get();

        // 2. Siapkan data 'labels' (untuk sumbu X, yaitu judul video)
        $chartLabels = $topVideos->map(function($item) {
            // Kita potong judulnya agar tidak terlalu panjang di grafik
            return Str::limit($item->jadwal->judul_video ?? 'N/A', 25); 
        });

        // 3. Siapkan data 'data' (untuk sumbu Y, yaitu jumlah views)
        $chartData = $topVideos->pluck('views');
        // =======================================================

        // Kirim semua data ke view
        return view('laporan.index', [
            'title'     => 'Laporan & Analitik Video',
            'analitiks' => $analitiks,
            'chartLabels' => $chartLabels, // Data baru untuk grafik
            'chartData'   => $chartData,   // Data baru untuk grafik
        ]);
    }
}
