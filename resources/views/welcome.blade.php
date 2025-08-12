<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manajemen Channel - Ilmuwan Top</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-red-500 selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    
                    {{-- Navigasi Login/Register di Pojok Kanan Atas --}}
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            {{-- Logo bisa ditaruh di sini --}}
                        </div>
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>
                                {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </a>
                                @endif --}}
                            @endauth
                        </nav>
                    </header>

                    <main class="mt-6">
                        {{-- Hero Section --}}
                        <div class="text-center py-20">
                            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                                Atur Konten & Jadwal Channel Ilmuwan Top
                            </h1>
                            <p class="mt-4 text-lg max-w-3xl mx-auto text-gray-600 dark:text-gray-400">
                                Dari ide konten hingga jadwal publikasi, kelola seluruh alur kerja channel "Ilmuwan Top" dengan lebih terorganisir dan efisien.
                            </p>
                            <div class="mt-8 flex justify-center gap-4">
                                {{-- <a href="{{ route('register') }}" class="inline-block rounded-lg bg-indigo-600 px-8 py-3 text-lg font-semibold text-white hover:bg-indigo-500">Mulai Sekarang</a> --}}
                                <a href="{{ route('login') }}" class="inline-block rounded-lg bg-indigo-600 px-8 py-3 text-lg font-semibold text-white hover:bg-indigo-500"">Masuk</a>
                            </div>
                        </div>

                        {{-- Fitur Section --}}
                        <div class="py-16">
                            <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Fitur Unggulan</h2>
                            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2">
                                
                                {{-- Kartu Fitur 1 --}}
                                <div class="p-8 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">Manajemen Konten</h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400">Tulis, simpan, dan kelola semua naskah dan ide konten Anda. Beri status 'Draf' atau 'diPublish' dan jangan biarkan ide brilian hilang begitu saja.</p>
                                </div>

                                {{-- Kartu Fitur 2 --}}
                                <div class="p-8 bg-white dark:bg-gray-900 rounded-lg shadow-md">
                                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">Penjadwalan Terpusat</h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400">Rencanakan kalender konten Anda. Atur tanggal tayang, status produksi, dan hubungkan langsung dengan naskah yang sudah Anda siapkan.</p>
                                </div>

                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        {{-- Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) --}}
                        Yt: Ilmuwan Top
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>