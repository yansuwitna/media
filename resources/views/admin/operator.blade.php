@extends('layouts.app')

@section('konten')
<div x-data="{ modalOperator: false }" class="flex flex-col lg:flex-row min-h-[calc(100vh-80px)] w-full">

    <!-- Sidebar Admin (Desktop: Fixed Diam / Tidak Bergerak) -->
    <aside class="hidden lg:flex fixed top-20 bottom-0 left-0 w-72 bg-white/95 dark:bg-[#151824]/95 backdrop-blur-md border-r border-slate-200/80 dark:border-slate-800 p-6 flex-col justify-between shrink-0 z-30 overflow-y-auto">
        <div>
            <div class="p-4 rounded-3xl bg-indigo-50/80 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/60 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-indigo-500/30 shrink-0">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-black text-sm text-slate-800 dark:text-white truncate">{{ auth('admin')->user()->nama }}</h4>
                        <span class="inline-flex items-center gap-1.5 text-[10px] text-indigo-600 dark:text-indigo-400 font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Administrator
                        </span>
                    </div>
                </div>
            </div>

            <nav class="flex flex-col gap-2.5 text-xs font-bold">
                <a href="{{ route('admin.dasbor') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-400"></i> Dasbor
                </a>
                <a href="{{ route('admin.identitas') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition">
                    <i data-lucide="sliders" class="w-4 h-4 text-slate-400"></i> Identitas Web
                </a>
                <a href="{{ route('admin.operator') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/25 font-extrabold playful-btn">
                    <i data-lucide="users" class="w-4 h-4"></i> Kelola Operator
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

    <!-- Konten Kelola Operator -->
    <main class="flex-1 lg:ml-72 p-5 sm:p-8 lg:p-10 space-y-6 sm:space-y-8 max-w-full">
        <div class="bg-white dark:bg-[#151824] rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 soft-card">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="users" class="w-6 h-6 text-indigo-500"></i> Manajemen Akun Operator
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Daftarkan akun operator baru untuk menyusun dan mengelola rencana media.</p>
                </div>
                <button @click="modalOperator = true" type="button" class="w-full sm:w-auto text-xs font-extrabold px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/25 playful-btn flex items-center justify-center gap-1.5">
                    <span>+</span> Tambah Operator Baru
                </button>
            </div>

            <!-- Tabel Daftar Operator -->
            <div class="overflow-x-auto rounded-3xl border border-slate-200/80 dark:border-slate-800 -mx-1 sm:mx-0">
                <table class="w-full min-w-[500px] text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 uppercase font-extrabold text-slate-500 dark:text-slate-400 tracking-wider">
                        <tr>
                            <th class="p-3.5 sm:p-4">Nama Lengkap</th>
                            <th class="p-3.5 sm:p-4">Nama Pengguna</th>
                            <th class="p-3.5 sm:p-4">Email</th>
                            <th class="p-3.5 sm:p-4">Tanggal Dibuat</th>
                            <th class="p-3.5 sm:p-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-[#151824]">
                        @forelse($daftarOperator as $op)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                <td class="p-3.5 sm:p-4 font-bold text-slate-800 dark:text-white flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                    </div>
                                    <span class="truncate max-w-[120px] sm:max-w-none">{{ $op->nama }}</span>
                                </td>
                                <td class="p-3.5 sm:p-4 font-medium">{{ $op->nama_pengguna }}</td>
                                <td class="p-3.5 sm:p-4 truncate max-w-[120px] sm:max-w-none">{{ $op->email }}</td>
                                <td class="p-3.5 sm:p-4 text-slate-400">{{ $op->created_at->format('d/m/Y') }}</td>
                                <td class="p-3.5 sm:p-4 text-right">
                                    <form action="{{ route('admin.operator.hapus', $op->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="konfirmasiHapus(event, 'Hapus Akun Operator?', 'Akun {{ $op->nama }} beserta aksesnya akan dihapus permanen.')" class="px-3 py-1 rounded-xl bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 text-rose-600 font-bold transition">Hapus</button>
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

    <!-- Modal Pop-up: Tambah Akun Operator (Modern Soft-Playful Edu) -->
    <div 
        x-show="modalOperator" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
        style="display: none;">
        
        <!-- Backdrop Overlay -->
        <div 
            x-show="modalOperator"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="modalOperator = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <!-- Modal Dialog Box -->
        <div 
            x-show="modalOperator"
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
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Tambah Akun Operator</h3>
                        <p class="text-xs text-slate-400 font-medium">Buat kredensial login baru untuk tim operator media.</p>
                    </div>
                </div>
                <button 
                    @click="modalOperator = false" 
                    type="button" 
                    class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('admin.operator.simpan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Contoh: Budi Santoso" required
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Nama Pengguna (Username)</label>
                        <input type="text" name="nama_pengguna" placeholder="Contoh: budi_media" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Alamat Surel (Email)</label>
                        <input type="email" name="email" placeholder="budi@sekolah.id" required
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase">Kata Sandi Akun</label>
                    <input type="password" name="kata_sandi" placeholder="Minimal 6 karakter" required minlength="6"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#0f111a] text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none text-slate-800 dark:text-white">
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button 
                        @click="modalOperator = false" 
                        type="button" 
                        class="px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-lg shadow-indigo-500/30 playful-btn flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Simpan Akun Operator
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
