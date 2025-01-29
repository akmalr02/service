<x-layouts-welcome>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="hero">
        {{-- Pesan sukses dan error --}}
        @if (session('success'))
            <div class="alert alert-success mb-4 w-100">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mb-4 w-100">
                {{ session('error') }}
            </div>
        @endif
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px;">
                <h1 class="text-center mb-4">Login</h1>

                <!-- Notifikasi Error -->
                @if (session('signInError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('signInError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="/login" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your E-mail" required value="{{ old('email') }}" autocomplete="email">
                    </div>

                    <!-- Password -->
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your Password" required autocomplete="current-password">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i id="eyeOpen" class="bi bi-eye" style="display: none;"></i>
                                <i id="eyeClosed" class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <!-- tombol sigin -->
                    <button type="submit" class="btn btn-primary w-100 my-4">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                <!-- Tombol Register -->
                <p class="text-center">
                    Belum punya akun? Silakan
                    <a href="/registrasi" class="d-inline-block mt-2">
                        Register
                    </a>
                </p>

            </div>
        </div>
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
