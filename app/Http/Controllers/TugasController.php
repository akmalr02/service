<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceStatus;
use Illuminate\Http\Request;
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

        return view('tugas.show', [
            'title' => $title,
            'service' => $service
        ]);
        // dd($service);
    }

    public function takeTask($id)
    {
        // Mencari service berdasarkan ID
        $service = Service::findOrFail($id);

        // Memastikan pengguna yang sedang login adalah teknisi
        if (Auth::user()->role == 'teknisi') {
            // Cari ID status "In Progress"
            $inProgressStatus = ServiceStatus::where('status_name', 'In Progress')->first();

            // Pastikan status "In Progress" ditemukan
            if (!$inProgressStatus) {
                return redirect()->route('tugas.index')->with('error', 'Status "In Progress" tidak ditemukan.');
            }

            // Perbarui data tugas
            $service->update([
                'status_tugas' => 'taken',
                'status_id' => $inProgressStatus->id,
                'technician_id' => Auth::id(),
            ]);

            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diambil.');
        }

        return redirect()->route('tugas.index')->with('error', 'Anda tidak memiliki izin untuk mengambil tugas ini.');
    }
}
