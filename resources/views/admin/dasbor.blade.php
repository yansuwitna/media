@extends('layouts.app')

@section('konten')
<div class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

    <!-- Sidebar Admin (Desktop: Fixed Diam / Tidak Bergerak) -->
    <aside class="hidden lg:flex fixed top-20 bottom-0 left-0 w-72 bg-white/95 dark:bg-[#151824]/95 backdrop-blur-md border-r border-slate-200/80 dark:border-slate-800 p-6 flex-col justify-between shrink-0 z-30 overflow-y-auto">
        <div>
            <!-- Banner Profil Admin -->
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

            <!-- Tautan Navigasi -->
            <nav class="flex flex-col gap-2.5 text-xs font-bold">
                <a href="{{ route('admin.dasbor') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/25 playful-btn font-extrabold">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dasbor
                </a>
                <a href="{{ route('admin.identitas') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:text-indigo-600 transition">
                    <i data-lucide="sliders" class="w-4 h-4 text-slate-400"></i> Identitas Web
                </a>
                <a href="{{ route('admin.operator') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:text-indigo-600 transition">
                    <i data-lucide="users" class="w-4 h-4 text-slate-400"></i> Kelola Operator
                </a>
                <a href="{{ route('admin.kata-sandi') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:text-indigo-600 transition">
                    <i data-lucide="key-round" class="w-4 h-4 text-slate-400"></i> Ubah Kata Sandi
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

    <!-- Konten Dashboard Admin -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-8 max-w-full">
        <!-- Header Dashboard -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] uppercase font-extrabold tracking-widest text-indigo-500 dark:text-indigo-400 block mb-1">Pusat Kendali Edu & Edukasi</span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-800 dark:text-white">
                    Dasbor Administrator
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">
                    Pantau kinerja tim operator media dan kelola konfigurasi aplikasi secara terpusat.
                </p>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-7 rounded-3xl bg-white dark:bg-[#151824] border border-indigo-100 dark:border-indigo-950 soft-card">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-extrabold text-indigo-500 uppercase tracking-wider">Operator Aktif</span>
                        <h3 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mt-2">{{ $totalOperator }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl shadow-sm">
                        <i data-lucide="users" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-emerald-500 font-bold flex items-center gap-1.5">● Terverifikasi</span>
                    <a href="{{ route('admin.operator') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold text-[11px]">Buka kelola →</a>
                </div>
            </div>

            <div class="p-7 rounded-3xl bg-white dark:bg-[#151824] border border-emerald-100 dark:border-emerald-950 soft-card">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-extrabold text-emerald-500 uppercase tracking-wider">Rencana Media</span>
                        <h3 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mt-2">{{ $totalProyek }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl shadow-sm">
                        <i data-lucide="clapperboard" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">Multi-Platform</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold text-[11px]">Semua kanal</span>
                </div>
            </div>

            <div class="p-7 rounded-3xl bg-white dark:bg-[#151824] border border-amber-100 dark:border-amber-950 soft-card sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-extrabold text-amber-500 uppercase tracking-wider">Identitas Sistem</span>
                        <h4 class="text-xl font-black text-slate-800 dark:text-white mt-2 truncate">{{ $identitas->nama_aplikasi ?? 'Media Plan' }}</h4>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl shadow-sm">
                        <i data-lucide="sliders" class="w-7 h-7"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium capitalize">Tema: <strong class="text-amber-500">{{ $identitas->tema_bawaan ?? 'Gelap' }}</strong></span>
                    <a href="{{ route('admin.identitas') }}" class="text-amber-600 dark:text-amber-400 hover:underline font-bold text-[11px]">Ubah nama →</a>
                </div>
            </div>
        </div>

        <!-- Tabel Aktivitas Proyek Terkini -->
        <div class="rounded-3xl bg-white dark:bg-[#151824] border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="calendar-days" class="w-5 h-5 text-indigo-500"></i> Agenda Proyek Terbaru
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Daftar rancangan proyek yang masuk dari para operator</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($proyekTerbaru as $proyek)
                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 p-3.5 rounded-2xl transition">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-base shrink-0">
                                <i data-lucide="palette" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="font-extrabold text-sm sm:text-base text-slate-800 dark:text-white">{{ $proyek->judul_proyek }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-2 font-medium">
                                    <span>Operator: <strong class="text-slate-700 dark:text-slate-300">{{ $proyek->operator->nama ?? '-' }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $proyek->rincian->count() }} Konten Siap</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 self-end sm:self-auto">
                            <span class="text-xs text-slate-400 font-medium">Target: {{ $proyek->target_selesai ?? '-' }}</span>
                            <span class="edu-badge
                                @if($proyek->status_proyek == 'selesai') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400
                                @else bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300 @endif">
                                {{ str_replace('_', ' ', $proyek->status_proyek) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-8 text-center">Belum ada proyek media terdaftar dalam sistem.</p>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
