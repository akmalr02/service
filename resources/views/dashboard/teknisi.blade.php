<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
     Pesan sukses dan error
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
    @foreach ($services as $service)
        <div>
            <h2>{{ $service->laptop_model }}</h2>
            <p>{{ $service->problem_description }}</p>
            <p>Status: {{ $service->status_tugas }}</p>

            @if ($service->status_tugas == 'available')
                <form action="{{ route('tugas.take', $service->id) }}" method="POST">
                    @csrf
                    <button type="submit">Ambil Tugas</button>
                </form>
            @endif
        </div>
    @endforeach
  </x-layouts-home>
  