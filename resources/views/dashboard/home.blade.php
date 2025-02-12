<x-layouts-home>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Pesan sukses dan error --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container-fluid">
        <!-- Header Section -->
        <div class="text-start mb-3">
            <div class="fs-1 pt-3 pb-2 mb-3 border-bottom">
                {{ $title }}
            </div>
        </div>
            
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Tombol Buat Tiket -->
            <a href="{{ route('service.create') }}" class="btn btn-info">
                <i class="bi bi-plus-circle me-2"></i> Buat Tiket
            </a>
        
            <!-- Tombol Syarat dan Ketentuan -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal">
                Syarat dan Ketentuan
            </button>
        </div>
        
      <!-- Modal syarat dan ketentuan -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="myModalLabel">Syarat dan Ketentuan Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <p class="text-black">
                        Dengan menggunakan layanan kami, pengguna dianggap telah membaca, memahami, dan menyetujui syarat dan ketentuan berikut:
                    </p>
                    <ul class="text-black">
                        <li><strong>Wilayah Layanan</strong>
                            <ul>
                                <li>Layanan onsite service hanya tersedia di wilayah Jabodetabek.</li>
                                <li>Biaya layanan di Jakarta sebesar Rp100.000.</li>
                                <li>Untuk wilayah di luar Jakarta (Bogor, Depok, Tangerang, dan Bekasi), akan dikenakan biaya tambahan sebesar Rp50.000.</li>
                                <li>Pemesanan di luar wilayah tersebut tidak dapat diproses atau langsung kami batalkan.</li>
                            </ul>
                        </li>
                        <li><strong>Waktu Pengerjaan</strong>
                            <ul>
                                <li>Pengerjaan akan diproses dalam waktu 1x24 jam pada hari kerja setelah permintaan layanan dikonfirmasi.</li>
                                <li>Hari kerja yang berlaku adalah Senin - Jumat (09.00 - 17.00 WIB).</li>
                                <li>Pemesanan di luar jam kerja akan diproses pada hari kerja berikutnya.</li>
                            </ul>
                        </li>
                        <li><strong>Kondisi Fisik Laptop</strong>
                            <ul>
                                <li>Laptop yang akan diperbaiki harus dalam kondisi yang memungkinkan untuk diperiksa dan diperbaiki.</li>
                                <li>Jika terdapat kerusakan fisik yang parah, seperti layar pecah, casing rusak, atau motherboard terbakar, teknisi akan memberikan rekomendasi lebih lanjut.</li>
                            </ul>
                        </li>
                        <li><strong>Penambahan Part atau Komponen</strong>
                            <ul>
                                <li>Jika dalam proses perbaikan diperlukan penggantian part atau komponen tambahan, pengguna akan diinformasikan terlebih dahulu.</li>
                                <li>Pengguna dapat menyetujui atau menolak penambahan part sebelum pengerjaan dilanjutkan.</li>
                            </ul>
                        </li>
                        <li><strong>Persetujuan Pengguna</strong>
                            <ul>
                                <li>Dengan menggunakan layanan ini, pengguna menyatakan telah membaca dan menyetujui seluruh Syarat dan Ketentuan yang berlaku.</li>
                                <li>BeeCS tidak bertanggung jawab atas kehilangan data, kerusakan tambahan akibat kondisi perangkat sebelumnya, atau kelalaian pengguna dalam memberikan informasi yang benar.</li>
                            </ul>
                        </li>
                    </ul>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-black" for="flexCheckDefault">
                            Saya setuju
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    </div>

    {{-- isi service setiap user --}}
    @if($services->isEmpty())
        <p class="text-center">Tidak ada service yang diajukan.</p>
    @else
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Model Laptop</th>
                    <th>Deskripsi Masalah</th>
                    <th>Status</th>
                    <th>Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->laptop_model }}</td>
                        <td>{{ $service->problem_description }}</td>
                        <td>{{ $service->status->status_name ?? 'Belum Diproses' }}</td>
                        <td>
                            @if(optional($service->status)->status_name === 'Penambahan')
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pembayaran Lanjutan
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('service.cancel', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Batalkan Pembayaran</button>
                                            </form>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#payModal{{ $service->id }}">Bayar</button>
                                        </li>
                                    </ul>
                                </div>
                            @elseif(optional($service->status)->status_name === 'Completed')
                                <span class="badge bg-success">Sudah Dibayar</span>
                            @else
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal{{ $service->id }}">Bayar</button>
                            @endif
                        
                            <!-- Modal bayar -->
                            <div class="modal fade" id="payModal{{ $service->id }}" tabindex="-1" aria-labelledby="payModalLabel{{ $service->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="payModalLabel{{ $service->id }}">Pembayaran untuk Service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Silakan transfer pembayaran ke salah satu rekening berikut:</p>
                                            <ul>
                                                <li><strong>Bank BCA</strong>: 123-456-7890 a.n. PT Bee Creative</li>
                                                <li><strong>Bank Mandiri</strong>: 987-654-3210 a.n. PT Bee Creative</li>
                                                <li><strong>Bank BRI</strong>: 456-123-7890 a.n. PT Bee Creative</li>
                                            </ul>
                                            <p>Setelah melakukan transfer, silahkan screenshot, lalu konfirmasi pembayaran Anda ke WhatsApp kami di 0812-3456-789.</p>

                                            @if (optional($service->status)->status_name === 'Payment Pending')
                                                {{-- upload pembayaran --}}
                                                <form action="{{ route('upload.payment', $service->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="paymentImage" class="form-label"><strong>Upload Pembayaran</strong></label>
                                                        <input class="form-control" type="file" id="paymentImage" name="payment_image" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                                                </form>
                                            @else
                                                <!-- Menampilkan deskripsi laporan -->
                                                <p class="mt-3"><strong>Deskripsi Penambahan:</strong></p>
                                                    @php
                                                        $laporanDeskripsi = $laporan->where('service_id', $service->id)->first();
                                                    @endphp
                                                @if($laporanDeskripsi)
                                                    <p>{{ $laporanDeskripsi->description }}</p>

                                                    {{-- upload pembayaran 2--}}
                                                    <form action="{{ route('upload.tambah', $service->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="paymentTambah" class="form-label"><strong>Upload Pembayaran Tambahan</strong></label>
                                                            <input class="form-control" type="file" id="paymentTambah" name="payment_tambah" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                                                    </form>
                                                @else
                                                    <p>Tidak ada deskripsi penambahan terkait untuk layanan ini.</p>
                                                @endif
                                            @endif                     
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <a href="{{ route('service.show', $service->id) }}" class="btn btn-info text-decoration-none">Detail</a>
                            @if (optional($service->status)->status_name === 'Payment Pending')
                            <form action="{{ route('service.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger border-0">Batalkan</button>
                            </form>                                
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-layouts-home>

<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin membatalkan service ini?');
    }

    document.getElementById("btnSimpan").addEventListener("click", function () {
        let checkbox = document.getElementById("flexCheckDefault");
        
        if (!checkbox.checked) {
            alert("Harap setujui syarat dan ketentuan sebelum menyimpan.");
        } else {
            alert("Syarat dan ketentuan telah disetujui. Data berhasil disimpan!");
            
            // Tutup modal setelah menyimpan (opsional)
            let modalElement = document.getElementById("myModal");
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
        }
    });
</script>
