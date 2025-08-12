<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User dan Posisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <a href="{{ route('users.create') }}" class="inline-block rounded items-center px-4 py-2 bg-blue-300 border ... mb-4">
                        BUAT USER BARU
                    </a>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">NAMA</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">EMAIL</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Posisi</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center justify-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-indigo-700 text-xs">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="inline-block rounded bg-yellow-500 px-4 py-2 text-xs font-medium text-white hover:bg-yellow-600">Edit Posisi</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>