<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@angpao.com'], // Cek berdasarkan email agar tidak duplikat
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // Ganti dengan password pilihan Anda
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Akun Admin berhasil dibuat!');
        $this->command->info('Email: admin@angpao.com');
        $this->command->info('Password: password123');
    }
}