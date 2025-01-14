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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        {{-- form input --}}
        <form class="row g-3" method="post" action="{{ route('register.store') }}" enctype="multipart/form-data">
            @csrf
        
            <!-- Name -->
            <div class="col-md-4">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="User name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Email -->
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Phone Number -->
            <div class="col-md-4">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" inputmode="numeric" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}" required>
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Address -->
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" value="{{ old('address') }}" required>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Password -->
            <div class="col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Submit -->
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