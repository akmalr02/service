<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
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
                    <th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->laptop_model }}</td>
                    {{-- <td>{{ $ticket->technician->name ?? 'Belum diteruskan' }}</td> --}}
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

        <!-- Tampilkan daftar teknisi -->
        {{-- <h2 class="mt-5">Daftar Teknisi</h2>
        <ul>
            @foreach ($technicians as $technician)
            <li>{{ $technician->name }}</li>
            @endforeach
        </ul> --}}
   
</x-layouts-home>
