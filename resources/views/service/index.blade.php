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
            <thead>
                <tr>
                    <th>No</th>
                    <th>Model Laptop</th>
                    <th>Deskripsi Masalah</th>
                    <th>Status</th>
                    <th>Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->laptop_model }}</td>
                        <td>{{ $service->problem_description }}</td>
                        <td>
                            <form action="{{ route('service.updateStatus', $service->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @foreach($statuses as $status)
                                    <div>
                                        <input type="radio" id="status-{{ $service->id }}-{{ $status->id }}" name="status_id" value="{{ $status->id }}" 
                                        {{ $service->status_id == $status->id ? 'checked' : '' }} 
                                        onchange="this.form.submit()">
                                        <label for="status-{{ $service->id }}-{{ $status->id }}">{{ $status->name }}</label>
                                    </div>
                                @endforeach
                            </form>
                        </td>
                        
                        <td>
                            @if($service->is_paid)
                                <span class="badge bg-success">Sudah Dibayar</span>
                            @else
                                <!-- Tombol Bayar -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal{{ $service->id }}">
                                    Bayar
                                </button>

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
                                                <p>Setelah melakukan transfer Silahkan Scerenshot, konfirmasi pembayaran Anda Whatsap kami 0812-3456-789.</p>
                                            </div>
                                            <div class="modal-footer">
                                                {{-- <form action="{{ route('service.pay', $service->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
                                                </form> --}}
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-layouts-home>
