@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-140px)]">

    <!-- Sidebar Kiri Operator -->
    <aside class="w-full md:w-64 bg-white dark:bg-slate-800/80 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between shrink-0">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-emerald-600/10 text-emerald-600 flex items-center justify-center font-bold">
                    OP
                </div>
                <div>
                    <h4 class="font-bold text-sm text-slate-900 dark:text-white leading-tight">{{ $operator->name }}</h4>
                    <span class="text-xs text-emerald-500 font-medium">Operator Media</span>
                </div>
            </div>

            <nav class="space-y-1.5 text-sm font-medium">
                <a href="#proyek" class="flex items-center gap-3 px-3 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <span>🎬</span> Proyek Media
                </a>
                <a href="#lokasi-upload" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span>🌐</span> Lokasi Upload
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-200 dark:border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 text-xs font-semibold">
                    <span>🚪</span> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama Operator -->
    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">

        <!-- Manajemen Lokasi Upload -->
        <div id="lokasi-upload" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span>🌐</span> Data Lokasi Upload Media
            </h3>

            <!-- Form Tambah Lokasi -->
            <form action="{{ route('operator.locations.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Nama Platform (e.g. YouTube, TikTok)" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div>
                    <input type="url" name="url" placeholder="URL Channel / Akun (Opsional)"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div class="flex gap-2">
                    <input type="text" name="description" placeholder="Keterangan singkat"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shrink-0">
                        + Tambah
                    </button>
                </div>
            </form>

            <!-- List Lokasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse($uploadLocations as $loc)
                    <div class="p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 flex items-center justify-between text-xs">
                        <div>
                            <div class="font-bold text-slate-900 dark:text-white">{{ $loc->name }}</div>
                            @if($loc->url)
                                <a href="{{ $loc->url }}" target="_blank" class="text-blue-500 hover:underline text-[11px] block truncate max-w-[180px]">{{ $loc->url }}</a>
                            @endif
                        </div>
                        <form action="{{ route('operator.locations.destroy', $loc->id) }}" method="POST" onsubmit="return confirm('Hapus lokasi upload ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold p-1">✕</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 col-span-full">Belum ada lokasi upload ditambahkan.</p>
                @endforelse
            </div>
        </div>

        <!-- Manajemen Proyek & Rincian -->
        <div id="proyek" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span>🎬</span> Buat Proyek Rencana Media
            </h3>

            <!-- Form Tambah Proyek -->
            <form action="{{ route('operator.projects.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-8 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                @csrf
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Judul Proyek</label>
                    <input type="text" name="title" placeholder="Contoh: Promo Ramadhan" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Target Tanggal</label>
                    <input type="date" name="target_date"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Status Proyek</label>
                    <select name="status" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                        <option value="draft">Draft</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="flex flex-col justify-end">
                    <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold">
                        + Simpan Proyek
                    </button>
                </div>
                <div class="sm:col-span-2 lg:col-span-4">
                    <textarea name="description" rows="2" placeholder="Deskripsi ringkas proyek..."
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs"></textarea>
                </div>
            </form>

            <!-- Daftar Proyek dan Detail Rincian -->
            <div class="space-y-6">
                @forelse($projects as $proj)
                    <div class="border border-slate-200 dark:border-slate-700 rounded-xl p-5 bg-slate-50/40 dark:bg-slate-900/30">
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 dark:border-slate-700 pb-3 mb-4">
                            <div>
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-bold uppercase
                                    @if($proj->status == 'completed') bg-emerald-500/10 text-emerald-500
                                    @elseif($proj->status == 'in_progress') bg-amber-500/10 text-amber-500
                                    @else bg-slate-500/10 text-slate-400 @endif">
                                    {{ $proj->status }}
                                </span>
                                <h4 class="text-base font-bold text-slate-900 dark:text-white mt-1">{{ $proj->title }}</h4>
                                <p class="text-xs text-slate-500">{{ $proj->description }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-slate-400">Target: {{ $proj->target_date ?? '-' }}</span>
                                <form action="{{ route('operator.projects.destroy', $proj->id) }}" method="POST" onsubmit="return confirm('Hapus seluruh proyek ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-500 hover:underline">Hapus Proyek</button>
                                </form>
                            </div>
                        </div>

                        <!-- Form Tambah Rincian Konten -->
                        <form action="{{ route('operator.details.store', $proj->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-4 bg-white dark:bg-slate-800 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                            @csrf
                            <div>
                                <input type="text" name="item_name" placeholder="Item Rincian (e.g. Video 15s)" required
                                    class="w-full px-2.5 py-1.5 rounded-md border border-slate-300 dark:border-slate-600 bg-transparent text-xs">
                            </div>
                            <div>
                                <select name="upload_location_id" class="w-full px-2.5 py-1.5 rounded-md border border-slate-300 dark:border-slate-600 bg-transparent text-xs">
                                    <option value="">-- Pilih Lokasi Upload --</option>
                                    @foreach($uploadLocations as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="media_type" class="w-full px-2.5 py-1.5 rounded-md border border-slate-300 dark:border-slate-600 bg-transparent text-xs">
                                    <option value="video">Video</option>
                                    <option value="image">Gambar / Foto</option>
                                    <option value="audio">Audio / Podcast</option>
                                    <option value="article">Artikel / Post</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            <div class="flex gap-1">
                                <select name="status" class="w-full px-2.5 py-1.5 rounded-md border border-slate-300 dark:border-slate-600 bg-transparent text-xs">
                                    <option value="pending">Pending</option>
                                    <option value="ready">Siap Upload</option>
                                    <option value="uploaded">Uploaded</option>
                                </select>
                                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs font-semibold shrink-0">
                                    + Rincian
                                </button>
                            </div>
                        </form>

                        <!-- Tabel Rincian Proyek -->
                        @if($proj->details->isEmpty())
                            <p class="text-[11px] text-slate-400 italic">Belum ada rincian konten untuk proyek ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-200/50 dark:bg-slate-800 text-slate-500 font-semibold">
                                        <tr>
                                            <th class="p-2">Item Konten</th>
                                            <th class="p-2">Tipe</th>
                                            <th class="p-2">Lokasi Upload</th>
                                            <th class="p-2">Status</th>
                                            <th class="p-2 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700/60">
                                        @foreach($proj->details as $det)
                                            <tr>
                                                <td class="p-2 font-medium">{{ $det->item_name }}</td>
                                                <td class="p-2 uppercase text-[10px] text-slate-400">{{ $det->media_type }}</td>
                                                <td class="p-2">{{ $det->uploadLocation->name ?? '-' }}</td>
                                                <td class="p-2">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                                        @if($det->status == 'uploaded') bg-emerald-500/10 text-emerald-500
                                                        @elseif($det->status == 'ready') bg-blue-500/10 text-blue-500
                                                        @else bg-amber-500/10 text-amber-500 @endif">
                                                        {{ $det->status }}
                                                    </span>
                                                </td>
                                                <td class="p-2 text-right">
                                                    <form action="{{ route('operator.details.destroy', $det->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rincian ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-500 hover:text-rose-700">Hapus</button>
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
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada proyek media. Silakan buat proyek baru di atas.</p>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
