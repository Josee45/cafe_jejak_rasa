<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'name' => 'Admin Pelanggan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}