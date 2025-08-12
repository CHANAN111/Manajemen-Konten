<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Menko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
     /**
     * Menampilkan halaman utama yang berisi daftar semua jadwal.
     */
    public function index()
    {
        $jadwals = Jadwal::with('menko')->latest()->paginate(10); // Ambil data jadwal beserta relasi menko

        return view('jadwals.index', [
            'title' => 'Penjadwalan Konten',
            'jadwals' => $jadwals
        ]);
    }

    /**
     * Menampilkan halaman formulir untuk membuat jadwal baru.
     */
    public function create()
    {
        $this->authorize('manage-schedules');

        $menkos = Menko::orderBy('judul')->get(); // Ambil data konten untuk dropdown

        return view('jadwals.create', [
            'title' => 'Buat Jadwal Baru',
            'menkos' => $menkos
        ]);
    }

    /**
     * Menyimpan data dari formulir tambah baru ke database.
     */
    public function store(Request $request)
    {
        $this->authorize('manage-schedules');
        
        // 1. Lakukan validasi data yang masuk
        $this->validate($request, [
            'judul_video'   => 'required|string|min:5',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:Draf,Dipublish',
            'tanggal_tayang'=> 'nullable|date',
            'link_video'    => 'nullable|url',
            'menko_id'      => 'nullable|exists:menkos,id'
        ]);

        // 2. Jika validasi berhasil, buat record baru di database
        Jadwal::create([
            'judul_video'    => $request->judul_video,
            'deskripsi'      => $request->deskripsi,
            'status'         => $request->status,
            'tanggal_tayang' => $request->tanggal_tayang,
            'link_video'     => $request->link_video,
            'menko_id'       => $request->menko_id
        ]);

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('jadwals.index')->with(['success' => 'Jadwal baru berhasil dibuat!']);
    }

    /**
     * Menampilkan detail dari satu jadwal spesifik.
     */
    public function show(Jadwal $jadwal)
    {
        $jadwal->load('analitik', 'menko');
        
        return view('jadwals.show', [
            'title' => 'Detail: ' . $jadwal->judul_video,
            'jadwal' => $jadwal
        ]);
    }

    /**
     * Menampilkan halaman formulir untuk mengedit jadwal.
     */
    public function edit(Jadwal $jadwal)
    {
        $this->authorize('manage-schedules');
        
        $menkos = Menko::orderBy('judul')->get(); // Ambil juga data konten untuk dropdown di form edit

        return view('jadwals.edit', [
            'title' => 'Edit Jadwal: ' . $jadwal->judul_video,
            'jadwal' => $jadwal,
            'menkos' => $menkos
        ]);
    }

    /**
     * Memperbarui data jadwal yang ada di database.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $this->authorize('manage-schedules');
        
        // 1. Lakukan validasi data yang masuk
        $this->validate($request, [
            'judul_video'   => 'required|string|min:5',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:Draf,Dipublish',
            'tanggal_tayang'=> 'nullable|date',
            'link_video'    => 'nullable|url',
            'menko_id'      => 'nullable|exists:menkos,id'
        ]);

        // 2. Update record yang ada
        $jadwal->update([
            'judul_video'    => $request->judul_video,
            'deskripsi'      => $request->deskripsi,
            'status'         => $request->status,
            'tanggal_tayang' => $request->tanggal_tayang,
            'link_video'     => $request->link_video,
            'menko_id'       => $request->menko_id
        ]);

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('jadwals.index')->with(['success' => 'Jadwal berhasil diperbarui!']);
    }

    /**
     * Menghapus data jadwal dari database.
     */
    public function destroy(Jadwal $jadwal)
    {
        $this->authorize('manage-schedules');
        
        $jadwal->delete();
        return redirect()->route('jadwals.index')->with(['success' => 'Jadwal berhasil dihapus!']);
    }
}
