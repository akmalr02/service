<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceStatus;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $title = 'Dashboard admin';
        $services = Service::with(['status'])->get();
        $statusOptions = ServiceStatus::all(); // Mengambil semua data status dari tabel service_status
        return view("dashboard.admin", [
            'title' => $title,
            'services' => $services,
            'statusOptions' => $statusOptions, // Mengirim statusOptions ke view
        ]);
    }
    // public function teknisi()
    // {
    //     $title = 'Daftar Service user';
    //     $services = Service::where('status_tugas', 'available')->get();
    //     return view("dashboard.teknisi", [
    //         'title' => $title,
    //         'services' => $services
    //     ]);
    // }
    public function auth()
    {
        $title = 'Daftar Service Saya';
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $services = Service::where('user_id', $userId)->get(); // Filter data berdasarkan user yang login
        return view("dashboard.home", [
            'title' => $title,
            'services' => $services
        ]);
    }
}
