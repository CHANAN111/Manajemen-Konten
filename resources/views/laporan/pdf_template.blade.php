<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        /* CSS sederhana untuk tampilan PDF */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 0px;
        }
        .date {
            text-align: center;
            font-size: 14px;
            margin-top: 5px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="date">Per tanggal: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Judul Video</th>
                <th>Tgl Tayang</th>
                <th>Views</th>
                <th>Likes</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($analitiks as $analitik)
                <tr>
                    {{-- Gunakan Null-safe operator (?) di PHP 8+ atau ternary check untuk keamanan --}}
                    <td>{{ $analitik->jadwal?->judul_video ?? 'Data Jadwal Dihapus' }}</td>
                    <td>{{ $analitik->jadwal?->tanggal_tayang ? \Carbon\Carbon::parse($analitik->jadwal->tanggal_tayang)->format('d M Y') : 'N/A' }}</td>
                    <td>{{ number_format($analitik->views) }}</td>
                    <td>{{ number_format($analitik->likes) }}</td>
                    <td>{{ number_format($analitik->comments) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data untuk ditampilkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>