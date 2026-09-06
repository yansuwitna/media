@extends('layouts.app')

@section('konten')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">

    <!-- Hero Header Soft Playful -->
    <div class="relative text-center max-w-3xl mx-auto mb-14 sm:mb-20">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-100/80 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800/80 text-indigo-600 dark:text-indigo-400 text-xs font-bold tracking-wide mb-6 shadow-sm">
            <i data-lucide="sparkles" class="w-3.5 h-3.5 text-indigo-500"></i> Rencanakan Konten Media Seru & Teratur
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-800 dark:text-white leading-tight">
            Ruang Kreatif Perencanaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">Media Interaktif</span>
        </h1>
        <p class="mt-5 text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
            {{ $identitas->deskripsi_aplikasi ?? 'Sistem kolaboratif ramah pengguna untuk merancang jadwal publikasi, rincian video/grafis, dan kanal distribusi media secara menyenangkan.' }}
        </p>

        <div class="mt-8 flex justify-center w-full">
            <a href="{{ route('masuk') }}" class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm shadow-xl shadow-indigo-500/25 playful-btn flex items-center justify-center gap-2">
                <span>Mulai Eksplorasi</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Soft Playful Metric Cards (Rounded besar, warna pastel edukatif) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-16">
        <!-- Total Proyek (Indigo/Blue Pastel) -->
        <div class="p-6 rounded-3xl bg-white dark:bg-[#151824] border border-indigo-100 dark:border-indigo-950 soft-card hover:-translate-y-1 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider">Total Proyek</span>
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-xl shadow-sm">
                    <i data-lucide="folder" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mt-3">{{ $totalProyek }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Agenda terdaftar</p>
        </div>

        <!-- Dalam Proses (Warm Sun Yellow / Amber) -->
        <div class="p-6 rounded-3xl bg-white dark:bg-[#151824] border border-amber-100 dark:border-amber-950 soft-card hover:-translate-y-1 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-amber-500 dark:text-amber-400 uppercase tracking-wider">Sedang Jalan</span>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-300 flex items-center justify-center text-xl shadow-sm">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mt-3">{{ $proyekDalamProses }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Dalam pengerjaan</p>
        </div>

        <!-- Selesai (Fresh Mint Green) -->
        <div class="p-6 rounded-3xl bg-white dark:bg-[#151824] border border-emerald-100 dark:border-emerald-950 soft-card hover:-translate-y-1 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-emerald-500 dark:text-emerald-400 uppercase tracking-wider">Selesai</span>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-300 flex items-center justify-center text-xl shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mt-3">{{ $proyekSelesai }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Telah dipublikasikan</p>
        </div>

        <!-- Draf (Soft Coral Pink) -->
        <div class="p-6 rounded-3xl bg-white dark:bg-[#151824] border border-rose-100 dark:border-rose-950 soft-card hover:-translate-y-1 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-rose-500 dark:text-rose-400 uppercase tracking-wider">Ide Draf</span>
                <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-300 flex items-center justify-center text-xl shadow-sm">
                    <i data-lucide="lightbulb" class="w-5 h-5"></i>
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mt-3">{{ $proyekDraf }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Rencana konsep awal</p>
        </div>
    </div>

    <!-- Daftar Proyek Terkini Edu Dashboard -->
    <div class="rounded-3xl bg-white dark:bg-[#151824] border border-slate-200/80 dark:border-slate-800 p-6 sm:p-10 soft-card">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-white tracking-tight flex items-center gap-2.5">
                    <i data-lucide="book-open" class="w-6 h-6 text-indigo-500"></i> Rencana Media Terkini
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Daftar agenda materi konten aktif yang siap publikasi</p>
            </div>
            <a href="{{ route('masuk') }}" class="self-start sm:self-auto inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 transition">
                Masuk untuk Kelola <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        @if($proyekTerbaru->isEmpty())
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-3xl bg-indigo-50 dark:bg-slate-800 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="palette" class="w-8 h-8"></i>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200">Belum Ada Proyek</h4>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Operator dapat masuk ke dasbor untuk mulai menyusun rencana media.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($proyekTerbaru as $proyek)
                    <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800/80 bg-slate-50/50 dark:bg-[#1b1f2e]/60 p-6 flex flex-col justify-between hover:border-indigo-400/50 transition duration-200">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="edu-badge
                                    @if($proyek->status_proyek == 'selesai') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                    @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400
                                    @else bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                                    {{ str_replace('_', ' ', $proyek->status_proyek) }}
                                </span>
                                <span class="text-xs font-semibold text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $proyek->target_selesai ? \Carbon\Carbon::parse($proyek->target_selesai)->format('d M Y') : 'Tanpa target' }}
                                </span>
                            </div>
                            <h3 class="font-extrabold text-base sm:text-lg text-slate-800 dark:text-white mb-2 leading-snug">{{ $proyek->judul_proyek }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed mb-6">{{ $proyek->deskripsi_proyek ?? 'Tidak ada rincian keterangan.' }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-200/70 dark:border-slate-700/60 flex items-center justify-between text-xs text-slate-500">
                            <span class="flex items-center gap-2 font-medium">
                                <span class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-[10px]">OP</span>
                                {{ $proyek->operator->nama ?? 'Operator' }}
                            </span>
                            <span class="font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-800/60 text-[11px]">
                                {{ $proyek->rincian->count() }} Konten
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
