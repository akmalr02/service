<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
            <a href="{{ url('/homeAuth') }}" class="btn btn-dark align-items-center mt-2">
                <i class="bi bi-backspace-fill me-2"></i> Back
            </a>

        </div>
        {{-- form input --}}
        <form class="row g-3" method="post" action={{ route('service.store') }} enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="laptop_model" class="form-label">Model laptop</label>
                <input type="text" class="form-control" name="laptop_model" id="laptop_model"
                    placeholder="Model laptop">
            </div>
            <div class="mb-3">
                <label for="problem_description" class="form-label">Deskripsi masalah</label>
                <textarea class="form-control" id="problem_description" name="problem_description" rows="3"
                    placeholder="deskripsi masalah"></textarea>
            </div>
            <!-- submit form -->
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>

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
