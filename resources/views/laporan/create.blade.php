<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/progres') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-arrow-left-circle me-2"></i> Back
            </a>
        </div>

        {{-- Form Input --}}
        <div class="col-md-12">
            <label for="laporan" class="form-label">Laptop model</label>
            <input class="form-control" type="text" value={{ $services->first()->laptop_model }} aria-label="Disabled input example" disabled readonly >                
        </div>

        <form class="row g-3" method="post" action="{{ route('laporan.store', $services->first()->id) }}" enctype="multipart/form-data">
            @csrf

            <!-- Dropdown untuk memilih status (service) -->
            <div class="col-md-12">
                <label for="laporan" class="form-label">Pilih status</label>
                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                    <option selected disabled >{{ $services->first()->status->status_name }}</option>
                    @foreach ($refStatus as $item)
                        <option value="{{ $item->id }}" {{ old('status_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->status_name ?? 'Tugas #' . $item->id }}
                        </option>
                    @endforeach
                </select>
                @error('status_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Deskripsi -->
            <div class="col-md-12">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-fill me-2"></i> Submit
                </button>
            </div>
        </form>
    </div>
</x-layouts-home>
