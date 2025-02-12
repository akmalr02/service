<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceStatus;
use Illuminate\Http\Request;
use App\Models\laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function teknisi()
    {
        // Menampilkan daftar service dengan status "Payment Approved"
        $title = 'Daftar Service User';

        // Mendapatkan data status dengan nama "Payment Approved"
        $status = ServiceStatus::where('status_name', 'Payment Approved')->first();

        // Cek jika status tidak ditemukan
        if (!$status) {
            return back()->with('error', 'Status "Payment Approved" tidak ditemukan.');
        }

        // Mengambil semua service dengan status yang sesuai
        $services = Service::where('status_id', $status->id)->get();

        return view('tugas.index', [
            'title' => $title,
            'services' => $services
        ]);
    }

    public function show($id)
    {
        $title = 'Daftar Service User';
        $service = Service::find($id);
        $technicians = User::where('role', 'teknisi')->get();
        $laporan = Laporan::where('service_id', $service->id)
            ->with('technician') // Relasi teknisi
            ->first();

        // dd($laporan);

        return view('tugas.show', [
            'title' => $title,
            'service' => $service,
            'laporan' => $laporan,
            'technicians' => $technicians
        ]);
    }

    public function takeTask(Request $request, $id)
    {
        // Mencari service berdasarkan ID
        $service = Service::findOrFail($id);

        // Memastikan pengguna adalah teknisi atau admin
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'teknisi') {
            // Cari ID status "In Progress"
            $inProgressStatus = ServiceStatus::where('status_name', 'In Progress')->first();

            // Pastikan status "In Progress" ditemukan
            if (!$inProgressStatus) {
                return redirect()->route('tugas.index')->with('error', 'Status "In Progress" tidak ditemukan.');
            }

            // Tentukan teknisi yang akan menangani tugas
            $technicianId = $service->technician_id ?? $request->technician_id;

            // Perbarui data tugas
            $service->update([
                'status_tugas' => 'taken',
                'status_id' => $inProgressStatus->id,
                'technician_id' => $technicianId,
            ]);

            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diserahkan ke teknisi.');
        }

        return redirect()->route('tugas.index')->with('error', 'Anda tidak memiliki izin untuk menyerahkan tugas ini.');
    }

    public function endTask($id)
    {
        // Mencari service berdasarkan ID
        $service = Service::findOrFail($id);

        // Memastikan pengguna yang sedang login adalah teknisi
        if (Auth::user()->role == 'teknisi') {
            // Cari ID status "Completed"
            $completedStatus = ServiceStatus::where('status_name', 'Completed')->first();

            // Pastikan status "Completed" ditemukan
            if (!$completedStatus) {
                return redirect()->route('tugas.index')->with('error', 'Status "Completed" tidak ditemukan.');
            }

            // Perbarui data tugas
            $service->update([
                // 'status_tugas' => 'completed',
                'status_id' => $completedStatus->id,
            ]);

            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diselesaikan, silahkan buat laporan anda');
        }

        return redirect()->route('tugas.index')->with('error', 'Anda tidak memiliki izin untuk menyelesaikan tugas ini.');
    }
}
