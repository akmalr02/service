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
          <a href="status/create" class="btn btn-info align-items-center mt-2">
              <i class="bi bi-plus-circle me-2"></i> Buat Status
          </a>
      </div>
  </div>

  @if($status->isEmpty())
      <p>Tidak ada status.</p>
  @else
      <table class="table table-striped">
          <thead class="table-dark">
              <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Deskripsi </th>
                  <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($status as $service)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $service->status_name }}</td>
                      <td>{{ $service->description }}</td>
                      <td>
                        {{-- <a href="status/{{ $service->id }}" class="btn btn-info text-decoration-none">Detail</a> --}}
                        <a href="status/{{ $service->id }}/edit" class="btn btn-warning text-decoration-none">Edit</a>
                        <form action="status/{{ $service->id }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger border-0">Hapus</button>
                        </form>
                    </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  @endif
</x-layouts-home>

<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus data ini?'); // Pesan konfirmasi
    }
</script>