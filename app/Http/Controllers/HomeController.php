<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\IdentitasWeb;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indeks()
    {
        $identitas = IdentitasWeb::first() ?? (object)[
            'nama_aplikasi' => 'Rencana Media Hub',
            'deskripsi_aplikasi' => 'Aplikasi Manajemen Perencanaan Media Digital.',
            'teks_footer' => '© 2026 Rencana Media Hub.',
            'tema_bawaan' => 'gelap'
        ];

        $totalProyek = Proyek::count();
        $proyekDalamProses = Proyek::where('status_proyek', 'dalam_proses')->count();
        $proyekSelesai = Proyek::where('status_proyek', 'selesai')->count();
        $proyekDraf = Proyek::where('status_proyek', 'draf')->count();

        $proyekTerbaru = Proyek::with(['operator', 'rincian.lokasiUnggah'])->latest()->take(6)->get();

        return view('beranda', compact(
            'identitas',
            'totalProyek',
            'proyekDalamProses',
            'proyekSelesai',
            'proyekDraf',
            'proyekTerbaru'
        ));
    }
}
