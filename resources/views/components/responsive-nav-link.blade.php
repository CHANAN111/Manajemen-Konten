@props(['active'])

@php
// Logika untuk menentukan kelas CSS berdasarkan status aktif atau tidak
$classes = ($active ?? false)
            // Kelas jika link SEDANG AKTIF: Latar biru, border kiri nila, teks putih
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-white bg-blue-700 focus:outline-none focus:text-white focus:bg-blue-800 focus:border-indigo-700 transition duration-150 ease-in-out'
            // Kelas jika link TIDAK AKTIF: Teks biru muda, dan efek hover
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-blue-200 hover:text-white hover:bg-blue-700 hover:border-gray-300 focus:outline-none focus:text-white focus:bg-blue-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>