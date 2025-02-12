<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
     {{-- Pesan sukses dan error --}}
     @if(session('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            @if (auth()->user()->role !== 'admin')
            <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Buat Tiket Baru</a>
            @endif
        </div>
    </div>

        <!-- Form pembuatan tiket hanya untuk user -->  
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Pengguna</th>
                    <th>Model Laptop</th>
                    <th>Bukti pembayaran</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->laptop_model }}</td>
                    <td>
                        <button class=" btn btn-info" data-bs-toggle="modal" data-bs-target="#payModal{{ $ticket->id }}">
                            Lihat Bukti Bayar
                        </button>
                        
                        <!-- Modal bukti -->
                        <div class="modal fade" id="payModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="payModalLabel{{ $ticket->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="payModalLabel{{ $ticket->id }}">Bukti Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h5>Bukti Trasnfer</h5>
                                        @if($ticket->payment_image)
                                            <img src="{{ asset('storage/' . $ticket->payment_image) }}" alt="Bukti Pembayaran" class="img-fluid rounded">
                                        @else
                                            <p class="text-danger">Belum ada bukti pembayaran.</p>
                                        @endif
                                    </div>
                                    @if (optional($ticket->status)->status_name === 'Penambahan' || optional($ticket->status)->status_name === 'Payment Approved')
                                    <div class="modal-body text-center">
                                        <h5>Bukti Trasnfer penambahan</h5>
                                        @if($ticket->payment_tambah)
                                            <img src="{{ asset('storage/' . $ticket->payment_tambah) }}" alt="Bukti Pembayaran" class="img-fluid rounded">
                                        @else
                                            <p class="text-danger">Belum ada bukti pembayaran.</p>
                                        @endif
                                    </div>
                                    @else
                                        {{-- <p>belum ada bukti transfer tambahan</p> --}}
                                    @endif                                   
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if (auth()->user()->role === 'admin')
                        <!-- Tombol Approve Payment hanya untuk admin -->
                        @if (!$ticket->is_paid)
                        <form action="{{ route('tickets.pay', $ticket->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Approve Payment</button>
                        </form>
                        @else
                        <span class="text-success">Sudah Dibayar</span>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
   
</x-layouts-home>
