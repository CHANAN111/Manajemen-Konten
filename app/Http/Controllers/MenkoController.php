<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenkoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil kata kunci pencarian dan status dari request
        $search = $request->input('search');
        $status = $request->input('status');

        // 2. Mulai query dasar ke model Menko
        $query = Menko::query();

        // 3. Terapkan kondisi pencarian jika ada input 'search'
        if ($search) {
            // Cari di kolom 'judul' yang mengandung kata kunci
            $query->where('judul', 'like', '%' . $search . '%');
        }

        // 4. Terapkan kondisi filter jika ada input 'status'
        if ($status) {
            $query->where('status', $status);
        }

        // 5. Ambil hasil akhir setelah difilter dan diurutkan, lalu paginasi
        $menkos = $query->latest()->paginate(10);

        // 6. Kirim data ke view seperti biasa
        return view('menko.index', [
            'title' => 'Manajemen Konten',
            'menkos' => $menkos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manage-content');

        // Kode di bawah ini hanya akan berjalan jika user diizinkan.
        return view('menko.create', [
            'title' => 'Tambah Konten Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('manage-content');

        $this->validate($request, [
            'judul'   => 'required|string|min:5',
            'konten'  => 'required|string|min:10',
            'file_naskah' => 'nullable|file|mimes:doc,docx|max:10240',
            'file_dubbing'=> 'nullable|file|mimes:zip,rar,mp3,wav,m4a|max:1024000',
            'status'  => 'required|in:Rencana,Dubbing,Editing,Terjadwal',
        ]);

        // Upload gambar jika ada
        $path_naskah = null;
        if ($request->hasFile('file_naskah')) {
            $path_naskah = $request->file('file_naskah')->store('menkos', 'public');
        }

        $path_dubbing = null;
        if ($request->hasFile('file_dubbing')) {
            $path_dubbing = $request->file('file_dubbing')->store('dubbing', 'public');
        }

        // 1. Buat data konten dan simpan ke variabel $menko
        $menko = Menko::create([
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'status'  => $request->status,
            'file_naskah'  => $path_naskah,
            'file_dubbing' => $path_dubbing,
        ]);

        

        return redirect()->route('menkos.index')->with(['success' => 'Konten dan checklist tugasnya berhasil dibuat!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menko $menko)
    {
        // Memuat relasi 'tugas' agar bisa diakses di view
        // $menko->load('tugas');
        return view('menko.show', compact('menko'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menko $menko)
    {
        $editors = User::whereHas('roles', function ($query) {
            $query->where('name', 'Editor');
        })->get();

        // 2. Kirim data konten dan data editor ke view
        return view('menko.edit', [
            'menko'   => $menko,
            'editors' => $editors, // Data baru yang kita kirim
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menko $menko)
    {
        $this->authorize('manage-content');

        $this->validate($request, [
            'judul'   => 'required|string|min:5',
            'konten'  => 'required|string|min:10',
            'file_naskah' => 'nullable|file|mimes:doc,docx|max:10240',
            'file_dubbing' => 'nullable|file|mimes:zip,rar,mp3,wav,m4a|max:1024000',
            'status'  => 'required|in:Rencana,Dubbing,Editing,Terjadwal',
            'editor_id' => 'nullable|exists:users,id',
        ]);

        // Cek jika ada file gambar baru yang di-upload
        $path_naskah = $menko->file_naskah; // Simpan path gambar lama sebagai default
        if ($request->hasFile('file_naskah')) {
            // Hapus gambar lama jika ada
            if ($menko->file_naskah) {
                Storage::disk('public')->delete($menko->file_naskah);
            }
            // Upload gambar baru
            $path_naskah = $request->file('file_naskah')->store('menkos', 'public');
        }

        $path_dubbing = $menko->file_dubbing; // Ambil path lama sebagai default
        if ($request->hasFile('file_dubbing')) {
            // Hapus file dubbing lama jika ada
            if ($menko->file_dubbing) {
                Storage::disk('public')->delete($menko->file_dubbing);
            }
            // Upload yang baru
            $path_dubbing = $request->file('file_dubbing')->store('dubbing', 'public');
        }
            
            $menko->update([
                'judul'   => $request->judul,
                'konten'  => $request->konten,
                'status'  => $request->status,
                'file_naskah'  => $path_naskah,
                'file_dubbing' => $path_dubbing,
                'editor_id' => $request->editor_id,
            ]);

        

        return redirect()->route('menkos.index')->with(['success' => 'Konten Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menko $menko)
    {
        $this->authorize('manage-content');
        
        if ($menko->file_naskah) {
            Storage::disk('public')->delete($menko->file_naskah);
        }
        if ($menko->file_dubbing) {
            Storage::disk('public')->delete($menko->file_dubbing);
        }
        
        $menko->delete();

        return redirect()->route('menkos.index')->with(['success' => 'Konten Berhasil Dihapus!']);
    }
}
