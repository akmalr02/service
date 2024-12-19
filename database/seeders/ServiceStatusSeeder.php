<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service_status')->insert([
            ['status_name' => 'Payment Pending', 'description' => 'Awaiting payment confirmation'],
            ['status_name' => 'Payment Approved', 'description' => 'Payment has been confirmed'],
            ['status_name' => 'In Progress', 'description' => 'Service is being worked on'],
            ['status_name' => 'Penambahan', 'description' => 'penambahan sparepart'],
            ['status_name' => 'Completed', 'description' => 'Service is completed'],
        ]);
    }
}
