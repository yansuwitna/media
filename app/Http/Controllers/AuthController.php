<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function tampilMasuk()
    {
        return view('otentikasi.masuk');
    }

    public function prosesMasuk(Request $request)
    {
        $request->validate([
            'peran' => 'required|in:admin,operator,pengguna',
            'masukan_login' => 'required|string',
            'kata_sandi' => 'required|string',
        ]);

        $peran = $request->peran;
        $penjaga = ($peran === 'pengguna') ? 'web' : $peran;
        $kolom = filter_var($request->masukan_login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nama_pengguna';

        if ($peran === 'pengguna') {
            $kredensial = ['email' => $request->masukan_login, 'password' => $request->kata_sandi];
        } else {
            $kredensial = [$kolom => $request->masukan_login, 'password' => $request->kata_sandi];
        }

        if (Auth::guard($penjaga)->attempt($kredensial, $request->filled('ingat_saya'))) {
            $request->session()->regenerate();

            if ($peran === 'admin') {
                return redirect()->intended('/admin/dasbor')->with('sukses', 'Selamat datang Administrator!');
            } elseif ($peran === 'operator') {
                return redirect()->intended('/operator/dasbor')->with('sukses', 'Selamat datang Operator!');
            }
            return redirect()->intended('/')->with('sukses', 'Berhasil masuk sistem!');
        }

        return back()->withInput()->with('galat', 'Kombinasi login dan kata sandi tidak cocok.');
    }

    public function keluar(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('operator')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('sukses', 'Berhasil keluar dari sistem!');
    }
}
