<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // 1. Mengambil semua data post dari database
        //    'latest()' akan mengurutkan dari yang paling baru
        $posts = Post::latest()->get();

        // 2. Mengirim data posts ke view 'posts.index'
        return view('posts.index', ['posts' => $posts]);
    }
    public function show(Post $post)
    {
        // Mengirim data post yang ditemukan ke view 'posts.show'
        return view('posts.show', ['post' => $post]);
    }
    public function create()
    {
        // Hanya menampilkan view yang berisi form
        return view('posts.create');
    }
    public function store(Request $request)
    {
        // 1. Validasi data form
        $this->validate($request, [
            'title'   => 'required|min:2',
            'content' => 'required|min:10'
        ]);

        // 2. Membuat post baru menggunakan Eloquent
        Post::create([
            'title'   => $request->title,
            'content' => $request->content
        ]);

        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }
    public function update(Request $request, Post $post)
    {
        // 1. Validasi data form
        $this->validate($request, [
            'title'   => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        // 2. Melakukan update data di database
        $post->update([
            'title'   => $request->title,
            'content' => $request->content
        ]);

        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy(Post $post)
    {
        // 1. Menghapus data post berdasarkan ID
        $post->delete();

        // 2. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
