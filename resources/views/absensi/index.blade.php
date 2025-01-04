 <x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container">
        <h1>{{ $title }}</h1>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->tanggal }}</td>
                        <td>{{ $data->jam_masuk }}</td>
                        <td>{{ $data->jam_keluar ?? '-' }}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td>{{ $data->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts-home>
