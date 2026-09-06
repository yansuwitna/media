<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,operator,user',
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $role = $request->role;
        $guard = ($role === 'user') ? 'web' : $role;
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Jika user umum hanya punya field email
        if ($role === 'user') {
            $credentials = ['email' => $request->login, 'password' => $request->password];
        } else {
            $credentials = [$field => $request->login, 'password' => $request->password];
        }

        if (Auth::guard($guard)->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang Admin!');
            } elseif ($role === 'operator') {
                return redirect()->intended('/operator/dashboard')->with('success', 'Selamat datang Operator!');
            }
            return redirect()->intended('/')->with('success', 'Berhasil login!');
        }

        return back()->withInput()->with('error', 'Kombinasi login dan password tidak sesuai.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('operator')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout!');
    }
}
