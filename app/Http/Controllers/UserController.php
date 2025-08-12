<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user beserta relasi roles-nya untuk ditampilkan
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        // Ambil semua role yang ada untuk ditampilkan sebagai pilihan checkbox
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Memperbarui role untuk user.
     */
    public function update(Request $request, User $user)
    {
        // 'sync' akan menangani penambahan & penghapusan role di tabel pivot secara otomatis
        // berdasarkan checkbox yang dicentang di form.
        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'Role untuk user berhasil diperbarui.');
    }

    public function create()
    {
        // Ambil semua role untuk ditampilkan sebagai pilihan
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['required', 'array'], // Pastikan roles yang dikirim adalah array
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Berikan role yang dipilih
        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'User baru berhasil dibuat.');
    }
}
