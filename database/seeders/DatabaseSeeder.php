<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Dummy PAC
        $pac = \App\Models\Pac::create([
            'nama_pac' => 'PAC Babat',
            'ketua_pac' => 'Ahmad Fulan',
            'jumlah_ranting' => 0
        ]);

        // 2. Buat Akun Admin
        User::create([
            'nama_lengkap' => 'Super Admin',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status' => 1 // Aktif
        ]);

        // 3. Buat Akun Pengurus PAC yang sudah aktif
        User::create([
            'nama_lengkap' => 'Pengurus Babat',
            'username' => 'pengurus_babat',
            'pac' => 'PAC Babat',
            'password' => bcrypt('password123'),
            'role' => 'pengurus_pac',
            'status' => 1 // Aktif
        ]);

        // 4. Buat Akun Pengurus PAC yang masih pending
        User::create([
            'nama_lengkap' => 'Pengurus Sugio',
            'username' => 'pengurus_sugio',
            'pac' => 'PAC Sugio',
            'password' => bcrypt('password123'),
            'role' => 'pengurus_pac',
            'status' => 0 // Pending (bisa dites di-approve oleh admin)
        ]);

        // 5. Buat Akun Penulis Berita (Lembaga Pers)
        User::create([
            'nama_lengkap' => 'Lembaga Pers',
            'username' => 'pers',
            'password' => bcrypt('password123'),
            'role' => 'penulis_berita',
            'status' => 1 // Aktif
        ]);
    }
}
