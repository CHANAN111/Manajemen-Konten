<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('analitiks.store', $jadwal->id) }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="views" class="block font-medium text-sm text-gray-700">VIEWS</label>
                                <input type="number" name="views" id="views" class="block mt-1 w-full rounded-md" value="{{ old('views', $analitik->views ?? 0) }}">
                                @error('views') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="likes" class="block font-medium text-sm text-gray-700">LIKES</label>
                                <input type="number" name="likes" id="likes" class="block mt-1 w-full rounded-md" value="{{ old('likes', $analitik->likes ?? 0) }}">
                                @error('likes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="comments" class="block font-medium text-sm text-gray-700">KOMENTAR</label>
                                <input type="number" name="comments" id="comments" class="block mt-1 w-full rounded-md" value="{{ old('comments', $analitik->comments ?? 0) }}">
                                @error('comments') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="block font-medium text-sm text-gray-700">CATATAN ANALISIS</label>
                            <textarea name="catatan" id="catatan" rows="5" class="block mt-1 w-full rounded-md">{{ old('catatan', $analitik->catatan ?? '') }}</textarea>
                            @error('catatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jadwals.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border ...">KEMBALI</a>
                            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border ...">SIMPAN ANALITIK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>