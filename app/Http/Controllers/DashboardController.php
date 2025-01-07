<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceStatus;
use App\Models\laporan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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

    public function auth()
    {
        $title = 'Daftar Service Saya';
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $services = Service::where('user_id', $userId)->get(); // Filter data berdasarkan user yang login
        $serviceIds = $services->pluck('id'); // Ambil semua ID dari layanan

        // Ambil data laporan berdasarkan service_id yang sesuai
        $laporan = Laporan::whereIn('service_id', $serviceIds)->get();

        return view("dashboard.home", [
            'title' => $title,
            'services' => $services,
            'laporan' => $laporan
        ]);
    }

    public function about()
    {
        $title = 'about';
       
        return view('about', [
            'title' => $title,
        ]);
    }

    public function more()
    {
        $title = 'more';
       
        return view('more', [
            'title' => $title,
        ]);
    }


}
