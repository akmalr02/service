<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid">
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/user') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>
        </div>
    </div>

    <div class="card" style="width: 24rem; padding: 20px; font-size: 1.2rem;">
        <div class="card-body">
            <h5 class="card-title p-1" style="font-size: 1.5rem;"><span>Nama: </span>{{ $user->name }}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary pb-3" style="font-size: 1.3rem;">Role: {{ $user->role }}</h6>
            <div class="d-flex justify-content-between align-items-center pb-4">
                <!-- Informasi email dan nomor telepon -->
                <h6 class="card-title text-muted small text-start" style="font-size: 1rem;">{{ $user->email }}</h6>
                <h6 class="card-title text-muted small text-end" style="font-size: 1rem;">{{ $user->phone_number }}</h6>
            </div>
            <p class="card-text" style="font-size: 1.1rem;">{{ $user->address }}</p>
        </div>
    </div>
    
</x-layouts-home>
