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
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" placeholder="Nama" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="col-md-4">
                <label for="phone_number" class="form-label">Nomor Telepon</label>
                <input type="tel" inputmode="numeric" pattern="\d{11,13}" maxlength="15"
                    class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                    name="phone_number" placeholder="Nomor Telepon (11-13 digit)" value="{{ old('phone_number') }}"
                    required aria-describedby="phoneHelp">
                <small id="phoneHelp" class="form-text text-muted"></small>
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <!-- Address -->
            <div class="col-md-6">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                    name="address" placeholder="Alamat" value="{{ old('address') }}" required>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="col-md-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Password" required>
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i id="eyeOpen" class="bi bi-eye" style="display: none;"></i>
                        <i id="eyeClosed" class="bi bi-eye-slash"></i>
                    </span>
                </div>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <div class="col-12">
                <button class="btn btn-primary mb-3" type="submit">Submit form</button>
            </div>
        </form>
        <p>
            sudah punya akun? Silakan
            <a href="/login" class="btn btn-dark d-flex justify-content-center align-items-center mt-2">
                Login
            </a>
        </p>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            // Toggle the password field type
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the visibility of the icons
            if (type === 'text') {
                eyeOpen.style.display = 'inline';
                eyeClosed.style.display = 'none';
            } else {
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'inline';
            }
        });
    </script>
</x-layouts-welcome>
