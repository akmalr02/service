<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Pesan sukses dan error --}}
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Container untuk konten -->
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/tugas') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>

        </div>
        {{-- Daftar Tugas --}}
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Nama pengguna :
                <span class="badge text-bg-primary rounded-pill">{{ $service->user->name }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Alamat :
                <span class="badge text-bg-primary rounded-pill">{{ $service->user->address }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Laptop model :
                <span class="badge text-bg-primary rounded-pill">{{ $service->laptop_model }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Status :
                <span class="badge text-bg-primary rounded-pill">{{ ucfirst($service->status_tugas) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Deskripsi masalah :
                <span class="badge text-bg-primary rounded-pill">{{ $service->problem_description }}</span>
            </li>
            @if(!empty($laporan->description))
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Deskripsi penambahan:
                    <span class="badge text-bg-primary rounded-pill">{!! nl2br(e($laporan->description)) !!}</span>
                </li>   
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Teknisi sebelumnya:
                    <span class="badge text-bg-primary rounded-pill">{!! nl2br(e(optional($laporan->technician)->name)) !!}</span>
                </li>   
            @endif
            <form action="{{ route('tugas.take', $service->id) }}" method="POST">
                @csrf
            
                @if ($service->technician_id)
                    {{-- Jika tugas sudah pernah diambil, langsung tampilkan teknisi sebelumnya --}}
                    <p class="m-3">Teknisi sebelumnya: <strong>{{ $service->technician->name }}</strong></p>
                    <input type="hidden" name="technician_id" value="{{ $service->technician_id }}">
                @else
                    {{-- Jika tugas belum pernah diambil, tampilkan pilihan teknisi --}}
                    <label class="m-3" for="technician_id">Pilih Teknisi:</label>
                    <select name="technician_id" id="technician_id" class="form-control">
                        @foreach ($technicians as $technician)
                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                        @endforeach
                    </select>
                @endif
            
                <button type="submit" class="btn btn-primary m-3">
                    Serahkan ke Teknisi
                </button>
            </form>
            
        </ul>
    </div>
</x-layouts-home>
