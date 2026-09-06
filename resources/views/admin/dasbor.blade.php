@extends('layouts.app')

@section('konten')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-140px)]">

    <!-- Sidebar Kiri Admin -->
    <aside class="w-full md:w-72 bg-white dark:bg-[#111827] border-r border-slate-200/80 dark:border-slate-800 p-6 flex flex-col justify-between shrink-0">
        <div>
            <!-- Banner Profil Admin -->
            <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-500/10 via-purple-500/5 to-transparent border border-indigo-200/40 dark:border-indigo-800/40 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center font-extrabold text-sm shadow-md shadow-indigo-500/30">
                        AD
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-extrabold text-sm text-slate-900 dark:text-white truncate">{{ auth('admin')->user()->nama }}</h4>
                        <span class="inline-flex items-center gap-1.5 text-[11px] text-indigo-500 font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Administrator
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tautan Navigasi -->
            <nav class="space-y-2 text-xs font-bold">
                <a href="#ikhtisar" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50 dark:border-indigo-800/50">
                    <span class="text-base">📊</span> Ikhtisar Sistem
                </a>
                <a href="#identitas-web" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 transition">
                    <span class="text-base">⚙️</span> Identitas Web
                </a>
                <a href="#kelola-operator" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 transition">
                    <span class="text-base">👥</span> Kelola Operator
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

    <!-- Konten Utama Dasbor Admin -->
    <main class="flex-1 p-6 md:p-10 space-y-8 overflow-y-auto">
        <!-- Kartu Ikhtisar -->
        <div id="ikhtisar" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Operator Terdaftar</span>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white mt-2">{{ $totalOperator }}</h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-3xl">
                    👥
                </div>
            </div>

            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#111827] border border-slate-200/80 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Rencana Media</span>
                    <h3 class="text-4xl font-black text-slate-900 dark:text-white mt-2">{{ $totalProyek }}</h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-3xl">
                    🎬
                </div>
            </div>
        </div>

        <!-- Perubahan Identitas Web -->
        <div id="identitas-web" class="bg-white dark:bg-[#111827] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-xl shadow-slate-200/30 dark:shadow-none">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>⚙️</span> Konfigurasi Identitas Website
                </h3>
                <p class="text-xs text-slate-400 mt-1">Perbarui nama aplikasi, footer hak cipta, dan tema tampilan web.</p>
            </div>

            <form action="{{ route('admin.identitas.perbarui') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-2 uppercase">Nama Aplikasi Web</label>
                        <input type="text" name="nama_aplikasi" value="{{ old('nama_aplikasi', $identitas->nama_aplikasi ?? '') }}" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-2 uppercase">Teks Footer Hak Cipta</label>
                        <input type="text" name="teks_footer" value="{{ old('teks_footer', $identitas->teks_footer ?? '') }}"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-2 uppercase">Deskripsi Aplikasi</label>
                    <textarea name="deskripsi_aplikasi" rows="2"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('deskripsi_aplikasi', $identitas->deskripsi_aplikasi ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-2 uppercase">Tema Bawaan</label>
                    <select name="tema_bawaan" class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="gelap" {{ ($identitas->tema_bawaan ?? '') === 'gelap' ? 'selected' : '' }}>Gelap (Tema Modern Dark)</option>
                        <option value="terang" {{ ($identitas->tema_bawaan ?? '') === 'terang' ? 'selected' : '' }}>Terang (Tema Bersih Light)</option>
                    </select>
                </div>

                <button type="submit" class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-lg shadow-indigo-600/30 transition">
                    Simpan Perubahan Identitas
                </button>
            </form>
        </div>

        <!-- Kelola Akun Operator -->
        <div id="kelola-operator" class="bg-white dark:bg-[#111827] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-xl shadow-slate-200/30 dark:shadow-none">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>👥</span> Kelola Akun Operator
                </h3>
                <p class="text-xs text-slate-400 mt-1">Buat akun baru untuk staf operator media yang berwenang.</p>
            </div>

            <!-- Form Tambah Operator -->
            <form action="{{ route('admin.operator.simpan') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-8 bg-slate-50 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800">
                @csrf
                <div>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <input type="text" name="nama_pengguna" placeholder="Nama Pengguna" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Alamat Surel / Email" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div class="flex gap-2">
                    <input type="password" name="kata_sandi" placeholder="Kata Sandi" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shrink-0 shadow-md shadow-indigo-600/20 transition">
                        + Tambah
                    </button>
                </div>
            </form>

            <!-- Tabel Daftar Operator -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-800">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-100/80 dark:bg-slate-900 uppercase font-bold text-slate-500 tracking-wider">
                        <tr>
                            <th class="p-4">Nama</th>
                            <th class="p-4">Nama Pengguna</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Tanggal Dibuat</th>
                            <th class="p-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/80 bg-white dark:bg-[#111827]">
                        @forelse($daftarOperator as $op)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                                <td class="p-4 font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-[10px] font-bold">OP</span>
                                    {{ $op->nama }}
                                </td>
                                <td class="p-4">{{ $op->nama_pengguna }}</td>
                                <td class="p-4">{{ $op->email }}</td>
                                <td class="p-4 text-slate-400">{{ $op->created_at->format('d M Y') }}</td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('admin.operator.hapus', $op->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun operator ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 font-semibold transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">Belum ada data operator.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
