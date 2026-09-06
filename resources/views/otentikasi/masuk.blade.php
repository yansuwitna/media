@extends('layouts.app')

@section('konten')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white dark:bg-[#111827] border border-slate-200/90 dark:border-slate-800 rounded-3xl shadow-2xl shadow-slate-200/50 dark:shadow-none p-8 sm:p-10 relative overflow-hidden"
         x-data="{ peranDipilih: 'admin' }">
        
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                🔐
            </div>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Portal Masuk Sistem</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Otentikasi Multi-Tabel Berdasarkan Peran</p>
        </div>

        <!-- Tombol Pilih Peran -->
        <div class="grid grid-cols-2 p-1.5 bg-slate-100 dark:bg-slate-900/90 rounded-2xl mb-6 text-xs font-bold border border-slate-200/60 dark:border-slate-800">
            <button type="button" 
                @click="peranDipilih = 'admin'" 
                :class="peranDipilih === 'admin' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200'"
                class="py-2.5 rounded-xl transition duration-200 text-center flex items-center justify-center gap-2">
                <span>🛡️</span> Admin
            </button>
            <button type="button" 
                @click="peranDipilih = 'operator'" 
                :class="peranDipilih === 'operator' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200'"
                class="py-2.5 rounded-xl transition duration-200 text-center flex items-center justify-center gap-2">
                <span>⚡</span> Operator
            </button>
        </div>

        <form action="{{ route('masuk.proses') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="peran" :value="peranDipilih">

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">
                    Nama Pengguna atau Email
                </label>
                <input type="text" name="masukan_login" required 
                    placeholder="Ketik nama pengguna atau surel"
                    class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/80 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-slate-900 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">
                    Kata Sandi
                </label>
                <input type="password" name="kata_sandi" required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/80 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-slate-900 transition">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400 font-medium">
                    <input type="checkbox" name="ingat_saya" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Ingat sesi saya
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-0.5 transition duration-200">
                Masuk ke Dasbor
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 text-center text-[11px] text-slate-400">
            <span class="font-semibold text-slate-500 block mb-1">Kredensial Demo:</span>
            <div class="flex justify-center gap-4 mt-1 font-mono text-[10px]">
                <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800/80 rounded-md">Admin: admin / Admin!</span>
                <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800/80 rounded-md">Operator: operator / operator123</span>
            </div>
        </div>
    </div>
</div>
@endsection
