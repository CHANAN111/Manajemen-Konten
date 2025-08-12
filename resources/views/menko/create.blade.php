<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Konten Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- PENTING: Tambahkan enctype untuk upload file --}}
                    <form action="{{ route('menkos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="file_naskah" class="block font-medium text-sm text-gray-700">UPLOAD NASKAH (WORD)</label>
                            <input type="file" id="file_naskah" name="file_naskah" class="block mt-1 w-full" accept=".doc,.docx">
                            @error('file_naskah')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="file_dubbing" class="block font-medium text-sm text-gray-700">UPLOAD FILE DUBBING (ZIP/MP3/WAV)</label>
                            <input type="file" id="file_dubbing" name="file_dubbing" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".zip,.rar,.mp3,.wav,.m4a">
                            @error('file_dubbing')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="judul" class="block font-medium text-sm text-gray-700">JUDUL</label>
                            <input type="text" id="judul" name="judul" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('judul') border-red-500 @enderror" value="{{ old('judul') }}">
                            @error('judul')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="konten" class="block font-medium text-sm text-gray-700">KONTEN</label>
                            <textarea id="konten" name="konten" rows="5" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('konten') border-red-500 @enderror">{{ old('konten') }}</textarea>
                            @error('konten')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">STATUS PRODUKSI</label>
                            <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                {{-- Di file edit.blade.php, gunakan old('status', $menko->status) --}}
                                <option value="Rencana" @if(old('status', $menko->status ?? '') == 'Rencana') selected @endif>Rencana</option>
                                <option value="Dubbing" @if(old('status', $menko->status ?? '') == 'Dubbing') selected @endif>Dubbing</option>
                                <option value="Editing" @if(old('status', $menko->status ?? '') == 'Editing') selected @endif>Editing</option>
                                <option value="Terjadwal" @if(old('status', $menko->status ?? '') == 'Terjadwal') selected @endif>Terjadwal</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                                BUAT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>