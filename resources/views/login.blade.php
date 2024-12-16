<x-layouts-welcome>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="hero">
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

                <form class="space-y-6" action="/login" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control" id="email" name="email" type="email" autocomplete="email" placeholder="Enter your E-mail" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" id="password" name="password" type="password" autocomplete="current-password" placeholder="Enter your Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 my-4">
                        <i class="bi bi-box-arrow-in-right"></i> Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts-welcome>
