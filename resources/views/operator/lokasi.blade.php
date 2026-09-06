@extends('layouts.app')

@section('konten')
<div x-data="{ modalLokasi: false }" class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

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

    <!-- Konten Halaman Kanal Unggahan -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-8 max-w-full">
        <!-- Header Kanal -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] uppercase font-extrabold tracking-widest text-emerald-500 dark:text-emerald-400 block mb-1">Destinasi Rilis Konten</span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-800 dark:text-white">
                    Kanal Unggahan Media
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">
                    Daftar saluran publikasi media seperti saluran streaming YouTube, feed sosial media, portal materi, dan penyimpanan cloud.
                </p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button @click="modalLokasi = true" type="button" class="w-full sm:w-auto text-xs font-extrabold px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/25 playful-btn flex items-center justify-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kanal Baru
                </button>
            </div>
        </div>

        <!-- Section List Kanal Unggahan -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="globe" class="w-5 h-5 text-indigo-500"></i> Daftar Kanal Terdaftar
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Kanal-kanal ini dapat langsung dipilih saat menjadwalkan item konten di proyek Anda</p>
                </div>
                <span class="edu-badge bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 text-xs">
                    {{ $daftarLokasiUnggah->count() }} Kanal
                </span>
            </div>

            <!-- Tabel Kanal Unggahan -->
            <div class="overflow-x-auto rounded-3xl border border-slate-200/80 dark:border-slate-800">
                @if($daftarLokasiUnggah->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-16 h-16 rounded-3xl bg-indigo-50 dark:bg-slate-800 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="globe" class="w-8 h-8"></i>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-200">Belum Ada Kanal Unggahan</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Tambahkan kanal publikasi baru seperti YouTube, Google Drive, atau akun media sosial lainnya.</p>
                    </div>
                @else
                    <table class="w-full min-w-[600px] text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 uppercase font-extrabold text-slate-500 dark:text-slate-400 tracking-wider">
                            <tr>
                                <th class="p-4">Nama Kanal</th>
                                <th class="p-4">Tautan / URL</th>
                                <th class="p-4">Keterangan Format</th>
                                <th class="p-4 text-center">Item Konten</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-[#151824]">
                            @foreach($daftarLokasiUnggah as $lok)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                                <i data-lucide="globe" class="w-4 h-4"></i>
                                            </div>
                                            <span class="font-extrabold text-slate-800 dark:text-white">{{ $lok->nama_kanal }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 max-w-[180px]">
                                        @if($lok->tautan)
                                            <a href="{{ $lok->tautan }}" target="_blank" class="text-indigo-500 hover:underline truncate block flex items-center gap-1">
                                                <i data-lucide="external-link" class="w-3 h-3 shrink-0"></i>
                                                <span class="truncate">{{ $lok->tautan }}</span>
                                            </a>
                                        @else
                                            <span class="text-slate-400 italic">—</span>
                                        @endif
                                    </td>
                                    <td class="p-4 max-w-[200px]">
                                        <span class="text-slate-500 dark:text-slate-400 truncate block">
                                            {{ $lok->keterangan ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="edu-badge bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400">
                                            {{ $lok->rincian_count }} Item
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('operator.lokasi.detail', $lok->id) }}" class="px-3.5 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 font-bold transition flex items-center gap-1.5">
                                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                                            </a>
                                            <form action="{{ route('operator.lokasi.hapus', $lok->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="konfirmasiHapus(event, 'Hapus Kanal Unggah?', 'Kanal {{ $lok->nama_kanal }} akan dihapus.')" class="px-3.5 py-2 rounded-xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-950/80 font-bold transition flex items-center gap-1.5">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal Pop-up: Tambah Kanal Unggah (Modern Soft Edu) -->
    <div 
        x-show="modalLokasi" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
        style="display: none;">
        
        <!-- Backdrop Overlay -->
        <div 
            x-show="modalLokasi"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="modalLokasi = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <!-- Modal Dialog Box -->
        <div 
            x-show="modalLokasi"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg bg-white dark:bg-[#151824] rounded-4xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 dark:border-slate-800 z-10">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/30">
                        <i data-lucide="globe" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Tambah Kanal Unggahan Baru</h3>
                        <p class="text-xs text-slate-400 font-medium">Daftarkan kanal publikasi seperti YouTube, TikTok, Cloud Drive, dll.</p>
                    </div>
                </div>
                <button 
                    @click="modalLokasi = false" 
                    type="button" 
                    class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('operator.lokasi.simpan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Nama Kanal / Media</label>
                    <input type="text" name="nama_kanal" placeholder="Contoh: Channel YouTube Edukasi, Akun Instagram" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Tautan / URL Kanal (Opsional)</label>
                    <input type="url" name="tautan" placeholder="https://youtube.com/@contoh"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Keterangan Format / Catatan</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Rasio 16:9 Full HD, Durasi maks 10 menit"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button 
                        @click="modalLokasi = false" 
                        type="button" 
                        class="px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-lg shadow-indigo-500/30 playful-btn flex items-center gap-2">
                        <i data-lucide="bookmark-plus" class="w-4 h-4"></i> Simpan Kanal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
