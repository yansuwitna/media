@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-140px)]">

    <!-- Sidebar Kiri Admin -->
    <aside class="w-full md:w-64 bg-white dark:bg-slate-800/80 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between shrink-0">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold">
                    AD
                </div>
                <div>
                    <h4 class="font-bold text-sm text-slate-900 dark:text-white leading-tight">{{ auth('admin')->user()->name }}</h4>
                    <span class="text-xs text-blue-500 font-medium">Administrator</span>
                </div>
            </div>

            <nav class="space-y-1.5 text-sm font-medium">
                <a href="#overview" class="flex items-center gap-3 px-3 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <span>📊</span> Ringkasan
                </a>
                <a href="#identitas-web" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span>⚙️</span> Identitas Web
                </a>
                <a href="#kelola-operator" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span>👥</span> Kelola Operator
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

    <!-- Konten Utama Admin -->
    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
        <!-- Overview Section -->
        <div id="overview" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Operator Terdaftar</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ $totalOperators }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-2xl">
                    👥
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Proyek Terdata</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ $totalProjects }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-2xl">
                    📁
                </div>
            </div>
        </div>

        <!-- Update Identitas Web Section -->
        <div id="identitas-web" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span>⚙️</span> Pengaturan Identitas Website
            </h3>
            <form action="{{ route('admin.identity.update') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300 mb-1">Nama Aplikasi</label>
                        <input type="text" name="app_name" value="{{ old('app_name', $identity->app_name ?? '') }}" required
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300 mb-1">Teks Footer</label>
                        <input type="text" name="footer_text" value="{{ old('footer_text', $identity->footer_text ?? '') }}"
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300 mb-1">Deskripsi Aplikasi</label>
                    <textarea name="app_description" rows="2"
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-sm">{{ old('app_description', $identity->app_description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-300 mb-1">Tema Default</label>
                    <select name="theme_default" class="w-full px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-sm">
                        <option value="light" {{ ($identity->theme_default ?? '') === 'light' ? 'selected' : '' }}>Terang (Light)</option>
                        <option value="dark" {{ ($identity->theme_default ?? '') === 'dark' ? 'selected' : '' }}>Gelap (Dark)</option>
                    </select>
                </div>

                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20">
                    Simpan Perubahan Identitas
                </button>
            </form>
        </div>

        <!-- Kelola Operator Section -->
        <div id="kelola-operator" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <span>👥</span> Manajemen Akun Operator
            </h3>

            <!-- Form Tambah Operator Baru -->
            <form action="{{ route('admin.operators.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Nama Lengkap Operator" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div>
                    <input type="text" name="username" placeholder="Username" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                </div>
                <div class="flex gap-2">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-xs">
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shrink-0">
                        + Tambah
                    </button>
                </div>
            </form>

            <!-- Tabel Operator -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-100 dark:bg-slate-900 uppercase font-semibold text-slate-500">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Username</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Dibuat Pada</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($operators as $op)
                            <tr>
                                <td class="p-3 font-medium text-slate-900 dark:text-white">{{ $op->name }}</td>
                                <td class="p-3">{{ $op->username }}</td>
                                <td class="p-3">{{ $op->email }}</td>
                                <td class="p-3 text-slate-400">{{ $op->created_at->format('d M Y') }}</td>
                                <td class="p-3 text-right">
                                    <form action="{{ route('admin.operators.destroy', $op->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus operator ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-slate-400">Belum ada operator.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
