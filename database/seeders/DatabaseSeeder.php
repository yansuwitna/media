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
        // 1. Pengguna Umum
        User::firstOrCreate(
            ['email' => 'pengguna@media.local'],
            [
                'name' => 'Pengguna Umum',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Admin
        $admin = Admin::firstOrCreate(
            ['nama_pengguna' => 'admin'],
            [
                'nama' => 'Administrator Utama',
                'email' => 'admin@media.local',
                'kata_sandi' => Hash::make('Admin!'),
            ]
        );

        // 3. Operator
        $operator = Operator::firstOrCreate(
            ['nama_pengguna' => 'operator'],
            [
                'nama' => 'Operator Media',
                'email' => 'operator@media.local',
                'kata_sandi' => Hash::make('operator123'),
                'id_admin_pembuat' => $admin->id,
            ]
        );

        // 4. Identitas Web
        IdentitasWeb::firstOrCreate(
            ['id' => 1],
            [
                'nama_aplikasi' => 'Rencana Media Hub',
                'deskripsi_aplikasi' => 'Aplikasi Manajemen Perencanaan Media Digital dan Distribusi Kanal Publikasi.',
                'teks_footer' => '© 2026 Rencana Media Hub. Hak cipta dilindungi.',
                'tema_bawaan' => 'gelap',
            ]
        );

        // 5. Lokasi Unggah
        $lok1 = LokasiUnggah::firstOrCreate(
            ['id_operator' => $operator->id, 'nama_kanal' => 'YouTube Resmi'],
            ['tautan' => 'https://youtube.com', 'keterangan' => 'Kanal video utama untuk teaser dan video panjang.']
        );
        $lok2 = LokasiUnggah::firstOrCreate(
            ['id_operator' => $operator->id, 'nama_kanal' => 'Instagram Feeds & Reels'],
            ['tautan' => 'https://instagram.com', 'keterangan' => 'Publikasi infografis visual dan konten reel.']
        );
        $lok3 = LokasiUnggah::firstOrCreate(
            ['id_operator' => $operator->id, 'nama_kanal' => 'TikTok Official'],
            ['tautan' => 'https://tiktok.com', 'keterangan' => 'Video vertikal pendek interaktif.']
        );

        // 6. Proyek
        $proyek = Proyek::firstOrCreate(
            ['id_operator' => $operator->id, 'judul_proyek' => 'Peluncuran Produk Kreatif Q3'],
            [
                'deskripsi_proyek' => 'Kampanye terintegrasi peluncuran inovasi produk di berbagai kanal digital.',
                'target_selesai' => '2026-10-20',
                'status_proyek' => 'dalam_proses',
            ]
        );

        // 7. Rincian Proyek
        RincianProyek::firstOrCreate(
            ['id_proyek' => $proyek->id, 'nama_item' => 'Video Teaser Utama 30 Detik'],
            [
                'id_lokasi_unggah' => $lok1->id,
                'jenis_media' => 'video',
                'catatan' => 'Rasio 16:9 resolusi 4K dengan subtitle bahasa Indonesia.',
                'status_unggah' => 'siap_unggah',
            ]
        );

        RincianProyek::firstOrCreate(
            ['id_proyek' => $proyek->id, 'nama_item' => 'Poster Teaser Feed Instagram'],
            [
                'id_lokasi_unggah' => $lok2->id,
                'jenis_media' => 'gambar',
                'catatan' => 'Rasio 4:5 resolusi tinggi palet gelap elegan.',
                'status_unggah' => 'terunggah',
            ]
        );
    }
}
