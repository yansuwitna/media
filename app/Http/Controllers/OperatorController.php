<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\RincianProyek;
use App\Models\LokasiUnggah;
use App\Models\KontenKanal;
use App\Models\IdentitasWeb;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function dasbor()
    {
        $identitas = IdentitasWeb::first();
        $operator = auth('operator')->user();
        
        $daftarProyek = Proyek::where('id_operator', $operator->id)->with('rincian.lokasiUnggah')->latest()->get();
        $daftarLokasiUnggah = LokasiUnggah::where('id_operator', $operator->id)->latest()->get();
        $proyekTerbaru = Proyek::where('id_operator', $operator->id)->with('rincian')->latest()->take(5)->get();

        return view('operator.dasbor', compact('identitas', 'operator', 'daftarProyek', 'daftarLokasiUnggah', 'proyekTerbaru'));
    }

    public function proyek()
    {
        $identitas = IdentitasWeb::first();
        $operator = auth('operator')->user();
        
        $daftarProyek = Proyek::where('id_operator', $operator->id)->with('rincian.lokasiUnggah')->latest()->get();
        $daftarLokasiUnggah = LokasiUnggah::where('id_operator', $operator->id)->latest()->get();

        return view('operator.proyek', compact('identitas', 'operator', 'daftarProyek', 'daftarLokasiUnggah'));
    }

    public function detailProyek($id)
    {
        $identitas = IdentitasWeb::first();
        $operator = auth('operator')->user();

        $proyek = Proyek::where('id_operator', $operator->id)
            ->with(['rincian' => function ($q) {
                $q->with(['lokasiUnggah', 'kanals.lokasiUnggah'])->orderBy('urutan');
            }])
            ->findOrFail($id);

        $daftarLokasiUnggah = LokasiUnggah::where('id_operator', $operator->id)->latest()->get();

        return view('operator.proyek-detail', compact('identitas', 'operator', 'proyek', 'daftarLokasiUnggah'));
    }

    public function lokasi()
    {
        $identitas = IdentitasWeb::first();
        $operator = auth('operator')->user();
        
        $daftarLokasiUnggah = LokasiUnggah::where('id_operator', $operator->id)->withCount('rincian')->latest()->get();

        return view('operator.lokasi', compact('identitas', 'operator', 'daftarLokasiUnggah'));
    }

    public function detailLokasi($id)
    {
        $identitas = IdentitasWeb::first();
        $operator = auth('operator')->user();

        $lokasi = LokasiUnggah::where('id_operator', $operator->id)->findOrFail($id);
        $rincianKonten = RincianProyek::with('proyek')
            ->where('id_lokasi_unggah', $id)
            ->whereHas('proyek', fn($q) => $q->where('id_operator', $operator->id))
            ->latest()
            ->get();

        return view('operator.lokasi-detail', compact('identitas', 'operator', 'lokasi', 'rincianKonten'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'nama_kanal' => 'required|string|max:100',
            'tautan' => 'nullable|url',
            'keterangan' => 'nullable|string',
        ]);

        LokasiUnggah::create([
            'id_operator' => auth('operator')->id(),
            'nama_kanal' => $request->nama_kanal,
            'tautan' => $request->tautan,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('sukses', 'Lokasi/Kanal unggah berhasil disimpan!');
    }

    public function hapusLokasi($id)
    {
        $lokasi = LokasiUnggah::where('id_operator', auth('operator')->id())->findOrFail($id);
        $lokasi->delete();

        return back()->with('sukses', 'Lokasi unggah berhasil dihapus!');
    }

    public function simpanProyek(Request $request)
    {
        $request->validate([
            'judul_proyek' => 'required|string|max:150',
            'deskripsi_proyek' => 'nullable|string',
            'target_selesai' => 'nullable|date',
            'status_proyek' => 'required|in:draf,dalam_proses,selesai,dibatalkan',
        ]);

        Proyek::create([
            'id_operator' => auth('operator')->id(),
            'judul_proyek' => $request->judul_proyek,
            'deskripsi_proyek' => $request->deskripsi_proyek,
            'target_selesai' => $request->target_selesai,
            'status_proyek' => $request->status_proyek,
        ]);

        return back()->with('sukses', 'Proyek rencana media baru berhasil dibuat!');
    }

    public function hapusProyek($id)
    {
        $proyek = Proyek::where('id_operator', auth('operator')->id())->findOrFail($id);
        $proyek->delete();

        return back()->with('sukses', 'Proyek rencana media berhasil dihapus!');
    }

    public function ubahProyek(Request $request, $id)
    {
        $proyek = Proyek::where('id_operator', auth('operator')->id())->findOrFail($id);

        $request->validate([
            'judul_proyek'    => 'required|string|max:150',
            'deskripsi_proyek'=> 'nullable|string',
            'target_selesai'  => 'nullable|date',
            'status_proyek'   => 'required|in:draf,dalam_proses,selesai,dibatalkan',
        ]);

        $proyek->update([
            'judul_proyek'    => $request->judul_proyek,
            'deskripsi_proyek'=> $request->deskripsi_proyek,
            'target_selesai'  => $request->target_selesai,
            'status_proyek'   => $request->status_proyek,
        ]);

        return back()->with('sukses', 'Data proyek berhasil diperbarui!');
    }

    public function simpanRincian(Request $request, $idProyek)
    {
        $proyek = Proyek::where('id_operator', auth('operator')->id())->findOrFail($idProyek);

        $request->validate([
            'nama_item'        => 'required|string|max:150',
            'kode'             => 'nullable|string|max:50',
            'urutan'           => 'nullable|integer|min:0',
            'deskripsi'        => 'nullable|string',
            'id_lokasi_unggah' => 'nullable|exists:lokasi_unggah,id',
            'jenis_media'      => 'nullable|in:video,gambar,audio,artikel,lainnya',
            'status_unggah'    => 'required|in:menunggu,siap_unggah,terunggah',
            'tautan_konten'    => 'nullable|string|max:255',
        ]);

        $maxUrutan = RincianProyek::where('id_proyek', $proyek->id)->max('urutan') ?? 0;
        $urutan = $request->filled('urutan') ? (int)$request->urutan : ($maxUrutan + 1);

        // Generate Kode Otomatis jika kosong (contoh: KTN-01, KTN-02, dst)
        if ($request->filled('kode')) {
            $kode = trim($request->kode);
        } else {
            $nomorKode = str_pad($urutan, 2, '0', STR_PAD_LEFT);
            $kode = 'KTN-' . $nomorKode;
        }

        RincianProyek::create([
            'id_proyek'        => $proyek->id,
            'id_lokasi_unggah' => $request->id_lokasi_unggah,
            'kode'             => $kode,
            'urutan'           => $urutan,
            'nama_item'        => $request->nama_item,
            'deskripsi'        => $request->deskripsi,
            'jenis_media'      => $request->jenis_media ?? 'video',
            'status_unggah'    => $request->status_unggah,
            'tautan_konten'    => $request->tautan_konten,
        ]);

        return back()->with('sukses', 'Konten berhasil ditambahkan!');
    }

    public function ubahRincian(Request $request, $id)
    {
        $rincian = RincianProyek::whereHas('proyek', function ($q) {
            $q->where('id_operator', auth('operator')->id());
        })->findOrFail($id);

        $request->validate([
            'nama_item'        => 'required|string|max:150',
            'kode'             => 'nullable|string|max:50',
            'urutan'           => 'nullable|integer|min:0',
            'deskripsi'        => 'nullable|string',
            'id_lokasi_unggah' => 'nullable|exists:lokasi_unggah,id',
            'jenis_media'      => 'nullable|in:video,gambar,audio,artikel,lainnya',
            'status_unggah'    => 'required|in:menunggu,siap_unggah,terunggah',
            'tautan_konten'    => 'nullable|string|max:255',
        ]);

        $urutan = $request->filled('urutan') ? (int)$request->urutan : $rincian->urutan;

        if ($request->filled('kode')) {
            $kode = trim($request->kode);
        } else {
            $nomorKode = str_pad($urutan, 2, '0', STR_PAD_LEFT);
            $kode = $rincian->kode ?: ('KTN-' . $nomorKode);
        }

        $rincian->update([
            'id_lokasi_unggah' => $request->id_lokasi_unggah,
            'kode'             => $kode,
            'urutan'           => $urutan,
            'nama_item'        => $request->nama_item,
            'deskripsi'        => $request->deskripsi,
            'jenis_media'      => $request->jenis_media ?? $rincian->jenis_media,
            'status_unggah'    => $request->status_unggah,
            'tautan_konten'    => $request->tautan_konten,
        ]);

        return back()->with('sukses', 'Data konten berhasil diperbarui!');
    }

    public function hapusRincian($id)
    {
        $rincian = RincianProyek::whereHas('proyek', function ($q) {
            $q->where('id_operator', auth('operator')->id());
        })->findOrFail($id);

        $rincian->delete();

        return back()->with('sukses', 'Rincian konten berhasil dihapus!');
    }

    public function simpanKontenKanal(Request $request, $idRincian)
    {
        $rincian = RincianProyek::whereHas('proyek', function ($q) {
            $q->where('id_operator', auth('operator')->id());
        })->findOrFail($idRincian);

        $request->validate([
            'id_lokasi_unggah' => 'required|exists:lokasi_unggah,id',
            'link_unggahan'    => 'nullable|string|max:255',
        ]);

        KontenKanal::create([
            'id_rincian_proyek' => $rincian->id,
            'id_lokasi_unggah'  => $request->id_lokasi_unggah,
            'link_unggahan'     => $request->link_unggahan,
        ]);

        return back()->with('sukses', 'Kanal berhasil ditambahkan ke konten!');
    }

    public function hapusKontenKanal($id)
    {
        $kontenKanal = KontenKanal::whereHas('rincianProyek.proyek', function ($q) {
            $q->where('id_operator', auth('operator')->id());
        })->findOrFail($id);

        $kontenKanal->delete();

        return back()->with('sukses', 'Kanal pada konten berhasil dihapus!');
    }
}
