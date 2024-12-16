<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceStatus;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user yang ada di database
        $users = User::all();

        // Ambil status yang ada di database
        $statuses = ServiceStatus::all();

        // Pastikan ada user dan status
        if ($users->isEmpty() || $statuses->isEmpty()) {
            $this->command->info('Pastikan ada data user dan status di database sebelum menjalankan seeder ini.');
            return;
        }

        // Membuat 10 contoh data service
        foreach ($users as $user) {
            Service::create([
                'user_id' => $user->id,
                'laptop_model' => 'Laptop Model ' . Str::random(3),
                'problem_description' => 'Masalah dengan laptop ' . Str::random(5),
                'status_id' => $statuses->random()->id,
                'is_paid' => (bool) rand(0, 1),
            ]);
        }

        $this->command->info('Seeder Service telah selesai.');
    }
}
