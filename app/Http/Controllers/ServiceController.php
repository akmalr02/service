<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceStatus;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Formulir Pengajuan Service';
        return view('service.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'laptop_model' => 'required|string|max:255',
            'problem_description' => 'required|string',
        ]);

        // Tambahkan ID user yang sedang login
        $validated['user_id'] = Auth::id();

        // Simpan data ke database (status_id akan diatur secara otomatis di model)
        Service::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('homeAuth')->with('success', 'Pengajuan service berhasil dibuat.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detail Service';
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $service = Service::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya mengambil data milik user yang login

        return view('service.show', compact('title', 'service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Pengajuan Service';
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $service = Service::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya mengambil data milik user yang login

        return view('service.edit', compact('title', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'laptop_model' => 'required|string|max:255',
            'problem_description' => 'required|string',
            'payment' => 'required|boolean',
        ]);

        $userId = Auth::id(); // Ambil ID user yang sedang login
        $service = Service::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya mengambil data milik user yang login

        // Update data di database
        $service->update($validated);

        return redirect()->route('service.index')->with('success', 'Data service berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $service = Service::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya menghapus data milik user yang login

        // Hapus data dari database
        $service->delete();

        return redirect()->route('homeAuth')->with('danger', 'Data service berhasil dihapus.');
    }

    public function cancelPayment($id)
    {
        $service = Service::findOrFail($id);

        // Periksa apakah status adalah "Penambahan"
        if ($service->status->status_name !== 'Penambahan') {
            return response()->json(['success' => false, 'message' => 'Pembatalan hanya dapat dilakukan saat status Penambahan.']);
        }

        // Periksa apakah sudah dibayar
        if ($service->is_paid) {
            return response()->json(['success' => false, 'message' => 'Pembayaran sudah dikonfirmasi, tidak dapat dibatalkan.']);
        }

        // Mencari status "Completed"
        $completeStatus = ServiceStatus::where('status_name', 'Completed')->first();
        if (!$completeStatus) {
            return redirect()->route('homeAuth')->with('error', 'Status "Completed" tidak ditemukan.');
        }

        // Perbarui status service menjadi "Completed" dan set pembayaran ke belum dibayar
        $service->update([
            'is_paid' => false, // Set kembali ke belum bayar
            'status_id' => $completeStatus->id, // Perbarui kolom status_id
        ]);

        return redirect()->route('homeAuth')->with('success', 'Pembayaran berhasil dibatalkan dan status telah diubah menjadi Completed.');
    }
}
