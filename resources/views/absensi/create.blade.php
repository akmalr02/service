<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container">
        <h1>{{ $title }}</h1>
    
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    
        @if ($absensiHariIni && $absensiHariIni->jam_keluar)
            <p>Anda sudah menyelesaikan absensi hari ini.</p>
        @elseif ($absensiHariIni)
            <p>Status: {{ $absensiHariIni->status }}</p>
            
            {{-- Tampilkan tombol "Absen Keluar" hanya jika status adalah "Hadir" --}}
            @if ($absensiHariIni->status === 'Hadir')
                <form action="{{ route('absensi.keluar') }}" method="POST">
                    @csrf
                    <p>Jam Masuk: {{ $absensiHariIni->jam_masuk }}</p>
                    <button type="submit" class="btn btn-warning">Absen Keluar</button>
                </form>
            @else
                <p>Tidak diperlukan absen keluar untuk status "{{ $absensiHariIni->status }}".</p>
            @endif
        @else
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Hadir" selected>Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpha">Alpha</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @endif
    </div>
</x-layouts-home>
