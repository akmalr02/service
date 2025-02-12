<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Pesan sukses dan error --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Container untuk konten -->
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            
        </div>
        {{-- Daftar Tugas --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            @forelse ($services as $service)
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->laptop_model }}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                {{ ucfirst($service->status_tugas) }}
                            </h6>
                            <p class="card-text">{{ $service->problem_description }}</p>
                            <a href="tugas/{{ $service->id }}" class="btn btn-primary text-decoration-none">View Tiket</a>

                        </div>
                    </div>
                </div>
            @empty
            <div class="w-100">
                <p class="text-center fw-bold fs-4">Pekerjaan Tidak tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-layouts-home>
