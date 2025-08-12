<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function update(Request $request, Tugas $tugas)
    {
        $tugas->update([
            // Jika checkbox dicentang, request akan berisi 'on' (true).
            // Jika tidak, 'is_done' tidak akan dikirim, maka kita set false.
            'is_done' => $request->has('is_done')
        ]);

        // Kembali ke halaman detail konten sebelumnya
        return back();
    }
}
