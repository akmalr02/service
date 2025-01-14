<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function registrasi()
    {
        // dd('halaman register');

        $title = 'Sign Up';
        // $users = User::all();
        return view('SignUp', [
            'title' => $title
        ]);
    }

    public function store(Request $request)
    {
        // dd('halaman store');

        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|unique:users',
                'address' => 'required|max:255',
                'phone_number' => 'required|min:11|max:13',
                'password' => 'required|min:8'
            ],
            [
                'name.required' => 'Nama harus diisi.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'phone_number.required' => 'Nomor telepon harus diisi.',
                'phone_number.numeric' => 'Nomor telepon harus berupa angka.',
                'phone_number.digits_between' => 'Nomor telepon harus antara 11 hingga 13 digit.',
            ]
        );

        // Tambahkan password default
        $data['password'] = bcrypt($data['password']);
        // Meng-hash password default
        // dd($data);

        // Simpan data user baru
        User::create($data);

        // Debug data untuk memastikan berhasil
        // dd($user);

        return redirect('/login')->with('success', 'Registrasi akun berhasil');
    }
}
