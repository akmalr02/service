<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/user') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>

        </div>
        {{-- form input --}}
        <form class="row g-3" method="post" action={{ route('user.store') }} enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
            </div>
            <div class="col-md-4">
                <label for="phone_number" class="form-label">Nomor Telepon</label>
                <input type="tel" inputmode="numeric" pattern="\d{11,13}" maxlength="15"
                    class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                    name="phone_number" placeholder="Nomor Telepon (11-13 digit)" value="{{ old('phone_number') }}"
                    aria-describedby="phoneHelp">
                <small id="phoneHelp" class="form-text text-muted"></small>
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Alamat">
            </div>
            <div class="col-md-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option selected disabled value="">Role</option>
                    <option value="admin">Admin</option>
                    <option value="teknisi">Teknisi</option>
                    <option value="user">User</option>
                </select>
            </div>
            <!-- submit form -->
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("form").addEventListener("submit", function(event) {
                event.preventDefault();

                let isValid = true;
                let inputs = document.querySelectorAll("input, textarea, select");

                inputs.forEach(input => {
                    let errorDiv = input.parentNode.querySelector(".text-danger");

                    if (errorDiv) {
                        errorDiv.remove();
                    }

                    if (input.value.trim() === "") {
                        input.classList.add("is-invalid");

                        let errorMessage = document.createElement("div");
                        errorMessage.classList.add("text-danger", "mt-1");
                        errorMessage.innerText = "Field ini tidak boleh kosong!";
                        input.parentNode.appendChild(errorMessage);

                        isValid = false;
                    } else {
                        input.classList.remove("is-invalid");
                    }

                    // Hapus pesan error saat input diisi
                    input.addEventListener("input", function() {
                        if (input.value.trim() !== "") {
                            input.classList.remove("is-invalid");
                            if (errorDiv) {
                                errorDiv.remove();
                            }
                        }
                    });
                });

                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
</x-layouts-home>
