<x-layouts-home>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="container mt-5">
    <h1 class="mb-4">Buat Tiket Baru</h1>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Pilih Pengguna</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Pilih Pengguna --</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="payment" class="form-label">Pembayaran</label>
            <select name="payment" id="payment" class="form-select" required>
                <option value="1">Sudah Dibayar</option>
                <option value="0">Belum Dibayar</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</x-layouts-home>