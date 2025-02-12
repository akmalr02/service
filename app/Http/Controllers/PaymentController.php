<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceStatus;
use App\Models\laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $service = Service::findOrFail($id);

        if ($request->hasFile('payment_image')) {
            $path = $request->file('payment_image')->store('payments', 'public');

            $service->update(['payment_image' => $path]);

            return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }

    public function uploadTambah(Request $request, $id)
    {
        $request->validate([
            'payment_tambah' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $service = Service::findOrFail($id);

        if ($request->hasFile('payment_tambah')) {
            $path = $request->file('payment_tambah')->store('payments', 'public');

            $service->update(['payment_tambah' => $path]);

            return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}
