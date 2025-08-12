<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? 'Laporan & Analitik' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-800">Laporan Analitik Video</h3>
                        
                        <a href="{{ route('laporan.pdf', request()->query()) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            Download PDF
                        </a>
                    </div>
                    
                    {{-- KARTU GRAFIK --}}
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                        <h3 class="text-lg font-medium mb-4">Top 5 Video Berdasarkan Views</h3>
                        <canvas id="topVideosChart"></canvas>
                    </div>
                    
                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            {{-- Isi thead dan tbody tabel Anda seperti sebelumnya --}}
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">JUDUL VIDEO</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">TANGGAL TAYANG</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        <a href="{{ route('laporan.index', ['sort' => 'views', 'direction' => request('direction', 'desc' ? 'asc' : 'desc')]) }}">VIEWS</a>
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        <a href="{{ route('laporan.index', ['sort' => 'likes', 'direction' => request('direction', 'desc' ? 'asc' : 'desc')]) }}">LIKES</a>
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        <a href="{{ route('laporan.index', ['sort' => 'comments', 'direction' => request('direction', 'desc' ? 'asc' : 'desc')]) }}">KOMENTAR</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($analitiks as $analitik)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $analitik->jadwal->judul_video ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $analitik->jadwal->tanggal_tayang ? \Carbon\Carbon::parse($analitik->jadwal->tanggal_tayang)->format('d M Y') : 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ number_format($analitik->views) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ number_format($analitik->likes) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ number_format($analitik->comments) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <p class="text-gray-500">Belum ada data analitik untuk ditampilkan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $analitiks->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- LETAKKAN SCRIPT LANGSUNG DI SINI --}}
    {{-- ========================================================== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Kita tidak lagi menggunakan DOMContentLoaded karena script sudah pasti dimuat setelah elemen canvas
        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);
        const ctx = document.getElementById('topVideosChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Views',
                        data: chartData,
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>