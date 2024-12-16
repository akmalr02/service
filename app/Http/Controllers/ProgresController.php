<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProgresController extends Controller
{
    public function index()
    {
        $titel = 'Tugas saya';
        $teknisi = Auth::id();
        $services = Service::where('technician_id', $teknisi)->get();
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
