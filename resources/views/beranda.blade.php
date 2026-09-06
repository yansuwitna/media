@extends('layouts.app')

@section('konten')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Kepala Bagian Utama -->
    <div class="relative text-center max-w-3xl mx-auto mb-16">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-950/70 border border-indigo-200/60 dark:border-indigo-800/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-6">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
            Perencanaan & Manajemen Media
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
            Perencanaan Media Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">Terstruktur & Elegan</span>
        </h1>
        <p class="mt-5 text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
            {{ $identitas->deskripsi_aplikasi ?? 'Sistem kolaboratif multi-peran untuk merencanakan konten, menetapkan lokasi publikasi, dan memonitor eksekusi kampanye kreatif.' }}
        </p>
    </div>

    <!-- Kartu Statistik Jumlah Proyek -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        <div class="relative group p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800/80 shadow-xl shadow-slate-200/40 dark:shadow-none hover:border-indigo-500/50 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-wider font-bold text-slate-400">Total Proyek</span>
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl">
                    📁
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4">{{ $totalProyek }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Semua rencana media terdata</p>
        </div>

        <div class="relative group p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800/80 shadow-xl shadow-slate-200/40 dark:shadow-none hover:border-amber-500/50 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-wider font-bold text-slate-400">Dalam Proses</span>
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl">
                    ⚡
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4">{{ $proyekDalamProses }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Sedang diproduksi / disiapkan</p>
        </div>

        <div class="relative group p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800/80 shadow-xl shadow-slate-200/40 dark:shadow-none hover:border-emerald-500/50 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-wider font-bold text-slate-400">Proyek Selesai</span>
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                    ✅
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4">{{ $proyekSelesai }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Telah dipublikasikan penuh</p>
        </div>

        <div class="relative group p-6 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800/80 shadow-xl shadow-slate-200/40 dark:shadow-none hover:border-purple-500/50 transition duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-wider font-bold text-slate-400">Draf Rencana</span>
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl">
                    💡
                </div>
            </div>
            <h3 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4">{{ $proyekDraf }}</h3>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Konsep perencanaan awal</p>
        </div>
    </div>

    <!-- Daftar Proyek Rencana Media Terbaru -->
    <div class="rounded-3xl bg-white/80 dark:bg-[#111827]/80 border border-slate-200/80 dark:border-slate-800/80 p-8 sm:p-10 shadow-xl shadow-slate-200/30 dark:shadow-none">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Rencana Media Terkini</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar agenda kampanye dan materi konten yang sedang aktif</p>
            </div>
            <a href="{{ route('masuk') }}" class="inline-flex items-center gap-2 text-xs font-semibold px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition">
                Masuk untuk Kelola <span>→</span>
            </a>
        </div>

        @if($proyekTerbaru->isEmpty())
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4">
                    📝
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200">Belum Ada Proyek</h4>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Operator dapat masuk ke dasbor untuk mulai menambahkan proyek dan rincian konten media.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($proyekTerbaru as $proyek)
                    <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/40 p-6 flex flex-col justify-between hover:border-indigo-500/40 transition duration-200">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider
                                    @if($proyek->status_proyek == 'selesai') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20
                                    @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20
                                    @else bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/20 @endif">
                                    {{ str_replace('_', ' ', $proyek->status_proyek) }}
                                </span>
                                <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1">
                                    📅 {{ $proyek->target_selesai ? \Carbon\Carbon::parse($proyek->target_selesai)->format('d M Y') : 'Tanpa target' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2 leading-snug">{{ $proyek->judul_proyek }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed mb-6">{{ $proyek->deskripsi_proyek ?? 'Tidak ada rincian keterangan.' }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-[9px]">OP</span>
                                {{ $proyek->operator->nama ?? 'Operator' }}
                            </span>
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded-md">
                                {{ $proyek->rincian->count() }} Rincian
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
