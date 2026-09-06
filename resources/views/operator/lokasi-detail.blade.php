@extends('layouts.app')

@section('konten')
<div class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

    <!-- Sidebar Operator -->
    <aside class="hidden lg:flex fixed top-20 bottom-0 left-0 w-72 bg-white/95 dark:bg-[#151824]/95 backdrop-blur-md border-r border-slate-200/80 dark:border-slate-800 p-6 flex-col justify-between shrink-0 z-30 overflow-y-auto">
        <div>
            <div class="p-4 rounded-3xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/60 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30 shrink-0">
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

            <nav class="flex flex-col gap-2.5 text-xs font-bold">
                <a href="{{ route('operator.dasbor') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-600 transition">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-400"></i> Dashboard
                </a>
                <a href="{{ route('operator.proyek') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-600 transition">
                    <i data-lucide="clapperboard" class="w-4 h-4 text-slate-400"></i> Proyek Media
                </a>
                <a href="{{ route('operator.lokasi') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/25 font-extrabold playful-btn">
                    <i data-lucide="globe" class="w-4 h-4"></i> Kanal Unggahan
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

    <!-- Konten Halaman Detail Kanal -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-8 max-w-full">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <a href="{{ route('operator.lokasi') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1 transition">
                <i data-lucide="globe" class="w-3.5 h-3.5"></i> Kanal Unggahan
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-600 dark:text-slate-300 font-bold truncate">{{ $lokasi->nama_kanal }}</span>
        </div>

        <!-- Header Detail -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-3xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 shrink-0">
                    <i data-lucide="globe" class="w-8 h-8"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase font-extrabold tracking-widest text-indigo-500 dark:text-indigo-400 block mb-0.5">Detail Kanal Publikasi</span>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-800 dark:text-white">
                        {{ $lokasi->nama_kanal }}
                    </h1>
                    @if($lokasi->tautan)
                        <a href="{{ $lokasi->tautan }}" target="_blank" class="text-xs text-indigo-500 hover:underline flex items-center gap-1 mt-1">
                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i> {{ $lokasi->tautan }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('operator.lokasi') }}" class="w-full sm:w-auto text-xs font-extrabold px-5 py-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 shadow-sm flex items-center justify-center gap-2 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
                <form action="{{ route('operator.lokasi.hapus', $lokasi->id) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="konfirmasiHapus(event, 'Hapus Kanal Unggah?', 'Kanal {{ $lokasi->nama_kanal }} beserta semua item konten yang terhubung akan dihapus.')" class="w-full text-xs font-extrabold px-5 py-3 rounded-2xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 hover:bg-rose-100 flex items-center justify-center gap-2 transition">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Kanal
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-indigo-100 dark:border-indigo-950 p-6 soft-card flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-indigo-500 uppercase tracking-wider">Total Item Konten</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $rincianKonten->count() }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Materi terhubung ke kanal ini</p>
                </div>
                <div class="w-13 h-13 w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <i data-lucide="file-video" class="w-7 h-7"></i>
                </div>
            </div>

            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-emerald-100 dark:border-emerald-950 p-6 soft-card flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-emerald-500 uppercase tracking-wider">Terunggah</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $rincianKonten->where('status_unggah', 'terunggah')->count() }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Konten selesai dipublikasikan</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <i data-lucide="circle-check" class="w-7 h-7"></i>
                </div>
            </div>

            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-amber-100 dark:border-amber-950 p-6 soft-card flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold text-amber-500 uppercase tracking-wider">Menunggu / Proses</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $rincianKonten->whereIn('status_unggah', ['menunggu', 'siap_unggah'])->count() }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Konten belum diunggah</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <i data-lucide="clock" class="w-7 h-7"></i>
                </div>
            </div>
        </div>

        <!-- Info Kanal -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card">
            <h3 class="text-base font-black text-slate-800 dark:text-white flex items-center gap-2 mb-5">
                <i data-lucide="info" class="w-5 h-5 text-indigo-500"></i> Informasi Kanal
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 text-xs">
                <div>
                    <span class="uppercase font-extrabold text-slate-400 tracking-wider block mb-1.5">Nama Kanal</span>
                    <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $lokasi->nama_kanal }}</p>
                </div>
                <div>
                    <span class="uppercase font-extrabold text-slate-400 tracking-wider block mb-1.5">Tautan / URL</span>
                    @if($lokasi->tautan)
                        <a href="{{ $lokasi->tautan }}" target="_blank" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                            <i data-lucide="external-link" class="w-3.5 h-3.5 shrink-0"></i>
                            <span class="truncate">{{ $lokasi->tautan }}</span>
                        </a>
                    @else
                        <span class="text-slate-400 italic">Tidak ada tautan</span>
                    @endif
                </div>
                <div>
                    <span class="uppercase font-extrabold text-slate-400 tracking-wider block mb-1.5">Keterangan Format</span>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed">{{ $lokasi->keterangan ?? 'Tidak ada catatan format khusus.' }}</p>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Konten Terhubung -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="list-video" class="w-5 h-5 text-indigo-500"></i> Daftar Konten yang Menggunakan Kanal Ini
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Semua item rincian konten dari berbagai proyek yang dijadwalkan di kanal ini</p>
                </div>
                <span class="edu-badge bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400">
                    {{ $rincianKonten->count() }} Item
                </span>
            </div>

            @if($rincianKonten->isEmpty())
                <div class="text-center py-14">
                    <div class="w-14 h-14 rounded-3xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="inbox" class="w-7 h-7"></i>
                    </div>
                    <h4 class="font-bold text-sm text-slate-700 dark:text-slate-200">Belum Ada Konten Terhubung</h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Kanal ini belum dipilih sebagai tujuan unggah pada item konten manapun.</p>
                    <a href="{{ route('operator.proyek') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow-md shadow-emerald-500/25 playful-btn">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> Kelola Proyek
                    </a>
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-800">
                    <table class="w-full min-w-[560px] text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 uppercase font-extrabold text-slate-500 dark:text-slate-400 tracking-wider">
                            <tr>
                                <th class="p-4">Nama Konten</th>
                                <th class="p-4">Proyek</th>
                                <th class="p-4">Jenis Media</th>
                                <th class="p-4">Status Unggah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-[#151824]">
                            @foreach($rincianKonten as $item)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                                @if($item->jenis_media === 'video')
                                                    <i data-lucide="video" class="w-3.5 h-3.5"></i>
                                                @elseif($item->jenis_media === 'gambar')
                                                    <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                                @elseif($item->jenis_media === 'audio')
                                                    <i data-lucide="headphones" class="w-3.5 h-3.5"></i>
                                                @elseif($item->jenis_media === 'artikel')
                                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                                @else
                                                    <i data-lucide="file" class="w-3.5 h-3.5"></i>
                                                @endif
                                            </div>
                                            <span class="font-bold text-slate-800 dark:text-white truncate max-w-[150px]">{{ $item->nama_item }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <a href="{{ route('operator.proyek') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:underline truncate block max-w-[150px]">
                                            {{ $item->proyek->judul_proyek ?? '—' }}
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        <span class="edu-badge bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 uppercase">
                                            {{ $item->jenis_media }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="edu-badge
                                            @if($item->status_unggah === 'terunggah') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                            @elseif($item->status_unggah === 'siap_unggah') bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-400
                                            @else bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400 @endif">
                                            {{ str_replace('_', ' ', $item->status_unggah) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>
</div>
@endsection
