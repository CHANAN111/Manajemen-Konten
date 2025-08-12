<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? 'Detail Jadwal' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session()->has('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <h3 class="text-3xl font-bold mb-2">{{ $jadwal->judul_video }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                        <div>
                            <strong>Status:</strong>
                            <span class="font-semibold {{ $jadwal->status == 'Published' ? 'text-green-600' : 'text-gray-800' }}">{{ $jadwal->status }}</span>
                        </div>
                        <div>
                            <strong>Tanggal Tayang:</strong>
                            <span class="font-semibold">{{ $jadwal->tanggal_tayang ? \Carbon\Carbon::parse($jadwal->tanggal_tayang)->format('l, d F Y - H:i') : 'Belum Diatur' }}</span>
                        </div>
                        <div class="md:col-span-2">
                            <strong>Link Video:</strong>
                            @if($jadwal->link_video)
                                <a href="{{ $jadwal->link_video }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $jadwal->link_video }}</a>
                            @else
                                <span class="font-semibold">Belum ada link</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <strong class="text-gray-900 block mb-1">Konten Terkait:</strong>
                        @if ($jadwal->menko)
                            {{-- Jika ada, buat link ke halaman detail konten tersebut --}}
                            <a href="{{ route('menkos.show', $jadwal->menko->id) }}" class="text-blue-600 hover:underline font-semibold">
                                {{ $jadwal->menko->judul }}
                            </a>
                        @else
                            <span class="text-gray-600 italic">Tidak terhubung dengan konten manapun.</span>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-bold mb-2">Statistik dari YouTube</h4>
                        
                        {{-- Cek dulu apakah data analitik untuk jadwal ini sudah ada --}}
                        @if($jadwal->analitik)
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-indigo-50 dark:bg-gray-700 rounded-lg">
                                {{-- Views --}}
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">VIEWS</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($jadwal->analitik->views) }}</p>
                                </div>
                                {{-- Likes --}}
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">LIKES</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($jadwal->analitik->likes) }}</p>
                                </div>
                                {{-- Komentar --}}
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">KOMENTAR</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($jadwal->analitik->comments) }}</p>
                                </div>
                            </div>
                        @else
                            {{-- Tampilkan pesan ini jika data analitik belum pernah di-sync --}}
                            <div class="p-4 bg-gray-50 rounded-lg text-center text-sm text-gray-500">
                                Data analitik belum disinkronisasi. Klik tombol "Sync Statistik" di bawah.
                            </div>
                        @endif
                    </div>

                    <hr class="my-6">
                    
                    <h4 class="text-lg font-bold mb-2">Deskripsi & Catatan</h4>
                    <div class="prose max-w-none text-gray-800">
                        {!! nl2br(e($jadwal->deskripsi)) !!}
                    </div>

                    <hr class="my-6">

                    <div class="flex items-center justify-start gap-4 flex-wrap">
                        {{-- Tombol Kembali (sudah ada) --}}
                        <a href="{{ route('jadwals.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                            KEMBALI KE DAFTAR
                        </a>
                        
                        {{-- Tombol Sync (sudah ada) --}}
                        @if($jadwal->status == 'Dipublish' && $jadwal->link_video)
                            <form action="{{ route('analitiks.fetch', $jadwal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600">
                                    Sync Statistik
                                </button>
                            </form>
                        @endif
                        
                        @can('manage-schedules')
                        {{-- Tombol EDIT --}}
                        <a href="{{ route('jadwals.edit', $jadwal->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600">
                            Edit Jadwal
                        </a>

                        {{-- Tombol HAPUS --}}
                        <form action="{{ route('jadwals.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus jadwal ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Hapus Jadwal
                            </button>
                        </form>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>