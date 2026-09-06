@extends('layouts.app')

@section('konten')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-140px)]">

    <!-- Sidebar Kiri Operator -->
    <aside class="w-full md:w-72 bg-white dark:bg-[#111827] border-r border-slate-200/80 dark:border-slate-800 p-6 flex flex-col justify-between shrink-0">
        <div>
            <!-- Banner Profil Operator -->
            <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-teal-500/5 to-transparent border border-emerald-200/40 dark:border-emerald-800/40 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-extrabold text-sm shadow-md shadow-emerald-500/30">
                        OP
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-extrabold text-sm text-slate-900 dark:text-white truncate">{{ $operator->nama }}</h4>
                        <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-500 font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Operator Media
                        </span>
                    </div>
                </div>
            </div>

            <nav class="space-y-2 text-xs font-bold">
                <a href="#proyek" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-800/50">
                    <span class="text-base">🎬</span> Proyek & Konten Media
                </a>
                <a href="#lokasi-unggah" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 transition">
                    <span class="text-base">🌐</span> Lokasi & Kanal Unggah
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-200 dark:border-slate-800">
            <form action="{{ route('keluar') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 text-xs font-bold transition">
                    <span>🚪</span> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama Dasbor Operator -->
    <main class="flex-1 p-6 md:p-10 space-y-8 overflow-y-auto">

        <!-- Manajemen Lokasi Unggah -->
        <div id="lokasi-unggah" class="bg-white dark:bg-[#111827] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-xl shadow-slate-200/30 dark:shadow-none">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>🌐</span> Kanal & Lokasi Unggah Media
                </h3>
                <p class="text-xs text-slate-400 mt-1">Daftarkan kanal media sosial, link cloud, atau platform destinasi konten.</p>
            </div>

            <!-- Form Tambah Lokasi Unggah -->
            <form action="{{ route('operator.lokasi.simpan') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6 bg-slate-50 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800">
                @csrf
                <div>
                    <input type="text" name="nama_kanal" placeholder="Nama Kanal (e.g. YouTube Resmi)" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <input type="url" name="tautan" placeholder="Tautan / URL Kanal (Opsional)"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="flex gap-2">
                    <input type="text" name="keterangan" placeholder="Keterangan singkat format unggahan"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shrink-0 shadow-md shadow-emerald-600/20 transition">
                        + Tambah
                    </button>
                </div>
            </form>

            <!-- Kartu Lokasi Unggah -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($daftarLokasiUnggah as $lok)
                    <div class="p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40 flex items-center justify-between text-xs hover:border-emerald-500/40 transition">
                        <div class="overflow-hidden pr-2">
                            <div class="font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="text-sm">📌</span>
                                <span class="truncate">{{ $lok->nama_kanal }}</span>
                            </div>
                            @if($lok->tautan)
                                <a href="{{ $lok->tautan }}" target="_blank" class="text-indigo-500 hover:underline text-[11px] block truncate mt-1">{{ $lok->tautan }}</a>
                            @endif
                            @if($lok->keterangan)
                                <p class="text-[11px] text-slate-400 mt-1 truncate">{{ $lok->keterangan }}</p>
                            @endif
                        </div>
                        <form action="{{ route('operator.lokasi.hapus', $lok->id) }}" method="POST" onsubmit="return confirm('Hapus kanal unggah ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 flex items-center justify-center font-bold text-xs transition">✕</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 col-span-full py-2">Belum ada kanal unggah terdaftar.</p>
                @endforelse
            </div>
        </div>

        <!-- Manajemen Proyek & Rincian Konten -->
        <div id="proyek" class="bg-white dark:bg-[#111827] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-xl shadow-slate-200/30 dark:shadow-none">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>🎬</span> Rencana Proyek & Detail Media
                </h3>
                <p class="text-xs text-slate-400 mt-1">Buat judul kampanye baru dan susun rincian item konten yang akan diproduksi.</p>
            </div>

            <!-- Form Buat Proyek Baru -->
            <form action="{{ route('operator.proyek.simpan') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 bg-slate-50 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Judul Proyek Media</label>
                    <input type="text" name="judul_proyek" placeholder="Contoh: Kampanye Peluncuran Q4" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Target Selesai</label>
                    <input type="date" name="target_selesai"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status Proyek</label>
                    <select name="status_proyek" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="draf">Draf</option>
                        <option value="dalam_proses">Dalam Proses</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="flex flex-col justify-end">
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-600/25 transition">
                        + Buat Proyek
                    </button>
                </div>
                <div class="sm:col-span-2 lg:col-span-4">
                    <input type="text" name="deskripsi_proyek" placeholder="Catatan singkat tujuan kampanye..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </form>

            <!-- Daftar Proyek & Rincian Konten -->
            <div class="space-y-6">
                @forelse($daftarProyek as $proyek)
                    <div class="border border-slate-200/90 dark:border-slate-800 rounded-3xl p-6 bg-slate-50/40 dark:bg-slate-900/40">
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                            <div>
                                <span class="text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider
                                    @if($proyek->status_proyek == 'selesai') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20
                                    @elseif($proyek->status_proyek == 'dalam_proses') bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20
                                    @else bg-slate-500/10 text-slate-600 dark:text-slate-400 border border-slate-500/20 @endif">
                                    {{ str_replace('_', ' ', $proyek->status_proyek) }}
                                </span>
                                <h4 class="text-lg font-black text-slate-900 dark:text-white mt-2">{{ $proyek->judul_proyek }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $proyek->deskripsi_proyek ?? 'Tidak ada keterangan proyek.' }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-xs text-slate-400 font-medium">Target: <strong>{{ $proyek->target_selesai ?? '-' }}</strong></span>
                                <form action="{{ route('operator.proyek.hapus', $proyek->id) }}" method="POST" onsubmit="return confirm('Hapus seluruh proyek beserta rinciannya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-500/10 text-rose-500 hover:bg-rose-500/20 text-xs font-semibold transition">Hapus Proyek</button>
                                </form>
                            </div>
                        </div>

                        <!-- Form Tambah Rincian Konten -->
                        <form action="{{ route('operator.rincian.simpan', $proyek->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-2.5 mb-5 bg-white dark:bg-[#111827] p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                            @csrf
                            <div>
                                <input type="text" name="nama_item" placeholder="Nama Konten (e.g. Video 30s)" required
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>
                            <div>
                                <select name="id_lokasi_unggah" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="">-- Kanal Unggah --</option>
                                    @foreach($daftarLokasiUnggah as $lok)
                                        <option value="{{ $lok->id }}">{{ $lok->nama_kanal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="jenis_media" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="video">Video</option>
                                    <option value="gambar">Gambar / Grafis</option>
                                    <option value="audio">Audio / Podcast</option>
                                    <option value="artikel">Artikel / Teks</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="flex gap-1.5">
                                <select name="status_unggah" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="menunggu">Menunggu</option>
                                    <option value="siap_unggah">Siap Unggah</option>
                                    <option value="terunggah">Terunggah</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shrink-0 shadow-md shadow-indigo-600/20 transition">
                                    + Tambah
                                </button>
                            </div>
                        </form>

                        <!-- Tabel Rincian Proyek -->
                        @if($proyek->rincian->isEmpty())
                            <p class="text-xs text-slate-400 italic text-center py-2">Belum ada rincian konten pada proyek ini.</p>
                        @else
                            <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-100/70 dark:bg-slate-900 uppercase font-bold text-slate-500 tracking-wider">
                                        <tr>
                                            <th class="p-3">Nama Konten</th>
                                            <th class="p-3">Jenis Media</th>
                                            <th class="p-3">Kanal Unggah</th>
                                            <th class="p-3">Status</th>
                                            <th class="p-3 text-right">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60 bg-white dark:bg-[#111827]">
                                        @foreach($proyek->rincian as $rincian)
                                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                                <td class="p-3 font-semibold text-slate-900 dark:text-white">{{ $rincian->nama_item }}</td>
                                                <td class="p-3 uppercase text-[10px] font-bold text-slate-400">{{ $rincian->jenis_media }}</td>
                                                <td class="p-3">{{ $rincian->lokasiUnggah->nama_kanal ?? '-' }}</td>
                                                <td class="p-3">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                        @if($rincian->status_unggah == 'terunggah') bg-emerald-500/10 text-emerald-500 border border-emerald-500/20
                                                        @elseif($rincian->status_unggah == 'siap_unggah') bg-blue-500/10 text-blue-500 border border-blue-500/20
                                                        @else bg-amber-500/10 text-amber-500 border border-amber-500/20 @endif">
                                                        {{ str_replace('_', ' ', $rincian->status_unggah) }}
                                                    </span>
                                                </td>
                                                <td class="p-3 text-right">
                                                    <form action="{{ route('operator.rincian.hapus', $rincian->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rincian konten ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada proyek media yang dibuat.</p>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
