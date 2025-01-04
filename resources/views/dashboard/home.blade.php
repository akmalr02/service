<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Pesan sukses dan error --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Container untuk mengatur lebar konten -->
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ route('service.create') }}" class="btn btn-info align-items-center mt-2">
                <i class="bi bi-plus-circle me-2"></i> Buat Tiket
            </a>
        </div>
    </div>

    @if($services->isEmpty())
        <p class="text-center">Tidak ada service yang diajukan.</p>
    @else
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Model Laptop</th>
                    <th>Deskripsi Masalah</th>
                    <th>Status</th>
                    <th>Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->laptop_model }}</td>
                        <td>{{ $service->problem_description }}</td>
                        <td>{{ $service->status->status_name ?? 'Belum Diproses' }}</td>
                        <td>
                            @if(optional($service->status)->status_name === 'Penambahan')
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pembayaran Lanjutan
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('service.cancel', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Batalkan Pembayaran</button>
                                            </form>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#payModal{{ $service->id }}">Bayar</button>
                                        </li>
                                    </ul>
                                </div>
                            @elseif(optional($service->status)->status_name === 'Completed')
                                <span class="badge bg-success">Sudah Dibayar</span>
                            @else
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal{{ $service->id }}">Bayar</button>
                            @endif
                        
                            <!-- Modal -->
                            <div class="modal fade" id="payModal{{ $service->id }}" tabindex="-1" aria-labelledby="payModalLabel{{ $service->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="payModalLabel{{ $service->id }}">Pembayaran untuk Service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Silakan transfer pembayaran ke salah satu rekening berikut:</p>
                                            <ul>
                                                <li><strong>Bank BCA</strong>: 123-456-7890 a.n. PT Bee Creative</li>
                                                <li><strong>Bank Mandiri</strong>: 987-654-3210 a.n. PT Bee Creative</li>
                                                <li><strong>Bank BRI</strong>: 456-123-7890 a.n. PT Bee Creative</li>
                                            </ul>
                                            <p>Setelah melakukan transfer, silahkan screenshot, lalu konfirmasi pembayaran Anda ke WhatsApp kami di 0812-3456-789.</p>
                                            
                                            <!-- Menampilkan deskripsi laporan -->
                                            <p><strong>Deskripsi Penambahan:</strong></p>
                                            @php
                                                $laporanDeskripsi = $laporan->where('service_id', $service->id)->first();
                                            @endphp
                                            @if($laporanDeskripsi)
                                                <p>{{ $laporanDeskripsi->description }}</p>
                                            @else
                                                <p>Tidak ada deskripsi penambahan terkait untuk layanan ini.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <a href="{{ route('service.show', $service->id) }}" class="btn btn-info text-decoration-none">Detail</a>
                            @if (optional($service->status)->status_name === 'Payment Pending')
                            <form action="{{ route('service.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger border-0">Batalkan</button>
                            </form>                                
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-layouts-home>

<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin membatalkan service ini?');
    }
</script>
