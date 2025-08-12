<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Role untuk: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Nama</label>
                            <input type="text" class="block mt-1 w-full bg-gray-100" value="{{ $user->name }}" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="text" class="block mt-1 w-full bg-gray-100" value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Posisi</label>
                            @foreach ($roles as $role)
                                <div class="flex items-center">
                                    {{-- `roles[]` akan mengirim data sebagai array --}}
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="h-4 w-4 rounded border-gray-300" 
                                        {{-- Cek apakah user sudah memiliki role ini --}}
                                        @if($user->roles->contains($role->id)) checked @endif>
                                    <label class="ms-2 text-sm text-gray-600">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 ...">BATAL</a>
                            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-blue-300 ...">PERBARUI</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>