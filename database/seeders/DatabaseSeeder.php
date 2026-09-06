<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Operator;
use App\Models\User;
use App\Models\WebIdentity;
use App\Models\UploadLocation;
use App\Models\Project;
use App\Models\ProjectDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User Umum / Superadmin
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'General User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Admin
        $admin = Admin::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@media.local',
                'password' => Hash::make('Admin!'),
            ]
        );

        // 3. Operator
        $operator = Operator::firstOrCreate(
            ['username' => 'operator'],
            [
                'name' => 'Operator Media',
                'email' => 'operator@media.local',
                'password' => Hash::make('operator123'),
                'created_by_admin_id' => $admin->id,
            ]
        );

        // 4. Web Identity
        WebIdentity::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'Media Planner Hub',
                'app_description' => 'Aplikasi Manajemen Perencanaan Media Digital & Publikasi Multi-Platform.',
                'footer_text' => '© 2026 Media Planner Hub. All rights reserved.',
                'theme_default' => 'dark',
            ]
        );

        // 5. Upload Locations
        $loc1 = UploadLocation::firstOrCreate(
            ['operator_id' => $operator->id, 'name' => 'YouTube Channel Official'],
            ['url' => 'https://youtube.com', 'description' => 'Kanal video utama untuk video teaser dan materi panjang.']
        );
        $loc2 = UploadLocation::firstOrCreate(
            ['operator_id' => $operator->id, 'name' => 'Instagram Reels / Feeds'],
            ['url' => 'https://instagram.com', 'description' => 'Akun Instagram official brand.']
        );
        $loc3 = UploadLocation::firstOrCreate(
            ['operator_id' => $operator->id, 'name' => 'TikTok Channel'],
            ['url' => 'https://tiktok.com', 'description' => 'Konten video pendek vertikal dan tren.']
        );

        // 6. Projects
        $project = Project::firstOrCreate(
            ['operator_id' => $operator->id, 'title' => 'Peluncuran Produk Baru Q3'],
            [
                'description' => 'Kampanye peluncuran lini produk kreatif di media sosial.',
                'target_date' => '2026-10-15',
                'status' => 'in_progress',
            ]
        );

        // 7. Project Details
        ProjectDetail::firstOrCreate(
            ['project_id' => $project->id, 'item_name' => 'Video Teaser 30 Detik'],
            [
                'upload_location_id' => $loc1->id,
                'media_type' => 'video',
                'notes' => 'Format 16:9 resolusi 4K dengan subtitle.',
                'status' => 'ready',
            ]
        );

        ProjectDetail::firstOrCreate(
            ['project_id' => $project->id, 'item_name' => 'Poster Teaser Feed Instagram'],
            [
                'upload_location_id' => $loc2->id,
                'media_type' => 'image',
                'notes' => 'Resolusi 1080x1350 px, palet warna elegan gelap.',
                'status' => 'uploaded',
            ]
        );
    }
}
