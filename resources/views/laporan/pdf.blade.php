<!DOCTYPE html>
<html>

<head>
    <title>Laporan Teknisi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        header img {
            height: 70px;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f4f4f4;
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $logoPath }}" alt="Logo Perusahaan">
    </header>
    <h1>{{ $title }} Teknisi </h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Teknisi</th>
                <th>Nama User</th>
                <th>Model Laptop</th>
                <th>Status</th>
                <th>Deskripsi</th>
                <th>Waktu dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $log)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ optional($log->technician)->name ?? '-' }}</td>
                    <td>{{ optional($log->user)->name ?? '-' }}</td>
                    <td>{{ optional($log->service)->laptop_model ?? '-' }}</td>
                    <td style="text-align: center;">{{ optional($log->status)->status_name ?? '-' }}</td>
                    <td>{{ $log->description ?? '-' }}</td>
                    <td>{{ optional($log->service)->created_at ? $log->service->created_at->format('H:i:s d-m-Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
        <p>&copy; {{ \Carbon\Carbon::now()->year }} PT Bea Creative Solution. Semua hak dilindungi.</p>
    </footer>
</body>

</html>
