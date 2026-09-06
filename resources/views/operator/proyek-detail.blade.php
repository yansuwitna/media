@extends('layouts.app')

@section('konten')
<div x-data="{ 
    modalTambah: false, 
    modalUbah: false, 
    modalUbahRincian: false, 
    modalDetailRincian: false, 
    modalTambahKanal: false,
    rincianUbah: {}, 
    rincianDetail: { kanals: [] },
    formTambahKanal: { id_rincian: null, id_lokasi_unggah: '', link_unggahan: '' }
}" class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

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
                <a href="{{ route('operator.proyek') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/25 font-extrabold playful-btn">
                    <i data-lucide="clapperboard" class="w-4 h-4"></i> Proyek Media
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

    <!-- Konten Halaman Detail Proyek -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-8 max-w-full">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium flex-wrap">
            <a href="{{ route('operator.proyek') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 flex items-center gap-1 transition">
                <i data-lucide="clapperboard" class="w-3.5 h-3.5"></i> Proyek Media
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-600 dark:text-slate-300 font-bold truncate">{{ $proyek->judul_proyek }}</span>
        </div>

        <!-- Header Detail Proyek -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-3xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 shrink-0">
                    <i data-lucide="clapperboard" class="w-8 h-8"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase font-extrabold tracking-widest text-emerald-500 dark:text-emerald-400 block mb-0.5">Detail Proyek Media</span>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-800 dark:text-white leading-tight">
                        {{ $proyek->judul_proyek }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 max-w-xl leading-relaxed">
                        {{ $proyek->deskripsi_proyek ?? 'Tidak ada keterangan proyek.' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                <button @click="modalTambah = true" type="button" class="w-full sm:w-auto text-xs font-extrabold px-5 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/25 playful-btn flex items-center justify-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Konten
                </button>
                <a href="{{ route('operator.proyek') }}" class="w-full sm:w-auto text-xs font-extrabold px-5 py-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 shadow-sm flex items-center justify-center gap-2 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
                <button @click="modalUbah = true" type="button" title="Ubah Data Proyek" class="w-11 h-11 rounded-2xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 hover:bg-amber-100 flex items-center justify-center transition">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </button>
                <form action="{{ route('operator.proyek.hapus', $proyek->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" title="Hapus Proyek" onclick="konfirmasiHapus(event, 'Hapus Proyek Media?', 'Seluruh rincian konten di dalam proyek ini juga akan dihapus permanen!')" class="w-11 h-11 rounded-2xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 hover:bg-rose-100 flex items-center justify-center transition">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-5 soft-card">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Total Konten</span>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $proyek->rincian->count() }}</h3>
            </div>
            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-emerald-100 dark:border-emerald-950 p-5 soft-card">
                <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-wider block mb-1">Terunggah</span>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $proyek->rincian->where('status_unggah', 'terunggah')->count() }}</h3>
            </div>
            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-indigo-100 dark:border-indigo-950 p-5 soft-card">
                <span class="text-[10px] font-extrabold text-indigo-500 uppercase tracking-wider block mb-1">Siap Unggah</span>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $proyek->rincian->where('status_unggah', 'siap_unggah')->count() }}</h3>
            </div>
            <div class="bg-white dark:bg-[#151824] rounded-3xl border border-amber-100 dark:border-amber-950 p-5 soft-card">
                <span class="text-[10px] font-extrabold text-amber-500 uppercase tracking-wider block mb-1">Menunggu</span>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $proyek->rincian->where('status_unggah', 'menunggu')->count() }}</h3>
            </div>
        </div>

        <!-- Info Proyek -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-7 soft-card">
            <h3 class="text-base font-black text-slate-800 dark:text-white flex items-center gap-2 mb-5">
                <i data-lucide="info" class="w-5 h-5 text-emerald-500"></i> Informasi Proyek
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 text-xs">
                <div>
                    <span class="uppercase font-extrabold text-slate-400 tracking-wider block mb-1.5">Status Proyek</span>
                    <span class="edu-badge
                        @if($proyek->status_proyek == 'selesai') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                        @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400
                        @else bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                        {{ str_replace('_', ' ', $proyek->status_proyek) }}
                    </span>
                </div>
                <div>
                    <span class="uppercase font-extrabold text-slate-400 tracking-wider block mb-1.5">Target Selesai</span>
                    <p class="font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                        {{ $proyek->target_selesai ?? 'Tidak ada target' }}
                    </p>
                </div>
                <div>
                    <span class="uppercase font-extrabold text-slate-400 tracking-wider block mb-1.5">Dibuat Pada</span>
                    <p class="font-bold text-slate-800 dark:text-white">{{ $proyek->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Konten -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 soft-card overflow-hidden">
            <div class="flex items-center justify-between p-6 sm:p-7 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-lg font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="list-video" class="w-5 h-5 text-emerald-500"></i> Daftar Item Konten
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Seluruh item materi yang terjadwal dalam proyek ini</p>
                </div>
                <button @click="modalTambah = true" type="button" class="text-xs font-extrabold px-4 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white shadow-md shadow-emerald-500/25 playful-btn flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                </button>
            </div>

            @if($proyek->rincian->isEmpty())
                <div class="text-center py-14">
                    <div class="w-14 h-14 rounded-3xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="inbox" class="w-7 h-7"></i>
                    </div>
                    <h4 class="font-bold text-sm text-slate-700 dark:text-slate-200">Belum Ada Item Konten</h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Klik "+ Tambah Konten" untuk mulai menjadwalkan materi media dalam proyek ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[650px] text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 uppercase font-extrabold text-slate-500 dark:text-slate-400 tracking-wider">
                            <tr>
                                <th class="px-5 py-4">Kode</th>
                                <th class="px-3 py-4 text-center">Urutan</th>
                                <th class="px-5 py-4">Nama Konten</th>
                                <th class="px-5 py-4">Deskripsi</th>
                                <th class="px-4 py-4">Status</th>
                                <th class="px-4 py-4">Link</th>
                                <th class="px-5 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-[#151824]">
                            @foreach($proyek->rincian->sortBy('urutan') as $rincian)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="px-5 py-4">
                                        <span class="font-mono text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                                            {{ $rincian->kode ?: ('KTN-' . str_pad($rincian->urutan, 2, '0', STR_PAD_LEFT)) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 text-center font-black text-slate-600 dark:text-slate-400">
                                        #{{ $rincian->urutan }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-500 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                                @if($rincian->jenis_media === 'video')
                                                    <i data-lucide="video" class="w-3.5 h-3.5"></i>
                                                @elseif($rincian->jenis_media === 'gambar')
                                                    <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                                @elseif($rincian->jenis_media === 'audio')
                                                    <i data-lucide="headphones" class="w-3.5 h-3.5"></i>
                                                @elseif($rincian->jenis_media === 'artikel')
                                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                                @else
                                                    <i data-lucide="file" class="w-3.5 h-3.5"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-800 dark:text-white max-w-[180px] truncate block">{{ $rincian->nama_item }}</span>
                                                @if($rincian->lokasiUnggah)
                                                    <span class="text-[10px] text-slate-400 font-medium flex items-center gap-1 mt-0.5">
                                                        <i data-lucide="globe" class="w-2.5 h-2.5"></i> {{ $rincian->lokasiUnggah->nama_kanal }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 max-w-[200px]">
                                        <span class="text-slate-500 dark:text-slate-400 truncate block">{{ $rincian->deskripsi ?? '—' }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="edu-badge
                                            @if($rincian->status_unggah == 'terunggah') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                            @elseif($rincian->status_unggah == 'siap_unggah') bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-400
                                            @else bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400 @endif">
                                            {{ str_replace('_', ' ', $rincian->status_unggah) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($rincian->tautan_konten)
                                            <a href="{{ $rincian->tautan_konten }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 font-bold hover:bg-indigo-100 transition">
                                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Link
                                            </a>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button type="button" title="Lihat Detail & Kanal Unggahan"
                                                @click="rincianDetail = {
                                                    id: '{{ $rincian->id }}',
                                                    kode: '{{ addslashes($rincian->kode ?: ('KTN-' . str_pad($rincian->urutan, 2, '0', STR_PAD_LEFT))) }}',
                                                    urutan: '{{ $rincian->urutan }}',
                                                    nama: '{{ addslashes($rincian->nama_item) }}',
                                                    deskripsi: '{{ addslashes($rincian->deskripsi ?? '') }}',
                                                    status: '{{ $rincian->status_unggah }}',
                                                    kanals: [
                                                        @foreach($rincian->kanals as $k)
                                                            {
                                                                id: '{{ $k->id }}',
                                                                nama_kanal: '{{ addslashes($k->lokasiUnggah->nama_kanal ?? 'Kanal') }}',
                                                                tautan_kanal: '{{ addslashes($k->lokasiUnggah->tautan ?? '') }}',
                                                                link: '{{ addslashes($k->link_unggahan ?? '') }}'
                                                            },
                                                        @endforeach
                                                    ]
                                                }; modalDetailRincian = true"
                                                class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 flex items-center justify-center transition">
                                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            </button>
                                            <button type="button" title="Ubah Konten"
                                                @click="rincianUbah = {
                                                    id: '{{ $rincian->id }}',
                                                    kode: '{{ addslashes($rincian->kode ?? '') }}',
                                                    urutan: '{{ $rincian->urutan }}',
                                                    nama: '{{ addslashes($rincian->nama_item) }}',
                                                    deskripsi: '{{ addslashes($rincian->deskripsi ?? '') }}',
                                                    kanal: '{{ $rincian->id_lokasi_unggah ?? '' }}',
                                                    jenis: '{{ $rincian->jenis_media }}',
                                                    status: '{{ $rincian->status_unggah }}',
                                                    link: '{{ addslashes($rincian->tautan_konten ?? '') }}'
                                                }; modalUbahRincian = true"
                                                class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 hover:bg-amber-100 flex items-center justify-center transition">
                                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            </button>
                                            <form action="{{ route('operator.rincian.hapus', $rincian->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" title="Hapus Item" onclick="konfirmasiHapus(event, 'Hapus Item Konten?', 'Item {{ addslashes($rincian->nama_item) }} akan dihapus dari proyek ini.')" class="w-8 h-8 rounded-xl bg-rose-50 dark:bg-rose-950/50 text-rose-500 dark:text-rose-400 hover:bg-rose-100 flex items-center justify-center transition">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Modal Tambah Item Konten -->
    <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display:none;">
        <div x-show="modalTambah"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="modalTambah = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div x-show="modalTambah"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg bg-white dark:bg-[#151824] rounded-4xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 z-10">

            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30">
                        <i data-lucide="plus-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Tambah Item Konten</h3>
                        <p class="text-xs text-slate-400 font-medium">Jadwalkan materi baru dalam proyek ini.</p>
                    </div>
                </div>
                <button @click="modalTambah = false" type="button" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('operator.rincian.simpan', $proyek->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Kode Konten</label>
                        <input type="text" name="kode" value="KTN-{{ str_pad(($proyek->rincian->max('urutan') ?? 0) + 1, 2, '0', STR_PAD_LEFT) }}" placeholder="Contoh: KTN-01"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Urutan</label>
                        <input type="number" name="urutan" min="1" value="{{ ($proyek->rincian->max('urutan') ?? 0) + 1 }}"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Status</label>
                        <select name="status_unggah" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                            <option value="menunggu">Menunggu</option>
                            <option value="siap_unggah">Siap Unggah</option>
                            <option value="terunggah">Terunggah</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Nama Konten</label>
                    <input type="text" name="nama_item" placeholder="Contoh: Video Pengantar Bab 1" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" placeholder="Catatan singkat deskripsi materi..."
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Link / Tautan Konten</label>
                        <input type="url" name="tautan_konten" placeholder="https://..."
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Kanal Unggah</label>
                        <select name="id_lokasi_unggah" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                            <option value="">— Tanpa Kanal —</option>
                            @foreach($daftarLokasiUnggah as $lok)
                                <option value="{{ $lok->id }}">{{ $lok->nama_kanal }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button @click="modalTambah = false" type="button" class="px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow-lg shadow-emerald-500/30 playful-btn flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> Simpan Konten
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ubah Item Konten -->
    <div x-show="modalUbahRincian" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display:none;">
        <div x-show="modalUbahRincian"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="modalUbahRincian = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div x-show="modalUbahRincian"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg bg-white dark:bg-[#151824] rounded-4xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 z-10">

            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/30">
                        <i data-lucide="pencil" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Ubah Data Konten</h3>
                        <p class="text-xs text-slate-400 font-medium">Perbarui rincian item konten materi.</p>
                    </div>
                </div>
                <button @click="modalUbahRincian = false" type="button" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form :action="'/operator/rincian/' + rincianUbah.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Kode</label>
                        <input type="text" name="kode" :value="rincianUbah.kode" placeholder="KTN-01"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Urutan</label>
                        <input type="number" name="urutan" min="1" :value="rincianUbah.urutan"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Status</label>
                        <select name="status_unggah" x-model="rincianUbah.status"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                            <option value="menunggu">Menunggu</option>
                            <option value="siap_unggah">Siap Unggah</option>
                            <option value="terunggah">Terunggah</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Nama Konten</label>
                    <input type="text" name="nama_item" :value="rincianUbah.nama" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" x-text="rincianUbah.deskripsi" placeholder="Deskripsi materi..."
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Link / Tautan Konten</label>
                        <input type="url" name="tautan_konten" :value="rincianUbah.link" placeholder="https://..."
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Kanal Unggah</label>
                        <select name="id_lokasi_unggah" x-model="rincianUbah.kanal"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                            <option value="">— Tanpa Kanal —</option>
                            @foreach($daftarLokasiUnggah as $lok)
                                <option value="{{ $lok->id }}">{{ $lok->nama_kanal }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button @click="modalUbahRincian = false" type="button" class="px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs shadow-lg shadow-amber-500/30 playful-btn flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ubah Data Proyek -->
    <div x-show="modalUbah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display:none;">
        <div x-show="modalUbah"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="modalUbah = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div x-show="modalUbah"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg bg-white dark:bg-[#151824] rounded-4xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 z-10">

            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/30">
                        <i data-lucide="pencil" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Ubah Data Proyek</h3>
                        <p class="text-xs text-slate-400 font-medium">Perbarui informasi rencana proyek media.</p>
                    </div>
                </div>
                <button @click="modalUbah = false" type="button" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('operator.proyek.ubah', $proyek->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Judul Proyek</label>
                    <input type="text" name="judul_proyek" value="{{ $proyek->judul_proyek }}" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Deskripsi Proyek</label>
                    <textarea name="deskripsi_proyek" rows="3" placeholder="Catatan singkat mengenai proyek ini..."
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white resize-none">{{ $proyek->deskripsi_proyek }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Target Selesai</label>
                        <input type="date" name="target_selesai" value="{{ $proyek->target_selesai }}"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Status Proyek</label>
                        <select name="status_proyek"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                            <option value="draf" @selected($proyek->status_proyek === 'draf')>Draf</option>
                            <option value="dalam_proses" @selected($proyek->status_proyek === 'dalam_proses')>Dalam Proses</option>
                            <option value="selesai" @selected($proyek->status_proyek === 'selesai')>Selesai</option>
                            <option value="dibatalkan" @selected($proyek->status_proyek === 'dibatalkan')>Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button @click="modalUbah = false" type="button" class="px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs shadow-lg shadow-amber-500/30 playful-btn flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Item Konten -->
    <div x-show="modalDetailRincian" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display:none;">
        <div x-show="modalDetailRincian"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="modalDetailRincian = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div x-show="modalDetailRincian"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg bg-white dark:bg-[#151824] rounded-4xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 z-10">

            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-500 text-white flex items-center justify-center shadow-md shadow-indigo-500/30">
                        <i data-lucide="info" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Detail Item Konten</h3>
                        <p class="text-xs text-slate-400 font-medium">Informasi menyeluruh materi konten media.</p>
                    </div>
                </div>
                <button @click="modalDetailRincian = false" type="button" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-3 p-4 rounded-2xl bg-slate-50 dark:bg-[#0f111a] border border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Kode Konten</span>
                        <span class="font-mono font-bold text-sm text-slate-800 dark:text-white" x-text="rincianDetail.kode"></span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Urutan</span>
                        <span class="font-black text-sm text-slate-800 dark:text-white" x-text="'#' + rincianDetail.urutan"></span>
                    </div>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Nama Konten</span>
                    <p class="font-bold text-slate-800 dark:text-white text-sm" x-text="rincianDetail.nama"></p>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Status Publikasi</span>
                    <div>
                        <span class="edu-badge inline-block"
                            :class="{
                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400': rincianDetail.status === 'terunggah',
                                'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-400': rincianDetail.status === 'siap_unggah',
                                'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400': rincianDetail.status !== 'terunggah' && rincianDetail.status !== 'siap_unggah'
                            }"
                            x-text="rincianDetail.status ? rincianDetail.status.replace('_', ' ').toUpperCase() : '—'"></span>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Daftar Kanal Unggahan</span>
                        <button type="button"
                            @click="formTambahKanal = { id_rincian: rincianDetail.id, id_lokasi_unggah: '', link_unggahan: '' }; modalTambahKanal = true"
                            class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 transition">
                            <i data-lucide="plus" class="w-3 h-3"></i> Tambah Kanal
                        </button>
                    </div>

                    <!-- Tabel Daftar Kanal Pada Konten -->
                    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 overflow-hidden">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 dark:bg-slate-800/60 text-[10px] uppercase font-bold text-slate-400 border-b border-slate-100 dark:border-slate-800">
                                <tr>
                                    <th class="py-2 px-3">Kanal</th>
                                    <th class="py-2 px-3">Link Unggahan</th>
                                    <th class="py-2 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 bg-white dark:bg-[#151824]">
                                <template x-if="rincianDetail.kanals && rincianDetail.kanals.length > 0">
                                    <template x-for="itemKanal in rincianDetail.kanals" :key="itemKanal.id">
                                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40">
                                            <td class="py-2 px-3 font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                                                <i data-lucide="globe" class="w-3 h-3 text-indigo-500 shrink-0"></i>
                                                <span x-text="itemKanal.nama_kanal"></span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <template x-if="itemKanal.link">
                                                    <a :href="itemKanal.link" target="_blank" rel="noopener noreferrer" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline inline-flex items-center gap-1 truncate max-w-[160px]">
                                                        <i data-lucide="external-link" class="w-3 h-3 shrink-0"></i>
                                                        <span x-text="itemKanal.link"></span>
                                                    </a>
                                                </template>
                                                <template x-if="!itemKanal.link">
                                                    <span class="text-slate-400">—</span>
                                                </template>
                                            </td>
                                            <td class="py-2 px-3 text-right">
                                                <form :action="'/operator/konten-kanal/' + itemKanal.id" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="konfirmasiHapus(event, 'Hapus Kanal Konten?', 'Kanal ini akan dilepas dari konten.')" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/40 transition">
                                                        <i data-lucide="trash-2" class="w-3 h-3"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="!rincianDetail.kanals || rincianDetail.kanals.length === 0">
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-slate-400 italic">
                                            Belum ada kanal unggahan yang ditambahkan.
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi</span>
                    <div class="p-3 rounded-2xl bg-slate-50/70 dark:bg-[#0f111a] border border-slate-100 dark:border-slate-800 text-slate-600 dark:text-slate-300 leading-relaxed" x-text="rincianDetail.deskripsi || 'Tidak ada deskripsi tambahan.'"></div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-slate-100 dark:border-slate-800 mt-5">
                <button @click="modalDetailRincian = false" type="button" class="px-5 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kanal ke Konten -->
    <div x-show="modalTambahKanal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display:none;">
        <div x-show="modalTambahKanal"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="modalTambahKanal = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div x-show="modalTambahKanal"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-md bg-white dark:bg-[#151824] rounded-4xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 z-10">

            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-800 dark:text-white">Tambah Kanal Unggahan</h3>
                        <p class="text-[11px] text-slate-400 font-medium">Pilih kanal dan tautan materi ini.</p>
                    </div>
                </div>
                <button @click="modalTambahKanal = false" type="button" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form :action="'/operator/rincian/' + formTambahKanal.id_rincian + '/kanal'" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Pilih Kanal</label>
                    <select name="id_lokasi_unggah" x-model="formTambahKanal.id_lokasi_unggah" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                        <option value="">— Pilih Kanal Unggah —</option>
                        @foreach($daftarLokasiUnggah as $lok)
                            <option value="{{ $lok->id }}">{{ $lok->nama_kanal }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Link Unggahan</label>
                    <input type="url" name="link_unggahan" x-model="formTambahKanal.link_unggahan" placeholder="https://youtube.com/watch?v=..."
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button @click="modalTambahKanal = false" type="button" class="px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow-lg shadow-emerald-500/30 playful-btn flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Simpan Kanal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
