@extends('layouts.app')

@section('konten')
<div class="min-h-[calc(100vh-160px)] flex flex-col items-center justify-center p-4">

    <!-- Tombol Kembali ke Beranda -->
    <div class="w-full max-w-md mb-4 flex justify-start">
        <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white dark:bg-[#151824] border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-indigo-50 hover:text-indigo-600 transition shadow-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Kotak Login Soft Playful -->
    <div class="w-full max-w-md bg-white dark:bg-[#151824] border border-slate-200/90 dark:border-slate-800/90 rounded-4xl shadow-xl shadow-indigo-500/5 p-8 sm:p-10 relative overflow-hidden"
         x-data="{ peranDipilih: 'admin' }">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-3xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto mb-3 shadow-inner">
                <i data-lucide="graduation-cap" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">Portal Masuk</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Pilih peran akun Anda untuk mulai belajar & berencana</p>
        </div>

        <!-- Tombol Pilih Peran Edu Playful -->
        <div class="grid grid-cols-2 p-1.5 bg-slate-100 dark:bg-[#0f111a] rounded-2xl mb-6 text-xs font-bold border border-slate-200/70 dark:border-slate-800">
            <button type="button" 
                @click="peranDipilih = 'admin'" 
                :class="peranDipilih === 'admin' ? 'bg-white dark:bg-[#151824] text-indigo-600 dark:text-indigo-400 shadow-md font-extrabold' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200'"
                class="py-2.5 rounded-xl transition duration-200 text-center flex items-center justify-center gap-2">
                <i data-lucide="shield" class="w-4 h-4"></i> Admin
            </button>
            <button type="button" 
                @click="peranDipilih = 'operator'" 
                :class="peranDipilih === 'operator' ? 'bg-white dark:bg-[#151824] text-indigo-600 dark:text-indigo-400 shadow-md font-extrabold' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200'"
                class="py-2.5 rounded-xl transition duration-200 text-center flex items-center justify-center gap-2">
                <i data-lucide="palette" class="w-4 h-4"></i> Operator
            </button>
        </div>

        <form action="{{ route('masuk.proses') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="peran" :value="peranDipilih">

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">
                    Nama Pengguna atau Email
                </label>
                <input type="text" name="masukan_login" required 
                    placeholder="Masukkan nama pengguna..."
                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-slate-800 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">
                    Kata Sandi
                </label>
                <input type="password" name="kata_sandi" required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-slate-800 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400 font-medium">
                    <input type="checkbox" name="ingat_saya" class="w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Ingat sesi saya
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-indigo-500/25 playful-btn">
                Masuk ke Ruang Kerja
            </button>
        </form>

    </div>
</div>
@endsection
