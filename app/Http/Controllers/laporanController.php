<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\Service;
use App\Models\ServiceStatus;

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

        // Memperbaiki query untuk memfilter berdasarkan status melalui relasi
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

        return redirect()->route('laporan.index')
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
}