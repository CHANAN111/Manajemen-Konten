<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Menko') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tombol Tambah Data --}}
                    @can('manage-content')
                    <a href="{{ route('menkos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-4">
                        TAMBAH KONTEN
                    </a>
                    @endcan

                    <div class="mb-4 p-4 bg-gray-100 rounded-lg">
                        <form action="{{ route('menkos.index') }}" method="GET">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Input Pencarian Judul --}}
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Judul</label>
                                    <input type="text" name="search" id="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ketik judul konten..." value="{{ request('search') }}">
                                </div>

                                {{-- Filter Berdasarkan Status --}}
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Filter Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Semua Status</option>
                                        <option value="Rencana" @if(request('status') == 'Rencana') selected @endif>Rencana</option>
                                        <option value="Dubbing" @if(request('status') == 'Dubbing') selected @endif>Dubbing</option>
                                        <option value="Editing" @if(request('status') == 'Editing') selected @endif>Editing</option>
                                        <option value="Terjadwal" @if(request('status') == 'Terjadwal') selected @endif>Terjadwal</option>
                                    </select>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="flex items-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Cari
                                    </button>
                                    <a href="{{ route('menkos.index') }}" class="ms-3 inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Pesan Sukses --}}
                    @if(session()->has('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-300">
                                {{-- <tr class="bg-gray-100 whitespace-nowrap"> --}}
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">FILE NASKAH</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">FILE DUBBING</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">JUDUL</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">STATUS</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">EDITOR</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900" style="width: 20%">AKSI</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($menkos as $menko)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            @if($menko->file_naskah)
                                                <a href="{{ asset('storage/' . $menko->file_naskah) }}" target="_blank" class="inline-block rounded bg-blue-500 px-3 py-1 text-xs font-medium text-white hover:bg-blue-600">
                                                    Download
                                                </a>
                                            @else
                                                <span class="text-xs italic text-gray-500">Tidak ada file</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            @if($menko->file_dubbing)
                                                <a href="{{ asset('storage/' . $menko->file_dubbing) }}" target="_blank" class="inline-block rounded bg-teal-500 px-3 py-1 text-xs font-medium text-white hover:bg-teal-600">
                                                    Download
                                                </a>
                                            @else
                                                <span class="text-xs italic text-gray-500">Tidak ada file</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $menko->judul }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            <span class="inline-flex items-center justify-center rounded-full px-2.5 py-0.5 
                                                @if($menko->status == 'Terjadwal') bg-blue-100 text-blue-700 @endif
                                                @if($menko->status == 'Editing') bg-yellow-100 text-yellow-700 @endif
                                                @if($menko->status == 'Dubbing') bg-purple-100 text-purple-700 @endif
                                                @if($menko->status == 'Rencana') bg-gray-100 text-gray-700 @endif
                                            ">
                                                <p class="whitespace-nowrap text-sm">{{ $menko->status }}</p>
                                            </span>
                                        </td>

                                        <td class="px-4 py-2 text-gray-700">
                                            @if ($menko->editor)
                                                <div class="flex items-center gap-2">
                                                    {{-- Avatar Editor --}}
                                                    @if($menko->editor->avatar)
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $menko->editor->avatar) }}" alt="{{ $menko->editor->name }}">
                                                    @else
                                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500">
                                                            <span class="text-xs font-medium leading-none text-white">{{ strtoupper(substr($menko->editor->name, 0, 2)) }}</span>
                                                        </span>
                                                    @endif
                                                    {{-- Nama Editor --}}
                                                    <span>{{ $menko->editor->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs italic text-gray-500">Belum Ditugaskan</span>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-2 text-center">
                                            {{-- Tombol Lihat selalu tampil untuk semua orang --}}
                                            <a href="{{ route('menkos.show', $menko->id) }}" class="inline-block rounded bg-indigo-600 ...">LIHAT</a>

                                            {{-- Tombol Edit dan Hapus hanya untuk yang berhak --}}
                                            @can('manage-content')
                                                <form class="inline-block" onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('menkos.destroy', $menko->id) }}" method="POST">
                                                    <a href="{{ route('menkos.edit', $menko->id) }}" class="inline-block rounded bg-yellow-500 ...">EDIT</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block rounded bg-red-600 ...">HAPUS</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    {{-- ... Bagian empty tidak berubah ... --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Navigasi Halaman --}}
                    <div class="mt-4">
                        {{ $menkos->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>