@extends('layouts.app')

@section('konten')
<div class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

    <!-- Sidebar Operator (Desktop: Fixed Diam / Tidak Bergerak) -->
    <aside class="hidden lg:flex fixed top-20 bottom-0 left-0 w-72 bg-white/95 dark:bg-[#151824]/95 backdrop-blur-md border-r border-slate-200/80 dark:border-slate-800 p-6 flex-col justify-between shrink-0 z-30 overflow-y-auto">
        <div>
            <!-- Banner Profil Operator -->
            <div class="p-4 rounded-3xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/60 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center font-black text-sm shadow-md shadow-emerald-500/30 shrink-0">
                        <i data-lucide="palette" class="w-6 h-6"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-black text-sm text-slate-800 dark:text-white truncate">{{ $operator->nama }}</h4>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Operator Media
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigasi Operator -->
            <nav class="flex flex-col gap-2.5 text-xs font-bold">
                <a href="{{ route('operator.dasbor') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/25 font-extrabold playful-btn">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                <a href="{{ route('operator.proyek') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-600 transition">
                    <i data-lucide="clapperboard" class="w-4 h-4 text-slate-400"></i> Proyek Media
                </a>
                <a href="{{ route('operator.lokasi') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-600 transition">
                    <i data-lucide="globe" class="w-4 h-4 text-slate-400"></i> Kanal Unggahan
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

    <!-- Konten Dashboard Operator -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-8 max-w-full">
        <!-- Header Dasbor -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] uppercase font-extrabold tracking-widest text-emerald-500 dark:text-emerald-400 block mb-1">Ruang Kreasi Operator</span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-800 dark:text-white">
                    Dashboard Operator
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">
                    Selamat datang kembali, <strong>{{ $operator->nama }}</strong>! Ringkasan aktivitas dan kemajuan konten media Anda.
                </p>
            </div>
        </div>


        <!-- Metric Stat Cards Soft Edu -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-[#151824] border border-emerald-100 dark:border-emerald-950 soft-card flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-emerald-500 uppercase tracking-wider">Total Proyek</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $daftarProyek->count() }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Rencana media terdaftar</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl shadow-sm">
                    <i data-lucide="folder-kanban" class="w-7 h-7"></i>
                </div>
            </div>

            <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-[#151824] border border-indigo-100 dark:border-indigo-950 soft-card flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-indigo-500 uppercase tracking-wider">Kanal Unggahan</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $daftarLokasiUnggah->count() }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Destinasi publikasi aktif</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl shadow-sm">
                    <i data-lucide="globe" class="w-7 h-7"></i>
                </div>
            </div>

            <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-[#151824] border border-purple-100 dark:border-purple-950 soft-card flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-purple-500 uppercase tracking-wider">Item Konten</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $daftarProyek->sum(fn($p) => $p->rincian->count()) }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Total rincian materi media</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl shadow-sm">
                    <i data-lucide="file-video" class="w-7 h-7"></i>
                </div>
            </div>
        </div>

        <!-- Progress Status Proyek & Ringkasan Kanal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Status Proyek -->
            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-7 soft-card">
                <h3 class="text-base sm:text-lg font-black text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-emerald-500"></i> Status Proyek Saya
                </h3>
                <div class="space-y-3.5">
                    @php
                        $totalP = max($daftarProyek->count(), 1);
                        $drafCount = $daftarProyek->where('status_proyek', 'draf')->count();
                        $prosesCount = $daftarProyek->where('status_proyek', 'dalam_proses')->count();
                        $selesaiCount = $daftarProyek->where('status_proyek', 'selesai')->count();
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600 dark:text-slate-300">Selesai</span>
                            <span class="text-emerald-600 dark:text-emerald-400">{{ $selesaiCount }} Proyek</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: {{ ($selesaiCount / $totalP) * 100 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600 dark:text-slate-300">Dalam Proses</span>
                            <span class="text-amber-600 dark:text-amber-400">{{ $prosesCount }} Proyek</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full rounded-full" style="width: {{ ($prosesCount / $totalP) * 100 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600 dark:text-slate-300">Draf Awal</span>
                            <span class="text-slate-500 dark:text-slate-400">{{ $drafCount }} Proyek</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-slate-400 h-full rounded-full" style="width: {{ ($drafCount / $totalP) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 text-center">
                    <a href="{{ route('operator.proyek') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
                        Buka Halaman Proyek Media <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Ringkasan Kanal Unggahan -->
            <div class="lg:col-span-2 bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-7 soft-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="globe" class="w-5 h-5 text-indigo-500"></i> Kanal Unggahan Aktif
                    </h3>
                    <a href="{{ route('operator.lokasi') }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                        Kelola Semua Kanal →
                    </a>
                </div>

                @if($daftarLokasiUnggah->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-xs text-slate-400">Belum ada kanal unggahan terdaftar.</p>
                        <a href="{{ route('operator.lokasi') }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Kanal Pertama
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($daftarLokasiUnggah->take(4) as $lok)
                            <div class="p-3.5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/60 dark:bg-[#1b1f2e]/60 flex items-center justify-between">
                                <div class="overflow-hidden pr-2">
                                    <div class="font-extrabold text-xs text-slate-800 dark:text-white flex items-center gap-1.5">
                                        <i data-lucide="pin" class="w-3.5 h-3.5 text-emerald-500 shrink-0"></i>
                                        <span class="truncate">{{ $lok->nama_kanal }}</span>
                                    </div>
                                    @if($lok->tautan)
                                        <a href="{{ $lok->tautan }}" target="_blank" class="text-[11px] text-indigo-500 hover:underline block truncate mt-0.5">{{ $lok->tautan }}</a>
                                    @endif
                                </div>
                                <span class="edu-badge bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 text-[10px] shrink-0">
                                    {{ $lok->rincian->count() }} Konten
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Daftar Proyek Terkini -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="calendar-days" class="w-5 h-5 text-emerald-500"></i> Proyek Media Terkini
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Daftar rencana kerja media terbaru yang sedang Anda kelola</p>
                </div>
                <a href="{{ route('operator.proyek') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                    Lihat Semua Proyek →
                </a>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($proyekTerbaru as $proyek)
                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 p-3.5 rounded-2xl transition">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black text-base shrink-0">
                                <i data-lucide="clapperboard" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="font-extrabold text-sm sm:text-base text-slate-800 dark:text-white">{{ $proyek->judul_proyek }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-2 font-medium">
                                    <span>{{ $proyek->rincian->count() }} Item Konten Terjadwal</span>
                                    <span>•</span>
                                    <span>Target: {{ $proyek->target_selesai ?? 'Tanpa Target' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 self-end sm:self-auto">
                            <span class="edu-badge
                                @if($proyek->status_proyek == 'selesai') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400
                                @else bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                                {{ str_replace('_', ' ', $proyek->status_proyek) }}
                            </span>
                            <a href="{{ route('operator.proyek') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-emerald-50 hover:text-emerald-600 text-xs font-bold transition">
                                Buka
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-14 h-14 rounded-3xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-500 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="folder-plus" class="w-7 h-7"></i>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-slate-200">Belum Ada Proyek Media</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Mulai susun rencana materi dan agenda kampanye media Anda.</p>
                        <a href="{{ route('operator.proyek') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow-md shadow-emerald-500/25 playful-btn">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Proyek Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
