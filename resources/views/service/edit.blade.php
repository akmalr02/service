<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/service',$service->id) }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>
            
        </div>
        {{-- form input --}}
        <form class="row g-3" method="post" action={{ route('service.update',$service->id) }} enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="laptop_model" class="form-label">Model laptop</label>
                <input type="text" class="form-control" name="laptop_model" id="laptop_model" placeholder="Model laptop" value="{{ old('service', $service->laptop_model) }}" required >
              </div>
              <div class="mb-3">
                <label for="problem_description" class="form-label">Problem description</label>
                <textarea class="form-control" id="problem_description" name="problem_description" rows="3" placeholder="Problem description" required>{{ old('service', $service->problem_description) }}</textarea>
              </div>
            <!-- submit form -->
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
        

</x-layouts-home>
