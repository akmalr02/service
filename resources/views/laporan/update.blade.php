<x-layouts-home>
  <x-slot:title>{{ $title }}</x-slot:title>

  <div class="container-fluid">
      <div class="text-start mb-3">
          <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
              {{ $title }}
          </div>
          <a href="{{ route('laporan.index') }}" class="btn btn-dark align-items-center mt-2">
              <i class="bi bi-backspace-fill me-2"></i> Back
          </a>
      </div>
  </div>

  {{-- Form Input --}}
  <form class="row g-3" method="post" action="{{ route('laporan.update', $laporan->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="col-md-12">
        <label for="laporan" class="form-label">Laptop model</label>
        <input class="form-control" type="text" value={{  $laporan->service->laptop_model }} aria-label="Disabled input example" disabled readonly >                
    </div>

      <div class="col-md-12">
          <label for="status_id" class="form-label">Status</label>
          <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
              <option disabled {{ old('status_id', $laporan->status_id) ? '' : 'selected' }}>Select Status</option>
              @foreach ($refStatus as $status)
                  <option value="{{ $status->id }}" {{ old('status_id', $laporan->status_id) == $status->id ? 'selected' : '' }}>
                      {{ $status->status_name }}
                  </option>
              @endforeach
          </select>
          @error('status_id')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      {{-- Description --}}
      <div class="col-md-12">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $laporan->description) }}</textarea>
          @error('description')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      {{-- Submit Form --}}
      <div class="col-12">
          <button class="btn btn-primary" type="submit">Update Laporan</button>
      </div>
  </form>
</x-layouts-home>
