<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiTeknisi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan data absensi (hanya untuk admin)
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $absensi = AbsensiTeknisi::with('user')->get();
        $title = 'Data Absensi Teknisi';

        return view('absensi.index', compact('absensi', 'title'));
    }

    // Menampilkan form absensi untuk teknisi
    public function create()
    {
        if (Auth::user()->role !== 'teknisi') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan absensi.');
        }

        $title = 'Form Absensi Teknisi';
        $tanggalHariIni = now()->format('Y-m-d');
        $absensiHariIni = AbsensiTeknisi::where('user_id', Auth::id())
            ->where('tanggal', $tanggalHariIni)
            ->first();

        return view('absensi.create', compact('title', 'absensiHariIni'));
    }

    // Menyimpan data absensi masuk
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'teknisi') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan absensi.');
        }

        $tanggalHariIni = now()->format('Y-m-d');
        $absensiHariIni = AbsensiTeknisi::where('user_id', Auth::id())
            ->where('tanggal', $tanggalHariIni)
            ->exists();

        if ($absensiHariIni) {
            return redirect()->back()->withErrors(['error' => 'Anda sudah melakukan absensi hari ini.']);
        }

        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Jika status adalah "Hadir", maka isi jam_masuk
        $jamMasuk = $request->status === 'Hadir' ? now()->toTimeString() : null;

        AbsensiTeknisi::create([
            'user_id' => Auth::id(),
            'tanggal' => $tanggalHariIni,
            'jam_masuk' => $jamMasuk,
            'jam_keluar' => null, // Jam keluar dikosongkan pada saat absensi
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return redirect()->route('absensi.create')->with('success', 'Absensi berhasil.');
    }



    // Menyimpan data absensi keluar
    public function absenKeluar()
    {
        $userId = Auth::id();
        $absensi = AbsensiTeknisi::where('user_id', $userId)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if (!$absensi) {
            return redirect()->back()->withErrors(['error' => 'Anda belum melakukan absensi masuk hari ini.']);
        }

        if ($absensi->jam_keluar) {
            return redirect()->back()->withErrors(['error' => 'Anda sudah melakukan absensi keluar hari ini.']);
        }

        $jamKeluar = now()->toTimeString();
        $absensi->update(['jam_keluar' => $jamKeluar]);

        $jamMasuk = Carbon::parse($absensi->jam_masuk);
        $durasiKerja = $jamMasuk->diffInHours(Carbon::now());

        if ($durasiKerja < 8) {
            return redirect()->back()->with('warning', 'Durasi kerja Anda kurang dari 8 jam.');
        }

        return redirect()->back()->with('success', 'Absensi keluar berhasil.');
    }
}
