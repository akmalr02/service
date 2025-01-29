<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\Service;
use App\Models\ServiceStatus;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Laporan Teknisi';
        $laporan = laporan::all();
        // dd($laporan);
        return view('laporan.index', [
            'title' => $title,
            'laporan' => $laporan,
        ]);
    }

    public function selesai()
    {

        $title = 'Laporan Selesai';
        $status = ServiceStatus::where('status_name', 'Completed')->first();

        $laporan = Laporan::with(['service', 'user', 'status'])
            ->whereHas('status', function ($query) use ($status) {
                $query->where('id', $status->id); // Memfilter berdasarkan ID status
            })
            ->latest()
            ->get();

        return view('laporan.selesai', [
            'title' => $title,
            'laporan' => $laporan,
        ]);
    }


    public function penambahan()
    {
        $title = 'Laporan Penambahan';
        $status = ServiceStatus::where('status_name', 'Penambahan')->first();

        // Memperbaiki query untuk memfilter berdasarkan status melalui relasi
        $laporan = Laporan::with(['service', 'user', 'status'])
            ->whereHas('status', function ($query) use ($status) {
                $query->where('id', $status->id); // Memfilter berdasarkan ID status
            })
            ->latest()
            ->get();

        // dd($laporan);
        return view('laporan.pending', [
            'title' => $title,
            'laporan' => $laporan,
        ]);
    }

    public function byTeknisi()
    {
        $title = 'Laporan Teknisi';
        $technicianId = Auth::id(); // Ambil ID teknisi yang sedang login

        // Ambil laporan berdasarkan technician_id
        $laporan = Laporan::where('technician_id', $technicianId)->get();

        return view('laporan.byTeknisi', [
            'title' => $title,
            'laporan' => $laporan,
        ]);
    }


    public function create($id)
    {
        $title = 'Create Laporan';
        $technicianId = Auth::id(); // ID teknisi yang sedang login
        $status = ServiceStatus::where('status_name', 'In Progress')->first();
        $refStatus = ServiceStatus::whereIn('status_name', ['In Progress', 'Penambahan', 'Completed'])->get();

        if (!$status) {
            return back()->with('error', 'Status "In Progress" tidak ditemukan.');
        }

        // Ambil service berdasarkan ID dan teknisi
        $services = Service::where('technician_id', $technicianId)
            ->where('status_id', $status->id)
            ->where('id', $id) // Filter berdasarkan ID service
            ->get();

        // Jika service tidak ditemukan, berikan pesan error
        if ($services->isEmpty()) {
            return back()->with('error', 'Service tidak ditemukan atau tidak sesuai.');
        }

        return view('laporan.create', [
            'title' => $title,
            'services' => $services,
            'userId' => $technicianId,
            'statusId' => $status->id,
            'refStatus' => $refStatus
        ]);
    }


    public function store(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'status_id' => 'required|exists:service_status,id',
            'description' => 'required|string|max:255',
        ]);

        // Ambil data service berdasarkan ID
        $service = Service::findOrFail($id);

        // Tambahkan data yang diperlukan
        $validatedData['service_id'] = $service->id;
        $validatedData['user_id'] = $service->user_id; // Ambil user_id dari service
        $validatedData['technician_id'] = Auth::id(); // ID teknisi yang sedang login

        // Simpan ke database
        Laporan::create($validatedData);

        // Update status service
        $service->update(['status_id' => $request->status_id]);

        // Jika status adalah "Penambahan", ubah is_paid menjadi 0
        $statusPenambahan = ServiceStatus::where('status_name', 'Penambahan')->first();
        if ($request->status_id == $statusPenambahan->id) {
            $service->update(['is_paid' => 0]);
        }

        return redirect()->route('laporan.byTeknisi')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }


    public function edit($id)
    {

        $title = 'Edit Laporan';
        $laporan = Laporan::with(['service', 'status'])->findOrFail($id); // Ambil laporan berdasarkan ID
        $refStatus = ServiceStatus::whereIn('status_name', ['In Progress', 'Penambahan', 'Completed'])->get();
        // dd($laporan);
        return view('laporan.update', [
            'title' => $title,
            'laporan' => $laporan,
            'refStatus' => $refStatus,
        ]);
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'status_id' => 'required|exists:service_status,id',
            'description' => 'required|string|max:255',
        ]);

        // Ambil laporan berdasarkan ID
        $laporan = Laporan::findOrFail($id);

        // Update data laporan
        $laporan->update($validatedData);

        // Update status service
        $service = $laporan->service; // Mengambil service terkait laporan
        $service->update(['status_id' => $request->status_id]);

        // Jika status adalah "Penambahan", ubah is_paid menjadi 0
        $statusPenambahan = ServiceStatus::where('status_name', 'Penambahan')->first();
        if ($request->status_id == $statusPenambahan->id) {
            $service->update(['is_paid' => 0]);
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hapus laporan
        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function pdfAll()
    {
        // Ambil data laporan
        $laporan = Laporan::with(['user', 'service', 'status'])->get();
        // dd($laporan);
        $title = "Semua Laporan";
        // Jalur absolut untuk logo
        $logoPath = asset('img/logo.png');

        // Generate tampilan HTML untuk PDF
        $html = view('laporan.pdf', compact('laporan', 'logoPath', 'title'))->render();

        // Set opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Ukuran dan orientasi kertas
        header('Content-Type: application/pdf');
        $dompdf->render();

        // Unduh file PDF secara langsung
        return $dompdf->stream('Semua laporan.pdf', ['Attachment' => true]);
    }

    public function pdfById($id)
    {
        // Ambil data laporan beserta relasi
        $laporan = Laporan::with(['user', 'service', 'status'])->findOrFail($id);
        $title = "Laporan";

        // Jalur absolut untuk logo
        $logoPath = asset('img/logo.png');

        // Generate tampilan HTML untuk PDF
        $html = view('laporan.pdfById', compact('laporan', 'logoPath', 'title'))->render();

        // Set opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Ukuran dan orientasi kertas

        // Render dan unduh PDF
        $dompdf->render();
        return $dompdf->stream('laporan.pdf', ['Attachment' => true]);
    }

    public function pdfByUser()
    {
        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Ambil data laporan terkait user
        $laporan = Laporan::with(['service', 'user', 'status'])
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->latest()
            ->get();

        // Judul laporan
        $title = "Laporan User";

        // Path absolut untuk logo
        $logoPath = asset('img/logo.png');

        // Generate tampilan HTML untuk PDF
        $html = view('laporan.pdf', compact('laporan', 'logoPath', 'title'))->render();

        // Konfigurasi opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Buat instance DomPDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Atur ukuran dan orientasi kertas

        // Render PDF dan unduh
        $dompdf->render();
        return $dompdf->stream('Laporan_User.pdf', ['Attachment' => true]);
    }


    public function pdfSelesai()
    {
        $status = ServiceStatus::where('status_name', 'Completed')->first();
        $laporan = Laporan::with(['service', 'user', 'status'])
            ->whereHas('status', function ($query) use ($status) {
                $query->where('id', $status->id); // Memfilter berdasarkan ID status
            })
            ->latest()
            ->get();

        // dd($laporan);
        $title = "Laporan selesai";

        // Jalur absolut untuk logo
        $logoPath = asset('img/logo.png');

        // Generate tampilan HTML untuk PDF
        $html = view('laporan.pdf', compact('laporan', 'logoPath', 'title'))->render();

        // Set opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Ukuran dan orientasi kertas

        // Render dan unduh PDF
        $dompdf->render();
        return $dompdf->stream('Laporan selesai.pdf', ['Attachment' => true]);
    }

    public function pdfPending()
    {
        // dd("pending");
        $status = ServiceStatus::where('status_name', 'Penambahan')->first();
        $laporan = Laporan::with(['service', 'user', 'status'])
            ->whereHas('status', function ($query) use ($status) {
                $query->where('id', $status->id); // Memfilter berdasarkan ID status
            })
            ->latest()
            ->get();

        // dd($laporan);
        $title = "Laporan penambahan";

        // Jalur absolut untuk logo
        $logoPath = asset('img/logo.png');

        // Generate tampilan HTML untuk PDF
        $html = view('laporan.pdf', compact('laporan', 'logoPath', 'title'))->render();

        // Set opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Ukuran dan orientasi kertas

        // Render dan unduh PDF
        $dompdf->render();
        return $dompdf->stream('Laporan penambahan.pdf', ['Attachment' => true]);
    }

    // public function pdfById()
    // {
    //     dd('berhasil');
    // }
}
