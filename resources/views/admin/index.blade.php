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
            <a href="user/create" class="btn btn-info align-items-center mt-2">
                <i class="bi bi-plus-circle me-2"></i> Tambah User
            </a>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="user/{{ $user->id }}" class="btn btn-info text-decoration-none">Detail</a>
                                <a href="user/{{ $user->id }}/edit" class="btn btn-warning text-decoration-none">Edit</a>
                                <form action="user/{{ $user->id }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger border-0">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts-home>

<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus user ini?');
    }
</script>
