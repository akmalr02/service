<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    // Menampilkan daftar tiket
    public function index()
    {
        $title = 'Halaman tiket';
        $tickets = Ticket::with(['user', 'technician'])->get();
        // $technicians = User::where('role', 'teknisi')->get();
        $services = Service::all();
        return view('tickets.index', [
            'title' => $title,
            'tickets' => $tickets,
            'services' => $services,
            // 'technicians' => $technicians
        ]);
    }

    // Form untuk membuat tiket baru
    public function create()
    {
        $title = 'Halaman membuat tiket';
        $users = User::where('role', 'user')->get();
        return view('tickets.create', [
            'title' => $title,
            'users' => $users
        ]);
    }

    // // Menyimpan tiket baru
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'payment' => 'boolean',
    //     ]);

    //     Ticket::create($validated);

    //     return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat.');
    // }

    // // Menampilkan detail tiket
    // public function show($id)
    // {
    //     $ticket = Ticket::with(['user', 'technician'])->findOrFail($id);
    //     return view('tickets.show', compact('ticket'));
    // }

    // // Form untuk mengedit tiket
    // public function edit($id)
    // {
    //     $ticket = Ticket::findOrFail($id);
    //     $technicians = User::where('role', 'technician')->get(); // Ambil hanya user dengan role "technician"
    //     return view('tickets.edit', compact('ticket', 'technicians'));
    // }

    // // Memperbarui tiket
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'payment' => 'boolean',
    //         'technician_id' => 'nullable|exists:users,id',
    //     ]);

    //     // Periksa jika technician_id adalah seorang teknisi
    //     if (isset($validated['technician_id'])) {
    //         $technician = User::where('id', $validated['technician_id'])->where('role', 'technician')->first();
    //         if (!$technician) {
    //             return redirect()->back()->withErrors(['technician_id' => 'ID teknisi tidak valid.']);
    //         }
    //     }

    //     $ticket = Ticket::findOrFail($id);
    //     $ticket->update($validated);

    //     return redirect()->route('tickets.index')->with('success', 'Tiket berhasil diperbarui.');
    // }

    // Menghapus tiket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus.');
    }

    public function pay($id)
    {
        $service = Service::findOrFail($id);

        // Periksa jika service sudah dibayar
        if ($service->is_paid) {
            return response()->json(['success' => false, 'message' => 'Service sudah dibayar.']);
        }

        // Perbarui status service menjadi "Payment Approved"
        $paidStatus = ServiceStatus::where('status_name', 'Payment Approved')->first();
        if (!$paidStatus) {
            return response()->json(['success' => false, 'message' => 'Status "Payment Approved" tidak ditemukan.']);
        }

        $service->update([
            'is_paid' => true,
            'status_id' => $paidStatus->id, // Perbarui kolom status_id
        ]);

        return redirect()->route('tickets.index')->with(['success' => true, 'message' => 'Pembayaran berhasil dikonfirmasi.']);
    }


    public function forwardToTechnical(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Pastikan pembayaran sudah disetujui
        if (!$ticket->is_payment_approved) {
            return redirect()->back()->withErrors(['payment' => 'Pembayaran harus disetujui oleh admin terlebih dahulu.']);
        }

        $validated = $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        // Periksa apakah technician_id merujuk ke user dengan role 'technician'
        $technician = User::where('id', $validated['technician_id'])->where('role', 'technician')->first();

        if (!$technician) {
            return redirect()->back()->withErrors(['technician_id' => 'ID teknisi tidak valid.']);
        }

        // Update tiket dengan teknisi yang valid
        $ticket->update(['technician_id' => $technician->id]);

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil diteruskan ke teknisi.');
    }
}
