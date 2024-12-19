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
        $services = Service::all();
        return view('tickets.index', [
            'title' => $title,
            'tickets' => $tickets,
            'services' => $services,
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
            return redirect()->route('tickets.index')->with('error', 'Status name tidak di temukan');
        }

        $service->update([
            'is_paid' => true,
            'status_id' => $paidStatus->id, // Perbarui kolom status_id
        ]);

        return redirect()->route('tickets.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
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
