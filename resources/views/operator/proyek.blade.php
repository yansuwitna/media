@extends('layouts.app')

@section('konten')
<div x-data="{ modalProyek: false, modalUbah: false, proyekUbah: {} }" class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

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

    <!-- Konten Halaman Proyek Media -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-8 max-w-full">
        <!-- Header Proyek -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] uppercase font-extrabold tracking-widest text-emerald-500 dark:text-emerald-400 block mb-1">Manajemen Rencana Media</span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-800 dark:text-white">
                    Proyek & Konten Media
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">
                    Kelola rancangan proyek kampanye dan item rincian konten media yang akan diproduksi.
                </p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button @click="modalProyek = true" type="button" class="w-full sm:w-auto text-xs font-extrabold px-5 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/25 playful-btn flex items-center justify-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i> Buat Proyek Baru
                </button>
            </div>
        </div>

        <!-- Tabel Daftar Proyek -->
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 soft-card overflow-hidden">
            <div class="flex items-center justify-between p-6 sm:p-8 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="clapperboard" class="w-5 h-5 text-emerald-500"></i> Rencana Proyek & Detail Media
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Susun dan pantau jadwal pengerjaan konten setiap proyek</p>
                </div>
                <span class="edu-badge bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400 text-xs">
                    {{ $daftarProyek->count() }} Proyek
                </span>
            </div>

            @if($daftarProyek->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[560px] text-xs">
                        <thead class="bg-emerald-50/60 dark:bg-emerald-950/20 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th class="p-4 text-left font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Judul Proyek</th>
                                <th class="p-4 text-center font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Jml</th>
                                <th class="p-4 text-left font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-left font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Target Selesai</th>
                                <th class="p-4 text-left font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Deskripsi</th>
                                <th class="p-4 text-right font-extrabold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarProyek as $proyek)
                                <!-- Baris Utama Proyek -->
                                <tr class="bg-white dark:bg-[#151824] border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50/40 dark:hover:bg-slate-800/20 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                                <i data-lucide="clapperboard" class="w-4 h-4"></i>
                                            </div>
                                            <span class="font-extrabold text-slate-800 dark:text-white">{{ $proyek->judul_proyek }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 rounded-xl text-xs font-black {{ $proyek->rincian->count() > 0 ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/50' : 'bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500' }}">
                                            {{ $proyek->rincian->count() }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="edu-badge
                                            @if($proyek->status_proyek == 'selesai') bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400
                                            @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400
                                            @else bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                                            {{ str_replace('_', ' ', $proyek->status_proyek) }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-semibold text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                            {{ $proyek->target_selesai ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="p-4 max-w-[220px]">
                                        <span class="text-slate-500 dark:text-slate-400 truncate block">{{ $proyek->deskripsi_proyek ?? '—' }}</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('operator.proyek.detail', $proyek->id) }}" title="Lihat Detail Proyek" class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 flex items-center justify-center transition">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <button type="button" title="Ubah Proyek"
                                                @click="proyekUbah = {
                                                    id: '{{ $proyek->id }}',
                                                    judul: '{{ addslashes($proyek->judul_proyek) }}',
                                                    deskripsi: '{{ addslashes($proyek->deskripsi_proyek ?? '') }}',
                                                    target: '{{ $proyek->target_selesai ?? '' }}',
                                                    status: '{{ $proyek->status_proyek }}'
                                                }; modalUbah = true"
                                                class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 hover:bg-amber-100 flex items-center justify-center transition">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            @if($proyek->rincian->count() > 0)
                                                <button type="button" disabled title="Tidak dapat dihapus karena memiliki {{ $proyek->rincian->count() }} rincian konten" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800/60 text-slate-300 dark:text-slate-600 cursor-not-allowed flex items-center justify-center">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('operator.proyek.hapus', $proyek->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" title="Hapus Proyek" onclick="konfirmasiHapus(event, 'Hapus Proyek Media?', 'Proyek {{ addslashes($proyek->judul_proyek) }} akan dihapus secara permanen!')" class="w-9 h-9 rounded-xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 hover:bg-rose-100 flex items-center justify-center transition">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-50 dark:bg-slate-800 text-emerald-500 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="clapperboard" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 dark:text-slate-200">Belum Ada Proyek Rencana Media</h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Klik tombol "+ Buat Proyek Baru" di atas untuk mulai membuat rencana materi konten Anda.</p>
                </div>
            @endif

        </div>
    </main>

    <!-- Modal Pop-up: Buat Proyek Baru (Modern Soft Edu) -->
    <div 
        x-show="modalProyek" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
        style="display: none;">
        
        <!-- Backdrop Overlay -->
        <div 
            x-show="modalProyek"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="modalProyek = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <!-- Modal Dialog Box -->
        <div 
            x-show="modalProyek"
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
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30">
                        <i data-lucide="clapperboard" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Buat Proyek Media Baru</h3>
                        <p class="text-xs text-slate-400 font-medium">Susun rencana materi kampanye atau konten pembelajaran.</p>
                    </div>
                </div>
                <button 
                    @click="modalProyek = false" 
                    type="button" 
                    class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('operator.proyek.simpan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Judul Proyek</label>
                    <input type="text" name="judul_proyek" placeholder="Contoh: Modul Video Pembelajaran Interaktif" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Target Selesai</label>
                        <input type="date" name="target_selesai"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Status Awal</label>
                        <select name="status_proyek" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white">
                            <option value="draf">Draf</option>
                            <option value="dalam_proses">Dalam Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi_proyek" rows="3" placeholder="Catatan rincian, sasaran audiens, atau deskripsi ringkas rencana media..."
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-white resize-none"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button 
                        @click="modalProyek = false" 
                        type="button" 
                        class="px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow-lg shadow-emerald-500/30 playful-btn flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> Simpan & Buat Proyek
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

            <form :action="'/operator/proyek/' + proyekUbah.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Judul Proyek</label>
                    <input type="text" name="judul_proyek" :value="proyekUbah.judul" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Deskripsi Proyek</label>
                    <textarea name="deskripsi_proyek" rows="3" x-text="proyekUbah.deskripsi" placeholder="Catatan singkat mengenai proyek ini..."
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Target Selesai</label>
                        <input type="date" name="target_selesai" :value="proyekUbah.target"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Status Proyek</label>
                        <select name="status_proyek" x-model="proyekUbah.status"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none text-slate-800 dark:text-white">
                            <option value="draf">Draf</option>
                            <option value="dalam_proses">Dalam Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
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

</div>
@endsection
