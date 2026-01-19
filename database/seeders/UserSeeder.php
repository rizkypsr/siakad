<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Fakultas
        User::create([
            'name' => 'Admin Fakultas',
            'email' => 'admin.fakultas@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'admin_fakultas',
            'is_active' => true,
        ]);

        // Admin Prodi
        User::create([
            'name' => 'Admin Prodi',
            'email' => 'admin.prodi@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'admin_prodi',
            'is_active' => true,
        ]);
    }
}
