<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceStatus;
use Illuminate\Support\Facades\Auth;


class ProgresController extends Controller
{
    public function index()
    {
        $titel = 'Pekerjaan saya';
        $teknisi = Auth::id();
        // Mendapatkan data status dengan nama "Payment Approved"
        $status = ServiceStatus::where('status_name', 'In Progress')->first();

        // Cek jika status tidak ditemukan
        if (!$status) {
            return back()->with('error', 'Status "Payment Approved" tidak ditemukan.');
        }

        // Mengambil semua service dengan status yang sesuai
        $services = Service::where('technician_id', $teknisi)
            ->where('status_id', $status->id)
            ->get();
        // dd($servis);
        return view('teknisi.index', [
            'title' => $titel,
            'services' => $services
        ]);
    }

    public function show($id)
    {
        $title = 'Daftar Service User';
        $service = Service::find($id);

        return view('teknisi.show', [
            'title' => $title,
            'service' => $service
        ]);
        // dd($service);
    }
}
