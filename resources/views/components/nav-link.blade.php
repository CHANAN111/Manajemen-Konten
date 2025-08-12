@props(['active'])

@php
// Ganti 'cyan' dengan warna dasar Anda jika berbeda (misal: 'blue')
$classes = ($active ?? false)
            // Kelas jika link SEDANG AKTIF:
            // Border bawah tebal berwarna cyan terang, teks putih.
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-cyan-400 text-sm font-medium leading-5 text-white focus:outline-none focus:border-cyan-300 transition duration-150 ease-in-out'
            
            // Kelas jika link TIDAK AKTIF:
            // Border transparan, teks cyan pucat, saat di-hover teks jadi putih & border muncul.
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-cyan-200 hover:text-white hover:border-cyan-300 focus:outline-none focus:text-white focus:border-cyan-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>