<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Operator;
use App\Models\User;
use App\Models\IdentitasWeb;
use App\Models\LokasiUnggah;
use App\Models\Proyek;
use App\Models\RincianProyek;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin (nama_pengguna: admin, password: admin)
        Admin::updateOrCreate(
            ['nama_pengguna' => 'admin'],
            [
                'nama' => 'Administrator Utama',
                'email' => 'admin@media.local',
                'kata_sandi' => Hash::make('admin'),
            ]
        );

        // 2. Identitas Web
        IdentitasWeb::firstOrCreate(
            ['id' => 1],
            [
                'nama_aplikasi' => 'Rencana Media Hub',
                'deskripsi_aplikasi' => 'Aplikasi Manajemen Perencanaan Media Digital dan Distribusi Kanal Publikasi.',
                'teks_footer' => '© 2026 Rencana Media Hub. Hak cipta dilindungi.',
                'tema_bawaan' => 'gelap',
            ]
        );
    }
}
