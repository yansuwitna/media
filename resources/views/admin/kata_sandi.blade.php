@extends('layouts.app')

@section('konten')
<div class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

    <!-- Sidebar Admin (Desktop: Fixed Diam / Tidak Bergerak) -->
    <aside class="hidden lg:flex fixed top-20 bottom-0 left-0 w-72 bg-white/95 dark:bg-[#151824]/95 backdrop-blur-md border-r border-slate-200/80 dark:border-slate-800 p-6 flex-col justify-between shrink-0 z-30 overflow-y-auto">
        <div>
            <div class="p-4 rounded-3xl bg-indigo-50/80 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/60 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-indigo-500/30 shrink-0">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-black text-sm text-slate-800 dark:text-white truncate">{{ auth('admin')->user()->nama }}</h4>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-indigo-600 dark:text-indigo-400 font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Administrator
                        </span>
                    </div>
                </div>
            </div>

            <nav class="flex flex-col gap-2.5 text-xs font-bold">
                <a href="{{ route('admin.dasbor') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-400"></i> Dasbor
                </a>
                <a href="{{ route('admin.identitas') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition">
                    <i data-lucide="sliders" class="w-4 h-4 text-slate-400"></i> Identitas Web
                </a>
                <a href="{{ route('admin.operator') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition">
                    <i data-lucide="users" class="w-4 h-4 text-slate-400"></i> Kelola Operator
                </a>
                <a href="{{ route('admin.kata-sandi') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/25 font-extrabold playful-btn">
                    <i data-lucide="key-round" class="w-4 h-4"></i> Ubah Kata Sandi
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-200/80 dark:border-slate-800">
            <form action="{{ route('keluar') }}" method="POST">
                @csrf
                <button type="button" onclick="konfirmasiKeluar(event)" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Ubah Kata Sandi -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-6 sm:space-y-8 max-w-full">
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card max-w-2xl">
            <div class="mb-6">
                <h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                    <i data-lucide="key-round" class="w-6 h-6 text-indigo-500"></i> Ubah Kata Sandi Administrator
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Perbarui kata sandi akun Anda secara berkala demi keamanan sistem.</p>
            </div>

            <form action="{{ route('admin.kata-sandi.perbarui') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase">Kata Sandi Saat Ini</label>
                    <input type="password" name="kata_sandi_lama" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="Masukkan kata sandi saat ini">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase">Kata Sandi Baru</label>
                    <input type="password" name="kata_sandi_baru" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="kata_sandi_baru_confirmation" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                        placeholder="Ulangi kata sandi baru">
                </div>

                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-extrabold shadow-lg shadow-indigo-500/25 playful-btn">
                    Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </main>
</div>
@endsection
