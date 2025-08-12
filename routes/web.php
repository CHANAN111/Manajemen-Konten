<?php

use App\Models\Jadwal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenkoController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalitikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalApiController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     // Ambil 5 jadwal berikutnya yang belum 'Published' dan urutkan berdasarkan tanggal tayang
//     $jadwalAkanTayang = Jadwal::where('status', '!=', 'Published')
//                               ->whereNotNull('tanggal_tayang')
//                               ->orderBy('tanggal_tayang', 'asc')
//                               ->take(5)
//                               ->get();

//     return view('dashboard', [
//         'jadwalAkanTayang' => $jadwalAkanTayang
//     ]);
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/', function () {
//     return view('home', ['title' => 'Home']);
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/menko', function () {
//     return view('menko.index', ['title' => 'Menko']);
// });

Route::get('/penjadwalan', function () {
    return view('penjadwalan', ['title' => 'Penjadwalan']);
});

Route::get('/gudang', function () {
    return view('gudang', ['title' => 'Gudang']);
});

Route::get('/artikel', function () {
    return view('artikel', ['title' => 'Tentang Kami']);
});


Route::middleware('auth')->group(function () {
    
    // ===================================================================
    // SATU BARIS INI MENGGANTIKAN SEMUA 7 ROUTE CRUD ANDA
    // ===================================================================
    Route::resource('posts', PostController::class);
    // ===================================================================

    Route::resource('menkos', MenkoController::class);

    Route::resource('jadwals', JadwalController::class);

    // Routes untuk Analytics
    Route::get('/jadwals/{jadwal}/analitik', [AnalitikController::class, 'edit'])->name('analitiks.edit');
    Route::post('/jadwals/{jadwal}/analitik', [AnalitikController::class, 'store'])->name('analitiks.store');

    Route::patch('/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');

    // -- ROUTES UNTUK MANAJEMEN USER --
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:manage-users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:manage-users'); // <-- TAMBAHKAN INI
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('can:manage-users'); // <-- TAMBAHKAN INI
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:manage-users');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('can:manage-users');

    // Route API khusus untuk data kalender
    Route::get('/api/jadwals', [JadwalApiController::class, 'index'])->name('api.jadwals.index');

    // Route untuk update tanggal via drag & drop
    Route::patch('/api/jadwals/{jadwal}', [JadwalApiController::class, 'update'])->name('api.jadwals.update');

    // Route untuk mengambil data statistik dari YouTube API
    Route::post('/jadwals/{jadwal}/fetch-stats', [AnalitikController::class, 'fetchStats'])->name('analitiks.fetch');

    Route::get('/laporan-analitik', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/laporan-analitik/pdf', [LaporanController::class, 'exportPDF'])->name('laporan.pdf');
    

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
