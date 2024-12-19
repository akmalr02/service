<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/user') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>
        </div>
    </div>
   
    {{-- Form Input --}}
    <form class="row g-3" method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="col-md-4">
            <label for="name" class="form-label">User Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="User name" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="E-mail" required>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" inputmode="numeric" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Phone Number" required>
            @error('phone_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="Address" required>
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                <option disabled {{ old('role', $user->role) ? '' : 'selected' }}>Select Role</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teknisi" {{ old('role', $user->role) == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Form -->
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Update User</button>
        </div>
    </form>
</x-layouts-home>
