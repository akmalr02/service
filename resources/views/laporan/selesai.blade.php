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
        </div>
    </div>
  
    @if($laporan->isEmpty())
        <p>Tidak ada service yang selesai.</p>
    @else
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Model Laptop</th>
                    <th>Deskripsi Masalah</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $ref)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ref->user->name }}</td>
                        <td>{{ $ref->service->laptop_model }}</td>
                        <td>{{ $ref->service->problem_description }}</td>
                        <td>{{ $ref->description}}</td>
                        <td>{{ $ref->status->status_name ?? 'Belum Diproses' }}</td>
                        <td><a href="{{ $ref->id }}/edit" class="btn btn-primary text-decoration-none">Update Tugas</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
  </x-layouts-home>