<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Ilmuwan Top') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Kartu "Jadwal Akan Tayang" --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Channel</h3>

                    {{-- Grid container untuk kartu statistik --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        {{-- Kartu 1: Konten Draft --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <p class="text-sm font-medium text-yellow-600">Konten Dalam Produksi</p>
                            <p class="text-3xl font-bold text-yellow-800 mt-2">{{ $totalKontenDraft }}</p>
                        </div>

                        {{-- Kartu 2: Video Terjadwal --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <p class="text-sm font-medium text-blue-600">Video Siap Tayang</p>
                            <p class="text-3xl font-bold text-blue-800 mt-2">{{ $totalVideoTerjadwal }}</p>
                        </div>

                        {{-- Kartu 3: Views Bulan Ini --}}
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <p class="text-sm font-medium text-green-600">Total 👁️ Bulan Ini</p>
                            <p class="text-3xl font-bold text-green-800 mt-2">{{ number_format($viewsBulanIni) }}</p>
                        </div>

                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <p class="text-sm font-medium text-red-600">Total 👍Bulan Ini</p>
                            <p class="text-3xl font-bold text-red-800 mt-2">{{ number_format($likesBulanIni) }}</p>
                        </div>

                        {{-- Kartu 4: Tugas Aktif --}}
                        {{-- <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <p class="text-sm font-medium text-red-600">Tugas Belum Selesai</p>
                            <p class="text-3xl font-bold text-red-800 mt-2">{{ $totalTugasAktif }}</p>
                        </div> --}}

                    </div>
                    <div class="mt-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Komposisi Status Konten</h3>
                        
                        {{-- Beri pembungkus dengan tinggi tertentu agar grafik tidak gepeng --}}
                        <div style="height: 300px;">
                            {{-- Di sinilah grafik akan digambar oleh Chart.js --}}
                            <canvas id="statusDonutChart"></canvas>
                        </div>
                    </div>
                    <div class="mt-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Konten yang Ditugaskan kepada Saya</h3>
                        
                        <div class="space-y-3">
                            @forelse ($myAssignedContents as $menko)
                                {{-- Setiap item adalah link ke halaman detail kontennya --}}
                                <a href="{{ route('menkos.show', $menko->id) }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-center">
                                        {{-- Detail Konten --}}
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $menko->judul }}</div>
                                            <div class="text-sm text-gray-500">
                                                Klik untuk melihat detail naskah dan file.
                                            </div>
                                        </div>
                                        
                                        {{-- Badge Status --}}
                                        <span class="text-xs font-semibold text-white px-2 py-1 rounded-full 
                                            @if($menko->status == 'Editing') bg-yellow-500 
                                            @elseif($menko->status == 'Dubbing') bg-purple-500 
                                            @else bg-gray-500 
                                            @endif">
                                            {{ $menko->status }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                {{-- Pesan jika tidak ada tugas --}}
                                <div class="text-center py-4">
                                    <p class="text-gray-500">Luar biasa! Tidak ada konten yang sedang ditugaskan kepada Anda.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- Anda bisa menambahkan kartu-kartu lainnya di sini --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil data dari variabel PHP yang dikirim oleh controller
        const donutLabels = @json($donutChartLabels);
        const donutData = @json($donutChartData);

        // Ambil elemen canvas
        const donutCtx = document.getElementById('statusDonutChart');

        if (donutCtx) {
            new Chart(donutCtx, {
                type: 'doughnut', // Tipe grafik: donat
                data: {
                    labels: donutLabels,
                    datasets: [{
                        label: 'Jumlah Konten',
                        data: donutData,
                        // Warna-warna yang bagus dan modern untuk setiap status
                        backgroundColor: [
                            'rgba(234, 179, 8, 0.7)',   // Rencana (Kuning Amber)
                            'rgba(139, 92, 246, 0.7)', // Dubbing (Ungu Violet)
                            'rgba(59, 130, 246, 0.7)',  // Editing (Biru)
                            'rgba(16, 185, 129, 0.7)',  // Terjadwal (Hijau Emerald)
                            // Tambahkan warna lain jika ada status lain
                        ],
                        borderColor: [ // Warna border agar terlihat solid
                            'rgba(234, 179, 8, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Penting agar grafik mengisi div pembungkusnya
                    plugins: {
                        legend: {
                            position: 'top', // Posisi legenda (Rencana, Editing, dll)
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>