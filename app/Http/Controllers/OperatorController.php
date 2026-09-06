<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\RincianProyek;
use App\Models\LokasiUnggah;
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

        return view('operator.dasbor', compact('identitas', 'operator', 'daftarProyek', 'daftarLokasiUnggah'));
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

    public function simpanRincian(Request $request, $idProyek)
    {
        $proyek = Proyek::where('id_operator', auth('operator')->id())->findOrFail($idProyek);

        $request->validate([
            'nama_item' => 'required|string|max:150',
            'id_lokasi_unggah' => 'nullable|exists:lokasi_unggah,id',
            'jenis_media' => 'required|in:video,gambar,audio,artikel,lainnya',
            'catatan' => 'nullable|string',
            'status_unggah' => 'required|in:menunggu,siap_unggah,terunggah',
        ]);

        RincianProyek::create([
            'id_proyek' => $proyek->id,
            'id_lokasi_unggah' => $request->id_lokasi_unggah,
            'nama_item' => $request->nama_item,
            'jenis_media' => $request->jenis_media,
            'catatan' => $request->catatan,
            'status_unggah' => $request->status_unggah,
        ]);

        return back()->with('sukses', 'Rincian konten berhasil ditambahkan ke proyek!');
    }

    public function hapusRincian($id)
    {
        $rincian = RincianProyek::whereHas('proyek', function ($q) {
            $q->where('id_operator', auth('operator')->id());
        })->findOrFail($id);

        $rincian->delete();

        return back()->with('sukses', 'Rincian konten berhasil dihapus!');
    }
}
