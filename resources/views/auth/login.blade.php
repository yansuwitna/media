@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-140px)] flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl shadow-xl p-8"
         x-data="{ selectedRole: 'admin' }">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Portal Akses Pengguna</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Login multi-tabel sesuai wewenang peran Anda</p>
        </div>

        <!-- Role Selector Tabs -->
        <div class="grid grid-cols-2 p-1 bg-slate-100 dark:bg-slate-900 rounded-xl mb-6 text-sm font-semibold">
            <button type="button" 
                @click="selectedRole = 'admin'" 
                :class="selectedRole === 'admin' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="py-2 rounded-lg transition text-center">
                Admin
            </button>
            <button type="button" 
                @click="selectedRole = 'operator'" 
                :class="selectedRole === 'operator' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="py-2 rounded-lg transition text-center">
                Operator
            </button>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="role" :value="selectedRole">

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">
                    Username atau Email
                </label>
                <input type="text" name="login" required 
                    placeholder="Masukkan username atau email"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">
                    Kata Sandi
                </label>
                <input type="password" name="password" required 
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md shadow-blue-500/20 transition">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 text-center text-xs text-slate-500">
            <span class="block mb-1">Demo Akun Default:</span>
            <span class="font-mono text-[11px] block">Admin: admin / Admin!</span>
            <span class="font-mono text-[11px] block">Operator: operator / operator123</span>
        </div>
    </div>
</div>
@endsection
