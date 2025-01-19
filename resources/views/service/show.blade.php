<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/homeAuth') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>           
        </div>
        <div class="card" style="display: flex; justify-content-center">
            <div class="card-header">
              Tiket Details
            </div>
            <div class="card-body">
                <p class="my-4"><strong>User Name:</strong> {{ $service->user->name }}</p>
                <p class="my-4"><strong>Adress:</strong> {{ $service->user->address }}</p>
                <p class="my-4"><strong>No_telpon:</strong> {{ $service->user->phone_number }}</p>
                <p class="my-4"><strong>Jenis laptop:</strong> {{ $service->laptop_model }}</p>
                <p class="my-4"><strong>Descripsi:</strong> {{ $service->problem_description }}</p>
                @if (optional($service->status)->status_name == 'Payment Pending')
                        <a href="{{ $service->id }}/edit" class="btn btn-warning text-decoration-none">Ubah Keterangan</a>
                    @else
                        <p class="my-4"><strong>Status:</strong> {{ optional($service->status)->status_name }}</p>
                @endif
            </div>

          </div>
                
</x-layouts-home>
