<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
     {{-- Pesan sukses dan error --}}
     @if(session('success'))
     <div class="alert alert-success">
         {{ session('success') }}
     </div>
    @endif
  
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
  
    <!-- Container untuk mengatur lebar konten -->
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="service/create" class="btn btn-info align-items-center mt-2">
                <i class="bi bi-plus-circle me-2"></i> Buat Tiket
            </a>
        </div>
    </div>
  
    @if($services->isEmpty())
        <p>Tidak ada service yang diajukan.</p>
    @else
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Model Laptop</th>
                    <th>Deskripsi Masalah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->user->name }}</td>
                        <td>{{ $service->laptop_model }}</td>
                        <td>{{ $service->problem_description }}</td>
                        <td>{{ $service->status->status_name ?? 'Belum Diproses' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
  </x-layouts-home>
  