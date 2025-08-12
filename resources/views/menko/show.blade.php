<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Judul Konten --}}
                    <h3 class="text-3xl font-bold mb-2">{{ $menko->judul }}</h3>

                    {{-- Metadata: Status, Editor, dan Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-500 mb-4">
                        <div>
                            <strong>Status Produksi:</strong> 
                            <span class="font-semibold text-gray-800">{{ $menko->status }}</span>
                        </div>
                        <div>
                            <strong>Ditugaskan kepada:</strong>
                            <span class="font-semibold text-gray-800">{{ $menko->editor?->name ?? 'Belum Ditugaskan' }}</span>
                        </div>
                        <div>
                            <strong>Dibuat pada:</strong> 
                            <span class="font-semibold text-gray-800">{{ $menko->created_at->format('d F Y') }}</span>
                        </div>
                    </div>

                    <hr class="my-6">
                    
                    {{-- =============================================== --}}
                    {{-- BAGIAN BARU UNTUK FILE DOWNLOAD --}}
                    {{-- =============================================== --}}
                    <div>
                        <h4 class="text-lg font-bold mb-2">File Terlampir</h4>
                        <div class="space-y-3 border p-4 rounded-md">
                            {{-- File Naskah --}}
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-medium">Naskah (.docx, .doc):</p>
                                @if ($menko->file_naskah)
                                    <a href="{{ asset('storage/' . $menko->file_naskah) }}" target="_blank" class="inline-block rounded bg-blue-500 px-3 py-1 text-xs font-medium text-white hover:bg-blue-600">
                                        Download Naskah
                                    </a>
                                @else
                                    <span class="text-sm italic text-gray-500">Tidak ada file</span>
                                @endif
                            </div>

                            <hr class="border-gray-100">

                            {{-- File Dubbing --}}
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-medium">File Dubbing (.zip, .mp3):</p>
                                @if ($menko->file_dubbing)
                                    <a href="{{ asset('storage/' . $menko->file_dubbing) }}" target="_blank" class="inline-block rounded bg-teal-500 px-3 py-1 text-xs font-medium text-white hover:bg-teal-600">
                                        Download Dubbing
                                    </a>
                                @else
                                    <span class="text-sm italic text-gray-500">Tidak ada file</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- =============================================== --}}


                    {{-- Checklist Produksi --}}
                    

                    <hr class="my-6">

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-start gap-4">
                        <a href="{{ route('menkos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                            KEMBALI
                        </a>
                        {{-- Tombol edit dan hapus lain bisa ditambahkan di sini jika perlu --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>