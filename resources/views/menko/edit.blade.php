<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Form action menunjuk ke route 'update' dan menggunakan method PUT --}}
                    <form action="{{ route('menkos.update', $menko->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="file_naskah" class="block font-medium text-sm text-gray-700">UPLOAD NASKAH BARU (OPSIONAL)</label>

                            {{-- Tampilkan link download file yang ada saat ini --}}
                            @if($menko->file_naskah)
                                <div class="mt-2 text-sm">
                                    <p>File saat ini: 
                                        <a href="{{ asset('storage/' . $menko->file_naskah) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Download Naskah
                                        </a>
                                    </p>
                                </div>
                            @endif

                            <input type="file" id="file_naskah" name="file_naskah" class="block mt-2 w-full" accept=".doc,.docx">
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengganti file naskah.</small>
                            @error('file_naskah')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="file_dubbing" class="block font-medium text-sm text-gray-700">UPLOAD FILE DUBBING BARU (OPSIONAL)</label>
                            
                            {{-- Tampilkan link download jika file sudah ada --}}
                            @if($menko->file_dubbing)
                                <div class="mt-2 text-sm">
                                    <p>File dubbing saat ini: 
                                        <a href="{{ asset('storage/' . $menko->file_dubbing) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Download File Dubbing
                                        </a>
                                    </p>
                                </div>
                            @endif

                            <input type="file" id="file_dubbing" name="file_dubbing" class="block mt-2 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".zip,.rar,.mp3,.wav,.m4a">
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengganti file dubbing.</small>
                            @error('file_dubbing')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="judul" class="block font-medium text-sm text-gray-700">JUDUL</label>
                            {{-- 'old' akan mengambil data lama dari validasi, jika tidak ada, ambil dari database --}}
                            <input type="text" id="judul" name="judul" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('judul') border-red-500 @enderror" value="{{ old('judul', $menko->judul) }}">
                            @error('judul')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="konten" class="block font-medium text-sm text-gray-700">KONTEN</label>
                            <textarea id="konten" name="konten" rows="5" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('konten') border-red-500 @enderror">{{ old('konten', $menko->konten) }}</textarea>
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

                        @if(in_array($menko->status, ['Editing', 'Dubbing', 'Terjadwal']))
                        <div class="mb-4">
                            <label for="editor_id" class="block font-medium text-sm text-gray-700">TUGASKAN KEPADA EDITOR (OPSIONAL)</label>
                            <select name="editor_id" id="editor_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="">-- Tidak Ditugaskan --</option>
                                
                                {{-- Loop semua data editor yang dikirim dari controller --}}
                                @foreach($editors as $editor)
                                    <option value="{{ $editor->id }}" {{ old('editor_id', $menko->editor_id) == $editor->id ? 'selected' : '' }}>
                                        {{ $editor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('editor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('menkos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                                KEMBALI
                            </a>
                            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                                UPDATE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>