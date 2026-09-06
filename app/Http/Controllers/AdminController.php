<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Proyek;
use App\Models\IdentitasWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dasbor()
    {
        $identitas = IdentitasWeb::first();
        $totalOperator = Operator::count();
        $totalProyek = Proyek::count();
        $proyekTerbaru = Proyek::with(['operator', 'rincian'])->latest()->take(5)->get();

        return view('admin.dasbor', compact('identitas', 'totalOperator', 'totalProyek', 'proyekTerbaru'));
    }

    public function identitas()
    {
        $identitas = IdentitasWeb::first();
        return view('admin.identitas', compact('identitas'));
    }

    public function perbaruiIdentitas(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:100',
            'deskripsi_aplikasi' => 'nullable|string',
            'teks_footer' => 'nullable|string|max:150',
            'tema_bawaan' => 'required|in:terang,gelap',
        ]);

        $identitas = IdentitasWeb::firstOrCreate(['id' => 1]);
        $identitas->update($request->only('nama_aplikasi', 'deskripsi_aplikasi', 'teks_footer', 'tema_bawaan'));

        return back()->with('sukses', 'Identitas website berhasil diperbarui!');
    }

    public function operator()
    {
        $identitas = IdentitasWeb::first();
        $daftarOperator = Operator::latest()->get();
        return view('admin.operator', compact('identitas', 'daftarOperator'));
    }

    public function simpanOperator(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nama_pengguna' => 'required|string|unique:operator,nama_pengguna|max:50',
            'email' => 'required|email|unique:operator,email|max:100',
            'kata_sandi' => 'required|string|min:6',
        ]);

        Operator::create([
            'nama' => $request->nama,
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'id_admin_pembuat' => auth('admin')->id(),
        ]);

        return back()->with('sukses', 'Akun operator baru berhasil didaftarkan!');
    }

    public function hapusOperator($id)
    {
        $operator = Operator::findOrFail($id);
        $operator->delete();

        return back()->with('sukses', 'Akun operator berhasil dihapus!');
    }
}
