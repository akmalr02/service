<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbsensiTeknisi;
use App\Models\User;

class AbsensiTeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role 'teknisi'
        $teknisiUsers = User::where('role', 'teknisi')->get();

        // Tambahkan data absensi untuk setiap teknisi
        foreach ($teknisiUsers as $teknisi) {
            AbsensiTeknisi::factory()->count(5)->create([
                'user_id' => $teknisi->id,
            ]);
        }
    }
}
