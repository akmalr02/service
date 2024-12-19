<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'User List';
        $users = User::all();
        return view('admin.index', [
            'title' => $title,
            'users' => $users
        ]);

        // dd('berhasil');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create New User';
        // $users = User::all();
        return view('admin.create', [
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('halaman store');

        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'address' => 'required|max:255',
            'phone_number' => 'required|min:12|max:13',
            'role' => 'required'
        ]);

        // Tambahkan password default
        $data['password'] = bcrypt('password'); // Meng-hash password default

        // Simpan data user baru
        User::create($data);

        // Debug data untuk memastikan berhasil
        // dd($user);

        return redirect('/user')->with('success', 'User Baru Telah Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd('hamalan show');
        $title = 'View User';
        $user = User::find($id);
        return view('admin.show', [
            'title' => $title,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // dd('halaman edit');
        $title = 'Update User';
        // $user = auth()->user();
        return view('admin.update', [
            'title' => $title,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd('halaman update');
        // $user = User::findOrFail($id);
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'address' => 'required|max:255',
            'phone_number' => 'required|min:12|max:13',
            // 'image' => 'image|file|max:5120',
            'role' => 'required'
        ];
        $data = $request->validate($rules);

        // Perbarui data minuman
        $user->update($data);
        // dd($user);
        return redirect('/user')->with('success', 'User Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd('delet berhasil');
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('danger', 'User berhasil di hapus!!!');
    }
}
