<x-layouts-welcome>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="hero">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
   
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            
        </div>
        {{-- form input --}}
        <form class="row g-3" method="post" action="{{ route('register.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
                <label for="name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="User name" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="col-md-4">
                <label for="phone_number" class="form-label">Phone Number</label>
                <div class="input-group">
                    <input type="text" inputmode="numeric" class="form-control" id="phone_number" name="phone_number" aria-describedby="inputGroupPrepend2" placeholder="Phone Number" required>
                </div>
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
            </div>
            <!-- submit form -->
            <div class="col-12">
                <button class="btn btn-primary mb-3" type="submit">Submit form</button>
            </div>
        </form>
        <p  >
            sudah punya akun? Silakan 
            <a href="/login" class="btn btn-dark d-flex justify-content-center align-items-center mt-2">
                Sign In
            </a>
        </p>
    </div>
    
</x-layouts-welcome>