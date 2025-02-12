<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        $title = 'Login Page';
        return view('login', [
            'title' => $title
        ]);
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Periksa apakah email sudah terdaftar
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar. Silakan daftar terlebih dahulu.');
        }

        // Autentikasi pengguna
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('homeAdmin');
                case 'teknisi':
                    return redirect()->route('progres.index');
                case 'user':
                    return redirect()->route('homeAuth');
                default:
                    // Logout jika role tidak dikenali
                    Auth::logout();
                    return back()->with('error', 'Role tidak dikenali. Silakan hubungi admin.');
            }
        }

        // Jika autentikasi gagal
        return back()->with('error', 'Password yang Anda masukkan salah.');
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
