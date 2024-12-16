<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Buat 1 pengguna dengan peran admin
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'), // Gunakan password yang aman
            'address' => 'Jalan Admin 1',
            'phone_number' => '081234567890',
            'role' => 'admin',
        ]);

        // Buat 2 pengguna dengan peran teknisi
        User::create([
            'name' => 'Teknisi 1',
            'email' => 'teknisi1@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jalan Teknisi 1',
            'phone_number' => '081234567891',
            'role' => 'teknisi',
        ]);

        User::create([
            'name' => 'Teknisi 2',
            'email' => 'teknisi2@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jalan Teknisi 2',
            'phone_number' => '081234567892',
            'role' => 'teknisi',
        ]);

        // Buat 2 pengguna dengan peran user
        User::create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jalan User 1',
            'phone_number' => '081234567893',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jalan User 2',
            'phone_number' => '081234567894',
            'role' => 'user',
        ]);
    }
}
