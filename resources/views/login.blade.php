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
                <h1 class="text-center mb-4">Sign In</h1>

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
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your E-mail" required value="{{ old('email') }}" autocomplete="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your Password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 my-4">
                        <i class="bi bi-box-arrow-in-right"></i> Sign in
                    </button>
                </form>

                <!-- Tombol Register -->
                <p class="text-center">
                    Belum punya akun? Silakan
                    <a href="/registrasi" class="d-inline-block mt-2">
                        Daftar Akun
                    </a>
                </p>

            </div>
        </div>
    </div>
</x-layouts-welcome>
