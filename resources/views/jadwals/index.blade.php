<x-app-layout>
    {{-- Slot untuk Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? 'Penjadwalan Konten' }}
        </h2>
    </x-slot>

    {{-- Slot Utama (Default) untuk Konten Halaman --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('jadwals.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 mb-4">
                        BUAT JADWAL BARU
                    </a>

                    @if(session()->has('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    {{-- DIV untuk kalender --}}
                    <div id='calendar' class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>


    {{-- ========================================================== --}}
    {{-- PENTING: @push sekarang berada DI DALAM x-app-layout --}}
    {{-- Letakkan di bagian paling bawah sebelum tag penutup --}}
    {{-- ========================================================== --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (typeof FullCalendar === 'undefined') {
                console.error('ERROR: FullCalendar library tidak termuat. Cek file app.js dan jalankan `npm run dev`.');
                return;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin, FullCalendar.listPlugin, FullCalendar.interactionPlugin ],
                editable: true,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: '{{ route("api.jadwals.index") }}',
                eventDrop: function(info) {
                    // Minta konfirmasi dari user
                    if (!confirm("Anda yakin ingin memindahkan jadwal '" + info.event.title + "'?")) {
                        // Jika dibatalkan, kembalikan event ke posisi semula
                        info.revert();
                        return;
                    }

                    // Ambil ID event dan tanggal baru
                    let jadwalId = info.event.id;
                    let newStartDate = info.event.startStr;

                    // Kirim request AJAX ke server menggunakan Fetch API
                    fetch(`/api/jadwals/${jadwalId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            // Ini sangat penting untuk keamanan Laravel (CSRF Token)
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            start: newStartDate // Kirim tanggal baru
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            // Jika server mengembalikan error, batalkan perubahan
                            throw new Error('Update gagal');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Update berhasil!');
                        // Opsional: tampilkan notifikasi sukses (misalnya dengan library SweetAlert)
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi error saat memindahkan jadwal.');
                        info.revert(); // Kembalikan event jika ada error
                    });
                },
                locale: 'id',
                timeZone: 'Asia/Jakarta',

                eventContent: function(arg) {
                    // Ambil warna dari data event yang kita kirim dari API
                    let eventColor = arg.event.backgroundColor;

                    // Struktur HTML untuk isi event, sekarang dengan inline style untuk warna
                    let eventHtml = `
                        <div class="fc-event-main-frame" 
                            style="background-color: ${eventColor}; border-color: ${eventColor}; color: white; padding: 2px 4px; height: 100%; border-radius: 3px;">
                            <div class="fc-event-time">${arg.timeText}</div>
                            <div class="fc-event-title-container">
                                <div class="fc-event-title fc-sticky" style="white-space: normal;">
                                    ${arg.event.title}
                                </div>
                            </div>
                        </div>
                    `;
                    return { html: eventHtml };
                },
            });
            calendar.render();
        });
    </script>
    @endpush

</x-app-layout>