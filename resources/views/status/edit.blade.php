<x-layouts-home>
  <x-slot:title>
    {{ $title }}
  </x-slot:title>

  <div class="container-fluid">
    <div class="text-start mb-3">
      <h1 class="fs-1 pt-3 pb-2 mb-3 border-bottom">{{ $title }}</h1>
      <a href="{{ url('/status') }}" class="btn btn-dark align-items-center mt-2">
        <i class="bi bi-backspace-fill me-2"></i> Back
      </a>
    </div>

  {{-- Form Input --}}
  <form class="row g-3" method="post" action="{{ route('status.update', $status->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Status Name -->
    <div class="col-md-4">
      <label for="status_name" class="form-label">Status Name</label>
      <input 
        type="text" 
        class="form-control @error('status_name') is-invalid @enderror" 
        id="status_name" 
        name="status_name" 
        value="{{ old('status_name', $status->status_name) }}" 
        placeholder="Enter Status Name" 
        required
      >
      @error('status_name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Description -->
    <div class="col-md-6">
      <label for="description" class="form-label">Deskripsi</label>
      <textarea 
          class="form-control @error('description') is-invalid @enderror" 
          id="description" 
          name="description" 
          placeholder="Enter Deskripsi" 
          rows="4" 
          required
      >{{ old('description', $status->description) }}</textarea>
      @error('description')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
  </div>

    <!-- Submit Button -->
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Update Status</button>
    </div>
  </form>
</div>

</x-layouts-home>
