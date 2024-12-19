<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function registrasi()
    {
        $title = 'Sign Up';
        // $users = User::all();
        return view('SignUp', [
            'title' => $title
        ]);
    }

    public function store(Request $request)
    {
        // dd('halaman store');

        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'address' => 'required|max:255',
            'phone_number' => 'required|min:12|max:13',
        ]);

        // Tambahkan password default
        $data['password'] = bcrypt('password'); // Meng-hash password default

        // Simpan data user baru
        User::create($data);

        // Debug data untuk memastikan berhasil
        // dd($user);

        return redirect('/login')->with('success', 'User Baru Telah Di Tambahkan');
    }
}
