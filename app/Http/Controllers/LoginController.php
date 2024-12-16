<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($login)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('homeAdmin');
            } elseif ($user->role === 'teknisi') {
                return redirect()->route('tugas.index');
            } elseif ($user->role === 'user') {
                return redirect()->route('homeAuth');
            }

            // Logout jika role tidak dikenali
            Auth::logout();
            return back()->with('signInError', 'Role tidak dikenali. Silakan hubungi admin.');
        }

        return back()->with('signInError', 'Email atau password salah.');
    }


    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
