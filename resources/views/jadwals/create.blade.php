<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? 'Buat Jadwal Baru' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('jadwals.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="judul_video" class="block font-medium text-sm text-gray-700">JUDUL VIDEO</label>
                            <input type="text" id="judul_video" name="judul_video" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('judul_video') }}">
                            @error('judul_video') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="menko_id" class="block font-medium text-sm text-gray-700">HUBUNGKAN DENGAN KONTEN (OPSIONAL)</label>
                            <select name="menko_id" id="menko_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="">-- Tidak Dihubungkan --</option>
                                {{-- Loop semua data konten yang dikirim dari controller --}}
                                @foreach($menkos as $item)
                                    <option value="{{ $item->id }}" {{ old('menko_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('menko_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_tayang" class="block font-medium text-sm text-gray-700">TANGGAL TAYANG</label>
                            <input type="datetime-local" id="tanggal_tayang" name="tanggal_tayang" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('tanggal_tayang') }}">
                            @error('tanggal_tayang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">STATUS PUBLIKASI</label>
                            <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                {{-- Di file edit.blade.php, gunakan old('status', $jadwal->status) --}}
                                <option value="Draf" @if(old('status', $jadwal->status ?? '') == 'Draf') selected @endif>Draf</option>
                                <option value="Dipublish" @if(old('status', $jadwal->status ?? '') == 'Dipublish') selected @endif>Dipublish</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="link_video" class="block font-medium text-sm text-gray-700">LINK VIDEO (Opsional)</label>
                            <input type="text" id="link_video" name="link_video" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('link_video') }}" placeholder="https://youtube.com/watch?v=...">
                            @error('link_video') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block font-medium text-sm text-gray-700">DESKRIPSI / CATATAN (Opsional)</label>
                            <textarea id="deskripsi" name="deskripsi" rows="5" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jadwals.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">KEMBALI</a>
                            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">BUAT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>